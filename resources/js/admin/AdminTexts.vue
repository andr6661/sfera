<template>
    <div class="admin-texts">
        <div class="section-header">
            <h3><AdminIcon name="edit" :size="18" /> Управление текстами на главной странице</h3>
            <p class="texts-hint">
                <AdminIcon name="info-circle" :size="12" />
                Изменения сохраняются автоматически при нажатии на "Сохранить все изменения" в главной панели
            </p>
        </div>

        <div class="texts-list">
            <div class="text-item">
                <label><AdminIcon name="heading" :size="12" /> Hero-блок (главный текст)</label>
                <textarea v-model="edits.heroText" rows="3" placeholder="Найди своё призвание в парке «Сфера»"></textarea>
                <small class="hint">Используйте &lt;span class=&quot;highlight-hero&quot;&gt;текст&lt;/span&gt; для выделения слова</small>
            </div>

            <div class="text-item">
                <label><AdminIcon name="header" :size="12" /> Заголовок блока "О парке"</label>
                <input type="text" v-model="edits.aboutTitle" placeholder="Введите заголовок">
            </div>

            <div class="text-item">
                <label><AdminIcon name="align-left" :size="12" /> Текст блока "О парке"</label>
                <textarea v-model="edits.aboutText" rows="4" placeholder="Введите описание парка"></textarea>
            </div>

            <div class="text-item">
                <label><AdminIcon name="copyright" :size="12" /> Копирайт в футере</label>
                <input type="text" v-model="edits.footerCopyright" placeholder="© 2026 ...">
            </div>

            <div class="text-item">
                <label><AdminIcon name="envelope" :size="12" /> Email в футере</label>
                <input type="email" v-model="edits.footerEmail" placeholder="email@example.com">
            </div>
        </div>

        <div class="preview">
            <h4><AdminIcon name="eye" :size="14" /> Предпросмотр:</h4>
            <div class="preview-block">
                <div class="hero-preview">
                    <strong><AdminIcon name="star" :size="12" /> Hero текст:</strong>
                    <div class="hero-preview-content" v-html="edits.heroText || 'Текст не задан'"></div>
                </div>
                <div class="about-preview">
                    <strong><AdminIcon name="info-circle" :size="12" /> Блок "О парке":</strong>
                    <h5>{{ edits.aboutTitle || 'Заголовок не задан' }}</h5>
                    <p>{{ edits.aboutText || 'Текст не задан' }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted, watch } from 'vue'
import { useDataStore } from '../composables/useDataStore'
import AdminIcon from './AdminIcon.vue'

export default {
    name: 'AdminTexts',
    components: { AdminIcon },
    emits: ['has-changes', 'save-complete'],
    setup(props, { emit }) {
        const { getHomeTexts, updateHomeText } = useDataStore()

        const originalData = ref(null)
        const hasChanges = ref(false)
        const edits = ref({
            heroText: '',
            aboutTitle: '',
            aboutText: '',
            footerCopyright: '',
            footerEmail: ''
        })

        const loadTexts = async () => {
            const texts = await getHomeTexts()
            edits.value = {
                heroText: texts.heroText || 'Найди своё <span class="highlight-hero">призвание</span> в парке «Сфера»',
                aboutTitle: texts.aboutTitle || 'О мультимедийном парке "Сфера"',
                aboutText: texts.aboutText || 'Сфера — это инновационное пространство, где школьники могут познакомиться с современными профессиями в интерактивном формате. VR-тренажеры, профпробы, квесты и мастер-классы помогут тебе найти свой путь!',
                footerCopyright: texts.footerCopyright || '© 2026 ГБПОУ Нижегородский Губернский колледж',
                footerEmail: texts.footerEmail || 'sfera@ngknn.ru'
            }
            originalData.value = JSON.parse(JSON.stringify(edits.value))
        }

        const checkChanges = () => {
            const currentStr = JSON.stringify(edits.value)
            const originalStr = JSON.stringify(originalData.value)
            const newHasChanges = currentStr !== originalStr
            if (hasChanges.value !== newHasChanges) {
                hasChanges.value = newHasChanges
                emit('has-changes', { tabId: 'texts', hasChanges: hasChanges.value })
            }
        }

        watch(edits, () => {
            checkChanges()
        }, { deep: true })

        const saveData = async () => {
            await updateHomeText('heroText', edits.value.heroText)
            await updateHomeText('aboutTitle', edits.value.aboutTitle)
            await updateHomeText('aboutText', edits.value.aboutText)
            await updateHomeText('footerCopyright', edits.value.footerCopyright)
            await updateHomeText('footerEmail', edits.value.footerEmail)

            await loadTexts()
            originalData.value = JSON.parse(JSON.stringify(edits.value))
            hasChanges.value = false
            emit('has-changes', { tabId: 'texts', hasChanges: false })
            emit('save-complete', 'texts')
        }

        onMounted(() => {
            loadTexts()
        })

        return {
            edits,
            saveData
        }
    }
}
</script>

<style scoped>
.admin-texts {
    width: 100%;
}

.section-header {
    margin-bottom: 20px;
}

.section-header h3 {
    margin: 0 0 8px 0;
    font-size: 18px;
    color: #23519D;
    display: flex;
    align-items: center;
    gap: 8px;
}

.texts-hint {
    font-size: 12px;
    color: #888;
    margin: 0;
    padding: 8px 12px;
    background: #f0f7ff;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.texts-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin-bottom: 30px;
}

.text-item {
    display: flex;
    flex-direction: column;
    gap: 8px;
    padding: 16px;
    background: #f8f9fc;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.text-item:hover {
    background: #e8eef4;
}

.text-item label {
    font-weight: 600;
    color: #23519D;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.text-item input,
.text-item textarea {
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
    font-family: inherit;
    width: 100%;
    box-sizing: border-box;
    transition: all 0.3s ease;
}

.text-item input:focus,
.text-item textarea:focus {
    outline: none;
    border-color: #23519D;
    box-shadow: 0 0 0 2px rgba(35, 81, 157, 0.1);
}

.text-item textarea {
    resize: vertical;
}

.hint {
    font-size: 11px;
    color: #888;
    margin-top: 4px;
}

.preview {
    padding: 20px;
    background: #f8f9fc;
    border-radius: 16px;
}

.preview h4 {
    margin: 0 0 16px 0;
    color: #23519D;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.preview-block {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.hero-preview, .about-preview {
    padding: 16px;
    background: white;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.hero-preview:hover, .about-preview:hover {
    transform: translateX(5px);
    box-shadow: 0 4px 12px rgba(35, 81, 157, 0.1);
}

.hero-preview strong, .about-preview strong {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 8px;
    color: #23519D;
    font-size: 13px;
}

.hero-preview-content {
    font-size: 16px;
    font-weight: 500;
    color: #333;
    line-height: 1.4;
}

.hero-preview-content :deep(.highlight-hero) {
    background: linear-gradient(135deg, #23519D, #4B93D7);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    font-weight: bold;
}

.about-preview h5 {
    margin: 0 0 8px 0;
    color: #23519D;
    font-size: 16px;
    font-weight: 600;
}

.about-preview p {
    margin: 0;
    color: #333;
    font-size: 14px;
    line-height: 1.5;
}

@media (max-width: 768px) {
    .texts-hint {
        font-size: 11px;
    }
    .preview-block {
        gap: 16px;
    }
    .hero-preview, .about-preview {
        padding: 12px;
    }
    .hero-preview-content {
        font-size: 14px;
    }
}
</style>
