<template>
    <div class="admin-statistics">
        <div class="section-header">
            <h3><AdminIcon name="chart-line" :size="18" /> Управление статистикой</h3>
            <p class="stats-hint">
                <AdminIcon name="info-circle" :size="12" />
                Изменения сохраняются при нажатии на "Сохранить все изменения"
            </p>
        </div>

        <div class="stats-list">
            <div class="stat-item">
                <div class="stat-info">
                    <span class="stat-icon"><AdminIcon name="file-alt" :size="20" /></span>
                    <div class="stat-text">
                        <span class="stat-label">Сценариев мероприятий</span>
                        <span class="stat-value">{{ edits.case1.value }}+</span>
                    </div>
                </div>
                <div class="stat-edit">
                    <input type="text" v-model="edits.case1.title" placeholder="Заголовок">
                    <input type="number" v-model.number="edits.case1.value" placeholder="Число">
                </div>
            </div>

            <div class="stat-item">
                <div class="stat-info">
                    <span class="stat-icon"><AdminIcon name="gamepad" :size="20" /></span>
                    <div class="stat-text">
                        <span class="stat-label">Интерактивных игр</span>
                        <span class="stat-value">{{ edits.case2.value }}+</span>
                    </div>
                </div>
                <div class="stat-edit">
                    <input type="text" v-model="edits.case2.title" placeholder="Заголовок">
                    <input type="number" v-model.number="edits.case2.value" placeholder="Число">
                </div>
            </div>

            <div class="stat-item">
                <div class="stat-info">
                    <span class="stat-icon"><AdminIcon name="users" :size="20" /></span>
                    <div class="stat-text">
                        <span class="stat-label">Гостей в год</span>
                        <span class="stat-value">{{ edits.case3.value }}+</span>
                    </div>
                </div>
                <div class="stat-edit">
                    <input type="text" v-model="edits.case3.title" placeholder="Заголовок">
                    <input type="number" v-model.number="edits.case3.value" placeholder="Число">
                </div>
            </div>
        </div>

        <div class="preview">
            <h4><AdminIcon name="eye" :size="14" /> Предпросмотр:</h4>
            <div class="preview-cards">
                <div class="preview-card">
                    <div class="preview-number">{{ edits.case1.value }}+</div>
                    <div class="preview-title">{{ edits.case1.title }}</div>
                </div>
                <div class="preview-card">
                    <div class="preview-number">{{ edits.case2.value }}+</div>
                    <div class="preview-title">{{ edits.case2.title }}</div>
                </div>
                <div class="preview-card">
                    <div class="preview-number">{{ edits.case3.value }}+</div>
                    <div class="preview-title">{{ edits.case3.title }}</div>
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
    name: 'AdminStatistics',
    components: { AdminIcon },
    emits: ['has-changes', 'save-complete'],
    setup(props, { emit }) {
        const { getStatistics, updateStatistics } = useDataStore()

        const originalData = ref(null)
        const hasChanges = ref(false)
        const edits = ref({
            case1: { value: 0, title: '' },
            case2: { value: 0, title: '' },
            case3: { value: 0, title: '' }
        })

        const loadStatistics = async () => {
            const stats = await getStatistics()
            console.log('Загружена статистика из store:', stats)
            edits.value = {
                case1: { value: stats.case1?.value || 40, title: stats.case1?.title || 'Сценариев мероприятий' },
                case2: { value: stats.case2?.value || 100, title: stats.case2?.title || 'Интерактивных игр' },
                case3: { value: stats.case3?.value || 2000, title: stats.case3?.title || 'Гостей в год' }
            }
            originalData.value = JSON.parse(JSON.stringify(edits.value))
        }

        const checkChanges = () => {
            const currentStr = JSON.stringify(edits.value)
            const originalStr = JSON.stringify(originalData.value)
            const newHasChanges = currentStr !== originalStr
            if (hasChanges.value !== newHasChanges) {
                hasChanges.value = newHasChanges
                emit('has-changes', { tabId: 'statistics', hasChanges: hasChanges.value })
            }
        }

        watch(edits, () => {
            checkChanges()
        }, { deep: true })

        const saveData = async () => {
            const allStats = {
                case1: {
                    value: Number(edits.value.case1.value),
                    title: edits.value.case1.title
                },
                case2: {
                    value: Number(edits.value.case2.value),
                    title: edits.value.case2.title
                },
                case3: {
                    value: Number(edits.value.case3.value),
                    title: edits.value.case3.title
                }
            }

            console.log('Сохраняем статистику:', allStats)
            await updateStatistics(allStats)

            // Проверяем, что сохранилось
            const check = await getStatistics()
            console.log('После сохранения статистика в store:', check)

            // Обновляем локальное состояние
            originalData.value = JSON.parse(JSON.stringify(edits.value))
            hasChanges.value = false
            emit('has-changes', { tabId: 'statistics', hasChanges: false })
            emit('save-complete', 'statistics')
        }

        onMounted(() => {
            loadStatistics()
        })

        return {
            edits,
            saveData
        }
    }
}
</script>

<style scoped>
.admin-statistics {
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

.stats-hint {
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

.stats-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
    margin-bottom: 30px;
}

.stat-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    background: #f8f9fc;
    border-radius: 12px;
    flex-wrap: wrap;
    gap: 12px;
    transition: all 0.3s ease;
}

.stat-item:hover {
    background: #e8eef4;
    transform: translateX(5px);
}

.stat-info {
    display: flex;
    align-items: center;
    gap: 16px;
}

.stat-icon {
    width: 44px;
    height: 44px;
    background: rgba(35, 81, 157, 0.1);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-text {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.stat-label {
    font-size: 14px;
    color: #666;
}

.stat-value {
    font-size: 24px;
    font-weight: bold;
    color: #23519D;
}

.stat-edit {
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
}

.stat-edit input {
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
    width: 180px;
    transition: all 0.3s ease;
}

.stat-edit input:focus {
    outline: none;
    border-color: #23519D;
    box-shadow: 0 0 0 2px rgba(35, 81, 157, 0.1);
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

.preview-cards {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.preview-card {
    flex: 1;
    text-align: center;
    padding: 20px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.preview-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(35, 81, 157, 0.1);
}

.preview-number {
    font-size: 32px;
    font-weight: bold;
    color: #23519D;
}

.preview-title {
    font-size: 14px;
    color: #666;
    margin-top: 8px;
}

@media (max-width: 600px) {
    .stat-item {
        flex-direction: column;
        align-items: stretch;
    }
    .stat-edit {
        justify-content: stretch;
    }
    .stat-edit input {
        width: 100%;
    }
    .preview-cards {
        flex-direction: column;
    }
    .stat-info {
        gap: 12px;
    }
    .stat-icon {
        width: 36px;
        height: 36px;
    }
    .stat-value {
        font-size: 20px;
    }
}
</style>
