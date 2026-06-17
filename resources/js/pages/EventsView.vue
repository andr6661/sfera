<template>
    <div class="events-page">
        <div class="container">
            <div class="breadcrumbs">
                <Link href="/">Главная</Link>
                <span class="separator">—</span>
                <span class="current">Мероприятия</span>
            </div>
        </div>

        <div class="container">
            <div class="events-header">
                <h1>Мероприятия</h1>
                <p>Актуальные мероприятия для посещения парка «Сфера»</p>
            </div>

            <div class="filters">
                <button v-for="filter in filters" :key="filter.id" class="filter-btn"
                        :class="{ active: activeFilter === filter.id }" @click="changeFilter(filter.id)">
                    <div class="filter-icon"><i :class="`fas fa-${filter.icon}`"></i></div>
                    <span>{{ filter.name }}</span>
                </button>
            </div>

            <div class="events-grid">
                <div v-for="event in filteredEvents" :key="event.id" class="event-card"
                     @mouseenter="hoveredEvent = event.id" @mouseleave="hoveredEvent = null">
                    <div class="event-image">
                        <img :src="event.image" :alt="event.title">
                        <div class="event-tag" :class="event.type">
                            <i :class="`fas fa-${getTagIcon(event.type)}`"></i>
                            <span>{{ event.tag }}</span>
                        </div>
                    </div>
                    <div class="event-content">
                        <div class="event-date">
                            <i class="fas fa-calendar-alt"></i>
                            <span>{{ event.dateString || 'Дата не указана' }}</span>
                        </div>
                        <h3 class="event-title">{{ event.title }}</h3>
                        <p class="event-desc">{{ event.shortDesc }}</p>
                        <div class="event-bottom">
                            <div class="event-stats">
                                <div class="stat"><i class="fas fa-users"></i><span>{{ event.participants }} участников</span></div>
                                <div class="stat"><i class="fas fa-clock"></i><span>{{ event.duration }}</span></div>
                            </div>
                            <button class="detail-btn" @click="openEventModal(event)">
                                <span>Подробнее</span> <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pagination" v-if="totalPages > 1">
                <button class="page-btn" :disabled="currentPage === 1" @click="goToPage(currentPage - 1)"><i class="fas fa-chevron-left"></i></button>
                <button v-for="page in visiblePages" :key="page" class="page-btn" :class="{ active: currentPage === page }" @click="goToPage(page)">{{ page }}</button>
                <button class="page-btn" :disabled="currentPage === totalPages" @click="goToPage(currentPage + 1)"><i class="fas fa-chevron-right"></i></button>
            </div>

            <!-- Модальное окно -->
            <div class="modal" v-if="selectedEvent" @click="closeEventModal">
                <div class="modal-container" @click.stop>
                    <div class="modal-header">
                        <h2>{{ selectedEvent.title }}</h2>
                        <button class="close-modal" @click="closeEventModal"><i class="fas fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <img :src="selectedEvent.image" :alt="selectedEvent.title" class="modal-image">
                        <div class="modal-meta">
                            <div class="meta-item"><i class="fas fa-calendar-alt"></i><span>{{ selectedEvent.dateString || 'Дата не указана' }}</span></div>
                            <div class="meta-item"><i class="fas fa-clock"></i><span>{{ selectedEvent.duration }}</span></div>
                            <div class="meta-item"><i class="fas fa-users"></i><span>{{ selectedEvent.participants }} участников</span></div>
                        </div>
                        <div class="modal-description">
                            <p v-for="(text, idx) in selectedEvent.fullDesc" :key="idx">{{ text }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3'
import { useDataStore } from '@/composables/useDataStore'

export default {
    name: 'EventsView',
    components: { Link },
    props: { initialEvents: { type: Array, default: () => [] } },
    data() {
        return {
            activeFilter: 'all',
            currentPage: 1,
            itemsPerPage: 12,
            selectedEvent: null,
            hoveredEvent: null,
            events: this.initialEvents || [],
            filters: [
                { id: 'all', name: 'Все', icon: 'th-large' },
                { id: 'probe', name: 'Профпробы', icon: 'briefcase' },
                { id: 'game', name: 'Игры', icon: 'gamepad' },
                { id: 'quest', name: 'Квесты', icon: 'map' },
                { id: 'quiz', name: 'Квизы', icon: 'question-circle' },
                { id: 'vr', name: 'VR-тренажер', icon: 'vr-cardboard' },
                { id: 'interactive', name: 'Интерактивный урок', icon: 'chalkboard-teacher' },
                { id: 'victorina', name: 'Викторина', icon: 'puzzle-piece' }
            ]
        }
    },
    async mounted() {
        await this.loadEvents()
    },
    computed: {
        filteredEvents() {
            let filtered = this.events
            if (this.activeFilter !== 'all') filtered = filtered.filter(e => e.type === this.activeFilter)
            const start = (this.currentPage - 1) * this.itemsPerPage
            return filtered.slice(start, start + this.itemsPerPage)
        },
        totalPages() {
            let filtered = this.events
            if (this.activeFilter !== 'all') filtered = filtered.filter(e => e.type === this.activeFilter)
            return Math.ceil(filtered.length / this.itemsPerPage)
        },
        visiblePages() {
            const pages = [], maxVisible = 5
            let start = Math.max(1, this.currentPage - Math.floor(maxVisible / 2))
            let end = Math.min(this.totalPages, start + maxVisible - 1)
            if (end - start + 1 < maxVisible) start = Math.max(1, end - maxVisible + 1)
            for (let i = start; i <= end; i++) pages.push(i)
            return pages
        }
    },
    methods: {
        getTagIcon(type) {
            const icons = {
                probe: 'briefcase',
                game: 'gamepad',
                quest: 'map',
                quiz: 'question-circle',
                vr: 'vr-cardboard',
                interactive: 'chalkboard-teacher',
                victorina: 'puzzle-piece'
            }
            return icons[type] || 'star'
        },
        async loadEvents() {
            const { getEvents } = useDataStore()
            const fresh = await getEvents()
            this.events = fresh.length ? fresh : this.events
        },
        changeFilter(filterId) {
            this.activeFilter = filterId
            this.currentPage = 1
        },
        goToPage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page
            }
        },
        openEventModal(event) {
            this.selectedEvent = event
            document.body.style.overflow = 'hidden'
        },
        closeEventModal() {
            this.selectedEvent = null
            document.body.style.overflow = ''
        }
    }
}
</script>

