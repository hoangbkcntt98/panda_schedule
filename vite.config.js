import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import { quasar, transformAssetUrls } from '@quasar/vite-plugin'
export default defineConfig({
    server: {
        host: true,
        hmr: {
            host: 'localhost',
        },
        watch: {
            usePolling: true,
        },
    },
    plugins: [
        vue(),
        laravel({
            input: ['resources/js/app.js'],
            refresh: [
                'app/Http/Controllers/**',
                'resources/views/**',
            ],
        }),
        quasar({
            sassVariables: './resources/sass/quasar-variables.sass'
        })
    ],
    alias: {
        '@': './resources/js',
    },
    optimizeDeps: {
        exclude: ['js-big-decimal']
    }
});