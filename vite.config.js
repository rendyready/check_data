import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/main.scss',
                'resources/sass/codebase/themes/corporate.scss',
                'resources/sass/codebase/themes/earth.scss',
                'resources/sass/codebase/themes/elegance.scss',
                'resources/sass/codebase/themes/flat.scss',
                'resources/sass/codebase/themes/pulse.scss',
                'resources/js/codebase/app.js',
                'resources/js/app.js',
                'resources/js/pages/datatables.js',
                'resources/js/pages/slick.js',
            ],
            refresh: [
                'resources/views/**','app/Http/Controllers/**'
            ],
        }),
    ],
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
        }
    },
});
