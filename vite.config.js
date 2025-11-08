import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import Components from 'unplugin-vue-components/vite';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel([
            'resources/css/app.css',
            'resources/js/app.js',
        ]),

        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),

        Components({
            dirs: ['resources/js/components'],
        }),

        tailwindcss(),
    ],

    resolve: {
        alias: {
            '@': '/resources',
            '~': '/resources/js',
        },
    },
});
