      @extends('layouts.loginLayout')

      @section('content')
          <!-- Logo -->
          <div class="flex justify-center">
              <img src="{{ asset('subscription/assets/icons/subscription_logo.svg') }}" alt="MAIS Logo" class="w-24 h-24" />
          </div>
          <!-- Title -->
          <h1 class="text-center text-3xl font-semibold text-blue-600">SISTEM LANGGANAN MAIS</h1>



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

              @if ($invoiceDetails != null)
                  <!-- Header -->
                  <h1 class="text-red-600 text-2xl !font-bold text-center">
                      BAYAR BELUM DIBUAT
                  </h1>

                  <p class="text-base font-semibold text-center">Jumlah keseluruhan yang perlu dibayar
                      <br> <b>RM {{ $invoiceDetails->total }}</b>
                  </p>

                  <div class="flex items-center p-4 bg-gray-100 rounded-lg shadow-md w-full max-w-sm">
                      <img src="{{ asset('subscription/assets/icons/subscription_pdf.svg') }}" alt="PDF Icon"
                          class="w-10 h-10 mr-3" />
                      <span class="flex-grow font-semibold text-gray-900">INVOIS LANGGANAN SPM 2025</span>
                      <button class="text-blue-600 hover:text-blue-800">
                          <span class="fe fe-download-cloud text-2xl"></span>
                      </button>
                  </div>
                  <a href="{{ route('makePayment', ['id' => $user->uid, 'c_id' => $invoiceDetails->code]) }}">
                      <div
                          class="flex items-center p-4 bg-gray-100 rounded-lg shadow-md w-full max-w-sm cursor-pointer mt-4">
                          <img src="{{ asset('subscription/assets/icons/subscription_payment_01.svg') }}" alt="PDF Icon"
                              class="w-10 h-10 mr-3" />
                          <img src="{{ asset('subscription/assets/icons/subscription_payment_02.svg') }}" alt="PDF Icon"
                              class="w-10 h-10 mr-3" />
                          <span class="flex-grow font-semibold text-gray-900">BAYAR YURAN LANGGANAN</span>
                      </div>
                  </a>
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






          {{-- <!-- Copyright -->
    <div class="flex justify-center items-center gap-2 text-sm text-gray-900">
        <img src="{{ asset('subscription/assets/icons/fin_logo_tiny.svg') }}" alt="Admin" class="w-18 h-18" />
        <p>Hakcipta terpelihara oleh Majlis Agama Islam Selangor (MAIS)</p>
    </div> --}}
      @endsection
