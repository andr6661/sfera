<template>
    <div class="statistics-section" ref="sectionRef">
        <div class="container">
            <div class="stats-header">
                <h2 class="stats-title">Наши <span class="highlight">достижения</span></h2>
                <p class="stats-subtitle">Цифры, которыми мы гордимся</p>
            </div>

            <div class="stats-grid">
                <!-- Карточка 1 -->
                <div class="stat-card" :class="{ 'filled': filled.case1 }">
                    <div class="water-fill" :class="{ 'active': filled.case1 }"></div>
                    <div class="card-content">
                        <div class="circular-progress">
                            <div class="progress-circle">
                                <svg width="140" height="140" viewBox="0 0 140 140">
                                    <circle class="progress-bg" cx="70" cy="70" r="60" stroke="rgba(255,255,255,0.2)" stroke-width="8" fill="none"/>
                                    <circle class="progress-fill" cx="70" cy="70" r="60" stroke="url(#silverGrad)" stroke-width="8" fill="none"
                                            :stroke-dasharray="circumference" :stroke-dashoffset="progressOffset1"
                                            transform="rotate(-90 70 70)"/>
                                </svg>
                                <svg width="0" height="0">
                                    <defs>
                                        <linearGradient id="silverGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#E2E8F0"/>
                                            <stop offset="100%" stop-color="#94A3B8"/>
                                        </linearGradient>
                                    </defs>
                                </svg>
                                <div class="progress-content">
                                    <span class="progress-number">
                                        <span class="numberplus">{{ currentValues.case1 }}</span>
                                        <span class="plus">+</span>
                                    </span>
                                </div>
                            </div>
                            <h3 class="stat-title">{{ titles.case1 }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Карточка 2 -->
                <div class="stat-card" :class="{ 'filled': filled.case2 }">
                    <div class="water-fill" :class="{ 'active': filled.case2 }"></div>
                    <div class="card-content">
                        <div class="circular-progress">
                            <div class="progress-circle">
                                <svg width="140" height="140" viewBox="0 0 140 140">
                                    <circle class="progress-bg" cx="70" cy="70" r="60" stroke="rgba(255,255,255,0.2)" stroke-width="8" fill="none"/>
                                    <circle class="progress-fill" cx="70" cy="70" r="60" stroke="url(#silverGrad2)" stroke-width="8" fill="none"
                                            :stroke-dasharray="circumference" :stroke-dashoffset="progressOffset2"
                                            transform="rotate(-90 70 70)"/>
                                </svg>
                                <svg width="0" height="0">
                                    <defs>
                                        <linearGradient id="silverGrad2" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#E2E8F0"/>
                                            <stop offset="100%" stop-color="#94A3B8"/>
                                        </linearGradient>
                                    </defs>
                                </svg>
                                <div class="progress-content">
                                    <span class="progress-number">
                                        <span class="numberplus">{{ currentValues.case2 }}</span>
                                        <span class="plus">+</span>
                                    </span>
                                </div>
                            </div>
                            <h3 class="stat-title">{{ titles.case2 }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Карточка 3 -->
                <div class="stat-card" :class="{ 'filled': filled.case3 }">
                    <div class="water-fill" :class="{ 'active': filled.case3 }"></div>
                    <div class="card-content">
                        <div class="circular-progress">
                            <div class="progress-circle">
                                <svg width="140" height="140" viewBox="0 0 140 140">
                                    <circle class="progress-bg" cx="70" cy="70" r="60" stroke="rgba(255,255,255,0.2)" stroke-width="8" fill="none"/>
                                    <circle class="progress-fill" cx="70" cy="70" r="60" stroke="url(#silverGrad3)" stroke-width="8" fill="none"
                                            :stroke-dasharray="circumference" :stroke-dashoffset="progressOffset3"
                                            transform="rotate(-90 70 70)"/>
                                </svg>
                                <svg width="0" height="0">
                                    <defs>
                                        <linearGradient id="silverGrad3" x1="0%" y1="0%" x2="100%" y2="100%">
                                            <stop offset="0%" stop-color="#E2E8F0"/>
                                            <stop offset="100%" stop-color="#94A3B8"/>
                                        </linearGradient>
                                    </defs>
                                </svg>
                                <div class="progress-content">
                                    <span class="progress-number">
                                        <span class="numberplus">{{ currentValues.case3 }}</span>
                                        <span class="plus">+</span>
                                    </span>
                                </div>
                            </div>
                            <h3 class="stat-title">{{ titles.case3 }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { useDataStore } from '@/composables/useDataStore'

export default {
    name: 'StatisticsSection',
    props: {
        initialStats: {
            type: Object,
            default: () => ({})
        }
    },
    data() {
        return {
            circumference: 2 * Math.PI * 60,
            targets: {
                case1: 40,
                case2: 100,
                case3: 2000
            },
            titles: {
                case1: 'Сценариев мероприятий',
                case2: 'Интерактивных игр',
                case3: 'Гостей в год'
            },
            currentValues: {
                case1: 0,
                case2: 0,
                case3: 0
            },
            progress: {
                case1: 0,
                case2: 0,
                case3: 0
            },
            filled: {
                case1: false,
                case2: false,
                case3: false
            },
            animationStarted: false,
            animationTimer: null
        }
    },
    computed: {
        progressOffset1() {
            return this.circumference - (this.progress.case1 * this.circumference)
        },
        progressOffset2() {
            return this.circumference - (this.progress.case2 * this.circumference)
        },
        progressOffset3() {
            return this.circumference - (this.progress.case3 * this.circumference)
        }
    },
    async mounted() {
        await this.loadStatistics()
        this.initObserver()
    },
    beforeUnmount() {
        if (this.animationTimer) {
            clearTimeout(this.animationTimer)
        }
    },
    methods: {
        async loadStatistics() {
            const { getStatistics } = useDataStore()
            const stats = await getStatistics()
            console.log('StatisticsSection загрузил статистику:', stats)

            this.targets = {
                case1: stats.case1?.value || 40,
                case2: stats.case2?.value || 100,
                case3: stats.case3?.value || 2000
            }
            this.titles = {
                case1: stats.case1?.title || 'Сценариев мероприятий',
                case2: stats.case2?.title || 'Интерактивных игр',
                case3: stats.case3?.title || 'Гостей в год'
            }
        },
        initObserver() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !this.animationStarted) {
                        this.animationStarted = true
                        this.startAnimation()
                        observer.unobserve(entry.target)
                    }
                })
            }, { threshold: 0.3 })
            const element = this.$refs.sectionRef
            if (element) observer.observe(element)
        },
        startAnimation() {
            const duration = 2000
            const startTime = performance.now()
            const animate = (currentTime) => {
                const elapsed = currentTime - startTime
                const t = Math.min(elapsed / duration, 1)
                const easeOutCubic = 1 - Math.pow(1 - t, 3)
                this.currentValues.case1 = Math.floor(easeOutCubic * this.targets.case1)
                this.currentValues.case2 = Math.floor(easeOutCubic * this.targets.case2)
                this.currentValues.case3 = Math.floor(easeOutCubic * this.targets.case3)
                this.progress.case1 = easeOutCubic
                this.progress.case2 = easeOutCubic
                this.progress.case3 = easeOutCubic
                if (t < 1) {
                    requestAnimationFrame(animate)
                } else {
                    this.animationTimer = setTimeout(() => {
                        this.filled.case1 = true
                        this.filled.case2 = true
                        this.filled.case3 = true
                    }, 300)
                }
            }
            requestAnimationFrame(animate)
        }
    }
}
</script>

