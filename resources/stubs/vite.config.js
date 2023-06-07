import path from 'path';
import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';
import { viteStaticCopy } from 'vite-plugin-static-copy'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/scss/app.scss', 'resources/js/app.js'],
            refresh: [
                ...refreshPaths,
                'app/Http/Livewire/**',
            ],
        }),
        viteStaticCopy({
            targets: [
                {
                    src: 'resources/images',
                    dest: '.././images'
                },
                {
                    src: 'resources/favicon',
                    dest: '.././favicon'
                }
            ]
        }),
    ],
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            '~tabler': path.resolve(__dirname, 'node_modules/@tabler'),
            '~sweetalert2': path.resolve(__dirname, 'node_modules/sweetalert2'),
        }
    },
    server: {
        port: 8080,
        hot: true
    }
});
