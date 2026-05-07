import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: '0.0.0.0', // Escuchar en todas las interfaces de red
        port: 5173,
        strictPort: true,
        // Permitir solicitudes desde cualquier origen (necesario cuando Laravel
        // se sirve por una IP de LAN distinta a localhost, p.ej. 192.168.x.x:8001)
        cors: {
            origin: true,
        },
        hmr: {
            host: 'localhost', // Cambiar por la IP de tu servidor si accedes desde otro PC
        },
    },
});
