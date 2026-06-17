<template>
    <div class="admin-directions">
        <div class="section-header">
            <h3><AdminIcon name="compass" :size="18" /> Управление направлениями</h3>
            <button class="add-btn" @click="openAddModal">
                <AdminIcon name="plus" :size="14" /> Добавить направление
            </button>
        </div>

        <div class="directions-list" ref="directionsList">
            <div v-for="dir in directions" :key="dir.id" class="direction-item" :class="{ 'marked-for-delete': dir._markedForDelete }">
                <div class="drag-handle">
                    <AdminIcon name="grip-vertical" :size="16" />
                </div>
                <img :src="dir.imageUrl" :alt="dir.title" class="direction-image" @error="e => e.target.src = '/storage/img/placeholder.webp'">
                <div class="direction-info">
                    <h4>{{ dir.title }}</h4>
                    <p>{{ dir.shortDesc }}</p>
                    <div class="details-preview">
                        <span v-for="detail in dir.details.slice(0, 2)" :key="detail">{{ detail }}</span>
                    </div>
                </div>
                <div class="direction-actions">
                    <button class="edit-btn" @click="openEditModal(dir)" :disabled="dir._markedForDelete">
                        <AdminIcon name="edit" :size="14" />
                    </button>
                    <button class="delete-btn" @click="toggleMarkForDelete(dir)" :class="{ active: dir._markedForDelete }">
                        <AdminIcon :name="dir._markedForDelete ? 'undo' : 'trash-alt'" :size="14" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Модальное окно -->
        <div class="modal" v-if="showModal" @click="closeModal">
            <div class="modal-container" @click.stop>
                <div class="modal-header">
                    <h3>
                        <AdminIcon :name="isEdit ? 'edit' : 'plus-circle'" :size="18" />
                        {{ isEdit ? 'Редактировать направление' : 'Добавить направление' }}
                    </h3>
                    <button class="close-modal" @click="closeModal">
                        <AdminIcon name="times" :size="18" />
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label><AdminIcon name="heading" :size="12" /> Заголовок</label>
                        <input type="text" v-model="form.title" placeholder="Введите заголовок">
                    </div>

                    <div class="form-group">
                        <label><AdminIcon name="align-left" :size="12" /> Короткое описание</label>
                        <textarea v-model="form.shortDesc" rows="2" placeholder="Введите короткое описание"></textarea>
                    </div>

                    <div class="form-group">
                        <label><AdminIcon name="list" :size="12" /> Детали</label>
                        <div v-for="(item, idx) in form.details" :key="idx" class="detail-row">
                            <input type="text" v-model="form.details[idx]" placeholder="Пункт детали">
                            <button class="remove-detail" @click="form.details.splice(idx, 1)">
                                <AdminIcon name="times" :size="12" />
                            </button>
                        </div>
                        <button class="add-detail" @click="form.details.push('')">
                            <AdminIcon name="plus" :size="12" /> Добавить пункт
                        </button>
                    </div>

                    <div class="form-group">
                        <label><AdminIcon name="image" :size="12" /> Изображение</label>
                        <div class="upload-area" @click="$refs.fileInput.click()">
                            <AdminIcon name="cloud-upload-alt" :size="24" />
                            <span>Нажмите для выбора изображения</span>
                            <input type="file" ref="fileInput" @change="upload" accept="image/*" style="display: none">
                        </div>
                        <img v-if="preview" :src="preview" class="preview-img">
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="cancel-btn" @click="closeModal">
                        <AdminIcon name="times" :size="14" /> Отмена
                    </button>
                    <button class="save-btn" @click="saveDirection">
                        <AdminIcon name="save" :size="14" /> Сохранить
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted, nextTick } from 'vue'
import Sortable from 'sortablejs'
import { useDataStore } from '../composables/useDataStore'
import AdminIcon from './AdminIcon.vue'

