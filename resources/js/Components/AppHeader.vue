<template>
    <header>
        <a href="/" class="logo-link">
            <img :src="logoSrc" alt="Сфера" class="logo">
        </a>

        <div class="links-header">
            <a href="/" :class="{ active: page.url === '/' }">Главная</a>
            <a href="/directions" :class="{ active: page.url === '/directions' }">Направления</a>
            <a href="/events" :class="{ active: page.url === '/events' }">Мероприятия</a>
            <a href="/about" :class="{ active: page.url === '/about' }">О нас</a>
            <a href="/contacts" :class="{ active: page.url === '/contacts' }">Контакты</a>
        </div>

        <div class="header-actions">
            <button class="burger-meny" @click="toggleMenu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>

        <div class="mobile-nav" :class="{ open: menuOpen }" @click="closeMenu">
            <div class="panel" @click.stop>
                <a href="/" @click="closeMenu" :class="{ active: page.url === '/' }">Главная</a>
                <a href="/directions" @click="closeMenu" :class="{ active: page.url === '/directions' }">Направления</a>
                <a href="/events" @click="closeMenu" :class="{ active: page.url === '/events' }">Мероприятия</a>
                <a href="/about" @click="closeMenu" :class="{ active: page.url === '/about' }">О нас</a>
                <a href="/contacts" @click="closeMenu" :class="{ active: page.url === '/contacts' }">Контакты</a>
            </div>
        </div>
    </header>
</template>

<script setup>
import { ref } from 'vue'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const menuOpen = ref(false)
const logoSrc = '/logo.svg'

const toggleMenu = () => {
    menuOpen.value = !menuOpen.value
    document.body.style.overflow = menuOpen.value ? 'hidden' : ''
}

const closeMenu = (e) => {
    if (e.target === e.currentTarget) {
        menuOpen.value = false
        document.body.style.overflow = ''
    }
}
</script>

<style scoped>
header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 40px;
    background: linear-gradient(135deg, #030D29 0%, #0A2D8F 50%, #030D29 100%);
    position: relative;
    z-index: 100;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}

.logo-link {
    display: flex;
    align-items: center;
    text-decoration: none;
}

.logo {
    width: 300px;
    height: auto;
    display: block;
    filter: brightness(0) invert(1);
}

.links-header {
    display: flex;
    gap: 40px;
    align-items: center;
}

.links-header a {
    font-size: 20px;
    font-family: "Comfortaa", sans-serif;
    font-weight: 500;
    padding: 12px 24px;
    transition: all 0.3s ease;
    cursor: pointer;
    color: rgba(255, 255, 255, 0.85);
    text-decoration: none;
    border-radius: 12px;
    position: relative;
}

.links-header a:hover {
    color: white;
    background: rgba(255, 255, 255, 0.1);
    transform: translateY(-2px);
}

.links-header a.active {
    color: white;
    font-weight: 600;
    background: linear-gradient(135deg, rgba(255,255,255,0.15), rgba(255,255,255,0.05));
}

.links-header a.active::after {
    content: '';
    position: absolute;
    bottom: 4px;
    left: 50%;
    transform: translateX(-50%);
    width: 30px;
    height: 2px;
    background: linear-gradient(90deg, #E2E8F0, #94A3B8);
    border-radius: 2px;
}

.header-actions {
    display: flex;
    align-items: center;
}

.burger-meny {
    display: none;
    flex-direction: column;
    justify-content: space-between;
    width: 40px;
    height: 40px;
    background: none;
    border: none;
    cursor: pointer;
}

.burger-meny span {
    width: 100%;
    height: 4px;
    border-radius: 4px;
    background-color: white;
    transition: all 0.3s ease;
}

.mobile-nav {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(4px);
    opacity: 0;
    pointer-events: none;
    transition: 0.3s;
    z-index: 999;
}

.mobile-nav.open {
    opacity: 1;
    pointer-events: auto;
}

.mobile-nav .panel {
    position: absolute;
    right: 0;
    top: 0;
    height: 100%;
    width: 300px;
    background: linear-gradient(135deg, #030D29 0%, #0A2D8F 50%, #030D29 100%);
    padding: 100px 24px 24px 24px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    transform: translateX(100%);
    transition: 0.3s;
    box-shadow: -5px 0 30px rgba(0, 0, 0, 0.4);
}

.mobile-nav.open .panel {
    transform: translateX(0);
}

.mobile-nav .panel a {
    font-family: "Comfortaa";
    font-size: 20px;
    color: rgba(255, 255, 255, 0.85);
    padding: 14px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: block;
    text-align: center;
    border-radius: 12px;
}

.mobile-nav .panel a:hover {
    background: rgba(255, 255, 255, 0.1);
    padding-left: 28px;
    color: white;
}

.mobile-nav .panel a.active {
    background: linear-gradient(135deg, rgba(255,255,255,0.15), rgba(255,255,255,0.05));
    font-weight: 600;
    padding-left: 28px;
    color: white;
}

@media (max-width: 1200px) {
    .links-header { gap: 24px; }
    .links-header a { font-size: 18px; padding: 10px 20px; }
}
@media (max-width: 1024px) {
    header { padding: 12px 24px; }
    .logo { width: 250px; }
    .links-header { gap: 16px; }
    .links-header a { font-size: 16px; padding: 8px 16px; }
}
@media (max-width: 768px) {
    header { padding: 12px 16px; }
    .links-header { display: none; }
    .burger-meny { display: flex; }
    .logo { width: 180px; }
}
</style>
