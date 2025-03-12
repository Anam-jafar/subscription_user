      @extends('layouts.loginLayout')

      @section('content')
          <!-- Logo -->
          <div class="flex justify-center">
              <img src="{{ asset('subscription/assets/icons/fin_logo.svg') }}" alt="MAIS Logo" class="w-32 h-32" />
          </div>
          <!-- Title -->
          <h1 class="text-center text-3xl !font-normal text-[#2624D0] mt-2 font-mont">SISTEM MAIS</h1>



          <div class="max-w-5xl mx-auto p-6 space-y-6">

              <x-alert />

              <!-- Results Section -->
              <div class="space-y-4 flex flex-col items-center text-center">


                  <div class="flex items-center gap-3 text-gray-800 text-lg">
                      <img src="{{ asset('subscription/assets/icons/subscription_mosque.svg') }}" alt="MAIS Logo"
                          class="w-5 h-5" />

                      <p class="font-semibold">
                          {{ $user->name }}
                          {{ optional($user)->addr ? ', ' . $user->addr : '' }}
                          {{ optional($user)->city ? ', ' . $user->city : '' }}
                          {{ optional($user)->state ? ', ' . $user->state : '' }}
                      </p>

                      <a href="#"><span class="fe fe-edit text-blue-500"></span></a>
                  </div>

              </div>

              {{-- @if ($user->subscription_status == 0)
                  <h1 class="text-yellow-600 text-2xl !font-bold text-center">
                      BELUM LANGGAN
                  </h1>

                  <form action="" method="POST">
                      @csrf

                      <button type="submit"
                          class="w-full bg-green-600 text-white py-3 px-6 rounded-full hover:bg-blue-700 transition-colors text-lg font-semibold flex items-center justify-center">
                          Hantar Permintaan
                      </button>
                  </form>
              @elseif($user->subscription_status == 1)
                  <!-- Header -->
                  <h1 class="text-green-600 text-2xl !font-bold text-center">
                      BELUM DILULUSKAN </h1>
                  <p class="text-base font-semibold text-center">Setelah admin meluluskan, anda boleh membuat
                      pembayaran.</b>

                  </p>
              @endif --}}

              <!-- Subscription Status Section -->
              <div class="rounded-xl border border-gray-200 p-6 mb-6 bg-white flex justify-between items-center">
                  <!-- Left side (Centered) -->
                  <div class="flex flex-col items-start">
                      <p class="text-black text-sm font-semibold mb-4">
                          Keputusan sehingga <br>{{ $currentDateTime }}
                      </p>
                      <h2 class="text-left text-xl font-bold">STATUS LANGGANAN</h2>
                      <p class="text-left text-xl font-bold text-pink-600 mt-1">BAYARAN BELUM DIBUAT</p>
                  </div>


                  <!-- Right side -->
                  <div class="space-y-3 lg:min-w-[400px]">
                      <!-- Record Button -->
                      <a href="#"
                          class="flex items-center bg-gray-100 rounded-lg p-3 hover:bg-gray-200 transition-colors">
                          <img src="{{ asset('subscription/assets/icons/subscription_pdf.svg') }}" alt="PDF Icon"
                              class="w-10 h-10 mr-3" />
                          <div class="mr-3">
                              <span class="font-semibold text-sm mr-6">INVOIS LANGGANAN SPM 2025</span>
                          </div>
                          <div>
                              <button class="text-blue-600 hover:text-blue-800">
                                  <span class="fe fe-download-cloud text-2xl"></span>
                              </button>
                          </div>
                      </a>

                      <!-- Send New Button -->
                      <a href="#"
                          class="flex items-center bg-gray-100 rounded-lg p-4 mt-4 hover:bg-gray-200 transition-colors">
                          <div class="flex items-center">
                              <img src="{{ asset('subscription/assets/icons/subscription_payment_01.svg') }}" alt="PDF Icon"
                                  class="w-10 h-10 mr-3" />
                              <img src="{{ asset('subscription/assets/icons/subscription_payment_02.svg') }}" alt="PDF Icon"
                                  class="w-10 h-10 mr-3" />
                          </div>
                          <div class="font-semibold">BAYAR YURAN LANGGANAN</div>
                      </a>
                  </div>
              </div>


              <!-- Financial Report Section -->
              <div class="rounded-xl border border-gray-200 p-6 mb-6 bg-white flex justify-between items-center">
                  <!-- Left side (Centered) -->
                  <div class="flex flex-col items-start">
                      <h2 class="text-left text-xl font-bold">PENGHANTARAN</h2>
                      <p class="text-left text-xl font-bold mt-1">LAPORAN KEWANGAN</p>
                  </div>

                  <!-- Right side -->
                  <div class="space-y-3 lg:min-w-[400px]">
                      <!-- Record Button -->
                      <a href="#"
                          class="flex items-center bg-gray-100 rounded-lg p-4 hover:bg-gray-200 transition-colors">
                          <img src="{{ asset('subscription/assets/icons/subscription_statement_list.svg') }}"
                              alt="PDF Icon" class="w-10 h-10 mr-3" />
                          <span class="font-semibold">REKOD PENGHANTARAN</span>
                      </a>

                      <!-- Send New Button -->
                      <a href="#"
                          class="flex items-center bg-gray-100 rounded-lg p-4 hover:bg-gray-200 transition-colors">
                          <img src="{{ asset('subscription/assets/icons/subscription_new_statement.svg') }}" alt="PDF Icon"
                              class="w-10 h-10 mr-3" />
                          <span class="font-semibold">HANTAR BARU</span>
                      </a>
                  </div>
              </div>


              <!-- Divider -->
              <div class="border-t border-gray-300 my-6"></div>



              <div class="flex justify-center">

                  <form id="logout-form" action="{{ route('subscriptionLogout') }}" method="POST">
                      @csrf
                      <button type="submit"
                          class="w-[24rem] bg-blue-600 text-white py-3 px-6 rounded-full hover:bg-blue-700 transition-colors text-lg font-semibold flex items-center justify-center">
                          Keluar
                          <span class="fe fe-log-out text-2xl ml-4"></span>
                      </button>
                  </form>
              </div>


          </div>
      @endsection
