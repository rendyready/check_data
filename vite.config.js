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
                'resources/js/plugins/lib/jquery.min.js',
                'resources/js/codebase/app.js',
                'resources/js/app.js', 
                'resources/js/pages/jquery.tabledit.js',
                'resources/js/pages/datatables.js',
                'resources/js/pages/slick.js',
                'resources/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css',
                'resources/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css',
                'resources/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css',
                'resources/js/plugins/datatables/jquery.dataTables.min.js',
                'resources/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js',
                'resources/js/plugins/datatables-responsive/js/dataTables.responsive.min.js',
                'resources/js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js',
                'resources/js/plugins/datatables-buttons/dataTables.buttons.min.js',
                'resources/js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js',
                'resources/js/plugins/datatables-buttons-jszip/jszip.min.js',
                'resources/js/plugins/datatables-buttons-pdfmake/pdfmake.min.js',
                'resources/js/plugins/datatables-buttons-pdfmake/vfs_fonts.js',
                'resources/js/plugins/datatables-buttons/buttons.print.min.js',
                'resources/js/plugins/datatables-buttons/buttons.html5.min.js',
                'resources/js/plugins/select2/css/select2.min.css',
                'resources/js/plugins/select2/js/select2.full.min.js',
                'resources/js/plugins/ion-rangeslider/js/ion.rangeSlider.js',
                'resources/js/plugins/ion-rangeslider/css/ion.rangeSlider.css',
            ],
            refresh: [
                'resources/views/**','app/Http/Controllers/**','Modules/**'
            ],
        }),
    ],
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
        }
    },
    build: {
        chunkSizeWarningLimit: 1600,
      },
});
