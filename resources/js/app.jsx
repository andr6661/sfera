import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import '../css/app.css'
import App from './App.vue'
import '@fortawesome/fontawesome-free/css/all.min.css'

createInertiaApp({
    resolve: (name) => resolvePageComponent(
        `./Pages/${name}.vue`,
        import.meta.glob('./Pages/**/*.vue')
    ),
    setup({ el, App: InertiaApp, props, plugin }) {
        createApp({
            render: () => h(App, () => h(InertiaApp, props))
        })
            .use(plugin)
            .mount(el)
    },
})
