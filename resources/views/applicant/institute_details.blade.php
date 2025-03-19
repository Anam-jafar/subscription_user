@extends('layouts.loginLayout')

@section('content')
    <!-- Logo -->
    <div class="flex justify-center">
        <img src="{{ asset('subscription/assets/icons/fin_logo.svg') }}" alt="MAIS Logo" class="w-32 h-32" />
    </div>
    <!-- Title -->
    <h1 class="text-center text-3xl !font-normal text-[#2624D0] mt-2 font-mont">SISTEM PENGURUSAN MASJID</h1>

    <x-alert />

    <div class="max-w-md mx-auto space-y-4">
        <!-- Header -->
        <h1 class="text-[#2624D0] text-2xl !font-extrabold text-center mt-4">
            MOHON LANGGANAN
        </h1>

        <!-- Subtitle -->
        <div class="text-center space-y-1">
            <h2 class="text-black text-lg">Sila Semak Maklumat Berikut</h2>
        </div>

        <div class="bg-white !rounded-xl p-8 max-w-md w-full space-y-6 shadow-lg">
            <!-- Mosque Name -->
            <div class="flex items-center gap-4">
                <img src="{{ asset('subscription/assets/icons/subscription_details_mosque.svg') }}" alt="MAIS Logo"
                    class="w-6 h-6" />
                <span class="font-semibold text-lg">{{ $institute->name }}</span>
            </div>

            <!-- Address -->
            <div class="flex items-center gap-4">
                <img src="{{ asset('subscription/assets/icons/subscription_details_location.svg') }}" alt="MAIS Logo"
                    class="w-7 h-7" />
                <p class="font-semibold">
                    {{ $institute->addr }}
                    {{ optional($institute)->city ? ', ' . $institute->city : '' }}
                    {{ optional($institute)->state ? ', ' . $institute->state : '' }}
                </p>
            </div>

            <!-- Contact Person -->
            <div class="flex items-center gap-4">
                <img src="{{ asset('subscription/assets/icons/subscription_details_account.svg') }}" alt="MAIS Logo"
                    class="w-6 h-6" />
                <span class="font-semibold">{{ $institute->con1 }}</span>
            </div>

            <!-- Phone -->
            <div class="flex items-center gap-4">
                <img src="{{ asset('subscription/assets/icons/subscription_details_mobile.svg') }}" alt="MAIS Logo"
                    class="w-6 h-6" />
                <span class="font-semibold">{{ $institute->hp }}</span>
            </div>

            <!-- Email -->
            <div class="flex items-center gap-4">
                <img src="{{ asset('subscription/assets/icons/subscription_details_email.svg') }}" alt="MAIS Logo"
                    class="w-5 h-5" />
                <span class="font-semibold">{{ $institute->mel }}</span>
            </div>

            <!-- Role -->
            <div class="flex items-center gap-4">
                <img src="{{ asset('subscription/assets/icons/subscription_details_document.svg') }}" alt="MAIS Logo"
                    class="w-6 h-6" />
                <span class="font-semibold">{{ $institute->UserPosition->prm }}</span>
            </div>
        </div>
        {{-- 
        <form action="{{ route('instituteCheck') }}" method="POST" class="space-y-8">
            @csrf

            <!-- Hidden Inputs -->
            <input type="hidden" id="institute_name" name="institute_name">
            <input type="hidden" id="institute_refno" name="institute_refno"> --}}



        <!-- Submit Button -->
        <form action="" method="POST">
            @csrf
            <button
                class="w-full bg-[#2624D0] text-white py-3 px-6 rounded-full hover:bg-blue-700 transition-colors text-lg font-medium !mt-8 !mb-8">
                Teruskan
            </button>
        </form>

        {{-- </form> --}}

    </div>
@endsection
