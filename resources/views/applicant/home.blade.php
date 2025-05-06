      @extends('layouts.loginLayout')

      @section('content')
        <!-- Logo -->
        <div class="flex justify-center">
          <img src="{{ asset('subscription/assets/icons/fin_logo.svg') }}" alt="MAIS Logo" class="h-32 w-32" />
        </div>
        <!-- Title -->
        <div
          class="mt-2 flex cursor-pointer items-center justify-center text-center font-mont text-3xl !font-normal text-[#2624D0]"
          onclick="location.reload();">
          <h1 class="text-center font-mont text-3xl !font-normal text-[#2624D0]">
            SISTEM PENGURUSAN MASJID
          </h1>
          <img src="{{ asset('subscription/assets/icons/reload.svg') }}" alt="Reload Icon" class="h-10 w-10" />
        </div>

        <div class="mx-auto max-w-5xl space-y-6 p-6">

          <x-alert />

          <!-- Results Section -->
          <div class="flex flex-col items-center space-y-4 text-center">

            <div class="flex items-start gap-3 text-lg text-gray-800">
              {{-- <img src="{{ asset('subscription/assets/icons/subscription_mosque.svg') }}" alt="MAIS Logo"
                          class="w-5 h-5 mt-1" /> --}}

              <p class="font-semibold">
                {{ $user->name }}
              </p>

              <a href="{{ route('instituteEdit') }}"><span class="fe fe-edit text-blue-500"></span></a>
            </div>
            <div class="flex items-start gap-3 text-lg text-gray-800">

              <p class="font-semibold">
                {{ $user->addr }}
                {{ optional($user)->city ? ', ' . $user->CITY : '' }}
                {{ optional($user)->state ? ', ' . $user->STATE : '' }}
              </p>
            </div>

          </div>

          <!-- Financial Report Section -->
          <div
            class="mb-6 flex flex-col items-start justify-between space-y-4 rounded-xl border border-gray-200 bg-white p-6 md:flex-row md:items-center md:space-x-6 md:space-y-0">
            <!-- Left side (Centered) -->
            <div class="flex flex-col items-start">
              <h2 class="text-left text-xl font-bold">PENGHANTARAN</h2>
              <p class="mt-1 text-left text-xl font-bold">LAPORAN KEWANGAN</p>
            </div>

            <!-- Right side -->
            <div class="w-full space-y-3 md:w-1/2">
              <!-- Record Button -->
              <a href="{{ route('statementList') }}"
                class="mb-4 flex w-full items-center rounded-lg bg-gray-100 p-4 transition-colors hover:bg-gray-200 md:w-auto">
                <img src="{{ asset('subscription/assets/icons/subscription_statement_list.svg') }}" alt="PDF Icon"
                  class="mr-3 h-10 w-10" />
                <span class="font-semibold">REKOD PENGHANTARAN</span>
              </a>

              <!-- Send New Button -->
              <a href="{{ route('createStatement', ['id' => $user->uid]) }}"
                class="flex w-full items-center rounded-lg bg-gray-100 p-4 transition-colors hover:bg-gray-200 md:w-auto">
                <img src="{{ asset('subscription/assets/icons/subscription_new_statement.svg') }}" alt="PDF Icon"
                  class="mr-3 h-10 w-10" />
                <span class="font-semibold">HANTAR BARU</span>
              </a>
            </div>
          </div>

          <!-- Subscription Status Section -->
          <div
            class="mb-6 flex flex-col items-start justify-between space-y-4 rounded-xl border border-gray-200 bg-white p-6 md:flex-row md:items-center md:space-x-6 md:space-y-0">
            <!-- Left side (Centered) -->
            <div class="flex flex-col items-start">
              <h2 class="text-left text-xl font-bold">STATUS LANGGANAN</h2>
              @if ($user->subscription_status == 0)
                <p class="mt-1 text-left text-xl font-bold text-red-600">TIDAK AKTIF</p>
              @elseif ($user->subscription_status == 1)
                <p class="mt-1 text-left text-xl font-bold" style="color: orange;">DALAM SEMAKAN</p>
              @elseif($user->subscription_status == 2)
                <p class="mt-1 text-left text-xl font-bold text-red-600">
                  BAYARAN BELUM DIBUAT<br>
                  @if ($invoiceDetails != null)
                    <span class="text-md font-semibold"><b>RM {{ $invoiceDetails->total }}</b></span>
                  @endif
                </p>
              @elseif($user->subscription_status == 3)
                <p class="mt-1 text-left text-xl font-bold text-green-600">AKTIF</p>
              @endif
            </div>

            <!-- Right side -->
            <div class="w-full space-y-3 md:w-1/2">
              @if ($user->subscription_status == 0)
                <a href="javascript:void(0);" onclick="document.getElementById('successModal').style.display='flex'"
                  class="flex w-full items-center rounded-lg bg-gray-100 p-3 transition-colors hover:bg-gray-200 md:w-auto">
                  <img src="{{ asset('subscription/assets/icons/subscription_icon.svg') }}" alt="PDF Icon"
                    class="mr-3 h-10 w-10" />
                  <div class="mr-3">
                    <span class="text-sm font-semibold">LANGGAN SEKARANG</span>
                  </div>
                </a>

                <!-- Success Modal -->
                <div id="successModal"
                  class="fixed inset-0 z-50 flex hidden items-center justify-center bg-gray-900 bg-opacity-40">
                  <div class="relative w-full max-w-3xl rounded-xl bg-white p-6 text-center shadow-lg">
                    <!-- Close Button -->
                    <button onclick="document.getElementById('successModal').style.display='none'"
                      class="absolute right-4 top-2 p-3 text-3xl text-gray-500 hover:text-gray-700">
                      &times;
                    </button>

                    <!-- Modal Title -->
                    <h2 class="mb-2 text-start text-lg font-semibold text-green-600">
                      Permintaan Untuk Langganan!
                    </h2>
                    <hr>

                    <!-- Modal Content -->
                    <p class="mb-8 mt-4 text-xs text-black">
                      Adakah anda pasti mahu memohon langganan?
                    </p>
                    <hr>

                    <!-- Action Buttons -->
                    <div class="flex justify-end">
                      <button onclick="window.location.href='{{ route('requestSubscription', ['id' => $user->uid]) }}'"
                        class="mt-2 rounded-lg bg-blue-600 px-6 py-2 text-white hover:bg-blue-700">
                        Ya, Mohon Langganan
                      </button>
                    </div>
                  </div>
                </div>
              @elseif ($user->subscription_status == 1)
                <p class="text-md mt-1 text-left font-semibold">Permohonan Langganan anda dalam proses semakan.
                  Sila semak kembali status langganan dalam tempoh tiga (03) hari bekerja.</p>
              @elseif($user->subscription_status == 2)
                <!-- Record Button -->
                @if ($invoiceDetails != null)
                  <a href="{{ $invoiceLink }}" target="_blank"
                    class="mb-4 flex w-full items-center justify-between rounded-lg bg-gray-100 p-3 transition-colors hover:bg-gray-200 md:w-auto">

                    <!-- Left Section: PDF Icon + Text -->
                    <div class="flex items-center">
                      <img src="{{ asset('subscription/assets/icons/subscription_pdf.svg') }}" alt="PDF Icon"
                        class="mr-3 h-10 w-10" />
                      <span class="text-sm font-semibold">INVOIS LANGGANAN</span>
                    </div>

                    <!-- Right Section: Download Icon -->
                    <div class="ml-auto">
                      <span class="fe fe-download-cloud mr-3 text-2xl text-blue-700"></span>
                    </div>

                  </a>

                  <!-- Send New Button -->
                  <a href="{{ route('makePayment', ['id' => $user->uid, 'c_id' => $invoiceDetails->code]) }}"
                    target=_blank
                    class="flex w-full items-center rounded-lg bg-gray-100 p-4 transition-colors hover:bg-gray-200 md:w-auto">
                    <div class="flex items-center">
                      <img src="{{ asset('subscription/assets/icons/subscription_payment_01.svg') }}" alt="PDF Icon"
                        class="mr-3 h-10 w-10" />
                    </div>
                    <div class="font-semibold">BAYAR YURAN LANGGANAN</div>
                  </a>
                @endif
              @elseif($user->subscription_status == 3)
                @if ($receiptDetails != null)
                  <a href="{{ $receiptLink }}" target="_blank"
                    class="mb-4 flex w-full items-center justify-between rounded-lg bg-gray-100 p-3 transition-colors hover:bg-gray-200 md:w-auto">

                    <!-- Left Section: PDF Icon + Text -->
                    <div class="flex items-center">
                      <img src="{{ asset('subscription/assets/icons/subscription_pdf.svg') }}" alt="PDF Icon"
                        class="mr-3 h-10 w-10" />
                      <span class="text-sm font-semibold">RESIT LANGGANAN</span>
                    </div>

                    <!-- Right Section: Download Icon -->
                    <div class="ml-auto">
                      <span class="fe fe-download-cloud mr-3 text-2xl text-blue-700"></span>
                    </div>

                  </a>
                @endif
              @endif

            </div>
          </div>

          <!-- Divider -->
          <div class="my-6 border-t border-gray-300"></div>

          <div class="flex w-full justify-center">
            <form id="logout-form" action="{{ route('subscriptionLogout') }}" method="POST">
              @csrf
              <button type="submit"
                class="flex w-full items-center justify-center rounded-full bg-blue-600 px-6 py-3 text-lg font-semibold text-white transition-colors hover:bg-blue-700">
                Keluar
                <span class="fe fe-log-out ml-4 text-2xl"></span>
              </button>
            </form>
          </div>

        </div>
      @endsection