<style scoped>
.events-page {
    min-height: 100vh;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.breadcrumbs {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 30px;
    font-size: 14px;
    color: #94A3B8;
}

.breadcrumbs a {
    color: #94A3B8;
    cursor: pointer;
}

.breadcrumbs a:hover {
    color: #E2E8F0;
}

.breadcrumbs .separator {
    color: #4B5563;
}

.breadcrumbs .current {
    color: #E2E8F0;
    font-weight: 500;
}

.events-header {
    text-align: center;
    margin-bottom: 40px;
}

.events-header h1 {
    font-size: clamp(32px, 5vw, 48px);
    font-family: "Comfortaa";
    color: white;
    margin-bottom: 16px;
}

.events-header p {
    font-size: 18px;
    color: white;
}

.filters {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin-bottom: 40px;
    flex-wrap: wrap;
}

.filter-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 20px;
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 40px;
    color: #E2E8F0;
    cursor: pointer;
    transition: 0.3s;
}

.filter-icon {
    width: 28px;
    height: 28px;
    background: rgba(226,232,240,0.15);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.filter-icon i {
    font-size: 14px;
}

.filter-btn:hover {
    background: rgba(255,255,255,0.15);
    transform: translateY(-2px);
}

.filter-btn.active {
    background: rgba(255,255,255,0.18);
    border-color: rgba(255,255,255,0.35);
    color: white;
    box-shadow: 0 0 15px rgba(10,45,143,0.4);
}

.events-grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
    margin-bottom: 48px;
}

.event-card {
    width: 320px;
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 20px;
    overflow: hidden;
    transition: 0.35s;
    box-shadow: 0 0 15px rgba(10,45,143,0.4), 0 0 30px rgba(10,45,143,0.2);
    display: flex;
    flex-direction: column;
}

.event-card:hover {
    transform: translateY(-5px);
    background: rgba(255,255,255,0.15);
    border-color: rgba(255,255,255,0.25);
    box-shadow: 0 0 25px rgba(10,45,143,0.5);
}

.event-image {
    position: relative;
    height: 200px;
    overflow: hidden;
    flex-shrink: 0;
}

.event-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: 0.35s;
}

.event-card:hover .event-image img {
    transform: scale(1.05);
}

.event-tag {
    position: absolute;
    top: 12px;
    right: 12px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: bold;
    background: white;
    color: #0A2D8F;
    backdrop-filter: blur(4px);
    border: 1px solid #0A2D8F;
}

.event-tag i {
    font-size: 12px;
    color: #0A2D8F;
}

