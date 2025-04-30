@extends('layouts.loginLayout_')

@section('styles')
  <!-- FlatPickr CSS -->
  <link rel="stylesheet" href="{{ asset('subscription/build/assets/libs/flatpickr/flatpickr.min.css') }}">
@endsection

@section('content')
  <!-- Start::app-content -->
  <div class="main-content app-content m-0 p-0">
    <div class="container-fluid p-0">
      <!-- Start::row-1 -->
      <div class="grid grid-cols-12 gap-x-6">
        <div class="col-span-12 xl:col-span-12">
          <div class="box">
            <!-- Logo -->
            <div class="mt-4 flex justify-center">
              <img src="{{ asset('subscription/assets/icons/fin_logo.svg') }}" alt="MAIS Logo" class="h-24 w-24" />
            </div>
            <!-- Title -->
            <h1 class="mt-2 text-center font-mont text-3xl !font-normal text-[#2624D0]">PENGHANTARAN LAPORAN
              KEWANGAN BARU</h1>
            <div class='px-4'>
              <x-alert />
            </div>
            <div class="box-body !p-0">
              <form class="wizard wizard-tab horizontal" id="financial_form" method="POST"
                action="{{ route('createStatement', ['id' => $institute->id]) }}" enctype="multipart/form-data">

                @csrf
                <aside class="wizard-content container">
                  <div class="wizard-step" data-title="Butiran Penyata" data-id="2e8WqSV3slGIpTbnjcJzmDwBQaHrfh0Z">
                    <div class="justify-content-center grid grid-cols-12 sm:gap-x-6">
                      <div class="col-span-12 xl:col-span-12">
                        <div class="register-page">
                          @if ($instituteType == 2)
                            <div class="gap-y-4 sm:gap-x-6">
                              <x-required-warning-text />

                              <div class="grid-cols1 grid gap-6 md:grid-cols-2">
                                <div class="grid grid-cols-2 gap-6">
                                  <x-input-field level="Bagi Tahun" id="ye" name="fin_year" type="select"
                                    placeholder="Pilih" :valueList="$years" :required="true" />

                                  <x-input-field level="Kategori Penyata" id="statment" name="fin_category"
                                    type="select" placeholder="Pilih" :valueList="$parameters['statements']" :required="true" />
                                </div>
                                <x-input-field level="Peratus Kemajuan Pembinaan Terkini (%)"
                                  id="latest_contruction_progress" name="latest_contruction_progress" type="text"
                                  placeholder="00" :required="true" />
                              </div>

                              <div class="col-span-12 mt-4 xl:col-span-6">
                                <p class="font-medium text-gray-800">A. Maklumat Pembinaan
                                </p>
                              </div>
                              <div class="col-span-12 mt-4 xl:col-span-6">
                              </div>

                              <div class="grid-cols1 grid gap-6 md:grid-cols-2">
                                <x-input-field level="(i) Kos Pembinaan (Asal, RM)" id="ori_contruction_cost"
                                  name="ori_contruction_cost" type="money" placeholder="00.00" :rightAlign="true"
                                  :required="true" />
                                <x-input-field level="(ii) Variation Order (Tambah Kurang, RM)" id="variation_order"
                                  name="variation_order" type="money" placeholder="00.00" :rightAlign="true"
                                  :required="true" />
                              </div>

                              <div class="col-span-12 mt-4 xl:col-span-6">
                                <p class="font-medium text-gray-800">B. Jumlah Kutipan</p>
                              </div>
                              <div class="col-span-12 mt-4 xl:col-span-6">
                              </div>
                              <div class="grid-cols1 grid gap-6 md:grid-cols-2">
                                <x-input-field level="(i) Kutipan Semasa (RM)" id="current_collection"
                                  name="current_collection" type="money" placeholder="00.00" :rightAlign="true"
                                  :required="true" />
                                <x-input-field level="(ii) Kutipan Terkumpul (RM)" id="expenses" name="total_expenses"
                                  type="money" placeholder="00.00" :rightAlign="true" :required="true" />
                              </div>

                              <div class="col-span-12 mt-4 xl:col-span-6">
                                <p class="font-medium text-gray-800">C. Jumlah Perbelanjaan
                                </p>
                              </div>
                              <div class="col-span-12 mt-4 xl:col-span-6">
                              </div>
                              <div class="grid-cols1 grid gap-6 md:grid-cols-2">
                                <x-input-field level="(i) Pindahan Kepada PWS (RM)" id="transfer_pws" name="transfer_pws"
                                  type="money" placeholder="00.00" :rightAlign="true" :required="true" />
                                <x-input-field level="(ii) Belanja Pembinaan Masjid/Surau (RM)" id="contruction_expenses"
                                  name="contruction_expenses" type="money" placeholder="00.00" :rightAlign="true"
                                  :required="true" />
                              </div>

                              <div class="grid-cols1 grid gap-6 md:grid-cols-2">
                                <x-input-field level="(iii) Belanja Pembinaan PWS (RM)" id="pws_expenses"
                                  name="pws_expenses" type="money" placeholder="00.00" :rightAlign="true"
                                  :required="true" />
                              </div>
                              <div class="col-span-12 xl:col-span-6">
                              </div>
                              <div class="col-span-12 mt-4 xl:col-span-6">
                                <p class="font-medium text-gray-800">D. Jumlah Lebihan</p>
                              </div>
                              <div class="col-span-12 mt-4 xl:col-span-6">
                              </div>
                              <div class="grid-cols1 grid gap-6 md:grid-cols-2">
                                <x-input-field level="(i) Lebihan Masjid/Surau (RM)" id="inst_surplus" name="inst_surplus"
                                  type="money" placeholder="00.00" :rightAlign="true" :required="true" />
                                <x-input-field level="(ii) Lebihan PWS (RM)" id="pws_surplus" name="pws_surplus"
                                  type="money" placeholder="00.00" :rightAlign="true" :required="true" />
                              </div>
                            </div>
                          @else
                            <div class="gap-y-4 sm:gap-x-6">
                              <x-required-warning-text />

                              <div class="grid-cols1 grid gap-6 md:grid-cols-2">
                                <div class="grid grid-cols-2 gap-6">
                                  <x-input-field level="Bagi Tahun" id="ye" name="fin_year" type="select"
                                    placeholder="Pilih" :valueList="$years" :required="true" />

                                  <x-input-field level="Kategori Penyata" id="statment" name="fin_category"
                                    type="select" placeholder="Pilih" :valueList="$parameters['statements']" :required="true" />
                                </div>
                                <x-input-field level="(a) Baki Bawa Ke Hadapan 1 Januari (RM)" id="balance_forward"
                                  name="balance_forward" type="money" placeholder="00.00" :rightAlign="true"
                                  :required="true" spanText="Baki bawa kehadapan tahun sebelumnya bank dan tunai" />

                              </div>
                              <div class="grid-cols1 grid gap-6 md:grid-cols-2">

                                <x-input-field level="(b) Jumlah Kutipan (RM)" id="total_collection"
                                  name="total_collection" type="money" placeholder="00.00" :rightAlign="true"
                                  :required="true" spanText="Jumlah Kutipan Tahun Semasa" />
                                <x-input-field level="(c) Jumlah Perbelanjaan (RM)" id="total_expenses"
                                  name="total_expenses" type="money" placeholder="00.00" :rightAlign="true"
                                  :required="true" />

                              </div>
                              <div class="grid-cols1 grid gap-6 md:grid-cols-2">
                                <x-input-field level="(d) Jumlah Pendapatan (RM)" id="total_income" name="total_income"
                                  type="money" placeholder="00.00" :rightAlign="true" :required="true"
                                  :readonly="true" />
                                <x-input-field level="(e) Jumlah Lebihan/Kurangan Tahun Semasa (RM)" id="total_surplus"
                                  name="total_surplus" type="money" placeholder="00.00" :rightAlign="true"
                                  :required="true" :readonly="true" />

                              </div>
                              <div class="grid-cols1 grid gap-6 md:grid-cols-2">

                                <x-input-field level="(f) Maklumat Baki Bank Dan Tunai (RM)" id="bank_cash_balance"
                                  name="bank_cash_balance" type="money" placeholder="00.00" :rightAlign="true"
                                  :required="true" :readonly="true" />
                              </div>
                            </div>
                          @endif
                          <div class="mt-8 flex flex-col justify-between space-y-3 md:flex-row md:space-y-0">
                            <a href="{{ route('home') }}"
                              class="text-md flex items-center font-bold text-blue-500 no-underline hover:cursor-pointer hover:text-blue-700">
                              <span class="fe fe-arrow-left-circle text-md mr-2 font-bold"></span>
                              Kembali
                            </a>

                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="wizard-step" data-title="Lampiran" data-id="2e8WqSV3slGIpTbnjcJzmDwBQaHrfjHQ">
                    <div class="justify-content-center grid grid-cols-12 sm:gap-x-6">
                      <div class="col-span-12 xl:col-span-12">
                        <div class="register-page">
                          @if ($instituteType == 2)
                            <div class="gap-y-4 sm:gap-x-6">
                              <span class="text-md fe fe-info text-red-500">Hanya Fail PDF yang diterima</span>

                              <div class="grid-cols1 grid gap-6 md:grid-cols-2">
                                <div class="mt-4 flex flex-col">
                                  <label for="attachment1" class="mb-2 text-gray-800">
                                    Penyata Kewangan <span class="text-red-500">*</span>
                                  </label>
                                  <input type="file" id="attachment1" name="attachment1" required accept=".pdf"
                                    onchange="validateFiles()"
                                    class="block h-[3rem] w-full rounded-sm border border-gray-200 text-sm text-textmuted file:me-4 file:h-[3rem] file:rounded-s-sm file:border-0 file:bg-primary file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-primary focus:z-10 focus:border-gray-200 focus:shadow-sm focus:outline-0 focus-visible:outline-none dark:border-white/10 dark:text-textmuted/50 dark:focus:border-white/10 dark:focus:shadow-white/10">
                                  <span id="attachment1-error" class="mt-1 text-sm text-red-500"></span>
                                </div>
                                <div class="mt-4 flex flex-col">
                                  <label for="attachment2" class="mb-2 text-gray-800">
                                    Penyata Bank <span class="text-red-500">*</span>
                                  </label>
                                  <input type="file" id="attachment2" name="attachment2" required accept=".pdf"
                                    onchange="validateFiles()"
                                    class="block h-[3rem] w-full rounded-sm border border-gray-200 text-sm text-textmuted file:me-4 file:h-[3rem] file:rounded-s-sm file:border-0 file:bg-primary file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-primary focus:z-10 focus:border-gray-200 focus:shadow-sm focus:outline-0 focus-visible:outline-none dark:border-white/10 dark:text-textmuted/50 dark:focus:border-white/10 dark:focus:shadow-white/10">
                                  <span id="attachment2-error" class="mt-1 text-sm text-red-500"></span>
                                </div>
                              </div>
                              <div class="grid-cols1 grid gap-6 md:grid-cols-2">
                                <div class="mt-4 flex flex-col">
                                  <label for="attachment3" class="mb-2 text-gray-800">
                                    Certificate Completion & Compliance (CCC)
                                  </label>
                                  <input type="file" id="attachment3" name="attachment3" accept=".pdf"
                                    onchange="validateFiles()"
                                    class="block h-[3rem] w-full rounded-sm border border-gray-200 text-sm text-textmuted file:me-4 file:h-[3rem] file:rounded-s-sm file:border-0 file:bg-primary file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-primary focus:z-10 focus:border-gray-200 focus:shadow-sm focus:outline-0 focus-visible:outline-none dark:border-white/10 dark:text-textmuted/50 dark:focus:border-white/10 dark:focus:shadow-white/10">
                                  <span id="attachment3-error" class="mt-1 text-sm text-red-500"></span>
                                </div>
                              </div>
                            </div>
                          @else
                            <div class="gap-y-4 sm:gap-x-6">
                              <span class="text-md fe fe-info text-red-500">Hanya Fail PDF yang diterima</span>

                              <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div class="mt-4 flex flex-col">
                                  <label for="attachment1" class="mb-2 text-gray-800">
                                    Penyata Kewangan Dan Nota Kewangan <span class="text-red-500">*</span>
                                  </label>
                                  <input type="file" id="attachment1" name="attachment1" required accept=".pdf"
                                    onchange="validateFiles()"
                                    class="block h-[3rem] w-full rounded-sm border border-gray-200 text-sm text-textmuted file:me-4 file:h-[3rem] file:rounded-s-sm file:border-0 file:bg-primary file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-primary focus:z-10 focus:border-gray-200 focus:shadow-sm focus:outline-0 focus-visible:outline-none dark:border-white/10 dark:text-textmuted/50 dark:focus:border-white/10 dark:focus:shadow-white/10">
                                  <span id="attachment1-error" class="mt-1 text-sm text-red-500"></span>
                                </div>
                                <x-input-field level="Jenis Pengauditan" id="institusi" name="attachment1_info"
                                  type="select" placeholder="" :valueList="$parameters['audit_types']" :required="true" />
                              </div>

                              <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div class="mt-4 flex flex-col">
                                  <label for="attachment2" class="mb-2 text-gray-800">
                                    Penyata Bank <span class="text-red-500">*</span>
                                  </label>
                                  <input type="file" id="attachment2" name="attachment2" required accept=".pdf"
                                    onchange="validateFiles()"
                                    class="block h-[3rem] w-full rounded-sm border border-gray-200 text-sm text-textmuted file:me-4 file:h-[3rem] file:rounded-s-sm file:border-0 file:bg-primary file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-primary focus:z-10 focus:border-gray-200 focus:shadow-sm focus:outline-0 focus-visible:outline-none dark:border-white/10 dark:text-textmuted/50 dark:focus:border-white/10 dark:focus:shadow-white/10">
                                  <span id="attachment2-error" class="mt-1 text-sm text-red-500"></span>
                                </div>

                                <div class="mt-4 flex flex-col">
                                  <label for="attachment3" class="mb-2 text-gray-800">
                                    Penyata Penyesuaian Bank 
                                  </label>
                                  <input type="file" id="attachment3" name="attachment3" accept=".pdf"
                                    onchange="validateFiles()"
                                    class="block h-[3rem] w-full rounded-sm border border-gray-200 text-sm text-textmuted file:me-4 file:h-[3rem] file:rounded-s-sm file:border-0 file:bg-primary file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-primary focus:z-10 focus:border-gray-200 focus:shadow-sm focus:outline-0 focus-visible:outline-none dark:border-white/10 dark:text-textmuted/50 dark:focus:border-white/10 dark:focus:shadow-white/10">
                                  <span id="attachment3-error" class="mt-1 text-sm text-red-500"></span>
                                </div>
                              </div>
                            </div>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="wizard-step" data-title="Pengesahan" data-id="dOM0iRAyJXsLTr9b3KZfQ2jNv4pgn6Gu"
                    data-limit="3">
                    <div class="grid grid-cols-12 sm:gap-x-6">
                      <div class="col-span-12 xl:col-span-12">
                        <div class="checkout-payment-success">
                          <div class="mb-4">
                          </div>
                          <div class="mt-8 grid max-w-3xl grid-cols-1 gap-x-16 gap-y-2">

                            <x-show-key-value :key="'Nama Pengawal / Wakil Institusi'" :value="$institute->con1" />
                            <x-show-key-value :key="'Jawatan'" :value="$institute->UserPosition->prm" />
                            <x-show-key-value :key="'No. H/P'" :value="$institute->hp" />
                            <x-show-key-value :key="'Emel'" :value="$institute->mel" />

                          </div>

                          <input type="hidden" name="draft" id="draft_input" value="false">
                          <input type="hidden" name="inst_refno" value="{{ $institute->uid }}">

                          <label class="mt-8 flex items-start md:items-center">
                            <input type="checkbox" id="myCheckbox"
                              class="rounded-xs mr-5 h-3 w-3 border-2 border-black outline outline-1 outline-black focus:outline-4">
                            <span class="text-[0.875rem] font-bold text-red-500 sm:text-left">Saya
                              Bersetuju
                              Dengan Terma
                              Dan Syarat Di Bawah</span>
                          </label>

                          <p class="mb-4 mt-4 text-left text-[0.875rem] font-semibold md:pl-8">
                            SEGALA MAKLUMAT DAN LAMPIRAN YANG DIBERIKAN ADALAH BENAR DAN SAYA
                            BERTANGGUNGJAWAB DI ATAS MAKLUMAT YANG
                            DIBERIKAN INI. JIKA TERDAPAT MAKLUMAT PALSU YANG DIBERIKAN OLEH
                            SAYA, PIHAK MAJLIS AGAMA ISLAM SELANGOR
                            (MAIS) BERHAK MENGAMBIL TINDAKAN UNDANG-UNDANG KE ATAS DIRI SAYA.
                          </p>
                          <div class="mt-8 flex flex-col justify-between space-y-3 md:flex-row md:space-y-0">
                            <!-- Back button -->
                            <a href="{{ route('statementList') }}"
                              class="text-md mb-4 flex items-center font-bold text-blue-500 no-underline hover:cursor-pointer hover:text-blue-700 md:mb-0">
                              <span class="fe fe-arrow-left-circle text-md mr-2 font-bold"></span>
                              Kembali
                            </a>

                            <!-- Action buttons container -->
                            <div class="flex flex-col space-y-2 md:flex-row md:space-x-2 md:space-y-0">
                              <button type="button" id="save_draft"
                                class="mr-3 flex w-full items-center justify-center rounded-full bg-gray-700 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-gray-800 md:w-40">
                                Simpan Draft
                              </button>
                              <button type="submit" id="submit"
                                class="flex w-full items-center justify-center rounded-full bg-blue-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-700 md:w-40">
                                Hantar
                              </button>
                            </div>

                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                </aside>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--End::row-1 -->

  </div>
  </div>
  <!-- End::app-content -->
