      @extends('layouts.loginLayout')

      @section('content')
          <!-- Logo -->
          <div class="flex justify-center">
              <img src="{{ asset('subscription/assets/icons/fin_logo.svg') }}" alt="MAIS Logo" class="w-32 h-32" />
          </div>
          <!-- Title -->
          <h1 class="text-center text-3xl !font-normal text-[#2624D0] mt-2 font-mont">SISTEM PENGURUSAN MASJID</h1>

          <x-alert />


          <div class="max-w-md mx-auto p-6 space-y-6">
              <!-- Header -->
              <h1 class="text-[#2624D0] text-2xl !font-extrabold text-center mt-4">
                  SEMAK PENDAFTARAN
              </h1>

              <!-- Results Section -->
              <div class="space-y-4 flex flex-col items-center text-center">
                  <p class="text-black font-semibold">
                      Keputusan sehingga {{ $currentDateTime }}:
                  </p>


                  <div class="flex items-start gap-3 text-gray-800">
                      <img src="{{ asset('subscription/assets/icons/subscription_mosque.svg') }}" alt="MAIS Logo"
                          class="w-5 h-5 align-top" />
                      <p class="font-semibold">
                          {{ $institute->name }}
                          {{ optional($institute)->addr ? ', ' . $institute->addr : '' }}
                          {{ optional($institute)->city ? ', ' . $institute->City->prm : '' }}
                          {{ optional($institute)->state ? ', ' . $institute->State->prm : '' }}
                      </p>
                  </div>

              </div>

              <!-- Success Message -->
              <div class="flex justify-center">
                  <img src="{{ asset('subscription/assets/icons/pending.svg') }}" alt="MAIS Logo" class="w-56 h-56" />
              </div>

              <div class="text-center !mt-2 !mb-4">
                  <a href="{{ route('findInstitute') }}" class="text-base text-blue-600 hover:underline">Semak Lain</a>
              </div>


          </div>







          {{-- <!-- Copyright -->
    <div class="flex justify-center items-center gap-2 text-sm text-gray-900">
        <img src="{{ asset('subscription/assets/icons/fin_logo_tiny.svg') }}" alt="Admin" class="w-18 h-18" />
        <p>Hakcipta terpelihara oleh Majlis Agama Islam Selangor (MAIS)</p>
    </div> --}}
      @endsection
