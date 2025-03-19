@extends('layouts.loginLayout')

@section('content')
    <!-- Logo -->
    <div class="flex justify-center">
        <img src="{{ asset('subscription/assets/icons/fin_logo.svg') }}" alt="MAIS Logo" class="w-32 h-32" />
    </div>
    <!-- Title -->
    <h1 class="text-center text-3xl !font-normal text-[#2624D0] mt-2 font-mont">SISTEM PENGURUSAN MASJID
    </h1>

    <h1 class="text-center text-3xl font-semibold text-[#2624D0] flex items-center justify-center gap-2 mt-4">
        <img src="{{ asset('subscription/assets/icons/subscription_login_blue.svg') }}" alt="MAIS Logo" class="w-10 h-10" />
        Log Masuk
    </h1>

    <div class="max-w-sm mx-auto w-full space-y-8">
        <p class="text-center text-sm font-normal text-black mt-4 mb-4">Sila masukkan emel rasmi institusi anda</p>
        <x-alert />

        <form action="" method="POST">
            @csrf
            <div class="max-w-md mx-auto p-4 space-y-4 mb-">
                <div class="relative mb-8">
                    <span class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-500">
                        <i class="fe fe-mail"></i>
                    </span>
                    <input type="text" id="emailInput" placeholder="contoh@gmail.com" name="email"
                        class="w-full h-[3.5rem] py-3 px-4 bg-gray-200 !rounded-full pl-12 pr-10 shadow-lg bg-white"
                        autocomplete="off">
                </div>
                {{-- <a href="{{ route('subscriptionLoginPhone') }}"
                    class="text-center text-sm font-normal text-black mt-4 mb-8 block hover:underline">
                    Log Masuk Menggunakan No Telefon
                </a> --}}
                <div class="!mt-12">
                    {{-- onclick="window.location.href='{{ route('subscriptionLoginOtp') }}'" --}}
                    <button id="submitBtn" disabled type="submit"
                        class="w-full bg-gray-700 text-white text-base font-bold py-4 px-6 rounded-full flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200 !mt-8 !mb-8">
                        Teruskan
                    </button>
                    <div class="text-center !mt-4 !mb-4">
                        <a href="{{ route('subscriptionLogin') }}" class="text-base text-blue-600 hover:underline">Kembali
                            ke Halaman
                            Utama</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('emailInput');
            const submitBtn = document.getElementById('submitBtn');

            // Enable or disable the submit button based on the email input value
            emailInput.addEventListener('input', function() {
                if (emailInput.value.trim() !== '') {
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
