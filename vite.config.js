import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/admin/css/adminlte.css',
                'resources/admin/js/adminlte.js',
                'resources/admin/js/main.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
