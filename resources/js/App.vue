<template>
    <div>
        <AppHeader v-if="!hideHeader" />
        <main>
            <slot />
        </main>
        <AppFooter v-if="!hideFooter" />
    </div>
</template>

<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import AppHeader from '@/Components/AppHeader.vue'
import AppFooter from '@/Components/AppFooter.vue'

const page = usePage()

// Скрываем хедер и футер на страницах админки
const hideHeader = computed(() => {
    return page.component === 'Admin/Dashboard'
})

const hideFooter = computed(() => {
    return page.component === 'Admin/Dashboard'
})
</script>
