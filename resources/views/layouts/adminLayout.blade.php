<!DOCTYPE html>
<html lang="en" dir="ltr" data-nav-layout="vertical" class="light" data-header-styles="light"
  data-menu-styles="dark" data-width="fullwidth">

<head>

  <!-- META DATA -->
  <meta charset="UTF-8">
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="Description" content="Laravel Tailwind Responsive Admin Web Dashboard Template">
  <meta name="Author" content="Spruko Technologies Private Limited">
  <meta name="keywords"
    content="template admin, dashboard, laravel template, admin panel laravel, admin dashboard template, template dashboard, laravel, laravel vite, admin, laravel framework, tailwind css, laravel dashboard, dashboard admin template, laravel tailwind, tailwind admin template, dashboard tailwind, tailwind dashboard, tailwind dashboard template">
  <!-- TITLE -->
  <title> Mais </title>
  <!-- FAVICON -->
  <link rel="icon" href="{{ asset('subscription/assets/icons/sd_logo_half.svg') }}" type="image/x-icon">
  <!-- ICONS CSS -->
  <link href="{{ asset('subscription/build/assets/icon-fonts/icons.css') }}" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <!-- APP SCSS -->
  @vite(['resources/sass/app.scss'], 'subscription/build')
  <!-- APP CSS -->
  @vite(['resources/css/app.css'], 'subscription/build')
  <style>
    @media (min-width: 1024px) {
      .custom-width-container {
        width: 70% !important;
        margin-left: auto;
        margin-right: auto;
      }
    }

    .custom-height-container {
      min-height: 100vh !important;
    }

    @media (min-width: 768px) {
      .custom-height-container {
        min-height: 70vh !important;
      }
    }
  </style>
  @include('layouts.components.styles')
  <!-- MAIN JS -->
  <script src="{{ asset('subscription/build/assets/main.js') }}"></script>
  @yield('styles')
</head>

<body>
  <div class="page">
    <div
      class="flex min-h-screen items-center justify-center bg-white lg:bg-gradient-to-t lg:from-[rgb(0,5,22)] lg:to-[rgb(15,24,124)]">
      <div class="custom-height-container custom-width-container relative w-full space-y-8 overflow-hidden">
        <!-- Content container -->
        @yield('content')
      </div>
    </div>
  </div>
  <!-- SCRIPTS -->
  @include('layouts.components.scripts')
  @yield('scripts')
  <!-- APP JS -->
  @vite(['resources/js/app.js'], 'subscription/build')

  <!-- END SCRIPTS -->
</body>

</html>