export default {
    name: 'AdminDirections',
    components: { AdminIcon },
    emits: ['has-changes', 'save-complete'],
    setup(props, { emit }) {
        const { getDirections, saveDirections, uploadImage } = useDataStore()

        const directions = ref([])
        const showModal = ref(false)
        const isEdit = ref(false)
        const editId = ref(null)
        const preview = ref(null)
        const fileInput = ref(null)
        const directionsList = ref(null)
        let sortable = null

        const form = ref({
            id: null,
            title: '',
            shortDesc: '',
            details: [],
            image: null
        })

        const loadData = async () => {
            directions.value = await getDirections()
            await nextTick()
            initSortable()
        }

        const initSortable = () => {
            if (sortable) sortable.destroy()
            if (directionsList.value) {
                sortable = new Sortable(directionsList.value, {
                    handle: '.drag-handle',
                    animation: 300,
                    onEnd: () => {
                        emit('has-changes', { tabId: 'directions', hasChanges: true })
                    }
                })
            }
        }

        const upload = async (e) => {
            const file = e.target.files?.[0]
            if (!file) return

            const reader = new FileReader()
            reader.onload = () => preview.value = reader.result
            reader.readAsDataURL(file)

            try {
                const result = await uploadImage(file)
                if (result.success) {
                    form.value.image = result.path
                }
            } catch (error) {
                console.error('Upload error:', error)
            }
        }

        const saveDirection = () => {
            if (!form.value.title) {
                alert('Введите заголовок')
                return
            }

            const data = {
                title: form.value.title,
                shortDesc: form.value.shortDesc,
                details: form.value.details.filter(d => d),
                image: form.value.image
            }

            if (isEdit.value) {
                const index = directions.value.findIndex(d => d.id === editId.value)
                if (index !== -1) {
                    directions.value[index] = { ...directions.value[index], ...data }
                }
            } else {
                directions.value.push({ ...data, id: Date.now() })
            }

            emit('has-changes', { tabId: 'directions', hasChanges: true })
            closeModal()
        }

        const saveData = async () => {
            await saveDirections(directions.value)
            await loadData()
            emit('has-changes', { tabId: 'directions', hasChanges: false })
            emit('save-complete', 'directions')
        }

        const toggleMarkForDelete = (item) => {
            const idx = directions.value.findIndex(d => d.id === item.id)
            if (idx !== -1) {
                directions.value[idx]._markedForDelete = !directions.value[idx]._markedForDelete
                emit('has-changes', { tabId: 'directions', hasChanges: true })
            }
        }

        const openAddModal = () => {
            isEdit.value = false
            form.value = { id: null, title: '', shortDesc: '', details: [], image: null }
            preview.value = null
            showModal.value = true
        }

        const openEditModal = (item) => {
            if (item._markedForDelete) return
            isEdit.value = true
            editId.value = item.id
            form.value = {
                id: item.id,
                title: item.title,
                shortDesc: item.shortDesc,
                details: [...(item.details || [])],
                image: item.image
            }
            preview.value = item.imageUrl
            showModal.value = true
        }

        const closeModal = () => {
            showModal.value = false
        }

        onMounted(() => {
            loadData()
        })

        return {
            directions,
            showModal,
            form,
            preview,
            isEdit,
            fileInput,
            directionsList,
            upload,
            saveDirection,
            saveData,
            toggleMarkForDelete,
            openAddModal,
            openEditModal,
            closeModal
        }
    }
}
</script>

