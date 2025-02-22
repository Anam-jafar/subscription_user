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

    <div class="max-w-md mx-auto space-y-6">
        <!-- Header -->
        {{-- <h1 class="text-[#2624D0] text-2xl font-extrabold text-center">
            MOHON LANGGANAN
        </h1> --}}

        <div class="w-full max-w-md space-y-8">
            <!-- Header Text -->
            <div class="text-center space-y-2">
                <p class="text-gray-900">Kod TAC telah dihantar ke ********8509.</p>
                <p class="text-gray-900">Sila isi kod dibawah.</p>
            </div>

            <form action="" method="POST">
                @csrf

                <!-- Verification Code Inputs -->
                <div class="flex justify-center gap-4 my-8">
                    <input type="text" name="otp[]" maxlength="1" autocomplete="off"
                        class="otp-input w-16 h-16 text-center text-2xl font-bold border-2 border-gray-200 rounded-lg focus:border-gray-400 focus:outline-none" />
                    <input type="text" name="otp[]" maxlength="1" autocomplete="off"
                        class="otp-input w-16 h-16 text-center text-2xl font-bold border-2 border-gray-200 rounded-lg focus:border-gray-400 focus:outline-none" />
                    <input type="text" name="otp[]" maxlength="1" autocomplete="off"
                        class="otp-input w-16 h-16 text-center text-2xl font-bold border-2 border-gray-200 rounded-lg focus:border-gray-400 focus:outline-none" />
                    <input type="text" name="otp[]" maxlength="1" autocomplete="off"
                        class="otp-input w-16 h-16 text-center text-2xl font-bold border-2 border-gray-200 rounded-lg focus:border-gray-400 focus:outline-none" />
                    <input type="text" name="otp[]" maxlength="1" autocomplete="off"
                        class="otp-input w-16 h-16 text-center text-2xl font-bold border-2 border-gray-200 rounded-lg focus:border-gray-400 focus:outline-none" />
                    <input type="text" name="otp[]" maxlength="1" autocomplete="off"
                        class="otp-input w-16 h-16 text-center text-2xl font-bold border-2 border-gray-200 rounded-lg focus:border-gray-400 focus:outline-none" />
                </div>


                <!-- Resend Button -->
                <div class="flex justify-center">
                    <button class="flex items-center gap-2 text-gray-900 hover:text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z" />
                        </svg>
                        Hantar Semula
                    </button>
                </div>

                <!-- Submit Button -->
                <div class="!mt-8 !mb-8">
                    {{-- onclick="window.location.href='{{ route('activateSubscription') }}'" --}}
                    <button id="submitBtn" disabled type="submit"
                        class="w-full bg-gray-700 text-white py-4 px-6 rounded-full flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200">
                        Hantar Permohonan
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 2L11 13" />
                            <path d="M22 2l-7 20-4-9-9-4 20-7z" />
                        </svg>
                    </button>
                </div>
            </form>

        </div>

    </div>
@endsection

@section('scripts')
    <script defer>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.otp-input');
            const submitBtn = document.getElementById('submitBtn');

            // Handle input behavior
            inputs.forEach((input, index) => {
                input.addEventListener('input', function() {
                    if (this.value.length >= 1) {
                        this.value = this.value[0]; // Only keep first character
                        if (index < inputs.length - 1) {
                            inputs[index + 1].focus(); // Move to next input
                        }
                    }
                    checkInputs();
                });

                // Handle backspace
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && !this.value && index > 0) {
                        inputs[index - 1].focus(); // Move to previous input
                    }
                });
            });

            // Check if all inputs are filled
            function checkInputs() {
                const allFilled = Array.from(inputs).every(input => input.value.length === 1);
                submitBtn.disabled = !allFilled;
                submitBtn.classList.toggle('bg-blue-500', allFilled);
                submitBtn.classList.toggle('hover:bg-blue-600', allFilled);
                submitBtn.classList.toggle('bg-gray-700', !allFilled);
                submitBtn.classList.toggle('disabled:opacity-50', !allFilled);
                submitBtn.classList.toggle('disabled:cursor-not-allowed', !allFilled);
            }

            // Allow only numbers
            inputs.forEach(input => {
                input.addEventListener('keypress', function(e) {
                    if (!/[0-9]/.test(e.key)) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
@endsection
