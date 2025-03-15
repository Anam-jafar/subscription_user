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


                  <div class="flex items-start gap-3 text-gray-800 text-lg">
                      <img src="{{ asset('subscription/assets/icons/subscription_mosque.svg') }}" alt="MAIS Logo"
                          class="w-5 h-5 mt-1" />

                      <p class="font-semibold">
                          {{ $user->name }} <br>
                          {{ optional($user)->addr ? ', ' . $user->addr : '' }}
                          {{ optional($user)->city ? ', ' . $user->city : '' }}
                          {{ optional($user)->state ? ', ' . $user->state : '' }}
                      </p>

                      <a href="{{ route('instituteEdit') }}"><span class="fe fe-edit text-blue-500"></span></a>
                  </div>

              </div>


              <!-- Financial Report Section -->
              <div
                  class="rounded-xl border border-gray-200 p-6 mb-6 bg-white flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0 md:space-x-6">
                  <!-- Left side (Centered) -->
                  <div class="flex flex-col items-start">
                      <h2 class="text-left text-xl font-bold">PENGHANTARAN</h2>
                      <p class="text-left text-xl font-bold mt-1">LAPORAN KEWANGAN</p>
                  </div>

                  <!-- Right side -->
                  <div class="space-y-3 w-full md:w-[400px]">
                      <!-- Record Button -->
                      <a href="{{ route('statementList') }}"
                          class="flex items-center bg-gray-100 rounded-lg p-4 hover:bg-gray-200 transition-colors w-full md:w-auto">
                          <img src="{{ asset('subscription/assets/icons/subscription_statement_list.svg') }}" alt="PDF Icon"
                              class="w-10 h-10 mr-3" />
                          <span class="font-semibold">REKOD PENGHANTARAN</span>
                      </a>

                      <!-- Send New Button -->
                      <a href="{{ route('createStatement', ['id' => $user->uid]) }}"
                          class="flex items-center bg-gray-100 rounded-lg p-4 hover:bg-gray-200 transition-colors w-full md:w-auto">
                          <img src="{{ asset('subscription/assets/icons/subscription_new_statement.svg') }}" alt="PDF Icon"
                              class="w-10 h-10 mr-3" />
                          <span class="font-semibold">HANTAR BARU</span>
                      </a>
                  </div>
              </div>

              <!-- Subscription Status Section -->
              <div
                  class="rounded-xl border border-gray-200 p-6 mb-6 bg-white flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0 md:space-x-6">
                  <!-- Left side (Centered) -->
                  <div class="flex flex-col items-start">
                      <h2 class="text-left text-xl font-bold">STATUS LANGGANAN</h2>
                      <p class="text-left text-xl font-bold text-pink-600 mt-1">BAYARAN BELUM DIBUAT</p>
                  </div>

                  <!-- Right side -->
                  <div class="space-y-3 w-full md:w-[400px]">
                      <!-- Record Button -->
                      <a href="#"
                          class="flex items-center bg-gray-100 rounded-lg p-3 hover:bg-gray-200 transition-colors w-full md:w-auto">
                          <img src="{{ asset('subscription/assets/icons/subscription_pdf.svg') }}" alt="PDF Icon"
                              class="w-10 h-10 mr-3" />
                          <div class="mr-3">
                              <span class="font-semibold text-sm">INVOIS LANGGANAN SPM 2025</span>
                          </div>
                          <button class="text-blue-600 hover:text-blue-800">
                              <span class="fe fe-download-cloud text-2xl"></span>
                          </button>
                      </a>

                      <!-- Send New Button -->
                      <a href="#"
                          class="flex items-center bg-gray-100 rounded-lg p-4 hover:bg-gray-200 transition-colors w-full md:w-auto">
                          <div class="flex items-center">
                              <img src="{{ asset('subscription/assets/icons/subscription_payment_01.svg') }}"
                                  alt="PDF Icon" class="w-10 h-10 mr-3" />
                              <img src="{{ asset('subscription/assets/icons/subscription_payment_02.svg') }}"
                                  alt="PDF Icon" class="w-10 h-10 mr-3" />
                          </div>
                          <div class="font-semibold">BAYAR YURAN LANGGANAN</div>
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
