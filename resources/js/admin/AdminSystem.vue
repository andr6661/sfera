<template>
    <div class="admin-system">
        <div class="section-header">
            <h3><AdminIcon name="cog" :size="18" /> Системные настройки</h3>
            <p class="system-hint">
                <AdminIcon name="info-circle" :size="12" />
                Управление резервным копированием и сбросом данных
            </p>
        </div>

        <div class="system-section">
            <h4><AdminIcon name="database" :size="14" /> Резервное копирование</h4>
            <p>Экспортируйте или импортируйте данные в формате JSON</p>
            <div class="system-buttons">
                <button class="export-btn" @click="exportData">
                    <AdminIcon name="download" :size="14" /> Экспортировать данные (JSON)
                </button>
                <label class="import-btn">
                    <AdminIcon name="upload" :size="14" /> Импортировать данные
                    <input type="file" accept=".json" @change="importData" style="display: none">
                </label>
            </div>
        </div>

        <div class="system-section danger">
            <h4><AdminIcon name="exclamation-triangle" :size="14" /> Сброс данных</h4>
            <p><AdminIcon name="alert-circle" :size="12" /> Внимание! Это действие удалит все ваши изменения и восстановит исходные данные.</p>
            <button class="reset-btn" @click="showResetModal = true">
                <AdminIcon name="trash-alt" :size="14" /> Сбросить все данные
            </button>
        </div>

        <div class="system-section info">
            <h4><AdminIcon name="info-circle" :size="14" /> Информация о системе</h4>
            <div class="info-item">
                <span><AdminIcon name="tag" :size="12" /> Версия сайта:</span>
                <strong>2.0.0</strong>
            </div>
            <div class="info-item">
                <span><AdminIcon name="calendar-alt" :size="12" /> Последнее обновление:</span>
                <strong>{{ lastUpdated }}</strong>
            </div>
            <div class="info-item">
                <span><AdminIcon name="database" :size="12" /> Хранилище:</span>
                <strong>MySQL / SQLite</strong>
            </div>
            <div class="info-item">
                <span><AdminIcon name="code" :size="12" /> Фреймворк:</span>
                <strong>Laravel + Vue 3</strong>
            </div>
        </div>

        <!-- Модалка подтверждения сброса -->
        <div v-if="showResetModal" class="modal-overlay" @click="showResetModal = false">
            <div class="modal-container" @click.stop>
                <div class="modal-header">
                    <h3><AdminIcon name="exclamation-triangle" :size="16" /> Подтверждение сброса</h3>
                    <button class="modal-close" @click="showResetModal = false">
                        <AdminIcon name="times" :size="16" />
                    </button>
                </div>
                <div class="modal-body">
                    <div class="warning-icon">
                        <AdminIcon name="alert-circle" :size="48" />
                    </div>
                    <p>Вы уверены, что хотите сбросить все данные?</p>
                    <p class="warning">Это действие нельзя отменить. Все ваши изменения будут потеряны.</p>
                </div>
                <div class="modal-footer">
                    <button class="cancel-btn" @click="showResetModal = false">
                        <AdminIcon name="times" :size="14" /> Отмена
                    </button>
                    <button class="reset-confirm-btn" @click="resetData">
                        <AdminIcon name="trash-alt" :size="14" /> Сбросить
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue'
import { useDataStore } from '../composables/useDataStore'
import AdminIcon from './AdminIcon.vue'

export default {
    name: 'AdminSystem',
    components: { AdminIcon },
    setup() {
        const { exportData: exportDataFn, importData: importDataFn, resetAllData } = useDataStore()

        const showResetModal = ref(false)
        const lastUpdated = ref(new Date().toLocaleDateString('ru-RU'))

        const exportData = () => {
            exportDataFn()
        }

        const importData = (event) => {
            const file = event.target.files[0]
            if (!file) return

            const reader = new FileReader()
            reader.onload = (e) => {
                const success = importDataFn(e.target.result)
                if (success) {
                    alert('Данные успешно импортированы! Страница будет обновлена.')
                    window.location.reload()
                } else {
                    alert('Ошибка импорта: неверный формат файла')
                }
            }
            reader.readAsText(file)
        }

        const resetData = () => {
            resetAllData()
            showResetModal.value = false
            alert('Данные сброшены к значениям по умолчанию! Страница будет обновлена.')
            setTimeout(() => {
                window.location.reload()
            }, 500)
        }

        return {
            lastUpdated,
            showResetModal,
            exportData,
            importData,
            resetData
        }
    }
}
</script>

<style scoped>
.admin-system {
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

.system-hint {
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

.system-section {
    padding: 20px;
    background: #f8f9fc;
    border-radius: 16px;
    margin-bottom: 20px;
    transition: all 0.3s ease;
}

.system-section:hover {
    transform: translateY(-2px);
}

.system-section h4 {
    margin: 0 0 12px 0;
    color: #23519D;
    font-size: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.system-section p {
    margin: 0 0 16px 0;
    font-size: 13px;
    color: #666;
    display: flex;
    align-items: center;
    gap: 6px;
}

.system-buttons {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
}

.export-btn, .import-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: #23519D;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 14px;
}

.export-btn:hover, .import-btn:hover {
    background: #1a3d75;
    transform: translateY(-2px);
}

.danger {
    background: #fff5f5;
    border: 1px solid #fed7d7;
}

.danger h4 {
    color: #e74c3c;
}

.danger p {
    color: #c0392b;
}

.reset-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: #e74c3c;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.reset-btn:hover {
    background: #c0392b;
    transform: translateY(-2px);
}

.info {
    background: #e8f4fd;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.info-item:last-child {
    border-bottom: none;
}

.info-item span {
    color: #666;
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.info-item strong {
    color: #23519D;
}

/* Модальное окно */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2000;
    animation: fadeIn 0.2s ease;
}

.modal-container {
    background: white;
    border-radius: 20px;
    width: 90%;
    max-width: 450px;
    overflow: hidden;
    animation: slideUp 0.2s ease;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    background: #e74c3c;
    color: white;
}

.modal-header h3 {
    margin: 0;
    font-size: 18px;
    font-family: "Comfortaa";
    display: flex;
    align-items: center;
    gap: 8px;
}

.modal-close {
    background: none;
    border: none;
    color: white;
    font-size: 18px;
    cursor: pointer;
    padding: 0;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.modal-close:hover {
    background: rgba(255, 255, 255, 0.2);
}

.modal-body {
    padding: 24px;
    text-align: center;
}

.warning-icon {
    margin-bottom: 16px;
    color: #e74c3c;
}

.modal-body p {
    margin: 0 0 12px 0;
    font-size: 16px;
    color: #333;
}

.modal-body .warning {
    color: #e74c3c;
    font-size: 14px;
    background: #fff5f5;
    padding: 10px;
    border-radius: 8px;
    margin-top: 12px;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding: 16px 24px 24px 24px;
    border-top: 1px solid #eee;
}

.cancel-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 20px;
    background: #e0e4e8;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s ease;
}

.cancel-btn:hover {
    background: #cbd1d8;
    transform: translateY(-2px);
}

.reset-confirm-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 20px;
    background: #e74c3c;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s ease;
}

.reset-confirm-btn:hover {
    background: #c0392b;
    transform: translateY(-2px);
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 600px) {
    .system-buttons {
        flex-direction: column;
    }

    .export-btn, .import-btn {
        justify-content: center;
    }

    .info-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;
    }

    .modal-footer {
        flex-direction: column;
    }

    .cancel-btn, .reset-confirm-btn {
        justify-content: center;
    }
}
</style>
