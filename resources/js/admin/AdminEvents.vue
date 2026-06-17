<template>
    <div class="admin-events">
        <div class="section-header">
            <h3><AdminIcon name="calendar-alt" :size="18" /> Управление мероприятиями</h3>
            <button class="add-btn" @click="openAddModal">
                <AdminIcon name="plus" :size="14" /> Добавить мероприятие
            </button>
        </div>

        <div class="events-list" ref="eventsList">
            <div v-for="event in events" :key="event.id" class="event-item" :class="{ 'marked-for-delete': event._markedForDelete }">
                <div class="drag-handle">
                    <AdminIcon name="grip-vertical" :size="16" />
                </div>
                <img :src="event.imageUrl || '/storage/img/placeholder.webp'" :alt="event.title" class="event-image" @error="e => e.target.src = '/storage/img/placeholder.webp'">
                <div class="event-info">
                    <h4>{{ event.title }}</h4>
                    <p>{{ event.shortDesc || 'Описание отсутствует' }}</p>
                    <div class="event-meta">
                        <span><AdminIcon name="calendar-alt" :size="10" /> {{ event.dateString || 'Дата не указана' }}</span>
                        <span><AdminIcon name="users" :size="10" /> {{ event.participants || 0 }} участников</span>
                        <span><AdminIcon name="clock" :size="10" /> {{ event.duration || 'Не указано' }}</span>
                        <span class="tag" :class="event.type">{{ event.tag }}</span>
                    </div>
                </div>
                <div class="event-actions">
                    <button class="edit-btn" @click="openEditModal(event)" :disabled="event._markedForDelete">
                        <AdminIcon name="edit" :size="14" />
                    </button>
                    <button class="delete-btn" @click="toggleMarkForDelete(event)" :class="{ active: event._markedForDelete }">
                        <AdminIcon :name="event._markedForDelete ? 'undo' : 'trash-alt'" :size="14" />
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
                        {{ isEdit ? 'Редактировать мероприятие' : 'Добавить мероприятие' }}
                    </h3>
                    <button class="close-modal" @click="closeModal">
                        <AdminIcon name="times" :size="18" />
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label><AdminIcon name="heading" :size="12" /> Заголовок</label>
                            <textarea v-model="form.title" rows="2" placeholder="Введите заголовок"></textarea>
                        </div>
                        <div class="form-group">
                            <label><AdminIcon name="tag" :size="12" /> Тип</label>
                            <select v-model="form.type">
                                <option value="probe">Профпроба</option>
                                <option value="game">Игра</option>
                                <option value="quest">Квест</option>
                                <option value="quiz">Квиз</option>
                                <option value="vr">VR-тренажер</option>
                                <option value="interactive">Интерактивный урок</option>
                                <option value="victorina">Викторина</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><AdminIcon name="align-left" :size="12" /> Короткое описание</label>
                        <textarea v-model="form.shortDesc" rows="2" placeholder="Введите короткое описание"></textarea>
                    </div>

                    <div class="form-group">
                        <label><AdminIcon name="file-alt" :size="12" /> Полное описание</label>
                        <textarea v-model="form.fullDescText" rows="6" placeholder="Введите полное описание... Для переноса строки нажмите Enter"></textarea>
                    </div>

                    <div class="form-group">
                        <label><AdminIcon name="calendar-alt" :size="12" /> Дата проведения</label>
                        <input type="text" v-model="form.dateString" placeholder="например: 15 марта 2026 г. или по запись">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label><AdminIcon name="users" :size="12" /> Участников</label>
                            <input type="number" v-model.number="form.participants" placeholder="0">
                        </div>
                        <div class="form-group">
                            <label><AdminIcon name="clock" :size="12" /> Длительность</label>
                            <input type="text" v-model="form.duration" placeholder="2 часа">
                        </div>
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
                    <button class="save-btn" @click="saveEvent">
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
    name: 'AdminEvents',
    components: { AdminIcon },
    emits: ['has-changes', 'save-complete'],
    setup(props, { emit }) {
        const { getEvents, saveEvents, uploadImage } = useDataStore()

        const events = ref([])
        const showModal = ref(false)
        const isEdit = ref(false)
        const editId = ref(null)
        const preview = ref(null)
        const fileInput = ref(null)
        const eventsList = ref(null)
        let sortable = null

        const tagNames = {
            probe: 'Профпроба',
            game: 'Игра',
            quest: 'Квест',
            quiz: 'Квиз',
            vr: 'VR-тренажер',
            interactive: 'Интерактивный урок',
            victorina: 'Викторина'
        }

        const form = ref({
            id: null,
            title: '',
            shortDesc: '',
            fullDescText: '',
            type: 'probe',
            dateString: '',
            participants: 0,
            duration: '',
            image: null
        })

        const loadData = async () => {
            events.value = await getEvents()
            await nextTick()
            initSortable()
        }

        const initSortable = () => {
            if (sortable) sortable.destroy()
            if (eventsList.value) {
                sortable = new Sortable(eventsList.value, {
                    handle: '.drag-handle',
                    animation: 300,
                    onEnd: () => {
                        emit('has-changes', { tabId: 'events', hasChanges: true })
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

        const saveEvent = () => {
            if (!form.value.title) {
                alert('Введите заголовок')
                return
            }

            const fullDescArray = form.value.fullDescText
                .split(/\n\n+/)
                .filter(p => p.trim())

            const data = {
                title: form.value.title,
                shortDesc: form.value.shortDesc || '',
                fullDesc: fullDescArray.length ? fullDescArray : [],
                tag: tagNames[form.value.type],
                type: form.value.type,
                dateString: form.value.dateString || '',
                participants: parseInt(form.value.participants) || 0,
                duration: form.value.duration || '',
                image: form.value.image || null
            }

            if (isEdit.value) {
                const index = events.value.findIndex(e => e.id === editId.value)
                if (index !== -1) {
                    events.value[index] = { ...events.value[index], ...data }
                }
            } else {
                events.value.push({ ...data, id: Date.now() })
            }

            emit('has-changes', { tabId: 'events', hasChanges: true })
            closeModal()
        }

        const saveData = async () => {
            const cleanedEvents = events.value.filter(e => !e._markedForDelete)
            await saveEvents(cleanedEvents)
            await loadData()
            emit('has-changes', { tabId: 'events', hasChanges: false })
            emit('save-complete', 'events')
        }

        const toggleMarkForDelete = (item) => {
            const idx = events.value.findIndex(e => e.id === item.id)
            if (idx !== -1) {
                events.value[idx]._markedForDelete = !events.value[idx]._markedForDelete
                emit('has-changes', { tabId: 'events', hasChanges: true })
            }
        }

        const openAddModal = () => {
            isEdit.value = false
            form.value = {
                id: null,
                title: '',
                shortDesc: '',
                fullDescText: '',
                type: 'probe',
                dateString: '',
                participants: 0,
                duration: '',
                image: null
            }
            preview.value = null
            showModal.value = true
        }

        const openEditModal = (item) => {
            if (item._markedForDelete) return
            isEdit.value = true
            editId.value = item.id
            form.value = {
                id: item.id,
                title: item.title || '',
                shortDesc: item.shortDesc || '',
                fullDescText: item.fullDesc ? item.fullDesc.join('\n\n') : '',
                type: item.type || 'probe',
                dateString: item.dateString || '',
                participants: item.participants || 0,
                duration: item.duration || '',
                image: item.image || null
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
            events,
            showModal,
            form,
            preview,
            isEdit,
            fileInput,
            eventsList,
            upload,
            saveEvent,
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
.admin-events { width: 100%; }
.section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px; }
.section-header h3 { margin: 0; font-size: 18px; color: #23519D; display: flex; align-items: center; gap: 8px; }
.add-btn { padding: 8px 16px; background: #23519D; color: white; border: none; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 6px; transition: all 0.3s ease; }
.add-btn:hover { background: #1a3d75; transform: translateY(-2px); }
.events-list { display: flex; flex-direction: column; gap: 12px; }
.event-item { display: flex; align-items: center; gap: 15px; padding: 12px; background: #f8f9fc; border-radius: 12px; transition: all 0.3s ease; }
.event-item.marked-for-delete { background: #fee; opacity: 0.6; text-decoration: line-through; }
.event-item:hover { background: #e8eef4; }
.drag-handle { cursor: grab; user-select: none; color: #999; display: flex; align-items: center; }
.drag-handle:active { cursor: grabbing; }
.event-image { width: 80px; height: 60px; object-fit: cover; border-radius: 8px; background: #e2e8f0; }
.event-info { flex: 1; }
.event-info h4 { margin: 0 0 4px 0; font-size: 14px; color: #23519D; }
.event-info > p { margin: 0 0 6px 0; font-size: 12px; color: #666; }
.event-meta { display: flex; gap: 12px; font-size: 11px; color: #999; flex-wrap: wrap; align-items: center; }
.event-meta span { display: inline-flex; align-items: center; gap: 4px; }
.tag { padding: 2px 10px; border-radius: 12px; font-size: 11px; font-weight: 600; }
.tag.probe { background: white; color: #0A2D8F; border: 1px solid #0A2D8F; }
.tag.game { background: white; color: #0A2D8F; border: 1px solid #0A2D8F; }
.tag.quest { background: white; color: #0A2D8F; border: 1px solid #0A2D8F; }
.tag.quiz { background: white; color: #0A2D8F; border: 1px solid #0A2D8F; }
.tag.vr { background: white; color: #0A2D8F; border: 1px solid #0A2D8F; }
.tag.interactive { background: white; color: #0A2D8F; border: 1px solid #0A2D8F; }
.tag.victorina { background: white; color: #0A2D8F; border: 1px solid #0A2D8F; }
.event-actions { display: flex; gap: 8px; }
.event-actions button { width: 32px; height: 32px; border: none; border-radius: 8px; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; }
.edit-btn { background: #e8eef4; color: #23519D; }
.edit-btn:hover:not(:disabled) { background: #23519D; color: white; }
.edit-btn:disabled { opacity: 0.5; cursor: not-allowed; }
.delete-btn { background: #fee; color: #e74c3c; }
.delete-btn.active { background: #27ae60; color: white; }
.delete-btn:hover { transform: scale(1.05); }

.form-row { display: flex; gap: 16px; flex-wrap: wrap; }
.form-group { margin-bottom: 16px; flex: 1; }
.form-group label { display: block; margin-bottom: 6px; font-size: 14px; font-weight: 500; color: #333; display: flex; align-items: center; gap: 6px; }
.form-group label .required { color: #e74c3c; margin-left: 4px; }
.form-group input, .form-group textarea, .form-group select { width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: inherit; box-sizing: border-box; }
.form-group textarea { resize: vertical; min-height: 100px; }
.upload-area { padding: 20px; border: 2px dashed #ccc; border-radius: 12px; text-align: center; cursor: pointer; margin-bottom: 10px; display: flex; flex-direction: column; align-items: center; gap: 8px; background: #fafafa; transition: all 0.3s ease; }
.upload-area:hover { border-color: #23519D; background: #f0f7ff; }
.preview-img { width: 100px; margin-top: 10px; border-radius: 8px; }
.no-image-hint { font-size: 12px; color: #999; margin-top: 8px; text-align: center; }

.modal { position: fixed; inset: 0; background: rgba(0, 0, 0, 0.5); display: flex; align-items: center; justify-content: center; z-index: 1100; }
.modal-container { width: 650px; max-width: 90%; background: white; border-radius: 20px; display: flex; flex-direction: column; max-height: 85vh; overflow: hidden; }
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
