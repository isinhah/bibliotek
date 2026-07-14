import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import {bunny} from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';
import react from '@vitejs/plugin-react'
import inertia from "@inertiajs/vite";
import path from "node:path";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.jsx'],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        react(),
        inertia(),
        tailwindcss(),
    ],
    resolve : {
        alias: {
            '@': path.resolve(__dirname, './resources/js'),
        },
    },
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
        cors: true,
        host: '0.0.0.0',
        port: 5175,
        strictPort: true,
        hmr: {
            host: 'localhost',
        },
    },
    optimizeDeps: {
        exclude: ['rolldown-runtime']
    }
});
