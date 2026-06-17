import { ref, computed } from 'vue'

export function useAdmin() {
    // Просто работаем с localStorage напрямую
    const getStorage = (key, defaultValue = null) => {
        const data = localStorage.getItem(key)
        if (data === null) return defaultValue
        try {
            return JSON.parse(data)
        } catch (e) {
            return data
        }
    }

    const setStorage = (key, value) => {
        const data = typeof value === 'object' ? JSON.stringify(value) : value
        localStorage.setItem(key, data)
    }

    const removeStorage = (key) => {
        localStorage.removeItem(key)
    }

    const isAdmin = ref(getStorage('isAdmin', false))

    const login = (login, password) => {
        if (login === 'admin' && password === 'admin') {
            setStorage('isAdmin', true)
            isAdmin.value = true
            return true
        }
        return false
    }

    const logout = () => {
        removeStorage('isAdmin')
        isAdmin.value = false
    }

    const canEdit = computed(() => isAdmin.value)

    return { isAdmin, login, logout, canEdit }
}
