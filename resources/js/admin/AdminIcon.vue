<template>
    <i :class="`fas fa-${name}`" :style="{ fontSize: size + 'px' }"></i>
</template>

<script setup>
defineProps({
    name: {
        type: String,
        required: true
    },
    size: {
        type: Number,
        default: 16
    }
})
</script>
