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



    @include('layouts.components.styles')

    <!-- MAIN JS -->
    <script src="{{ asset('subscription/build/assets/main.js') }}"></script>

    @yield('styles')

</head>

<body>


    <!-- LOADER -->
    <div id="loader">
        <img src="{{ asset('subscription/build/assets/images/media/loader.svg') }}" alt="">
    </div>
    <!-- LOADER -->

    <div class="page">


        <div
            class="min-h-screen flex items-center justify-center bg-white lg:bg-gradient-to-t lg:from-[rgb(0,5,22)] lg:to-[rgb(15,24,124)]">
            <div class="w-full min-h-screen md:min-h-[70vh] lg:max-w-7xl p-0 lg:p-2 lg:px-20 lg:pt-20 lg:pb-10 space-y-8 relative overflow-hidden lg:rounded-xl lg:border"
                style="background-image: url('{{ asset('subscription/assets/icons/background.png') }}'); background-size: cover; background-position: center;">

                <!-- White overlay with blur - only visible on large screens -->
                {{-- <div class="absolute inset-0 backdrop-blur-md bg-white/60 lg:block lg:rounded-2xl"></div> --}}

                <!-- Content container -->
                <div class="relative z-10 p-4 lg:p-0">
                    @yield('content')
                </div>
            </div>
        </div>




    </div>

    <!-- SCRIPTS -->
    @include('layouts.components.scripts')

    @yield('scripts')

    <!-- STICKY JS -->
    <script src="{{ asset('subscription/build/assets/sticky.js') }}"></script>

    <!-- APP JS -->
    @vite(['resources/js/app.js'], 'subscription/build')






    <!-- END SCRIPTS -->
</body>

</html>
