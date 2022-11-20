<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Sipedas V4</title>

  <meta name="description" content="Sipedas V4 &amp; UI Framework created by pixelcave and published on Themeforest">
  <meta name="author" content="pixelcave">
  <meta name="robots" content="noindex, nofollow">

  <!-- Open Graph Meta -->
  <meta property="og:title" content="Sipedas V4 &amp; UI Framework">
  <meta property="og:site_name" content="Codebase">
  <meta property="og:description" content="Sipedas V4 &amp; UI Framework created by pixelcave and published on Themeforest">
  <meta property="og:type" content="website">
  <meta property="og:url" content="">
  <meta property="og:image" content="">

  <!-- Icons -->
  <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
  <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/favicon-192x192.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">

  <!-- Modules -->
  @yield('css')
  @vite(['resources/sass/main.scss',
  'public/js/lib/jquery.min.js', 
  'resources/js/codebase/app.js',
  'resources/sass/codebase/themes/pulse.scss',
  // 'resources/js/codebase.app.min.js',
  'public/js/plugins/datatables-bs5/css/dataTables.bootstrap5.min.css',
  'public/js/plugins/datatables-buttons-bs5/css/buttons.bootstrap5.min.css',
  'public/js/plugins/datatables-responsive-bs5/css/responsive.bootstrap5.min.css',
  'public/js/plugins/datatables/jquery.dataTables.min.js',
  'public/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js',
  'public/js/plugins/datatables-responsive/js/dataTables.responsive.min.js',
  'public/js/plugins/datatables-responsive-bs5/js/responsive.bootstrap5.min.js',
  'public/js/plugins/datatables-buttons/dataTables.buttons.min.js',
  'public/js/plugins/datatables-buttons-bs5/js/buttons.bootstrap5.min.js',
  'public/js/plugins/datatables-buttons-jszip/jszip.min.js',
  'public/js/plugins/datatables-buttons-pdfmake/pdfmake.min.js',
  'public/js/plugins/datatables-buttons-pdfmake/vfs_fonts.js',
  'public/js/plugins/datatables-buttons/buttons.print.min.js',
  'public/js/plugins/datatables-buttons/buttons.html5.min.js',
  'public/js/plugins/select2/css/select2.min.css',
  'public/js/plugins/select2/js/select2.full.min.js',
  'public/js/plugins/ion-rangeslider/js/ion.rangeSlider.js',
  'public/js/plugins/ion-rangeslider/css/ion.rangeSlider.css',
  'resources/js/pages/jquery.tabledit.js',
  'resources/js/pages/datatables.js',
  
  ])

  <!-- Alternatively, you can also include a specific color theme after the main stylesheet to alter the default color theme of the template -->
  {{-- @vite(['resources/sass/main.scss', 'resources/sass/codebase/themes/corporate.scss', 'resources/js/codebase/app.js']) --}}
  @yield('js')  
</head>