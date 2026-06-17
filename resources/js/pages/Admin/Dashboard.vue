<template>
    <div class="admin-dashboard">
        <!-- Шапка сайта -->
        <div class="admin-header">
            <div class="header-left">
                <div class="logo-area">
                    <AdminIcon name="tachometer-alt" :size="24" />
                    <h1>Панель управления</h1>
                </div>
            </div>
            <div class="header-right">
                <div v-if="hasUnsavedChanges" class="save-indicator">
                    <AdminIcon name="circle" :size="8" />
                    <span>Есть несохранённые изменения</span>
                </div>
                <button v-if="hasUnsavedChanges" class="save-btn" @click="saveAllChanges">
                    <AdminIcon name="save" :size="14" />
                    <span>Сохранить все изменения</span>
                </button>
                <button class="logout-btn" @click="handleLogout" :disabled="hasUnsavedChanges">
                    <AdminIcon name="sign-out-alt" :size="14" />
                    <span>Выйти</span>
                </button>
            </div>
        </div>

        <AdminPanel ref="adminPanel" @has-changes="onHasChanges" />
    </div>
</template>

<script>
import AdminPanel from '@/admin/AdminPanel.vue'
import AdminIcon from '@/admin/AdminIcon.vue'
import { router } from '@inertiajs/vue3'

export default {
    name: 'AdminDashboard',
    components: {
        AdminPanel,
        AdminIcon
    },
    data() {
        return {
            hasUnsavedChanges: false
        }
    },
    methods: {
        onHasChanges(hasChanges) {
            this.hasUnsavedChanges = hasChanges
        },
        saveAllChanges() {
            if (this.$refs.adminPanel && this.$refs.adminPanel.saveAllChanges) {
                this.$refs.adminPanel.saveAllChanges()
            }
            this.hasUnsavedChanges = false
        },
        handleLogout() {
            if (this.hasUnsavedChanges) {
                alert('Сначала сохраните изменения!')
                return
            }
            router.post('/admin/logout')
        }
    }
}
</script>

<style scoped>
.admin-dashboard {
    min-height: 100vh;
    background: #f0f4f9;
}

.admin-header {
    background: linear-gradient(135deg, #23519D 0%, #2E7EB8 100%);
    color: white;
    padding: 16px 32px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.header-left {
    display: flex;
    align-items: center;
}

.logo-area {
    display: flex;
    align-items: center;
    gap: 12px;
}

.logo-area h1 {
    margin: 0;
    font-size: 22px;
    font-family: "Comfortaa", sans-serif;
    font-weight: 600;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 20px;
}

.save-indicator {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 6px 12px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 30px;
    font-size: 13px;
}

.save-indicator i {
    color: #ffd700;
    animation: pulse 1.5s ease infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.save-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 24px;
    background: #27ae60;
    color: white;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.save-btn:hover {
    background: #219a52;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(39, 174, 96, 0.3);
}

.logout-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 24px;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.logout-btn:hover:not(:disabled) {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
}

.logout-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

@media (max-width: 768px) {
    .admin-header {
        padding: 12px 16px;
        flex-direction: column;
        gap: 12px;
    }

    .logo-area h1 {
        font-size: 18px;
    }

    .header-right {
        width: 100%;
        justify-content: center;
        flex-wrap: wrap;
    }

    .save-btn, .logout-btn {
        padding: 6px 16px;
        font-size: 12px;
    }

    .save-indicator {
        font-size: 11px;
        padding: 4px 10px;
    }
}
</style>
