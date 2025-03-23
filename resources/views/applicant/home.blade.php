      @extends('layouts.loginLayout')

      @section('content')
          <!-- Logo -->
          <div class="flex justify-center">
              <img src="{{ asset('subscription/assets/icons/fin_logo.svg') }}" alt="MAIS Logo" class="w-32 h-32" />
          </div>
          <!-- Title -->
          <h1 class="text-center text-3xl !font-normal text-[#2624D0] mt-2 font-mont">SISTEM PENGURUSAN MASJID
          </h1>



          <div class="max-w-5xl mx-auto p-6 space-y-6">

              <x-alert />

              <!-- Results Section -->
              <div class="space-y-4 flex flex-col items-center text-center">


                  <div class="flex items-start gap-3 text-gray-800 text-lg">
                      {{-- <img src="{{ asset('subscription/assets/icons/subscription_mosque.svg') }}" alt="MAIS Logo"
                          class="w-5 h-5 mt-1" /> --}}

                      <p class="font-semibold">
                          {{ $user->name }}
                      </p>

                      <a href="{{ route('instituteEdit') }}"><span class="fe fe-edit text-blue-500"></span></a>
                  </div>
                  <div class="flex items-start gap-3 text-gray-800 text-lg">

                      <p class="font-semibold">
                          {{ $user->addr }}
                          {{ optional($user)->city ? ', ' . $user->CITY : '' }}
                          {{ optional($user)->state ? ', ' . $user->STATE : '' }}
                      </p>
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
                  <div class="space-y-3 w-full md:w-1/2">
                      <!-- Record Button -->
                      <a href="{{ route('statementList') }}"
                          class="flex items-center bg-gray-100 rounded-lg p-4 hover:bg-gray-200 transition-colors w-full md:w-auto mb-4">
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
                      @if ($user->subscription_status == 0)
                          <p class="text-left text-xl font-bold text-red-600 mt-1">TIDAK AKTIF</p>
                      @elseif ($user->subscription_status == 1)
                          <p class="text-left text-xl font-bold mt-1" style="color: orange;">DALAM SEMAKAN</p>
                      @elseif($user->subscription_status == 2)
                          <p class="text-left text-xl font-bold text-red-600 mt-1">
                              BAYARAN BELUM DIBUAT<br>
                              @if ($invoiceDetails != null)
                                  <span class="text-md font-semibold"><b>RM {{ $invoiceDetails->total }}</b></span>
                              @endif
                          </p>
                      @elseif($user->subscription_status == 3)
                          <p class="text-left text-xl font-bold text-green-600 mt-1">AKTIF</p>
                      @endif
                  </div>

                  <!-- Right side -->
                  <div class="space-y-3 w-full md:w-1/2">
                      @if ($user->subscription_status == 0)
                          <a href="javascript:void(0);"
                              onclick="document.getElementById('successModal').style.display='flex'"
                              class="flex items-center bg-gray-100 rounded-lg p-3 hover:bg-gray-200 transition-colors w-full md:w-auto">
                              <img src="{{ asset('subscription/assets/icons/subscription_icon.svg') }}" alt="PDF Icon"
                                  class="w-10 h-10 mr-3" />
                              <div class="mr-3">
                                  <span class="font-semibold text-sm">LANGGAN SEKARANG</span>
                              </div>
                          </a>

                          <!-- Success Modal -->
                          <div id="successModal"
                              class="hidden fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-40 z-50">
                              <div class="bg-white rounded-xl shadow-lg p-6 max-w-3xl w-full text-center relative">
                                  <!-- Close Button -->
                                  <button onclick="document.getElementById('successModal').style.display='none'"
                                      class="absolute top-2 right-4 text-gray-500 hover:text-gray-700 text-3xl p-3">
                                      &times;
                                  </button>

                                  <!-- Modal Title -->
                                  <h2 class="text-green-600 text-lg font-semibold mb-2 text-start">
                                      Permintaan Untuk Langganan!
                                  </h2>
                                  <hr>

                                  <!-- Modal Content -->
                                  <p class="text-black text-xs mt-4 mb-8">
                                      Adakah anda pasti mahu memohon langganan?
                                  </p>
                                  <hr>

                                  <!-- Action Buttons -->
                                  <div class="flex justify-end">
                                      <button
                                          onclick="window.location.href='{{ route('requestSubscription', ['id' => $user->uid]) }}'"
                                          class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 mt-2">
                                          Ya, Mohon Langganan
                                      </button>
                                  </div>
                              </div>
                          </div>
                      @elseif ($user->subscription_status == 1)
                          <p class="text-left text-md font-semibold mt-1">Permohonan Langganan anda dalam proses semakan.
                              Sila semak kembali status langganan dalam tempoh tiga (03) hari bekerja.</p>
                      @elseif($user->subscription_status == 2)
                          <!-- Record Button -->
                          @if ($invoiceDetails != null)
                              <a href="{{ $invoiceLink }}" target="_blank"
                                  class="flex justify-between items-center bg-gray-100 rounded-lg p-3 hover:bg-gray-200 transition-colors w-full md:w-auto mb-4">

                                  <!-- Left Section: PDF Icon + Text -->
                                  <div class="flex items-center">
                                      <img src="{{ asset('subscription/assets/icons/subscription_pdf.svg') }}"
                                          alt="PDF Icon" class="w-10 h-10 mr-3" />
                                      <span class="font-semibold text-sm">INVOIS LANGGANAN</span>
                                  </div>

                                  <!-- Right Section: Download Icon -->
                                  <div class="ml-auto">
                                      <span class="fe fe-download-cloud text-2xl mr-3 text-blue-700"></span>
                                  </div>

                              </a>

                              <!-- Send New Button -->
                              <a href="{{ route('makePayment', ['id' => $user->uid, 'c_id' => $invoiceDetails->code]) }}"
                                  class="flex items-center bg-gray-100 rounded-lg p-4 hover:bg-gray-200 transition-colors w-full md:w-auto">
                                  <div class="flex items-center">
                                      <img src="{{ asset('subscription/assets/icons/subscription_payment_01.svg') }}"
                                          alt="PDF Icon" class="w-10 h-10 mr-3" />
                                  </div>
                                  <div class="font-semibold">BAYAR YURAN LANGGANAN</div>
                              </a>
                          @endif
                      @elseif($user->subscription_status == 3)
                          @if ($receiptDetails != null)
                              <a href="{{ $receiptLink }}" target="_blank"
                                  class="flex justify-between items-center bg-gray-100 rounded-lg p-3 hover:bg-gray-200 transition-colors w-full md:w-auto mb-4">

                                  <!-- Left Section: PDF Icon + Text -->
                                  <div class="flex items-center">
                                      <img src="{{ asset('subscription/assets/icons/subscription_pdf.svg') }}"
                                          alt="PDF Icon" class="w-10 h-10 mr-3" />
                                      <span class="font-semibold text-sm">RESIT LANGGANAN</span>
                                  </div>

                                  <!-- Right Section: Download Icon -->
                                  <div class="ml-auto">
                                      <span class="fe fe-download-cloud text-2xl mr-3 text-blue-700"></span>
                                  </div>

                              </a>
                          @endif
                      @endif

                  </div>
              </div>





              <!-- Divider -->
              <div class="border-t border-gray-300 my-6"></div>



              <div class="w-full flex justify-center">
                  <form id="logout-form" action="{{ route('subscriptionLogout') }}" method="POST">
                      @csrf
                      <button type="submit"
                          class="w-1/2 bg-blue-600 text-white py-3 px-6 rounded-full hover:bg-blue-700 transition-colors text-lg font-semibold flex items-center justify-center">
                          Keluar
                          <span class="fe fe-log-out text-2xl ml-4"></span>
                      </button>
                  </form>
              </div>



          </div>
      @endsection
