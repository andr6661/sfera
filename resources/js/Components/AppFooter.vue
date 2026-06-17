<template>
    <footer>
        <div class="footer-container">
            <div class="footer-left">
                <a href="/" class="logo-link">
                    <img :src="logoSrc" alt="Сфера" class="footer-logo">
                </a>
                <p class="footer-copyright">{{ footerCopyright }}</p>
            </div>

            <div class="footer-center">
                <div class="footer-contacts">
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <span>{{ contacts.phone }}</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>{{ footerEmail }}</span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ contacts.address }}</span>
                    </div>
                </div>
            </div>

            <div class="footer-right">
                <div class="social-links">
                    <a href="https://vk.com/ngknn_ru" target="_blank" class="social-link">
                        <i class="fab fa-vk"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
import { useDataStore } from '@/composables/useDataStore'

export default {
    name: 'AppFooter',
    data() {
        return {
            footerCopyright: '© 2026 ГБПОУ Нижегородский Губернский колледж',
            footerEmail: 'sfera@ngknn.ru',
            contacts: {
                phone: '',
                email: '',
                address: ''
            },
            logoSrc: '/logo.svg'
        }
    },
    async mounted() {
        await this.loadFooterTexts()
        await this.loadContacts()
    },
    methods: {
        async loadFooterTexts() {
            try {
                const { getHomeTexts } = useDataStore()
                const texts = await getHomeTexts()
                this.footerCopyright = texts.footerCopyright || '© 2026 ГБПОУ Нижегородский Губернский колледж'
                this.footerEmail = texts.footerEmail || 'sfera@ngknn.ru'
            } catch (error) {
                console.error('Footer error:', error)
            }
        },
        async loadContacts() {
            try {
                const { getContacts } = useDataStore()
                const data = await getContacts()
                this.contacts = {
                    phone: data.phone || '+7 (831) 218-22-12',
                    email: data.email || 'sfera@ngknn.ru',
                    address: data.address || '603116 Нижний Новгород, Московское шоссе, 1'
                }
            } catch (error) {
                console.error('Contacts error:', error)
            }
        }
    }
}
</script>

<style scoped>
footer {
    background: linear-gradient(180deg, #728AD5 5%, #071E60 100%);
    color: white;
    padding: 40px 0;
    border-top: none;
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 40px;
    flex-wrap: wrap;
}

.footer-left {
    flex: 1;
    min-width: 200px;
}

.logo-link {
    display: inline-block;
    text-decoration: none;
    margin-bottom: 16px;
}

.footer-logo {
    width: 300px;
    height: auto;
    display: block;
    filter: brightness(0) invert(1);
}

.footer-copyright {
    font-size: 12px;
    opacity: 0.7;
    margin: 0;
    color: rgba(255, 255, 255, 0.7);
}

.footer-center {
    flex: 2;
    min-width: 300px;
}

.footer-contacts {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 14px;
    color: rgba(255, 255, 255, 0.85);
    transition: all 0.3s ease;
}

.contact-item:hover {
    color: white;
    transform: translateX(5px);
}

.contact-item i {
    width: 20px;
    font-size: 16px;
    opacity: 0.8;
}

.footer-right {
    flex: 1;
    min-width: 80px;
    text-align: right;
}

.social-links {
    display: flex;
    justify-content: flex-end;
    gap: 16px;
}

.social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 50%;
    transition: all 0.3s ease;
    color: white;
    text-decoration: none;
    border: 1px solid rgba(255, 255, 255, 0.12);
}

.social-link i {
    font-size: 20px;
}

.social-link:hover {
    background: rgba(255, 255, 255, 0.15);
    transform: translateY(-3px);
    border-color: rgba(255, 255, 255, 0.25);
}

@media (max-width: 768px) {
    footer {
        padding: 30px 0;
    }
    .footer-container {
        flex-direction: column;
        text-align: center;
        gap: 24px;
    }
    .footer-left {
        text-align: center;
    }
    .footer-logo {
        margin: 0 auto 16px;
        width: 250px;
    }
    .footer-right {
        text-align: center;
    }
    .social-links {
        justify-content: center;
    }
    .contact-item {
        justify-content: center;
    }
    .contact-item:hover {
        transform: translateX(0);
    }
}
@media (max-width: 480px) {
    .footer-logo {
        width: 200px;
    }
}
</style>
