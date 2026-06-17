<template>
    <div class="app-icon" :class="sizeClass" :data-hover="parentHover">
        <i :class="`fas fa-${name}`"></i>
    </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    name: { type: String, required: true },
    size: { type: String, default: 'md' },
    parentHover: { type: Boolean, default: false }
})

const sizeClass = computed(() => {
    switch(props.size) {
        case 'sm': return 'icon-sm'
        case 'lg': return 'icon-lg'
        case 'xl': return 'icon-xl'
        default: return 'icon-md'
    }
})
</script>

<style scoped>
.app-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 20px;
    transition: all 0.35s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.app-icon i {
    color: white;
    font-size: inherit;
    transition: all 0.35s ease;
}

/* ПРИ НАВЕДЕНИИ — просто светлее, БЕЗ ГРАДИЕНТА */
.app-icon[data-hover="true"] {
    background: rgba(255, 255, 255, 0.25);
    border-color: rgba(255, 255, 255, 0.4);
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 0 15px rgba(10, 45, 143, 0.4);
}

.app-icon[data-hover="true"] i {
    color: white;
}

/* Размеры */
.icon-sm { width: 36px; height: 36px; font-size: 18px; border-radius: 14px; }
.icon-md { width: 48px; height: 48px; font-size: 22px; border-radius: 16px; }
.icon-lg { width: 64px; height: 64px; font-size: 28px; border-radius: 20px; }
.icon-xl { width: 80px; height: 80px; font-size: 36px; border-radius: 24px; }
</style>
