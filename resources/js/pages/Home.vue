<template>
    <div>
        <!-- Hero секция -->
        <section class="hero">
            <div class="plenka">
                <img :src="plenkaImg" alt="">
                <div class="dark-overlay"></div>
            </div>
            <div class="text-hero">
                <p v-html="homeTexts.heroText"></p>
                <div class="hero-tags">
                    <span class="tag">VR-тренажеры</span>
                    <span class="tag">Профпробы</span>
                    <span class="tag">Квесты</span>
                    <span class="tag">Мастер-классы</span>
                </div>
            </div>
        </section>

        <!-- О нас секция -->
        <div class="container section-animate" id="about-section">
            <div class="about-preview">
                <div class="about-text">
                    <h2>{{ homeTexts.aboutTitle }}</h2>
                    <p>{{ homeTexts.aboutText }}</p>
                    <Link href="/about" class="btn-glass">
                        Подробнее
                        <i class="fas fa-arrow-right"></i>
                    </Link>
                </div>
                <div class="about-video">
                    <video
                        :src="videoSrc"
                        autoplay
                        loop
                        muted
                        playsinline
                        class="video-element"
                    ></video>
                </div>
            </div>
        </div>

        <!-- Преимущества секция -->
        <div class="container section-animate">
            <div class="features-header">
                <h2>Почему выбирают парк <span class="highlight">«Сфера»</span></h2>
                <p>4 причины погрузиться в мир профессий вместе с нами</p>
            </div>
            <div class="features-grid">
                <div
                    v-for="feature in features"
                    :key="feature.id"
                    class="feature-card"
                    @mouseenter="hoveredFeature = feature.id"
                    @mouseleave="hoveredFeature = null"
                >
                    <div class="card-glow"></div>
                    <div class="feature-icon">
                        <AppIcon
                            :name="feature.icon"
                            size="xl"
                            :parent-hover="hoveredFeature === feature.id"
                        />
                    </div>
                    <h3>{{ feature.title }}</h3>
                    <p>{{ feature.description }}</p>
                </div>
            </div>
        </div>

        <!-- Цифры и статистика -->
        <StatisticsSection ref="statisticsSection" :key="statsKey" />

        <!-- Интерактивное меню -->
        <InteractiveMenu />
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3'
import InteractiveMenu from '@/Components/InteractiveMenu.vue'
import StatisticsSection from '@/Components/StatisticsSection.vue'
import AppIcon from '@/Components/AppIcon.vue'
import { useDataStore } from '@/composables/useDataStore'

export default {
    name: 'Home',
    components: {
        InteractiveMenu,
        StatisticsSection,
        Link,
        AppIcon
    },
    props: {
        initialData: {
            type: Object,
            default: () => ({})
        }
    },
    data() {
        return {
            homeTexts: this.initialData.homeTexts || {
                heroText: 'Найди своё <span class="highlight-hero">призвание</span> в парке «Сфера»',
                aboutTitle: 'О мультимедийном парке "Сфера"',
                aboutText: 'Сфера — это инновационное пространство, где школьники могут познакомиться с современными профессиями в интерактивном формате. VR-тренажеры, профпробы, квесты и мастер-классы помогут тебе найти свой путь!'
            },
            statsKey: 0,
            plenkaImg: '/img/plenka.webp',
            videoSrc: '/img/VIDEO.mp4',
            hoveredFeature: null,
            features: [
                { id: 1, icon: 'gamepad', title: 'Интерактивно', description: 'Погружение в профессию через игры, VR и практические задания' },
                { id: 2, icon: 'users', title: 'Доступно', description: 'Бесплатные мероприятия для школьников и студентов' },
                { id: 3, icon: 'trophy', title: 'Результативно', description: 'Помогаем сделать осознанный выбор профессии' },
                { id: 4, icon: 'briefcase', title: 'Профессионально', description: 'Встречи с экспертами и работодателями' }
            ]
        }
    },
    mounted() {
        this.initScrollAnimation()
        this.checkForUpdates()

        // Слушаем событие обновления статистики
        window.addEventListener('storage', this.handleStorageChange)
    },
    beforeUnmount() {
        window.removeEventListener('storage', this.handleStorageChange)
    },
    methods: {
        async checkForUpdates() {
            const { getHomeTexts } = useDataStore()
            const fresh = await getHomeTexts()
            if (JSON.stringify(fresh) !== JSON.stringify(this.homeTexts)) {
                this.homeTexts = fresh
                this.statsKey++
            }
        },
        handleStorageChange(e) {
            if (e.key === 'sfera_data') {
                console.log('Обнаружено изменение данных, обновляем статистику')
                // Обновляем ключ для перезагрузки StatisticsSection
                this.statsKey++
                // Также обновляем тексты
                this.checkForUpdates()
            }
        },
        initScrollAnimation() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) entry.target.classList.add('visible')
                })
            }, { threshold: 0.1 })
            document.querySelectorAll('.section-animate').forEach(el => observer.observe(el))
        }
    }
}
</script>

<style scoped>
/* Hero секция */
.hero {
    position: relative;
    min-height: 85vh;
    height: 85vh;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}