<style scoped>
.admin-directions { width: 100%; }
.section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px; }
.section-header h3 { margin: 0; font-size: 18px; color: #23519D; display: flex; align-items: center; gap: 8px; }
.add-btn { padding: 8px 16px; background: #23519D; color: white; border: none; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.3s ease; }
.add-btn:hover { background: #1a3d75; transform: translateY(-2px); }
.directions-list { display: flex; flex-direction: column; gap: 12px; }
.direction-item { display: flex; align-items: center; gap: 15px; padding: 12px; background: #f8f9fc; border-radius: 12px; transition: all 0.3s ease; }
.direction-item.marked-for-delete { background: #fee; opacity: 0.6; text-decoration: line-through; }
.direction-item:hover { background: #e8eef4; }
.drag-handle { cursor: grab; user-select: none; color: #999; display: flex; align-items: center; }
.drag-handle:active { cursor: grabbing; }
.direction-image { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; }
.direction-info { flex: 1; }
.direction-info h4 { margin: 0 0 4px 0; font-size: 16px; color: #23519D; }
.direction-info p { margin: 0 0 4px 0; font-size: 12px; color: #666; }
.details-preview { display: flex; gap: 8px; font-size: 11px; color: #999; }
.direction-actions { display: flex; gap: 8px; }
.direction-actions button { width: 32px; height: 32px; border: none; border-radius: 8px; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; }
.edit-btn { background: #e8eef4; color: #23519D; }
.edit-btn:hover:not(:disabled) { background: #23519D; color: white; }
.edit-btn:disabled { opacity: 0.5; cursor: not-allowed; }
.delete-btn { background: #fee; color: #e74c3c; }
.delete-btn.active { background: #27ae60; color: white; }
.delete-btn:hover { transform: scale(1.05); }
.form-group { margin-bottom: 16px; }
.form-group label { display: block; margin-bottom: 6px; font-size: 14px; font-weight: 500; color: #333; display: flex; align-items: center; gap: 6px; }
.form-group input, .form-group textarea { width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: inherit; box-sizing: border-box; }
.form-group textarea { resize: vertical; min-height: 60px; }
.detail-row { display: flex; gap: 8px; margin-bottom: 8px; }
.detail-row input { flex: 1; padding: 8px 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; }
.remove-detail { background: #fee; border: none; border-radius: 6px; cursor: pointer; padding: 0 12px; display: flex; align-items: center; justify-content: center; }
.add-detail { margin: 8px 0; padding: 6px 12px; background: #e8eef4; border: none; border-radius: 6px; cursor: pointer; display: flex; align-items: center; gap: 6px; font-size: 12px; color: #23519D; }
.upload-area { padding: 20px; border: 2px dashed #ccc; border-radius: 12px; text-align: center; cursor: pointer; margin-bottom: 10px; display: flex; flex-direction: column; align-items: center; gap: 8px; background: #fafafa; transition: all 0.3s ease; }
.upload-area:hover { border-color: #23519D; background: #f0f7ff; }
.upload-icon { font-size: 24px; }
.upload-text { font-size: 14px; color: #23519D; font-weight: 500; }
.preview-img { width: 100px; margin-top: 10px; border-radius: 8px; }

.modal { position: fixed; inset: 0; background: rgba(0, 0, 0, 0.5); display: flex; align-items: center; justify-content: center; z-index: 1100; }
.modal-container { width: 550px; max-width: 90%; background: white; border-radius: 20px; display: flex; flex-direction: column; max-height: 85vh; overflow: hidden; }
.modal-header { display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; border-bottom: 1px solid #eee; flex-shrink: 0; }
.modal-header h3 { margin: 0; font-size: 18px; color: #23519D; display: flex; align-items: center; gap: 8px; }
.close-modal { background: none; border: none; font-size: 18px; cursor: pointer; color: #999; transition: all 0.3s ease; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 50%; }
.close-modal:hover { background: #fee; color: #e74c3c; }
.modal-body { flex: 1; overflow-y: auto; padding: 20px 24px; }
.modal-body::-webkit-scrollbar { width: 6px; }
.modal-body::-webkit-scrollbar-track { background: #e2e8f0; border-radius: 10px; }
.modal-body::-webkit-scrollbar-thumb { background: linear-gradient(135deg, #23519D, #4B93D7); border-radius: 10px; }
.modal-footer { display: flex; justify-content: flex-end; gap: 12px; padding: 16px 24px; border-top: 1px solid #eee; flex-shrink: 0; }
.cancel-btn { padding: 8px 20px; background: #e0e4e8; border: none; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 6px; }
.save-btn { padding: 8px 20px; background: #23519D; color: white; border: none; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 6px; }
</style>
