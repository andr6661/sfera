import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import path from 'path'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.jsx'],
            refresh: true,
        }),
        vue(),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
            '@components': path.resolve(__dirname, 'resources/js/Components'),
            '@pages': path.resolve(__dirname, 'resources/js/Pages'),
            '@composables': path.resolve(__dirname, 'resources/js/composables'),
            '@assets': path.resolve(__dirname, 'resources/js/assets'),
        }
    },
    server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: false,
        cors: true,
        hmr: {
            host: 'localhost',
        },
    },
    // Добавь это - игнорируем статические файлы
    optimizeDeps: {
        entries: [
            'resources/js/**/*.{vue,js,jsx,ts,tsx}',
        ],
        exclude: [
            '*.webp',
            '*.MOV',
            '*.mp4',
            '*.jpg',
            '*.png'
        ]
    }
})
