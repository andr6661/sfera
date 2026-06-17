<template>
    <div class="admin-contacts">
        <div class="section-header">
            <h3><AdminIcon name="address-book" :size="18" /> Управление контактами</h3>
            <p class="contacts-hint">
                <AdminIcon name="info-circle" :size="12" />
                Изменения сохраняются автоматически при нажатии на "Сохранить все изменения" в главной панели
            </p>
        </div>

        <div class="contacts-list">
            <div class="contact-item">
                <label><AdminIcon name="phone-alt" :size="12" /> Телефон</label>
                <input type="text" v-model="edits.phone" placeholder="+7 (000) 000-00-00">
            </div>

            <div class="contact-item">
                <label><AdminIcon name="envelope" :size="12" /> Email</label>
                <input type="email" v-model="edits.email" placeholder="email@example.com">
            </div>

            <div class="contact-item">
                <label><AdminIcon name="map-marker-alt" :size="12" /> Адрес</label>
                <textarea v-model="edits.address" rows="2" placeholder="Город, улица, дом"></textarea>
            </div>

            <div class="contact-item">
                <label><AdminIcon name="clock" :size="12" /> Режим работы</label>
                <input type="text" v-model="edits.workHours" placeholder="Пн-Пт: 9:00 - 18:00">
            </div>

            <div class="contact-item">
                <label><AdminIcon name="subway" :size="12" /> Метро (как добраться)</label>
                <input type="text" v-model="edits.howToGetMetro" placeholder="станция метро">
            </div>

            <div class="contact-item">
                <label><AdminIcon name="bus" :size="12" /> Автобусы (как добраться)</label>
                <input type="text" v-model="edits.howToGetBuses" placeholder="номера автобусов">
            </div>

            <div class="contact-item">
                <label><AdminIcon name="parking" :size="12" /> Парковка (как добраться)</label>
                <input type="text" v-model="edits.howToGetParking" placeholder="информация о парковке">
            </div>
        </div>

        <div class="preview">
            <h4><AdminIcon name="eye" :size="14" /> Предпросмотр:</h4>
            <div class="preview-card">
                <div class="preview-item">
                    <AdminIcon name="phone-alt" :size="14" />
                    <span>{{ edits.phone || 'Телефон не указан' }}</span>
                </div>
                <div class="preview-item">
                    <AdminIcon name="envelope" :size="14" />
                    <span>{{ edits.email || 'Email не указан' }}</span>
                </div>
                <div class="preview-item">
                    <AdminIcon name="map-marker-alt" :size="14" />
                    <span>{{ edits.address || 'Адрес не указан' }}</span>
                </div>
                <div class="preview-item">
                    <AdminIcon name="clock" :size="14" />
                    <span>{{ edits.workHours || 'Режим работы не указан' }}</span>
                </div>
                <div class="preview-divider">
                    <AdminIcon name="directions" :size="12" /> Как добраться:
                </div>
                <div class="preview-item">
                    <AdminIcon name="subway" :size="14" />
                    <span>{{ edits.howToGetMetro || 'Не указано' }}</span>
                </div>
                <div class="preview-item">
                    <AdminIcon name="bus" :size="14" />
                    <span>{{ edits.howToGetBuses || 'Не указано' }}</span>
                </div>
                <div class="preview-item">
                    <AdminIcon name="parking" :size="14" />
                    <span>{{ edits.howToGetParking || 'Не указано' }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted, watch } from 'vue'
import { useDataStore } from '../composables/useDataStore'
import AdminIcon from './AdminIcon.vue'

