@extends('layouts.loginLayout')

@section('content')
    <!-- Logo -->
    <div class="flex justify-center">
        <img src="{{ asset('assets/icons/subscription_logo.svg') }}" alt="MAIS Logo" class="w-24 h-24" />
    </div>
    <!-- Title -->
    <h1 class="text-center text-3xl font-semibold text-[#2624D0]">SISTEM LANGGANAN MAIS</h1>

    <x-alert />


    <div class="max-w-sm mx-auto w-full space-y-8">
        <h1 class="text-center text-2xl !font-extrabold text-[#2624D0]">LOGIN</h1>
        <p class="text-center text-sm font-normal text-black mt-4 mb-4">Sebuah sistem pengurusan masjid yang pintar dan
            lengkap dalam menguruskan hal pentadbiran instutusi masjid di
            Malaysia.</p>
        <x-alert />
        <div class="max-w-md mx-auto p-4 space-y-4 !mt-12 !mb-8">
            <!-- Log Masuk Button -->
            <button onclick="window.location.href='{{ route('subscriptionLoginEmail') }}'"
                class="w-full bg-indigo-600 text-white py-3 px-6 rounded-full shadow-lg flex justify-between items-center hover:bg-indigo-700 transition-colors">
                <span class="text-lg font-normal">Log Masuk</span>
                <img src="{{ asset('assets/icons/subscription_login.svg') }}" alt="MAIS Logo" class="w-6 h-6" />

            </button>

            <!-- Semak Pendaftaran Button -->
            <button onclick="window.location.href='{{ route('findInstitute') }}'"
                class="w-full bg-purple-600 text-white py-3 px-6 rounded-full shadow-lg flex justify-between items-center hover:bg-purple-700 transition-colors">
                <span class="text-lg font-normal">Semak Pendaftaran</span>
                <i class="fe fe-search text-xl"></i>
            </button>
        </div>

    </div>







    {{-- <!-- Copyright -->
    <div class="flex justify-center items-center gap-2 text-sm text-gray-900">
        <img src="{{ asset('assets/icons/fin_logo_tiny.svg') }}" alt="Admin" class="w-18 h-18" />
        <p>Hakcipta terpelihara oleh Majlis Agama Islam Selangor (MAIS)</p>
    </div> --}}
@endsection
