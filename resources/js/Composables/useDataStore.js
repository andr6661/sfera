const API_URL = '/api'

async function fetchApi(endpoint, options = {}) {
    const response = await fetch(`${API_URL}${endpoint}`, {
        headers: { 'Content-Type': 'application/json' },
        ...options
    })
    return response.json()
}

function parseJsonField(field, defaultValue = []) {
    if (!field) return defaultValue
    if (typeof field === 'object') return field
    try { return JSON.parse(field) } catch { return defaultValue }
}

export function useDataStore() {
    const uploadImage = async (file) => {
        const formData = new FormData()
        formData.append('img', file)

        const response = await fetch('/api/upload-image', {
            method: 'POST',
            body: formData
        })

        const result = await response.json()
        if (result.success) {
            // Убираем возможный дубль /img//
            result.path = result.path.replace('/img//', '/')
        }
        return result
    }

    const getDirections = async () => {
        const data = await fetchApi('/data')
        return (data.directions || []).map(dir => ({
            ...dir,
            details: parseJsonField(dir.details, []),
            image: dir.image ? dir.image.replace('/img//', '/') : null,
            imageUrl: dir.image ? dir.image.replace('/img//', '/') : null
        }))
    }

    const saveDirections = async (directions) => {
        return fetchApi('/directions', {
            method: 'POST',
            body: JSON.stringify(directions)
        })
    }

    const getEvents = async () => {
        const data = await fetchApi('/data')
        return (data.events || []).map(event => ({
            ...event,
            fullDesc: parseJsonField(event.fullDesc, []),
            // ========== ЕДИНСТВЕННОЕ ИЗМЕНЕНИЕ: ПОДДЕРЖКА dateString ==========
            dateString: event.dateString || '',  // <--- читаем новое поле
            // ========== КОНЕЦ ИЗМЕНЕНИЯ ==========
            image: event.image ? event.image.replace('/img//', '/') : null,
            imageUrl: event.image ? event.image.replace('/img//', '/') : null
        }))
    }

    const saveEvents = async (events) => {
        return fetchApi('/events', {
            method: 'POST',
            body: JSON.stringify(events)
        })
    }

    const getStatistics = async () => {
        const data = await fetchApi('/data')
        return {
            case1: data.statistics?.case1 || { value: 0, title: '' },
            case2: data.statistics?.case2 || { value: 0, title: '' },
            case3: data.statistics?.case3 || { value: 0, title: '' }
        }
    }

    const updateStatistics = async (key, value, title) => {
        const stats = await getStatistics()
        stats[key] = { value, title }
        return fetchApi('/statistics', { method: 'POST', body: JSON.stringify(stats) })
    }

    const getHomeTexts = async () => {
        const data = await fetchApi('/data')
        return {
            heroText: data.homeTexts?.heroText || '',
            aboutTitle: data.homeTexts?.aboutTitle || '',
            aboutText: data.homeTexts?.aboutText || '',
            footerCopyright: data.homeTexts?.footerCopyright || '',
            footerEmail: data.homeTexts?.footerEmail || ''
        }
    }

    const updateHomeText = async (key, value) => {
        const texts = await getHomeTexts()
        texts[key] = value
        return fetchApi('/home-texts', { method: 'POST', body: JSON.stringify(texts) })
    }

    const getContacts = async () => {
        const data = await fetchApi('/data')
        return {
            phone: data.contacts?.phone || '',
            email: data.contacts?.email || '',
            address: data.contacts?.address || '',
            workHours: data.contacts?.workHours || '',
            howToGet: {
                metro: data.contacts?.howToGet?.metro || '',
                buses: data.contacts?.howToGet?.buses || '',
                parking: data.contacts?.howToGet?.parking || ''
            }
        }
    }

    const updateContact = async (key, value) => {
        const contacts = await getContacts()
        if (key.includes('.')) {
            const [parent, child] = key.split('.')
            if (!contacts[parent]) contacts[parent] = {}
            contacts[parent][child] = value
        } else {
            contacts[key] = value
        }
        const apiData = {
            phone: contacts.phone,
            email: contacts.email,
            address: contacts.address,
            workHours: contacts.workHours,
            'howToGet.metro': contacts.howToGet?.metro,
            'howToGet.buses': contacts.howToGet?.buses,
            'howToGet.parking': contacts.howToGet?.parking
        }
        return fetchApi('/contacts', { method: 'POST', body: JSON.stringify(apiData) })
    }

    const exportData = async () => {
        const data = await fetchApi('/data')
        const blob = new Blob([JSON.stringify(data, null, 2)], { type: 'application/json' })
        const url = URL.createObjectURL(blob)
        const link = document.createElement('a')
        link.href = url
        link.download = 'sfera-backup.json'
        link.click()
        URL.revokeObjectURL(url)
    }

    return {
        uploadImage,
        getDirections, saveDirections,
        getEvents, saveEvents,
        getStatistics, updateStatistics,
        getHomeTexts, updateHomeText,
        getContacts, updateContact,
        exportData
    }
}