.event-tag.probe {
    background: white;
    color: #0A2D8F;
}

.event-tag.game {
    background: white;
    color: #0A2D8F;
}

.event-tag.quest {
    background: white;
    color: #0A2D8F;
}

.event-tag.quiz {
    background: white;
    color: #0A2D8F;
}

.event-tag.vr {
    background: white;
    color: #0A2D8F;
}

.event-tag.interactive {
    background: white;
    color: #0A2D8F;
}

.event-tag.victorina {
    background: white;
    color: #0A2D8F;
}

.event-content {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.event-date {
    display: flex;
    align-items: center;
    gap: 8px;
    color: white;
    font-size: 13px;
    flex-shrink: 0;
    margin-bottom: 8px;
}

.event-date i {
    color: white;
}

.event-title {
    font-size: 18px;
    font-family: "Comfortaa";
    color: white;
    line-height: 1.3;
    word-break: break-word;
    overflow-wrap: break-word;
    hyphens: none;
    flex-shrink: 0;
    margin-bottom: 8px;
}

.event-desc {
    color: rgba(255,255,255,0.85);
    line-height: 1.5;
    font-size: 13px;
    flex: 1;
    word-break: break-word;
    overflow-wrap: break-word;
    hyphens: none;
    margin-bottom: 12px;
}

.event-bottom {
    margin-top: auto;
    flex-shrink: 0;
}

.event-stats {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 12px;
}

.stat {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: white;
    vertical-align: middle;
}

.stat i {
    color: white;
    font-size: 13px;
    width: 16px;
    text-align: center;
    flex-shrink: 0;
}

.detail-btn {
    width: 100%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 8px;
    color: #E2E8F0;
    cursor: pointer;
    transition: 0.35s;
    font-weight: 500;
}

.detail-btn:hover {
    background: rgba(255,255,255,0.2);
    border-color: rgba(255,255,255,0.35);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 0 15px rgba(10,45,143,0.4);
}

.pagination {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 20px;
}

.page-btn {
    width: 36px;
    height: 36px;
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 8px;
    color: #E2E8F0;
    cursor: pointer;
    transition: 0.35s;
}

.page-btn:hover:not(:disabled) {
    background: rgba(255,255,255,0.15);
    transform: translateY(-2px);
}

.page-btn.active {
    background: rgba(255,255,255,0.18);
    border-color: rgba(255,255,255,0.35);
    color: white;
    box-shadow: 0 0 15px rgba(10,45,143,0.4);
}

.page-btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.modal {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    padding: 20px;
    overflow-y: auto;
    overflow-x: hidden;
}

.modal-container {
    width: 550px;
    max-width: 90%;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.5);
    border-radius: 24px;
    display: flex;
    flex-direction: column;
    max-height: 85vh;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    margin: auto;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    background: rgba(255, 255, 255, 0.8);
    flex-shrink: 0;
}

.modal-header h2 {
    margin: 0;
    font-size: 20px;
    color: #0A2D8F;
    font-family: "Comfortaa", sans-serif;
    word-break: break-word;
    overflow-wrap: break-word;
    hyphens: none;
}

.close-modal {
    background: none;
    border: none;
    cursor: pointer;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 0.35s;
    color: #666;
    flex-shrink: 0;
}

.close-modal:hover {
    background: rgba(231, 76, 60, 0.1);
    color: #e74c3c;
}

.close-modal i {
    font-size: 18px;
}

.modal-body {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 20px 24px;
    background: rgba(255, 255, 255, 0.9);
}

.modal-body::-webkit-scrollbar {
    width: 6px;
}

.modal-body::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.1);
    border-radius: 10px;
}

.modal-body::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #0A2D8F, #728AD5);
    border-radius: 10px;
}

.modal-image {
    width: 100%;
    max-height: 220px;
    object-fit: cover;
    border-radius: 16px;
    margin-bottom: 20px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.modal-meta {
    display: flex;
    gap: 20px;
    padding: 12px 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #555;
}

.meta-item i {
    font-size: 13px;
    color: #0A2D8F;
}

.modal-description p {
    margin-bottom: 16px;
    line-height: 1.6;
    font-size: 14px;
    color: #333;
    word-break: break-word;
    overflow-wrap: break-word;
    hyphens: none;
}

.modal-description p:last-child {
    margin-bottom: 0;
}

@media (max-width: 768px) {
    .event-card {
        width: 100%;
        max-width: 340px;
    }

    .filter-btn {
        padding: 6px 14px;
        font-size: 12px;
    }
}
</style>