.plenka {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 0;
}
.plenka img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}
.dark-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(10, 45, 143, 0.7) 0%, rgba(3, 13, 41, 0.5) 100%);
    backdrop-filter: blur(3px);
}
.text-hero {
    position: relative;
    z-index: 2;
    max-width: 800px;
    width: 90%;
    text-align: center;
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(12px);
    padding: 40px 56px;
    border-radius: 28px;
    border: 1px solid rgba(255, 255, 255, 0.12);
    box-shadow: 0 0 15px rgba(10, 45, 143, 0.4), 0 0 30px rgba(10, 45, 143, 0.2), 0 0 50px rgba(10, 45, 143, 0.1), 0 4px 15px rgba(0, 0, 0, 0.2);
}
.text-hero p {
    font-size: clamp(32px, 5vw, 52px);
    font-weight: 700;
    line-height: 1.3;
    font-family: "Comfortaa", sans-serif;
    color: white;
    margin-bottom: 24px;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}
.text-hero p :deep(.highlight-hero) {
    background: linear-gradient(135deg, #E2E8F0, #FFFFFF);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
.hero-tags {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 12px;
}
.tag {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(4px);
    padding: 8px 20px;
    border-radius: 40px;
    font-size: 14px;
    font-weight: 500;
    color: #E2E8F0;
    font-family: 'Inter', sans-serif;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}
.tag:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-2px);
    color: white;
}
.container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 60px 20px;
}
.btn-glass {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 28px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.25);
    border-radius: 40px;
    color: white;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    box-shadow: 0 0 10px rgba(10, 45, 143, 0.3);
}
.btn-glass:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.4);
    transform: translateY(-3px);
    box-shadow: 0 0 20px rgba(10, 45, 143, 0.5);
}
.about-preview {
    display: flex;
    align-items: center;
    gap: clamp(20px, 5vw, 60px);
    background: linear-gradient(135deg, rgba(10, 45, 143, 0.4), rgba(3, 13, 41, 0.6));
    backdrop-filter: blur(10px);
    border-radius: clamp(20px, 5vw, 40px);
    padding: clamp(24px, 5vw, 50px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
}
.about-text { flex: 1; }
.about-text h2 {
    font-size: clamp(22px, 5vw, 38px);
    font-family: "Comfortaa";
    margin-bottom: clamp(12px, 3vw, 20px);
    color: white;
}
.about-text p {
    font-size: clamp(14px, 3.5vw, 20px);
    line-height: 1.5;
    margin-bottom: clamp(16px, 4vw, 24px);
    color: #CBD5E1;
}
.about-video {
    flex: 0.8;
    border-radius: clamp(12px, 3vw, 24px);
    overflow: hidden;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    background: #000;
}
.video-element { width: 100%; height: auto; display: block; }
.features-header {
    text-align: center;
    margin-bottom: 48px;
}
.features-header h2 {
    font-size: clamp(28px, 4vw, 42px);
    font-family: "Comfortaa";
    color: white;
    margin-bottom: 12px;
}
.features-header .highlight {
    background: linear-gradient(135deg, #E2E8F0, #FFFFFF);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
.features-header p {
    font-size: 18px;
    color: white;
}
.features-grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
}
.feature-card {
    position: relative;
    flex: 1;
    min-width: 220px;
    max-width: 280px;
    text-align: center;
    padding: 30px 20px;
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 24px;
    transition: all 0.35s ease-in-out;
    cursor: pointer;
    overflow: hidden;
    box-shadow: 0 0 15px rgba(10, 45, 143, 0.4), 0 0 30px rgba(10, 45, 143, 0.2), 0 0 50px rgba(10, 45, 143, 0.1), 0 4px 15px rgba(0, 0, 0, 0.2);
}
.feature-card:hover {
    transform: translateY(-5px);
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.25);
    box-shadow: 0 0 25px rgba(10, 45, 143, 0.5), 0 0 50px rgba(10, 45, 143, 0.3), 0 20px 40px rgba(0, 0, 0, 0.25);
}
.card-glow {
    position: absolute;
    inset: 0;
    border-radius: 24px;
    pointer-events: none;
    background: radial-gradient(circle at 50% 0%, rgba(255,255,255,0.1), transparent 70%);
}
.feature-icon {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
    transition: transform 0.35s ease-in-out;
}
.feature-card:hover .feature-icon { transform: scale(1.05); }
.feature-card h3 {
    font-size: 20px;
    font-family: "Comfortaa";
    color: white;
    margin-bottom: 12px;
}
.feature-card p {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.85);
    line-height: 1.5;
}
@media (max-width: 768px) {
    .hero { min-height: 70vh; height: 70vh; }
    .text-hero { max-width: 95%; padding: 28px 24px; }
    .text-hero p { font-size: 24px; margin-bottom: 16px; }
    .hero-tags { gap: 8px; }
    .tag { padding: 6px 14px; font-size: 11px; }
    .about-preview { flex-direction: column; text-align: center; }
    .about-video { flex: 1; width: 100%; }
    .container { padding: 40px 20px; }
    .features-header { margin-bottom: 30px; }
    .features-header p { font-size: 14px; }
    .features-grid { flex-direction: column; align-items: center; }
    .feature-card { max-width: 100%; width: 100%; }
    .btn-glass { padding: 10px 20px; font-size: 14px; }
}
@media (max-width: 480px) {
    .feature-card { padding: 20px 16px; }
    .feature-card h3 { font-size: 18px; }
    .feature-card p { font-size: 13px; }
    .text-hero { padding: 20px 16px; }
    .text-hero p { font-size: 20px; }
    .tag { padding: 4px 10px; font-size: 10px; }
    .btn-glass { padding: 8px 16px; font-size: 12px; }
}
</style>
