<template>
    <div class="admin-panel">
        <div class="admin-tabs-wrapper" ref="tabsWrapper">
            <div class="admin-tabs">
                <button
                    v-for="tab in tabs"
                    :key="tab.id"
                    :class="{ active: activeTab === tab.id, 'has-changes': tabHasChanges[tab.id] }"
                    @click="activeTab = tab.id"
                >
                    <AdminIcon :name="tab.icon" :size="16" />
                    <span class="tab-name">{{ tab.name }}</span>
                    <span v-if="tabHasChanges[tab.id]" class="change-dot">●</span>
                </button>
            </div>
        </div>

        <div class="admin-content">
            <transition name="fade" mode="out-in">
                <component
                    :is="currentComponent"
                    :key="activeTab"
                    ref="activeComponent"
                    @has-changes="onHasChanges"
                    @save-complete="onSaveComplete"
                />
            </transition>
        </div>
    </div>
</template>

<script>
import AdminDirections from './AdminDirections.vue'
import AdminEvents from './AdminEvents.vue'
import AdminStatistics from './AdminStatistics.vue'
import AdminTexts from './AdminTexts.vue'
import AdminContacts from './AdminContacts.vue'
import AdminSystem from './AdminSystem.vue'
import AdminIcon from './AdminIcon.vue'

export default {
    name: 'AdminPanel',
    components: {
        AdminDirections,
        AdminEvents,
        AdminStatistics,
        AdminTexts,
        AdminContacts,
        AdminSystem,
        AdminIcon
    },
    data() {
        const savedTab = localStorage.getItem('admin_active_tab')
        return {
            activeTab: savedTab || 'directions',
            hasUnsavedChanges: false,
            tabHasChanges: {
                directions: false,
                events: false,
                statistics: false,
                texts: false,
                contacts: false,
                system: false
            },
            tabs: [
                { id: 'directions', name: 'Направления', icon: 'compass' },
                { id: 'events', name: 'Мероприятия', icon: 'calendar-alt' },
                { id: 'statistics', name: 'Статистика', icon: 'chart-line' },
                { id: 'texts', name: 'Тексты', icon: 'edit' },
                { id: 'contacts', name: 'Контакты', icon: 'address-book' },
                { id: 'system', name: 'Система', icon: 'cog' }
            ]
        }
    },
    computed: {
        currentComponent() {
            const map = {
                directions: 'AdminDirections',
                events: 'AdminEvents',
                statistics: 'AdminStatistics',
                texts: 'AdminTexts',
                contacts: 'AdminContacts',
                system: 'AdminSystem'
            }
            return map[this.activeTab]
        }
    },
    watch: {
        activeTab(newTab) {
            localStorage.setItem('admin_active_tab', newTab)
        }
    },
    mounted() {
        const wrapper = this.$refs.tabsWrapper
        if (wrapper) {
            wrapper.addEventListener('wheel', this.handleWheel, { passive: false })
        }
    },
    beforeUnmount() {
        const wrapper = this.$refs.tabsWrapper
        if (wrapper) {
            wrapper.removeEventListener('wheel', this.handleWheel)
        }
    },
    methods: {
        onHasChanges(payload) {
            const { tabId, hasChanges } = payload
            this.tabHasChanges[tabId] = hasChanges
            this.hasUnsavedChanges = Object.values(this.tabHasChanges).some(v => v === true)
            this.$emit('has-changes', this.hasUnsavedChanges)
        },
        onSaveComplete(tabId) {
            this.tabHasChanges[tabId] = false
            this.hasUnsavedChanges = Object.values(this.tabHasChanges).some(v => v === true)
            this.$emit('has-changes', this.hasUnsavedChanges)
        },
        saveAllChanges() {
            const currentComponentRef = this.$refs.activeComponent
            if (currentComponentRef && currentComponentRef.saveData) {
                currentComponentRef.saveData()
            }
            for (const tabId in this.tabHasChanges) {
                this.tabHasChanges[tabId] = false
            }
            this.hasUnsavedChanges = false
            localStorage.setItem('admin_active_tab', this.activeTab)
        },
        handleWheel(e) {
            e.preventDefault()
            const wrapper = this.$refs.tabsWrapper
            if (wrapper) {
                wrapper.scrollLeft += e.deltaY
            }
        }
    }
}
</script>

<style scoped>
.admin-panel {
    width: 100%;
    background: white;
    position: relative;
}

.admin-tabs-wrapper {
    overflow-x: auto;
    overflow-y: hidden;
    background: #f8fafc;
    border-bottom: 2px solid #e2e8f0;
}

.admin-tabs-wrapper::-webkit-scrollbar {
    height: 6px;
}

.admin-tabs-wrapper::-webkit-scrollbar-track {
    background: #e2e8f0;
    border-radius: 10px;
}

.admin-tabs-wrapper::-webkit-scrollbar-thumb {
    background: linear-gradient(90deg, #23519D, #4B93D7);
    border-radius: 10px;
}

.admin-tabs {
    display: flex;
    gap: 6px;
    padding: 16px 20px;
    min-width: min-content;
}

.admin-tabs button {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: transparent;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s ease;
    color: #64748b;
    white-space: nowrap;
}

.admin-tabs button.has-changes {
    background: rgba(39, 174, 96, 0.1);
    color: #27ae60;
}

.change-dot {
    color: #27ae60;
    font-size: 10px;
    margin-left: 4px;
    animation: blink 1s ease infinite;
}

.admin-tabs button:hover {
    background: rgba(35, 81, 157, 0.1);
    color: #23519D;
}

.admin-tabs button.active {
    background: #23519D;
    color: white;
}

.tab-name {
    font-size: 14px;
}

.admin-content {
    padding: 24px;
    background: white;
}

@keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

@media (max-width: 768px) {
    .admin-tabs button {
        padding: 6px 12px;
    }

    .tab-name {
        font-size: 12px;
    }

    .admin-content {
        padding: 16px;
    }
}
</style>
