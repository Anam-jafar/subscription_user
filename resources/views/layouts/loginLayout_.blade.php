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
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <!-- Leaflet Geocoder Plugin -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <!-- APP SCSS -->
  @vite(['resources/sass/app.scss'], 'subscription/build')
  <!-- APP CSS -->
  @vite(['resources/css/app.css'], 'subscription/build')
  @include('layouts.components.styles')
  <!-- MAIN JS -->
  <script src="{{ asset('subscription/build/assets/main.js') }}"></script>
  @yield('styles')
</head>

<body>
  <div class="page">
    <div
      class="flex min-h-screen items-center justify-center bg-white lg:bg-gradient-to-t lg:from-[rgb(0,5,22)] lg:to-[rgb(15,24,124)]">
      <div class="relative min-h-screen w-full space-y-8 overflow-hidden md:min-h-[70vh] lg:max-w-5xl">

        <!-- White overlay with blur - only visible on large screens -->
        {{-- <div class="absolute inset-0 backdrop-blur-md bg-white/60 lg:block lg:rounded-2xl"></div> --}}

        <!-- Content container -->
        @yield('content')
      </div>
    </div>
  </div>
  <!-- SCRIPTS -->
  @include('layouts.components.scripts')
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
  @yield('scripts')
  <!-- APP JS -->
  @vite(['resources/js/app.js'], 'subscription/build')
  <!-- END SCRIPTS -->
</body>

</html>
