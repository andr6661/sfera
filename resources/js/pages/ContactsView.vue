<template>
    <div>
        <div class="container">
            <div class="breadcrumbs">
                <Link href="/">Главная</Link>
                <span class="separator">—</span>
                <span class="current">Контакты</span>
            </div>
        </div>

        <!-- Hero секция -->
        <div class="hero-contacts">
            <div class="container">
                <div class="hero-content">
                    <h1>Наши <span class="highlight">контакты</span></h1>
                    <p>Свяжитесь с нами любым удобным способом</p>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="contacts-wrapper">
                <!-- Контактная информация -->
                <div class="contacts-info">
                    <div class="contact-card glass-card">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-details">
                            <h3>Адрес</h3>
                            <p>{{ contacts.address }}</p>
                        </div>
                    </div>

                    <div class="contact-card glass-card">
                        <div class="contact-icon">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div class="contact-details">
                            <h3>Телефон</h3>
                            <p>{{ contacts.phone }}</p>
                        </div>
                    </div>

                    <div class="contact-card glass-card">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-details">
                            <h3>E-mail</h3>
                            <p>{{ contacts.email }}</p>
                        </div>
                    </div>

                    <div class="contact-card glass-card">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-details">
                            <h3>Режим работы</h3>
                            <p>{{ contacts.workHours }}</p>
                        </div>
                    </div>
                </div>

                <!-- Карта -->
                <div class="map-section glass-card">
                    <div class="map-container">
                        <iframe
                            src="https://yandex.ru/map-widget/v1/?um=constructor%3A0531225cb53ab3491d1b1032a8324eae6d0cf6583cff5a8f2ee9e16838606f74&amp;source=constructor"
                            width="100%"
                            height="400"
                            frameborder="0"
                            allowfullscreen
                        ></iframe>
                    </div>
                    <div class="map-buttons">
                        <a :href="`https://yandex.ru/maps/?text=${encodeURIComponent(contacts.address)}`" target="_blank" class="map-btn">
                            <i class="fas fa-external-link-alt"></i>
                            Открыть в Яндекс Картах
                        </a>
                    </div>
                </div>

                <!-- Как добраться -->
                <div class="how-to-get glass-card">
                    <h2>Как добраться</h2>
                    <div class="transport-grid">
                        <div class="transport-card">
                            <div class="transport-icon">
                                <i class="fas fa-subway"></i>
                            </div>
                            <div class="transport-text">
                                <strong>Метро</strong>
                                <p>{{ contacts.howToGet?.metro || 'станция "Московская" — 10 минут пешком' }}</p>
                            </div>
                        </div>
                        <div class="transport-card">
                            <div class="transport-icon">
                                <i class="fas fa-bus"></i>
                            </div>
                            <div class="transport-text">
                                <strong>Автобусы</strong>
                                <p>{{ contacts.howToGet?.buses || '№1, 3, 5, 10, 25 — остановка "Московское шоссе"' }}</p>
                            </div>
                        </div>
                        <div class="transport-card">
                            <div class="transport-icon">
                                <i class="fas fa-car"></i>
                            </div>
                            <div class="transport-text">
                                <strong>Парковка</strong>
                                <p>{{ contacts.howToGet?.parking || 'Бесплатная парковка на территории колледжа' }}</p>
                            </div>
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
    name: 'ContactsView',
    components: { Link },
    data() {
        return {
            contacts: {
                phone: '',
                email: '',
                address: '',
                workHours: '',
                howToGet: { metro: '', buses: '', parking: '' }
            }
        }
    },
    async mounted() {
        await this.loadContacts()
    },
    methods: {
        async loadContacts() {
            const { getContacts } = useDataStore()
            const data = await getContacts()
            this.contacts = {
                phone: data.phone || '+7 (831) 218-22-12',
                email: data.email || 'sfera@ngknn.ru',
                address: data.address || '603116 Нижний Новгород, Московское шоссе, 1',
                workHours: data.workHours || 'Пн-Пт: 9:00 - 18:00, Сб: 10:00 - 15:00',
                howToGet: {
                    metro: data.howToGet?.metro || 'станция "Московская" — 10 минут пешком',
                    buses: data.howToGet?.buses || '№1, 3, 5, 10, 25 — остановка "Московское шоссе"',
                    parking: data.howToGet?.parking || 'Бесплатная парковка на территории колледжа'
                }
            }
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
.hero-contacts { text-align: center; margin-bottom: 40px; }
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
.hero-content p { font-size: 18px; color: white; }
.contacts-wrapper { display: flex; flex-direction: column; gap: 40px; }
.contacts-info {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
}
.contact-card {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 20px;
    padding: 24px;
    text-align: center;
    transition: all 0.35s ease;
    box-shadow: 0 0 15px rgba(10, 45, 143, 0.4), 0 0 30px rgba(10, 45, 143, 0.2), 0 0 50px rgba(10, 45, 143, 0.1), 0 4px 15px rgba(0, 0, 0, 0.2);
}
.contact-card:hover {
    transform: translateY(-5px);
    background: rgba(255, 255, 255, 0.15);
    border-color: rgba(255, 255, 255, 0.25);
}
.contact-icon {
    width: 56px;
    height: 56px;
    background: rgba(226,232,240,0.15);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
    transition: all 0.35s ease-in-out;
}
.contact-icon i {
    font-size: 24px;
    background: linear-gradient(135deg, #E2E8F0, #94A3B8);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
.contact-card:hover .contact-icon { background: rgba(226,232,240,0.25); }
.contact-details h3 {
    font-size: 16px;
    color: white;
    margin-bottom: 8px;
}
.contact-details p { font-size: 14px; color: rgba(255, 255, 255, 0.85); line-height: 1.4; }
.map-section {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 0 15px rgba(10, 45, 143, 0.4), 0 0 30px rgba(10, 45, 143, 0.2), 0 0 50px rgba(10, 45, 143, 0.1), 0 4px 15px rgba(0, 0, 0, 0.2);
}
.map-container iframe { width: 100%; height: 400px; display: block; }
.map-buttons {
    padding: 16px 24px;
    background: rgba(0, 0, 0, 0.3);
    text-align: center;
}
.map-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 24px;
    background: rgba(255, 255, 255, 0.12);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #E2E8F0;
    text-decoration: none;
    border-radius: 30px;
    font-size: 14px;
    transition: all 0.35s ease;
}
.map-btn:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.35);
    transform: translateY(-2px);
    color: white;
    box-shadow: 0 0 15px rgba(10, 45, 143, 0.4);
}
.how-to-get {
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 24px;
    padding: 32px;
    box-shadow: 0 0 15px rgba(10, 45, 143, 0.4), 0 0 30px rgba(10, 45, 143, 0.2), 0 0 50px rgba(10, 45, 143, 0.1), 0 4px 15px rgba(0, 0, 0, 0.2);
}
.how-to-get h2 {
    font-size: 24px;
    font-family: "Comfortaa";
    color: white;
    text-align: center;
    margin-bottom: 24px;
}
.transport-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}
.transport-card {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 20px;
    border-radius: 16px;
    transition: all 0.35s ease;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.08);
}
.transport-card:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.2);
    transform: translateX(5px);
}
.transport-icon {
    width: 48px;
    height: 48px;
    background: rgba(226,232,240,0.15);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.transport-icon i {
    font-size: 20px;
    background: linear-gradient(135deg, #E2E8F0, #94A3B8);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
.transport-text strong {
    display: block;
    font-size: 16px;
    color: white;
    margin-bottom: 4px;
}
.transport-text p { font-size: 14px; color: rgba(255, 255, 255, 0.85); margin: 0; line-height: 1.4; }
@media (max-width: 1024px) {
    .contacts-info { grid-template-columns: repeat(2, 1fr); }
    .transport-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .container { padding: 15px; }
    .breadcrumbs { margin-bottom: 20px; font-size: 12px; }
    .hero-content p { font-size: 16px; }
    .contacts-info { grid-template-columns: 1fr; gap: 16px; }
    .transport-grid { grid-template-columns: 1fr; gap: 16px; }
    .transport-card:hover { transform: translateX(0); }
    .how-to-get { padding: 24px; }
    .how-to-get h2 { font-size: 20px; }
    .map-container iframe { height: 300px; }
}
</style>