export default {
    name: 'AdminContacts',
    components: { AdminIcon },
    emits: ['has-changes', 'save-complete'],
    setup(props, { emit }) {
        const { getContacts, updateContact } = useDataStore()

        const originalData = ref(null)
        const hasChanges = ref(false)
        const edits = ref({
            phone: '',
            email: '',
            address: '',
            workHours: '',
            howToGetMetro: '',
            howToGetBuses: '',
            howToGetParking: ''
        })

        const loadContacts = async () => {
            const contacts = await getContacts()
            edits.value = {
                phone: contacts.phone || '',
                email: contacts.email || '',
                address: contacts.address || '',
                workHours: contacts.workHours || '',
                howToGetMetro: contacts.howToGet?.metro || '',
                howToGetBuses: contacts.howToGet?.buses || '',
                howToGetParking: contacts.howToGet?.parking || ''
            }
            originalData.value = JSON.parse(JSON.stringify(edits.value))
        }

        const checkChanges = () => {
            const currentStr = JSON.stringify(edits.value)
            const originalStr = JSON.stringify(originalData.value)
            const newHasChanges = currentStr !== originalStr
            if (hasChanges.value !== newHasChanges) {
                hasChanges.value = newHasChanges
                emit('has-changes', { tabId: 'contacts', hasChanges: hasChanges.value })
            }
        }

        watch(edits, () => {
            checkChanges()
        }, { deep: true })

        const saveData = async () => {
            await updateContact('phone', edits.value.phone)
            await updateContact('email', edits.value.email)
            await updateContact('address', edits.value.address)
            await updateContact('workHours', edits.value.workHours)
            await updateContact('howToGet.metro', edits.value.howToGetMetro)
            await updateContact('howToGet.buses', edits.value.howToGetBuses)
            await updateContact('howToGet.parking', edits.value.howToGetParking)

            await loadContacts()
            originalData.value = JSON.parse(JSON.stringify(edits.value))
            hasChanges.value = false
            emit('has-changes', { tabId: 'contacts', hasChanges: false })
            emit('save-complete', 'contacts')
        }

        onMounted(() => {
            loadContacts()
        })

        return {
            edits,
            saveData
        }
    }
}
</script>

<style scoped>
.admin-contacts {
    width: 100%;
}

.section-header {
    margin-bottom: 20px;
}

.section-header h3 {
    margin: 0 0 8px 0;
    font-size: 18px;
    color: #23519D;
    display: flex;
    align-items: center;
    gap: 8px;
}

.contacts-hint {
    font-size: 12px;
    color: #888;
    margin: 0;
    padding: 8px 12px;
    background: #f0f7ff;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.contacts-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
    margin-bottom: 30px;
}

.contact-item {
    display: flex;
    flex-direction: column;
    gap: 8px;
    padding: 16px;
    background: #f8f9fc;
    border-radius: 12px;
    transition: all 0.3s ease;
    text-align: left;
}

.contact-item:hover {
    background: #e8eef4;
}

.contact-item label {
    font-weight: 600;
    color: #23519D;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 6px;
    text-align: left;
    justify-content: flex-start;
}

.contact-item input,
.contact-item textarea {
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
    font-family: inherit;
    width: 100%;
    box-sizing: border-box;
    transition: all 0.3s ease;
}

.contact-item input:focus,
.contact-item textarea:focus {
    outline: none;
    border-color: #23519D;
    box-shadow: 0 0 0 2px rgba(35, 81, 157, 0.1);
}

.contact-item textarea {
    resize: vertical;
    min-height: 60px;
}

.preview {
    padding: 20px;
    background: #f8f9fc;
    border-radius: 16px;
}

.preview h4 {
    margin: 0 0 16px 0;
    color: #23519D;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.preview-card {
    background: white;
    border-radius: 12px;
    padding: 16px;
    transition: all 0.3s ease;
}

.preview-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(35, 81, 157, 0.1);
}

.preview-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 0;
    font-size: 14px;
    color: #333;
    border-bottom: 1px dashed #eee;
}

.preview-item:last-child {
    border-bottom: none;
}

.preview-divider {
    padding: 12px 0 6px 0;
    font-weight: 600;
    color: #23519D;
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 6px;
}

@media (max-width: 600px) {
    .contacts-hint {
        font-size: 11px;
    }

    .preview-item {
        font-size: 13px;
        gap: 8px;
    }

    .preview-divider {
        font-size: 12px;
    }
}
</style>
