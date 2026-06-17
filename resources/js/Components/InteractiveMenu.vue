<template>
    <div class="interactive-menu-wrapper">
        <div class="container">
            <div class="menu-header">
                <h2>Что вас <span class="highlight">интересует</span>?</h2>
                <p>Выберите раздел, чтобы узнать больше</p>
            </div>

            <div class="menu-grid">
                <Link
                    v-for="item in menuItems"
                    :key="item.id"
                    :href="item.link"
                    class="menu-card"
                    @mouseenter="hoveredCard = item.id"
                    @mouseleave="hoveredCard = null"
                >
                    <div class="menu-card-content">
                        <div class="menu-icon">
                            <AppIcon :name="item.icon" size="lg" :parent-hover="hoveredCard === item.id" />
                        </div>
                        <h3>{{ item.title }}</h3>
                        <div class="menu-arrow" v-if="hoveredCard === item.id">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </div>
                </Link>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3'
import AppIcon from '@/Components/AppIcon.vue'

export default {
    name: 'InteractiveMenu',
    components: { Link, AppIcon },
    data() {
        return {
            hoveredCard: null,
            menuItems: [
                { id: 1, title: 'Наши направления', icon: 'compass', link: '/directions' },
                { id: 2, title: 'Мероприятия', icon: 'calendar-alt', link: '/events' },
                { id: 3, title: 'О нас', icon: 'info-circle', link: '/about' },
                { id: 4, title: 'Контакты', icon: 'phone-alt', link: '/contacts' }
            ]
        }
    }
}
</script>

<style scoped>
.interactive-menu-wrapper {
    padding: 60px 0;
    background: transparent;
}
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}
.menu-header {
    text-align: center;
    margin-bottom: 48px;
}
.menu-header h2 {
    font-size: clamp(28px, 4vw, 42px);
    font-family: "Comfortaa", sans-serif;
    color: white;
    margin-bottom: 12px;
}
.menu-header .highlight {
    background: linear-gradient(135deg, #E2E8F0, #FFFFFF);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
.menu-header p {
    font-size: 18px;
    color: white;
}
.menu-grid {
    display: flex;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
}
.menu-card {
    flex: 0 0 auto;
    width: 220px;
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 24px;
    cursor: pointer;
    transition: all 0.35s ease-in-out;
    text-decoration: none;
    display: block;
    position: relative;
    overflow: hidden;
    box-shadow: 0 0 15px rgba(10, 45, 143, 0.4), 0 0 30px rgba(10, 45, 143, 0.2), 0 0 50px rgba(10, 45, 143, 0.1), 0 4px 15px rgba(0, 0, 0, 0.2);
}
.menu-card:hover {
    transform: translateY(-8px);
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.25);
    box-shadow: 0 0 25px rgba(10, 45, 143, 0.5), 0 0 50px rgba(10, 45, 143, 0.3), 0 20px 40px rgba(0, 0, 0, 0.25);
}
.menu-card-content {
    padding: 32px 20px;
    text-align: center;
    position: relative;
}
.menu-icon {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
    transition: transform 0.35s ease-in-out;
}
.menu-card:hover .menu-icon { transform: scale(1.05); }
.menu-card h3 {
    font-size: 18px;
    font-family: "Comfortaa", sans-serif;
    color: white;
    margin: 0;
    font-weight: 600;
    line-height: 1.4;
}
.menu-arrow {
    position: absolute;
    bottom: 16px;
    left: 50%;
    transform: translateX(-50%);
    animation: fadeInUp 0.3s ease;
}
.menu-arrow i { font-size: 14px; color: #E2E8F0; }
@keyframes fadeInUp {
    from { opacity: 0; transform: translateX(-50%) translateY(10px); }
    to { opacity: 1; transform: translateX(-50%) translateY(0); }
}
@media (max-width: 1024px) {
    .menu-card { width: 200px; }
    .menu-card-content { padding: 24px 16px; }
    .menu-card h3 { font-size: 16px; }
}
@media (max-width: 768px) {
    .interactive-menu-wrapper { padding: 40px 0; }
    .menu-grid { gap: 16px; }
    .menu-card { width: calc(50% - 12px); min-width: 160px; }
    .menu-card-content { padding: 20px 12px; }
    .menu-icon { margin-bottom: 12px; }
    .menu-card h3 { font-size: 14px; }
}
@media (max-width: 480px) {
    .menu-card { width: 100%; }
    .menu-card-content {
        display: flex;
        align-items: center;
        gap: 16px;
        text-align: left;
        padding: 16px 20px;
    }
    .menu-icon { margin-bottom: 0; }
    .menu-arrow {
        position: static;
        transform: none;
        margin-left: auto;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateX(0) translateY(10px); }
        to { opacity: 1; transform: translateX(0) translateY(0); }
    }
}
</style>