@endsection

@section('scripts')
  <!-- Internal Form Wizard JS -->
  <script src="{{ asset('subscription/build/assets/form-wizard.js') }}"></script>
  @vite(['resources/assets/js/form-wizard-init.js'], 'subscription/build')
  <script>
    // Add this to your scripts section or create a new script tag with this code
    document.addEventListener('DOMContentLoaded', function() {

      const checkbox = document.getElementById('myCheckbox');
      const submitButton = document.querySelector('#submit');

      document.getElementById("save_draft").addEventListener("click", function() {
        document.getElementById("draft_input").value = "true"; // Set draft to true
        HTMLFormElement.prototype.submit.call(document.getElementById("financial_form"));
      });

      // Set initial button state
      submitButton.disabled = true;
      submitButton.classList.add('opacity-50', 'cursor-not-allowed');

      // Add event listener to checkbox
      checkbox.addEventListener('change', function() {
        if (this.checked) {
          submitButton.disabled = false;
          submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
          submitButton.disabled = true;
          submitButton.classList.add('opacity-50', 'cursor-not-allowed');
        }
      });
      @if ($instituteType != 2)
        function calculateIncome() {
          let balanceForward = parseFloat(document.getElementById("balance_forward").value) || 0;
          let totalCollection = parseFloat(document.getElementById("total_collection").value) || 0;
          let totalIncome = balanceForward + totalCollection;

          // Update both the hidden input and the formatted display
          document.getElementById("total_income").value = totalIncome;
          document.getElementById("total_income_formatted").value = totalIncome.toLocaleString('en-US');
        }

        function calculateSurplus() {
          let totalCollection = parseFloat(document.getElementById("total_collection").value) || 0;
          let totalExpense = parseFloat(document.getElementById("total_expenses").value) || 0;
          let totalSurplus = totalCollection - totalExpense;

          // Update both the hidden input and the formatted display
          document.getElementById("total_surplus").value = totalSurplus;
          document.getElementById("total_surplus_formatted").value = totalSurplus.toLocaleString('en-US');
        }

        function calculateBankCashBalance() {
          let balanceForward = parseFloat(document.getElementById("balance_forward").value) || 0;
          let totalCollection = parseFloat(document.getElementById("total_collection").value) || 0;
          let totalExpense = parseFloat(document.getElementById("total_expenses").value) || 0;
          let totalSurplus = totalCollection - totalExpense;
          let bankCashBalance = balanceForward + totalSurplus;

          // Update both the hidden input and the formatted display
          document.getElementById("bank_cash_balance").value = bankCashBalance;
          document.getElementById("bank_cash_balance_formatted").value = bankCashBalance.toLocaleString('en-US');
        }

        // Attach event listeners to formatted inputs
        document.getElementById("balance_forward_formatted").addEventListener("input", calculateIncome);
        document.getElementById("total_collection_formatted").addEventListener("input", calculateIncome);

        document.getElementById("balance_forward_formatted").addEventListener("input", calculateSurplus);
        document.getElementById("total_collection_formatted").addEventListener("input", calculateSurplus);
        document.getElementById("total_expenses_formatted").addEventListener("input", calculateSurplus);

        document.getElementById("balance_forward_formatted").addEventListener("input", calculateBankCashBalance);
        document.getElementById("total_collection_formatted").addEventListener("input", calculateBankCashBalance);
        document.getElementById("total_expenses_formatted").addEventListener("input",
          calculateBankCashBalance);
      @endif
    });

    function validateFiles() {
      const fileInputs = ["attachment1", "attachment2", "attachment3"];
      const maxSize = 10 * 1024 * 1024; // 10MB in bytes
      const allowedTypes = ["application/pdf"];
      let valid = true;

      fileInputs.forEach(id => {
        const fileInput = document.getElementById(id);
        const errorSpan = document.getElementById(id + "-error");

        if (fileInput && fileInput.files.length > 0) {
          const file = fileInput.files[0];

          if (!allowedTypes.includes(file.type)) {
            errorSpan.textContent = "Only PDF files are allowed.";
            fileInput.value = "";
            valid = false;
          } else if (file.size > maxSize) {
            errorSpan.textContent = "File must be less than 10MB.";
            fileInput.value = "";
            valid = false;
          } else {
            errorSpan.textContent = ""; // Clear error if valid
          }
        }
      });

      return valid;
    }
  </script>
@endsection
