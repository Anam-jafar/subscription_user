@extends('layouts.loginLayout')

@section('content')
    <!-- Logo -->
    <div class="flex justify-center">
        <img src="{{ asset('assets/icons/subscription_logo.svg') }}" alt="MAIS Logo" class="w-24 h-24" />
    </div>
    <!-- Title -->
    <h1 class="text-center text-3xl font-semibold text-[#2624D0] flex items-center justify-center gap-2">
        <img src="{{ asset('assets/icons/subscription_login_blue.svg') }}" alt="MAIS Logo" class="w-10 h-10" />
        Log Masuk
    </h1>

    <x-alert />

    <div class="max-w-sm mx-auto w-full space-y-8">
        <p class="text-center text-sm font-normal text-black mt-4 mb-4">Sila isi emel atau o telefon rasmi institusi anda
            dibawah:</p>
        <x-alert />

        <div class="max-w-md mx-auto p-4 space-y-4">
            <div class="relative mb-8">
                <span class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-500">
                    <i class="fe fe-phone"></i>
                </span>
                <input type="text" id="mobileInput" placeholder="+60 00 000 0000" name="mobile"
                    class="w-full h-[3.5rem] py-3 px-4 bg-gray-200 !rounded-full pl-12 pr-10 shadow-lg bg-white "
                    autocomplete="off">
            </div>
            <a href="{{ route('subscriptionLoginEmail') }}"
                class="text-center text-sm font-normal text-black mt-4 mb-8 block hover:underline">
                Log Masuk Menggunakan Emel
            </a>

            <!-- Adjusted gap -->
            <div class="!mt-12">
                <button id="submitBtn" disabled onclick="window.location.href='{{ route('subscriptionLoginOtp') }}'"
                    class="w-full bg-gray-700 text-base font-bold text-white py-4 px-6 rounded-full shadow-lg flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200 !mt-8 !mb-8">
                    Teruskan
                </button>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileInput = document.getElementById('mobileInput');
            const submitBtn = document.getElementById('submitBtn');

            // Enable or disable the submit button based on the mobile input value
            mobileInput.addEventListener('input', function() {
                if (mobileInput.value.trim() !== '') {
                    submitBtn.disabled = false; // Enable button
                    submitBtn.classList.remove('bg-gray-700');
                    submitBtn.classList.add('bg-blue-500', 'hover:bg-blue-600');
                } else {
                    submitBtn.disabled = true; // Disable button
                    submitBtn.classList.remove('bg-blue-500', 'hover:bg-blue-600');
                    submitBtn.classList.add('bg-gray-700');
                }
            });
        });
    </script>
@endsection
