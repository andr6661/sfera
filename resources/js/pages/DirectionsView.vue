<template>
    <div>
        <div class="container">
            <div class="breadcrumbs">
                <Link href="/">Главная</Link>
                <span class="separator">—</span>
                <span class="current">Направления</span>
            </div>
        </div>

        <!-- Hero секция -->
        <div class="hero-directions">
            <div class="container">
                <div class="hero-content">
                    <h1>Наши <span class="highlight">направления</span></h1>
                    <p>Интерактивные форматы профориентации для школьников</p>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="directions-grid" v-if="directions.length > 0">
                <div
                    v-for="dir in directions"
                    :key="dir.id"
                    class="direction-card"
                    @mouseenter="hoveredCard = dir.id"
                    @mouseleave="hoveredCard = null"
                >
                    <div class="direction-image">
                        <img :src="dir.imageUrl" :alt="dir.title" @error="handleImageError">
                    </div>
                    <div class="direction-content">
                        <h3>{{ dir.title }}</h3>
                        <p>{{ dir.shortDesc }}</p>
                        <div class="direction-divider"></div>
                        <div class="direction-details" v-if="hoveredCard === dir.id">
                            <div class="details-list">
                                <div v-for="detail in dir.details.slice(0, 4)" :key="detail" class="detail-item">
                                    <div class="detail-icon">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <span>{{ detail }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="empty-state">
                <p>Направления загружаются...</p>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3'
import { useDataStore } from '@/composables/useDataStore'

export default {
    name: 'DirectionsView',
    components: { Link },
    props: {
        initialDirections: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            hoveredCard: null,
            directions: this.initialDirections || []
        }
    },
    async mounted() {
        await this.loadDirections()
    },
    methods: {
        async loadDirections() {
            try {
                const { getDirections } = useDataStore()
                const fresh = await getDirections()
                this.directions = fresh.length ? fresh : this.directions
            } catch (error) {
                console.error('Ошибка загрузки направлений:', error)
            }
        },
        handleImageError(e) {
            e.target.src = '/storage/img/placeholder.webp'
        }
    }
}
</script>

<style scoped>
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
.breadcrumbs a { color: #94A3B8; text-decoration: none; cursor: pointer; }
.breadcrumbs a:hover { color: #E2E8F0; }
.breadcrumbs .separator { color: #4B5563; }
.breadcrumbs .current { color: #E2E8F0; font-weight: 500; }
.hero-directions {
    text-align: center;
    margin-bottom: 40px;
    padding: 40px 0;
}
.hero-content h1 {
    font-size: clamp(32px, 5vw, 48px);
    font-family: "Comfortaa";
    color: white;
    margin-bottom: 16px;
}
.hero-content .highlight {
    background: linear-gradient(135deg, #E2E8F0, #FFFFFF);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
.hero-content p {
    font-size: 18px;
    color: white;
}
.directions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 32px;
}
.direction-card {
    position: relative;
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 24px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    cursor: pointer;
    box-shadow: 0 0 15px rgba(10, 45, 143, 0.4), 0 0 30px rgba(10, 45, 143, 0.2), 0 0 50px rgba(10, 45, 143, 0.1), 0 4px 15px rgba(0, 0, 0, 0.2);
}
.direction-card:hover {
    transform: translateY(-8px);
    background: rgba(255, 255, 255, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 0 25px rgba(10, 45, 143, 0.6), 0 0 50px rgba(10, 45, 143, 0.4), 0 0 80px rgba(10, 45, 143, 0.2), 0 20px 40px rgba(0, 0, 0, 0.3);
}
.direction-image {
    position: relative;
    height: 220px;
    overflow: hidden;
}
.direction-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.direction-card:hover .direction-image img { transform: scale(1.05); }
.direction-content {
    padding: 24px;
}
.direction-content h3 {
    font-size: 22px;
    font-family: "Comfortaa", sans-serif;
    color: white;
    margin-bottom: 12px;
    letter-spacing: -0.3px;
}
.direction-content > p {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.85);
    line-height: 1.5;
    margin-bottom: 20px;
}
.direction-divider {
    width: 40px;
    height: 3px;
    background: linear-gradient(90deg, #E2E8F0, #94A3B8);
    border-radius: 3px;
    margin: 16px 0;
    transition: width 0.3s ease;
}
.direction-card:hover .direction-divider { width: 60px; }
.direction-details {
    margin-top: 8px;
    animation: slideUp 0.3s ease;
}
.details-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.detail-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    color: rgba(255, 255, 255, 0.9);
    padding: 6px 0;
    border-bottom: 1px dashed rgba(255, 255, 255, 0.15);
}
.detail-icon {
    width: 22px;
    height: 22px;
    background: rgba(226, 232, 240, 0.15);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #E2E8F0;
}
.detail-icon i { font-size: 10px; }
@keyframes slideUp {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}
.empty-state {
    text-align: center;
    padding: 60px;
    color: #94A3B8;
}
@media (max-width: 768px) {
    .directions-grid { gap: 20px; }
    .direction-image { height: 180px; }
    .direction-content { padding: 18px; }
    .direction-content h3 { font-size: 18px; }
}
</style>
