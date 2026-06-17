<template>
    <div>
        <div class="container">
            <div class="breadcrumbs">
                <Link href="/">Главная</Link>
                <span class="separator">—</span>
                <span class="current">О нас</span>
            </div>
        </div>

        <!-- Герой секция -->
        <div class="hero-about">
            <div class="container">
                <div class="hero-content">
                    <h1>О мультимедийном парке профориентации <span class="highlight">«Сфера»</span></h1>
                    <p>Инновационное пространство, где школьники открывают мир профессий через технологии и практику</p>
                </div>
            </div>
        </div>

        <!-- Краткое описание -->
        <div class="container section-animate">
            <div class="about-text-card glass-card">
                <p>«Сфера» — уникальное интерактивное пространство для школьников, где профессию можно не просто узнать, а потрогать, прочувствовать и испытать на себе. Парк создан на базе ГБПОУ «Нижегородский Губернский колледж» и открывает двери в мир современных специальностей через игру, виртуальные технологии и реальную практику.</p>
            </div>
        </div>

        <!-- Миссия -->
        <div class="container section-animate">
            <div class="mission-section glass-card">
                <div class="mission-icon">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h2>Наша миссия</h2>
                <p>Мы верим, что правильный выбор профессии — это не случайность, а результат осознанного погружения. Наша миссия — сломать стереотипы о специальностях, показать их динамичность, технологичность и творческий потенциал. Мы помогаем подросткам сделать первый и самый важный шаг — найти «свою» сферу, где таланты совпадут с интересом, а интерес — с востребованностью на рынке труда. Парк «Сфера» — это мост между школьной скамьей и успешным будущим, между учеником и профессией, между теорией и практикой.</p>
            </div>
        </div>

        <!-- Что ждет гостей -->
        <div class="container section-animate">
            <div class="guests-section glass-card">
                <h2>Что ждет гостей в мультимедийном парке <span class="highlight">«Сфера»</span>?</h2>
                <p class="guests-intro">Мы превратили знакомство с профессиями в увлекательное приключение. Для вас:</p>
                <div class="guests-grid">
                    <div class="guest-item">
                        <div class="guest-icon">
                            <i class="fas fa-vr-cardboard"></i>
                        </div>
                        <div class="guest-text">
                            <h4>VR-технологии и профпробы</h4>
                            <p>Не просто послушать, а самому запрограммировать робота, создать дизайн-макет, поработать за конвейером. Используя VR-тренажеры, можно совершить ошибку без ущерба и тут же исправить её под руководством наставника.</p>
                        </div>
                    </div>
                    <div class="guest-item">
                        <div class="guest-icon">
                            <i class="fas fa-gamepad"></i>
                        </div>
                        <div class="guest-text">
                            <h4>Современные форматы событий</h4>
                            <ul>
                                <li><i class="fas fa-check-circle"></i> Квизы и викторины по специальностям колледжа</li>
                                <li><i class="fas fa-check-circle"></i> Квесты по тематическим зонам парка</li>
                                <li><i class="fas fa-check-circle"></i> Мастер-классы от профессионалов</li>
                                <li><i class="fas fa-check-circle"></i> Тренинги по soft skills</li>
                                <li><i class="fas fa-check-circle"></i> Встречи с работодателями</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Наша уникальность -->
        <div class="container section-animate">
            <div class="unique-section glass-card">
                <div class="unique-header">
                    <div class="unique-badge">
                        <i class="fas fa-star"></i>
                    </div>
                    <h2>Наша <span class="highlight">уникальность</span></h2>
                </div>
                <h3>Парк, созданный будущими IT-гениями</h3>
                <p class="unique-fact">Весь интерактивный контент, цифровые симуляции, интерфейсы и программные решения для парка «Сфера» разрабатываются совместно со студентами Нижегородского Губернского колледжа специальности «Информационные системы и программирование».</p>
                <div class="unique-grid">
                    <div class="unique-item">
                        <div class="unique-icon"><i class="fas fa-code"></i></div>
                        <h4>Актуальность и «живой» код</h4>
                        <p>Школьники взаимодействуют с технологиями, которые создают их сверстники, понимая реальный уровень современных digital-решений.</p>
                    </div>
                    <div class="unique-item">
                        <div class="unique-icon"><i class="fas fa-users-gear"></i></div>
                        <h4>Двойная профориентация</h4>
                        <p>Гости «примеряют» профессии, а студенты-разработчики проходят бесценную практику, работая над реальным проектом.</p>
                    </div>
                    <div class="unique-item">
                        <div class="unique-icon"><i class="fas fa-bolt"></i></div>
                        <h4>Язык поколения Z</h4>
                        <p>Контент получается современным, динамичным и понятным именно для подростковой аудитории.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- История -->
        <div class="container section-animate">
            <div class="history-header">
                <h2>История парка <span class="highlight">«Сфера»</span></h2>
                <p>Как мы росли и развивались</p>
            </div>
            <div class="history-timeline">
                <div class="timeline-item" v-for="(item, index) in historyItems" :key="index">
                    <div class="timeline-marker">
                        <div class="marker-dot">
                            <i :class="item.icon"></i>
                        </div>
                        <div class="marker-line" v-if="index !== historyItems.length - 1"></div>
                    </div>
                    <div class="timeline-content glass-card">
                        <div class="timeline-year">
                            <i class="fas fa-calendar-alt"></i>
                            <span>{{ item.year }}</span>
                        </div>
                        <h3>{{ item.title }}</h3>
                        <p>{{ item.description }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Почему важна профориентация -->
        <div class="container section-animate">
            <div class="importance-header">
                <h2>Почему важна <span class="highlight">профориентация</span>?</h2>
                <p>4 причины, почему это нужно каждому школьнику</p>
            </div>
            <div class="importance-grid">
                <div class="importance-card" v-for="(reason, index) in importanceReasons" :key="index">
                    <div class="importance-icon">
                        <i :class="reason.icon"></i>
                    </div>
                    <h3 class="importance-title">{{ reason.title }}</h3>
                    <p>{{ reason.text }}</p>
                </div>
            </div>
        </div>

        <!-- Кто наши гости -->
        <div class="container section-animate">
            <div class="guests-audience glass-card">
                <h2>Кто наши <span class="highlight">гости</span>?</h2>
                <p class="audience-intro">Парк «Сфера» ждет в гости школьников 5-11 классов, которые:</p>
                <div class="audience-grid">
                    <div class="audience-item">
                        <div class="audience-icon"><i class="fas fa-graduation-cap"></i></div>
                        <p>Стоят на пороге выбора профессии и хотят сделать его осознанно.</p>
                    </div>
                    <div class="audience-item">
                        <div class="audience-icon"><i class="fas fa-star"></i></div>
                        <p>Желают получить уникальный опыт, которого нет в школе.</p>
                    </div>
                    <div class="audience-item">
                        <div class="audience-icon"><i class="fas fa-rocket"></i></div>
                        <p>Ищут свое место в мире профессий будущего.</p>
                    </div>
                </div>
                <p class="audience-additional">Мы также рады <strong>учителям и родителям</strong>, которые стремятся поддержать подростков в этом важном выборе.</p>
            </div>
        </div>

        <!-- Почему стоит выбрать «Сферу»? -->
        <div class="container section-animate">
            <div class="advantages-section glass-card">
                <h2>Почему стоит выбрать <span class="highlight">«Сферу»</span>?</h2>
                <p class="advantages-subtitle">Преимущества, которые делают нас уникальными</p>
                <div class="advantages-grid">
                    <div class="advantage-item">
                        <div class="advantage-icon"><i class="fas fa-building-columns"></i></div>
                        <h4>База ведущего колледжа</h4>
                        <p>Доступ к реальному оборудованию, мастерским и экспертизе педагогов-практиков.</p>
                    </div>
                    <div class="advantage-item">
                        <div class="advantage-icon"><i class="fas fa-gamepad"></i></div>
                        <h4>Интерактив и игра</h4>
                        <p>Скучные лекции остались в прошлом. Только практика, действие и вовлечение.</p>
                    </div>
                    <div class="advantage-item">
                        <div class="advantage-icon"><i class="fas fa-briefcase"></i></div>
                        <h4>Широкий спектр профессий</h4>
                        <p>От IT и дизайна до помощника руководителя.</p>
                    </div>
                    <div class="advantage-item">
                        <div class="advantage-icon"><i class="fas fa-handshake"></i></div>
                        <h4>Связь с работодателями</h4>
                        <p>Прямой диалог с компаниями-партнерами, которые ждут молодые кадры.</p>
                    </div>
                    <div class="advantage-item">
                        <div class="advantage-icon"><i class="fas fa-shield-alt"></i></div>
                        <h4>Безопасная среда</h4>
                        <p>Все активности проходят под чутким руководством опытных наставников.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from "@inertiajs/vue3"

export default {
    name: 'AboutView',
    components: { Link },
    data() {
        return {
            historyItems: [
                { year: '2018 год', title: 'Открытие парка «Сфера»', description: 'Торжественное открытие мультимедийного парка профориентации на базе ГБПОУ «Нижегородский Губернский колледж».', icon: 'fas fa-flag-checkered' },
                { year: '2020 год', title: 'Проект «Самый главный колледж»', description: 'Запуск масштабного профориентационного проекта для школьников Нижегородской области.', icon: 'fas fa-rocket' },
                { year: '2024 год', title: 'Проект «Великие традиции - новые технологии»', description: 'Обновление материально-технической базы, внедрение VR/AR технологий в профориентацию.', icon: 'fas fa-vr-cardboard' },
                { year: '2025 год', title: 'Проект «Вселенная Нижегородский Губернский колледж»', description: 'Создание единой цифровой экосистемы профориентации.', icon: 'fas fa-globe' }
            ],
            importanceReasons: [
                { id: 1, icon: 'fas fa-compass', title: 'Осознанный выбор', text: '8-11 класс — время формирования профессиональной идентичности. Важно дать подростку возможность «примерить» на себя разные роли.' },
                { id: 2, icon: 'fas fa-shield-alt', title: 'Борьба со страхами', text: 'Непонимание сути профессии рождает мифы. Прямой контакт с инструментами и специалистами развеивает сомнения.' },
                { id: 3, icon: 'fas fa-rocket', title: 'Мотивация к учебе', text: 'Когда подросток видит цель — «я хочу стать специалистом», — появляется мощная мотивация для углубленного изучения школьных предметов.' },
                { id: 4, icon: 'fas fa-coins', title: 'Экономия ресурсов', text: 'Гораздо дешевле «поэкспериментировать» с профессией на пробе, чем понять, что это «не твое», уже на втором курсе вуза или колледжа.' }
            ]
        }
    },
    mounted() {
        this.initScrollAnimation()
    },
    methods: {
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
.container {
    max-width: 1062px;
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
.hero-about {
    padding: 40px 0;
    margin-bottom: 20px;
}
.hero-content { text-align: center; }
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
    max-width: 600px;
    margin: 0 auto;
}
.mission-section {
    text-align: center;
    padding: 40px;
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(12px);
    border-radius: 30px;
    margin-bottom: 40px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 0 15px rgba(10, 45, 143, 0.4), 0 0 30px rgba(10, 45, 143, 0.2), 0 0 50px rgba(10, 45, 143, 0.1), 0 4px 15px rgba(0, 0, 0, 0.2);
}
.mission-icon {
    font-size: 48px;
    background: linear-gradient(135deg, #E2E8F0, #94A3B8);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    margin-bottom: 20px;
}
.mission-section h2 {
    font-size: 28px;
    font-family: "Comfortaa";
    color: white;
    margin-bottom: 16px;
}
.mission-section p {
    font-size: 18px;
    line-height: 1.6;
    color: rgba(255, 255, 255, 0.85);
    max-width: none;
    margin: 0 auto;
}
.about-text-card {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(12px);
    border-radius: 24px;
    padding: 40px;
    margin-bottom: 40px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 0 15px rgba(10, 45, 143, 0.4), 0 0 30px rgba(10, 45, 143, 0.2), 0 0 50px rgba(10, 45, 143, 0.1), 0 4px 15px rgba(0, 0, 0, 0.2);
}
.about-text-card p {
    font-size: 18px;
    line-height: 1.6;
    color: rgba(255, 255, 255, 0.85);
    margin-bottom: 20px;
}
.about-text-card p:last-child { margin-bottom: 0; }

/* ========== ЧТО ЖДЕТ ГОСТЕЙ ========== */
.guests-section {
    padding: 40px;
    margin-bottom: 40px;
    border-radius: 24px;
}
.guests-section h2 {
    font-size: clamp(26px, 4vw, 36px);
    font-family: "Comfortaa";
    color: white;
    text-align: center;
    margin-bottom: 12px;
}
.guests-section .highlight {
    background: linear-gradient(135deg, #E2E8F0, #FFFFFF);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
.guests-intro {
    text-align: center;
    font-size: 18px;
    color: white;
    margin-bottom: 32px;
}
.guests-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}
.guest-item {
    display: flex;
    gap: 16px;
    padding: 20px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.06);
    transition: all 0.3s ease;
}
.guest-item:hover {
    background: rgba(255, 255, 255, 0.08);
    transform: translateY(-3px);
}
.guest-icon {
    width: 50px;
    height: 50px;
    min-width: 50px;
    background: rgba(226, 232, 240, 0.15);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    background: linear-gradient(135deg, #E2E8F0, #94A3B8);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
.guest-text h4 {
    font-size: 16px;
    color: white;
    margin-bottom: 6px;
}
.guest-text p {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.85);
    line-height: 1.5;
}
.guest-text ul {
    list-style: none;
    padding: 0;
    margin: 0;
}
.guest-text ul li {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.85);
    padding: 4px 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.guest-text ul li i {
    font-size: 12px;
    background: linear-gradient(135deg, #E2E8F0, #94A3B8);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

/* ========== УНИКАЛЬНОСТЬ ========== */
.unique-section {
    padding: 40px;
    margin-bottom: 40px;
    border-radius: 24px;
}
.unique-header {
    display: flex;
    align-items: center;
    gap: 14px;
    justify-content: center;
    margin-bottom: 16px;
}
.unique-badge {
    width: 40px;
    height: 40px;
    background: rgba(226, 232, 240, 0.15);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    background: linear-gradient(135deg, #E2E8F0, #94A3B8);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
.unique-section h2 {
    font-size: clamp(26px, 4vw, 36px);
    font-family: "Comfortaa";
    color: white;
    text-align: center;
}
.unique-section .highlight {
    background: linear-gradient(135deg, #E2E8F0, #FFFFFF);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
.unique-section h3 {
    text-align: center;
    font-size: 22px;
    color: #E2E8F0;
    margin-bottom: 16px;
    font-family: "Comfortaa";
}
.unique-fact {
    text-align: center;
    font-size: 16px;
    color: rgba(255, 255, 255, 0.85);
    max-width: 800px;
    margin: 0 auto 30px;
    line-height: 1.6;
}
.unique-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}
.unique-item {
    text-align: center;
    padding: 24px 16px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.06);
    transition: all 0.3s ease;
}
.unique-item:hover {
    background: rgba(255, 255, 255, 0.08);
    transform: translateY(-3px);
}
.unique-icon {
    font-size: 28px;
    margin-bottom: 12px;
    background: linear-gradient(135deg, #E2E8F0, #94A3B8);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
.unique-item h4 {
    font-size: 16px;
    color: white;
    margin-bottom: 8px;
}
.unique-item p {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.85);
    line-height: 1.5;
}

/* ========== ИСТОРИЯ ========== */
.history-header {
    text-align: center;
    margin-bottom: 48px;
}
.history-header h2 {
    font-size: clamp(28px, 4vw, 38px);
    font-family: "Comfortaa";
    color: white;
    margin-bottom: 12px;
}
.history-header .highlight {
    background: linear-gradient(135deg, #E2E8F0, #FFFFFF);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
.history-header p { font-size: 18px; color: white; }
.history-timeline { margin-bottom: 60px; }
.timeline-item { display: flex; gap: 24px; margin-bottom: 0; }
.timeline-marker {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 60px;
    flex-shrink: 0;
}
.marker-dot {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #0A2D8F, #030D29);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2;
    transition: all 0.35s ease-in-out;
    border: 1px solid rgba(255,255,255,0.2);
    box-shadow: 0 0 15px rgba(10, 45, 143, 0.4);
}
.marker-dot i { color: white; font-size: 20px; }
.marker-line {
    width: 2px;
    flex: 1;
    background: linear-gradient(180deg, rgba(226,232,240,0.5), rgba(148,163,184,0.2));
    margin: 8px 0;
}
.timeline-content {
    flex: 1;
    padding-bottom: 40px;
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(12px);
    border-radius: 20px;
    padding: 20px 24px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 0 15px rgba(10, 45, 143, 0.4), 0 0 30px rgba(10, 45, 143, 0.2), 0 0 50px rgba(10, 45, 143, 0.1), 0 4px 15px rgba(0, 0, 0, 0.2);
}
.timeline-year {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 16px;
    background: rgba(10, 45, 143, 0.6);
    backdrop-filter: blur(8px);
    color: white;
    border-radius: 30px;
    font-size: 14px;
    margin-bottom: 12px;
    border: 1px solid rgba(255,255,255,0.15);
}
.timeline-year i { font-size: 12px; }
.timeline-content h3 {
    font-size: 20px;
    font-family: "Comfortaa";
    color: white;
    margin-bottom: 8px;
}
.timeline-content p { color: rgba(255, 255, 255, 0.85); line-height: 1.5; }

/* ========== ПОЧЕМУ ВАЖНА ПРОФОРИЕНТАЦИЯ ========== */
.importance-header {
    text-align: center;
    margin-bottom: 48px;
}
.importance-header h2 {
    font-size: clamp(28px, 4vw, 38px);
    font-family: "Comfortaa";
    color: white;
    margin-bottom: 12px;
}
.importance-header .highlight {
    background: linear-gradient(135deg, #E2E8F0, #FFFFFF);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
.importance-header p { font-size: 18px; color: white; }
.importance-grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 24px;
    margin-bottom: 40px;
}
.importance-card {
    flex: 0 0 auto;
    width: 260px;
    text-align: center;
    padding: 30px 24px;
    background: rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 20px;
    transition: all 0.35s ease-in-out;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15), 0 0 15px rgba(10, 45, 143, 0.3), 0 0 30px rgba(10, 45, 143, 0.15);
}
.importance-card:hover {
    transform: translateY(-5px);
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.25);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25), 0 0 25px rgba(10, 45, 143, 0.5), 0 0 50px rgba(10, 45, 143, 0.3);
}

.importance-icon {
    width: 64px;
    height: 64px;
    background: rgba(226,232,240,0.15);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
    transition: all 0.35s ease-in-out;
    font-size: 28px;
}

.importance-icon i {
    background: linear-gradient(135deg, #E2E8F0, #94A3B8);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    transition: all 0.35s ease-in-out;
}

.importance-card:hover .importance-icon {
    background: rgba(226,232,240,0.25);
}

.importance-card:hover .importance-icon i {
    background: white;
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

.importance-title {
    font-size: 18px;
    font-family: "Comfortaa";
    color: white;
    margin-bottom: 8px;
}
.importance-card p {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.9);
    line-height: 1.5;
}

/* ========== КТО НАШИ ГОСТИ ========== */
.guests-audience {
    padding: 40px;
    margin-bottom: 40px;
    border-radius: 24px;
}
.guests-audience h2 {
    font-size: clamp(26px, 4vw, 36px);
    font-family: "Comfortaa";
    color: white;
    text-align: center;
    margin-bottom: 12px;
}
.guests-audience .highlight {
    background: linear-gradient(135deg, #E2E8F0, #FFFFFF);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
.audience-intro {
    text-align: center;
    font-size: 18px;
    color: white;
    margin-bottom: 30px;
}
.audience-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
    margin-bottom: 20px;
}
.audience-item {
    text-align: center;
    padding: 24px 16px;
    background: rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(8px);
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.15);
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}
.audience-item:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
}
.audience-icon {
    font-size: 32px;
    margin-bottom: 12px;
    background: linear-gradient(135deg, #E2E8F0, #94A3B8);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
.audience-item p {
    font-size: 15px;
    color: rgba(255, 255, 255, 0.9);
    line-height: 1.5;
}
.audience-additional {
    text-align: center;
    font-size: 16px;
    color: rgba(255, 255, 255, 0.85);
    padding-top: 16px;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
}
.audience-additional strong {
    color: #E2E8F0;
}

/* ========== ПРЕИМУЩЕСТВА ========== */
.advantages-section {
    padding: 40px;
    margin-bottom: 40px;
    border-radius: 24px;
}
.advantages-section h2 {
    font-size: clamp(26px, 4vw, 36px);
    font-family: "Comfortaa";
    color: white;
    text-align: center;
    margin-bottom: 8px;
}
.advantages-section .highlight {
    background: linear-gradient(135deg, #E2E8F0, #FFFFFF);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
.advantages-subtitle {
    text-align: center;
    font-size: 18px;
    color: white;
    margin-bottom: 30px;
}
.advantages-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 20px;
}
.advantage-item {
    text-align: center;
    padding: 20px 12px;
    background: rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(8px);
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.15);
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}
.advantage-item:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
}
.advantage-icon {
    font-size: 28px;
    margin-bottom: 10px;
    background: linear-gradient(135deg, #E2E8F0, #94A3B8);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
.advantage-item h4 {
    font-size: 14px;
    color: white;
    margin-bottom: 6px;
}
.advantage-item p {
    font-size: 12px;
    color: rgba(255, 255, 255, 0.85);
    line-height: 1.4;
}

/* ========== АНИМАЦИЯ ========== */
.section-animate {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.6s ease, transform 0.6s ease;
}
.section-animate.visible {
    opacity: 1;
    transform: translateY(0);
}
.glass-card {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 0 15px rgba(10, 45, 143, 0.4), 0 0 30px rgba(10, 45, 143, 0.2), 0 0 50px rgba(10, 45, 143, 0.1), 0 4px 15px rgba(0, 0, 0, 0.2);
}

/* ========== АДАПТИВ ========== */
@media (max-width: 992px) {
    .guests-grid { grid-template-columns: 1fr; }
    .unique-grid { grid-template-columns: 1fr; }
    .advantages-grid { grid-template-columns: repeat(3, 1fr); }
    .audience-grid { grid-template-columns: 1fr; }
}
@media (max-width: 768px) {
    .hero-about { padding: 30px 0; }
    .hero-content p { font-size: 16px; }
    .mission-section { padding: 30px 20px; }
    .mission-section p { font-size: 16px; }
    .about-text-card { padding: 24px; }
    .about-text-card p { font-size: 16px; }
    .timeline-marker { width: 40px; }
    .marker-dot { width: 36px; height: 36px; }
    .marker-dot i { font-size: 16px; }
    .timeline-content h3 { font-size: 18px; }
    .timeline-content p { font-size: 14px; }
    .guests-section { padding: 24px; }
    .unique-section { padding: 24px; }
    .guests-audience { padding: 24px; }
    .advantages-section { padding: 24px; }
    .importance-grid { gap: 16px; }
    .importance-card { width: calc(50% - 16px); padding: 24px 16px; }
    .advantages-grid { grid-template-columns: repeat(2, 1fr); }
    .guest-item { flex-direction: column; align-items: center; text-align: center; }
    .unique-section h3 { font-size: 18px; }
}
@media (max-width: 480px) {
    .importance-card { width: 100%; }
    .advantages-grid { grid-template-columns: 1fr; }
    .timeline-item { flex-direction: column; gap: 12px; }
    .timeline-marker { flex-direction: row; width: 100%; }
    .marker-line { display: none; }
    .marker-dot { margin-right: 16px; }
}
</style>
