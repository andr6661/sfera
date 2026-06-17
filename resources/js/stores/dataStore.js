import { reactive } from 'vue'
import { useDataStore as useApiDataStore } from '@/composables/useDataStore'

const state = reactive({
    directions: [],
    events: [],
    statistics: null,
    homeTexts: null,
    contacts: null,
    loaded: false,
    loading: false
})

let loadPromise = null

export function useGlobalDataStore() {
    const api = useApiDataStore()

    const loadAllData = async () => {
        if (state.loaded) return
        if (loadPromise) return loadPromise

        state.loading = true
        loadPromise = (async () => {
            try {
                const [directions, events, statistics, homeTexts, contacts] = await Promise.all([
                    api.getDirections(),
                    api.getEvents(),
                    api.getStatistics(),
                    api.getHomeTexts(),
                    api.getContacts()
                ])
                state.directions = directions
                state.events = events
                state.statistics = statistics
                state.homeTexts = homeTexts
                state.contacts = contacts
                state.loaded = true
            } catch (error) {
                console.error('Ошибка загрузки данных:', error)
            } finally {
                state.loading = false
                loadPromise = null
            }
        })()

        return loadPromise
    }

    const getDirections = () => state.directions
    const getEvents = () => state.events
    const getStatistics = () => state.statistics
    const getHomeTexts = () => state.homeTexts
    const getContacts = () => state.contacts
    const isLoaded = () => state.loaded

    return {
        loadAllData,
        getDirections,
        getEvents,
        getStatistics,
        getHomeTexts,
        getContacts,
        isLoaded,
        state
    }
}
