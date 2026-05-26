import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input:   ['resources/js/app.js', 'resources/css/fontawesome.css', 'resources/css/app.css'],
            refresh: true,
        }),
        tailwindcss()
    ],
    resolve: {
        alias: {
            '~aos':      path.resolve(__dirname, 'node_modules/aos'),
            '~flickity': path.resolve(__dirname, 'node_modules/flickity'),
            '@':         path.resolve(__dirname, 'resources'),
        }
    },
});