<style scoped>
.statistics-section {
    padding: 60px 0;
    background: transparent;
}
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}
.stats-header {
    text-align: center;
    margin-bottom: 50px;
}
.stats-title {
    font-size: clamp(28px, 5vw, 42px);
    font-family: "Comfortaa", sans-serif;
    color: white;
    margin-bottom: 12px;
}
.stats-title .highlight {
    background: linear-gradient(135deg, #E2E8F0, #FFFFFF);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
.stats-subtitle {
    font-size: 18px;
    color: white;
}
.stats-grid {
    display: flex;
    justify-content: center;
    gap: 30px;
    flex-wrap: wrap;
}
.stat-card {
    position: relative;
    text-align: center;
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 32px;
    flex: 1;
    min-width: 260px;
    max-width: 320px;
    overflow: hidden;
    transition: all 0.3s ease;
    cursor: pointer;
    box-shadow: 0 0 15px rgba(10, 45, 143, 0.4), 0 0 30px rgba(10, 45, 143, 0.2), 0 0 50px rgba(10, 45, 143, 0.1), 0 4px 15px rgba(0, 0, 0, 0.2);
}
.stat-card:hover {
    transform: translateY(-8px);
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.25);
    box-shadow: 0 0 25px rgba(10, 45, 143, 0.5), 0 0 50px rgba(10, 45, 143, 0.3), 0 20px 40px rgba(0, 0, 0, 0.25);
}
.water-fill {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 0;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(8px);
    transition: height 1s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 0;
    border-radius: 32px;
}
.water-fill.active { height: 100%; }
.card-content {
    position: relative;
    z-index: 1;
    padding: 30px 25px;
}
.circular-progress {
    display: flex;
    flex-direction: column;
    align-items: center;
}
.progress-circle {
    position: relative;
    width: 140px;
    height: 140px;
    margin: 0 auto 20px;
}
.progress-circle svg { width: 100%; height: 100%; }
.progress-bg { stroke: rgba(255, 255, 255, 0.2); }
.progress-fill {
    stroke-width: 8;
    stroke-linecap: round;
    transition: stroke-dashoffset 0.05s linear;
}
.progress-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
}
.progress-number {
    font-size: 28px;
    font-weight: bold;
    display: flex;
    align-items: baseline;
    justify-content: center;
    gap: 3px;
}
.numberplus {
    font-size: 28px;
    font-weight: bold;
    background: linear-gradient(135deg, #E2E8F0, #FFFFFF);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
.plus {
    font-size: 18px;
    font-weight: bold;
    background: linear-gradient(135deg, #94A3B8, #E2E8F0);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}
.stat-title {
    font-size: 18px;
    font-weight: 600;
    color: rgba(255, 255, 255, 0.9);
    margin-top: 15px;
}
.stat-card.filled .numberplus,
.stat-card.filled .plus,
.stat-card.filled .stat-title {
    color: white !important;
    background: none;
    -webkit-background-clip: unset;
    background-clip: unset;
}
.stat-card.filled .progress-fill { stroke: white; }
.stat-card.filled .progress-bg { stroke: rgba(255, 255, 255, 0.3); }
@media (max-width: 768px) {
    .statistics-section { padding: 40px 0; }
    .stats-grid { flex-direction: column; align-items: center; }
    .stat-card { min-width: 100%; max-width: 100%; }
    .card-content { padding: 20px 16px; }
    .progress-circle { width: 100px; height: 100px; }
    .progress-number { font-size: 20px; }
    .numberplus { font-size: 20px; }
    .plus { font-size: 14px; }
    .stat-title { font-size: 14px; }
}
@media (max-width: 480px) {
    .progress-circle { width: 80px; height: 80px; }
    .progress-number { font-size: 16px; }
    .numberplus { font-size: 16px; }
    .plus { font-size: 12px; }
}
</style>
