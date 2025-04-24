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
              <div class="wizard wizard-tab horizontal" id="financial_form">
                <aside class="wizard-content container">
                  <div class="wizard-step" data-title="Status Penghantaran" data-id="dOM0iRAyJXsLTr9b3KZfQ2jNv4pgn6Gu"
                    data-limit="3">
                    <div class="grid grid-cols-12 sm:gap-x-6">
                      <div class="col-span-12 xl:col-span-12">
                        <div class="checkout-payment-success">
                          <div class="">
                            <h5 class="text-start"> Dihantar oleh </h5>
                          </div>
                          <div class="mb-4 mt-4 grid max-w-3xl grid-cols-1 gap-x-16 gap-y-2">

                            <x-show-key-value :key="'Nama Pengawal / Wakil Institusi'" :value="$institute->con1" />
                            <x-show-key-value :key="'Jawatan'" :value="$institute->UserPosition->prm" />
                            <x-show-key-value :key="'No. H/P'" :value="$institute->hp" />
                            <x-show-key-value :key="'Emel'" :value="$institute->mel" />
                            <x-show-key-value :key="'Dihantar pada '" :value="$financialStatement->submission_date" />

                          </div>

                          <div class="">
                            <h5 class="text-start">Status Penghantaran </h5>
                          </div>
                          <div class="mt-4 grid max-w-3xl grid-cols-1 gap-x-16 gap-y-2">
                            <div class="mb-2 flex">
                              <div class="block w-24 text-start font-medium text-black md:w-64">
                                Status</div>
                              <div class="mr-10 block font-medium text-black">:</div>
                              <div class="block font-medium text-black">
                                <x-status-badge :column="'FIN_STATUS'" :value="$financialStatement->FIN_STATUS['val'] ?? ''" :text="$financialStatement->FIN_STATUS['prm'] ?? 'Unknown'" />

                              </div>
                            </div>
                            @if ($financialStatement->status == 3)
                              @if ($financialStatement->cancel_reason_adm != null)
                                <x-show-key-value :key="'Sebab Pembatalan'" :value="$financialStatement->cancel_reason_adm" />
                              @endif
                              @if ($financialStatement->suggestion_adm != null)
                                <x-show-key-value :key="'Sebab Pembatalan'" :value="$financialStatement->suggestion_adm" />
                              @endif
                            @endif
                            @if ($financialStatement->status == 4)
                              <x-show-key-value :key="'Tarikh Permohonan Kemaskini'" :value="$financialStatement->request_edit_date" />
                              <x-show-key-value :key="'Alasan untuk Kemaskini'" :value="$financialStatement->request_edit_reason" />
                              <span class="fe fe-info w-full text-start text-red-500">
                                Emel makluman pengesahan akan diterima dan status
                                penghantaran laporan akan bertukar kepada DRAF setelah
                                permohonan diluluskan.
                              </span>
                            @else
                              <x-show-key-value :key="'Disahkan Oleh'" :value="$verifiedBy" />
                              <x-show-key-value :key="'Disahkan Di'" :value="$financialStatement->verified_at" />
                            @endif
                          </div>

                          <div class="mt-8 flex flex-col justify-between space-y-3 md:flex-row md:space-y-0">
                            <!-- Back button -->
                            <a href="{{ route('statementList') }}"
                              class="text-md mb-4 flex items-center font-bold text-blue-500 no-underline hover:cursor-pointer hover:text-blue-700 md:mb-0">
                              <span class="fe fe-arrow-left-circle text-md mr-2 font-bold"></span>
                              Kembali
                            </a>

                            <!-- Action buttons container -->
                            <div class="flex flex-col space-y-2 md:flex-row md:space-x-2 md:space-y-0">
                              @if ($financialStatement->status == 1)
                                <button type="button" id="save_draft" href="javascript:void(0);"
                                  onclick="document.getElementById('successModal').style.display='flex'"
                                  class="mr-3 flex w-full items-center justify-center rounded-full bg-gray-700 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-gray-800 md:w-40">
                                  Mohon Kemaskini
                                </button>

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
                                      Alasan Permohonan Kemaskini
                                    </h2>
                                    <hr>

                                    <!-- Modal Content -->
                                    <form id="subscriptionForm" method="POST"
                                      action="{{ route('editRequestStatement', ['id' => $financialStatement->id]) }}">

                                      @csrf
                                      <div class="mt-4 text-start">
                                        <label for="request_edit_reason" class="text-xs font-semibold text-black">Sebab
                                          Permintaan</label>
                                        <textarea id="request_edit_reason" name="request_edit_reason"
                                          class="mt-2 w-full rounded-md border p-2 focus:ring focus:ring-blue-300" rows="4"
                                          placeholder="Sila masukkan sebab permintaan anda"></textarea>
                                      </div>
                                      <hr class="mt-4">

                                      <!-- Action Buttons -->
                                      <div class="mt-4 flex justify-end">
                                        <button type="submit"
                                          class="rounded-lg bg-blue-600 px-6 py-2 text-white hover:bg-blue-700">
                                          Hantar
                                        </button>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                              @endif
                            </div>

                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="wizard-step" data-title="Maklumat Penyata" data-id="2e8WqSV3slGIpTbnjcJzmDwBQaHrfh0Z">
                    <div class="justify-content-center grid grid-cols-12 sm:gap-x-6">
                      <div class="col-span-12 xl:col-span-12">
                        <div class="register-page">
                          @if ($instituteType == 2)
                            <div class="gap-y-4 sm:gap-x-6">
                              <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                  <x-input-field level="Bagi Tahun" id="ye" name="fin_year" type="text"
                                    placeholder="Year" value="{{ $financialStatement->fin_year }}" disabled='true' />

                                  <x-input-field level="Kategori Penyata" id="statment" name="fin_category"
                                    type="text" placeholder="Pilih" value="{{ $financialStatement->Category->prm }}"
                                    disabled='true' />
                                </div>
                                <x-input-field level="Peratus Kemajuan Pembinaan Terkini (%)" id="p1"
                                  name="latest_contruction_progress" type="text" placeholder="00"
                                  value="{{ $financialStatement->latest_contruction_progress }}" disabled='true' />
                              </div>
                              <div class="col-span-12 mt-4 xl:col-span-6">
                                <p class="font-medium text-gray-800">A. Maklumat Pembinaan
                                </p>
                              </div>
                              <div class="col-span-12 mt-4 xl:col-span-6">
                              </div>

                              <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <x-input-field level="(i) Kos Pembinaan (Asal, RM)" id="i1"
                                  name="ori_contruction_cost" type="money" placeholder="00.00" :rightAlign="true"
                                  value="{{ $financialStatement->ori_contruction_cost }}" disabled='true' />
                                <x-input-field level="(ii) Variation Order (Tambah Kurang, RM)" id="i2"
                                  name="variation_order" type="money" placeholder="00.00" :rightAlign="true"
                                  value="{{ $financialStatement->variation_order }}" disabled='true' />

                              </div>
                              <div class="col-span-12 mt-4 xl:col-span-6">
                                <p class="font-medium text-gray-800">B. Jumlah Kutipan</p>
                              </div>
                              <div class="col-span-12 mt-4 xl:col-span-6">
                              </div>
                              <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <x-input-field level="(i) Kutipan Semasa (RM)" id="i3" name="current_collection"
                                  type="money" placeholder="00.00" :rightAlign="true"
                                  value="{{ $financialStatement->current_collection }}" disabled='true' />
                                <x-input-field level="(ii) Kutipan Terkumpul (RM)" id="i04" name="total_expenses"
                                  type="money" placeholder="00.00" :rightAlign="true"
                                  value="{{ $financialStatement->total_expenses }}" disabled='true' />
                              </div>
                              <div class="col-span-12 mt-4 xl:col-span-6">
                                <p class="font-medium text-gray-800">C. Jumlah Perbelanjaan
                                </p>
                              </div>
                              <div class="col-span-12 mt-4 xl:col-span-6">
                              </div>
                              <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <x-input-field level="(i) Pindahan Kepada PWS (RM)" id="i4" name="transfer_pws"
                                  type="money" placeholder="00.00" :rightAlign="true"
                                  value="{{ $financialStatement->transfer_pws }}" disabled='true' />
                                <x-input-field level="(ii) Belanja Pembinaan Masjid/Surau (RM)" id="i5"
                                  name="contruction_expenses" type="money" placeholder="00.00" :rightAlign="true"
                                  disabled='true' value="{{ $financialStatement->contruction_expenses }}" />
                              </div>
                              <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <x-input-field level="(iii) Belanja Pembinaan PWS (RM)" id="i6"
                                  name="pws_expenses" type="money" placeholder="00.00" :rightAlign="true"
                                  disabled='true' value="{{ $financialStatement->pws_expenses }}" />
                              </div>

                              <div class="col-span-12 mt-4 xl:col-span-6">
                                <p class="font-medium text-gray-800">D. Jumlah Lebihan</p>
                              </div>
                              <div class="col-span-12 mt-4 xl:col-span-6">
                              </div>
                              <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <x-input-field level="(i) Lebihan Masjid/Surau (RM)" id="i4" name="inst_surplus"
                                  type="money" placeholder="00.00" :rightAlign="true"
                                  value="{{ $financialStatement->inst_surplus }}" disabled='true' />
                                <x-input-field level="(ii) Lebihan PWS (RM)" id="i5" name="pws_surplus"
                                  type="money" placeholder="00.00" :rightAlign="true"
                                  value="{{ $financialStatement->pws_surplus }}" disabled='true' />
                              </div>
                            </div>
                          @else
                            <div class="gap-y-4 sm:gap-x-6">
                              <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div class="grid grid-cols-2 gap-6">
                                  <x-input-field level="Bagi Tahun" id="ye" name="fin_year" type="text"
                                    placeholder="Year" value="{{ $financialStatement->fin_year }}" disabled='true' />

                                  <x-input-field level="Kategori Penyata" id="statment" name="fin_category"
                                    type="text" placeholder="Pilih"
                                    value="{{ $financialStatement->Category->prm }}" disabled='true' />
                                </div>
                                <x-input-field level="(a) Baki Bawa Ke Hadapan 1 Januari (RM)" id="balance_forward"
                                  name="balance_forward" type="money" placeholder="00.00" :rightAlign="true"
                                  disabled='true' value="{{ $financialStatement->balance_forward }}" />
                              </div>
                              <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <x-input-field level="(b) Jumlah Kutipan (RM)" id="total_collection"
                                  name="total_collection" type="money" placeholder="00.00" :rightAlign="true"
                                  disabled='true' value="{{ $financialStatement->total_collection }}" />
                                <x-input-field level="(c) Jumlah Perbelanjaan (RM)" id="total_expenses"
                                  name="total_expenses" type="money" placeholder="00.00" :rightAlign="true"
                                  disabled='true' value="{{ $financialStatement->total_expenses }}" />
                              </div>

                              <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <x-input-field level="(d) Jumlah Pendapatan (RM)" id="total_income" name="total_income"
                                  type="money" placeholder="00.00" :rightAlign="true" disabled='true'
                                  :readonly="true" value="{{ $financialStatement->total_income }}" />
                                <x-input-field level="(e) Jumlah Lebihan/Kurangan Tahun Semasa (RM)" id="total_surplus"
                                  name="total_surplus" type="money" placeholder="00.00" :rightAlign="true"
                                  disabled='true' :readonly="true"
                                  value="{{ $financialStatement->total_surplus }}" />

                              </div>

                              <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                                <x-input-field level="(f) Maklumat Baki Bank Dan Tunai (RM)" id="i6"
                                  name="bank_cash_balance" type="money" placeholder="00.00" :rightAlign="true"
                                  disabled='true' value="{{ $financialStatement->bank_cash_balance }}"
                                  :readonly="true" />
                              </div>
                            </div>
                          @endif
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

                              <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <x-pdf-download title="Penyata Kewangan"
                                  pdfFile="{{ $financialStatement->attachment1 ?? '' }}" />
                                <x-pdf-download title="Penyata Bank"
                                  pdfFile="{{ $financialStatement->attachment2 ?? '' }}" />

                              </div>

                              <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <x-pdf-download
                                  title="Certificate
                                                                        Completion &
                                                                        Compliance (CCC)"
                                  pdfFile="{{ $financialStatement->attachment2 ?? '' }}" />
                              </div>

                            </div>
                          @else
                            <div class="gap-y-4 sm:gap-x-6">
                              <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <x-pdf-download title="Penyata Kewangan Dan Nota Kewangan"
                                  pdfFile="{{ $financialStatement->attachment1 ?? '' }}" />
                                <x-input-field level="Jenis Pengauditan" id="institusi" name="attachment1_info"
                                  type="text" placeholder="" value="{{ $financialStatement->AuditType->prm }}"
                                  disabled='true' />
                              </div>

                              <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <x-pdf-download title="Penyata Bank"
                                  pdfFile="{{ $financialStatement->attachment2 ?? '' }}" />

                                <x-pdf-download title="Penyata Penyesuaian Bank"
                                  pdfFile="{{ $financialStatement->attachment3 ?? '' }}" />
                              </div>
                            </div>
                          @endif
                          <div class="mt-8 flex flex-col justify-between space-y-3 md:flex-row md:space-y-0">
                            <a href="{{ route('statementList') }}"
                              class="text-md flex items-center font-bold text-blue-500 no-underline hover:cursor-pointer hover:text-blue-700">
                              <span class="fe fe-arrow-left-circle text-md mr-2 font-bold"></span>
                              Kembali
                            </a>

                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                </aside>
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

          document.getElementById("total_income").value = totalIncome.toFixed(2);
        }

        function calculateSurplus() {
          let balanceForward = parseFloat(document.getElementById("balance_forward").value) || 0;
          let totalCollection = parseFloat(document.getElementById("total_collection").value) || 0;
          let totalExpense = parseFloat(document.getElementById("total_expenses").value) || 0;
          let totalSurplus = balanceForward + totalCollection - totalExpense;

          document.getElementById("total_surplus").value = totalSurplus.toFixed(2);
        }

        // Attach event listeners only when instituteType is 'SD'
        document.getElementById("balance_forward").addEventListener("input", calculateIncome);
        document.getElementById("total_collection").addEventListener("input", calculateIncome);

        document.getElementById("balance_forward").addEventListener("input", calculateSurplus);
        document.getElementById("total_collection").addEventListener("input", calculateSurplus);
        document.getElementById("total_expenses").addEventListener("input", calculateSurplus);
      @endif
    });
  </script>
@endsection
