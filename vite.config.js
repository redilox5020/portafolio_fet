import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/mostrar_proyecto.css',
                'resources/js/app.js',
                'resources/js/admin/dashboard.js',
                'resources/js/mostrar_producto.js',
                'resources/js/mostrar_proyecto.js'
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },
});
