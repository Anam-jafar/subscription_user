      @extends('layouts.loginLayout')

      @section('content')
          <!-- Logo -->
          <div class="flex justify-center">
              <img src="{{ asset('subscription/assets/icons/fin_logo.svg') }}" alt="MAIS Logo" class="w-32 h-32" />
          </div>
          <!-- Title -->
          <h1 class="text-center text-3xl !font-normal text-[#2624D0] mt-2 font-mont mb-4">SISTEM MAIS</h1>



          <div class="max-w-md mx-auto p-6 space-y-6">

              <x-alert />

              <!-- Results Section -->
              <div class="space-y-4 flex flex-col items-center text-center">
                  <p class="text-black font-semibold">
                      Keputusan sehingga {{ $currentDateTime }}:
                  </p>


                  <div class="flex items-start gap-3 text-gray-800">
                      <img src="{{ asset('subscription/assets/icons/subscription_mosque.svg') }}" alt="MAIS Logo"
                          class="w-5 h-5 align-top" />
                      <p class="font-semibold">
                          {{ $user->name }}
                          {{ optional($user)->addr ? ', ' . $user->addr : '' }}
                          {{ optional($user)->city ? ', ' . $user->city : '' }}
                          {{ optional($user)->state ? ', ' . $user->state : '' }}
                      </p>
                  </div>
              </div>

              @if ($user->subscription_status == 0)
                  <h1 class="text-yellow-600 text-2xl !font-bold text-center">
                      BELUM DILULUSKAN
                  </h1>

                  <form action="" method="POST">
                      @csrf

                      <button type="submit"
                          class="w-full bg-green-600 text-white py-3 px-6 rounded-full hover:bg-blue-700 transition-colors text-lg font-semibold flex items-center justify-center">
                          Hantar Permintaan
                          <span class="fe fe-log-out text-2xl ml-4"></span>
                      </button>
                  </form>
              @elseif($user->subscription_status == 1)
                  <!-- Header -->
                  <h1 class="text-green-600 text-2xl !font-bold text-center">
                      BELUM DILULUSKAN </h1>
                  <p class="text-base font-semibold text-center">Setelah admin meluluskan, anda boleh membuat
                      pembayaran.</b>
                  </p>
              @endif



              <form id="logout-form" action="{{ route('subscriptionLogout') }}" method="POST">
                  @csrf
                  <button type="submit"
                      class="w-full bg-blue-600 text-white py-3 px-6 rounded-full hover:bg-blue-700 transition-colors text-lg font-semibold flex items-center justify-center">
                      Keluar
                      <span class="fe fe-log-out text-2xl ml-4"></span>
                  </button>
              </form>


          </div>
      @endsection
