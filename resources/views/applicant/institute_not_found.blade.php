      @extends('layouts.loginLayout')

      @section('content')
          <!-- Logo -->
          <div class="flex justify-center">
              <img src="{{ asset('subscription/assets/icons/fin_logo.svg') }}" alt="MAIS Logo" class="w-32 h-32" />
          </div>
          <!-- Title -->
          <h1 class="text-center text-3xl !font-normal text-[#2624D0] mt-2 font-mont">SISTEM MAIS</h1>

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
                          {{ optional($institute)->city ? ', ' . $institute->city : '' }}
                          {{ optional($institute)->state ? ', ' . $institute->state : '' }}
                      </p>
                  </div>

              </div>

              <!-- Success Message -->
              <div class="flex justify-center">
                  <img src="{{ asset('subscription/assets/icons/institute_not_registered.svg') }}" alt="MAIS Logo"
                      class="w-48 h-48" />
              </div>

              <!-- Login Button instituteDetails-->
              <a href="{{ route('instituteRegistration', ['id' => $institute->uid]) }}">
                  <button
                      class="w-full bg-[#2624D0] text-white py-3 px-6 rounded-full hover:bg-blue-700 transition-colors text-lg font-medium mt-4 shadow-lg">
                      Daftar <span class="text-xl fe fe-edit-3 ml-3"></span>
                  </button>
              </a>



              <!-- Back Link -->
              <div class="text-center">
                  <a href="#" class="text-blue-600 hover:underline">Semak Lain</a>
              </div>
          </div>






          {{-- <!-- Copyright -->
    <div class="flex justify-center items-center gap-2 text-sm text-gray-900">
        <img src="{{ asset('subscription/assets/icons/fin_logo_tiny.svg') }}" alt="Admin" class="w-18 h-18" />
        <p>Hakcipta terpelihara oleh Majlis Agama Islam Selangor (MAIS)</p>
    </div> --}}
      @endsection
