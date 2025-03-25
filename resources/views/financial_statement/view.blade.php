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
                <div class="xl:col-span-12 col-span-12">
                    <div class="box">
                        <!-- Logo -->
                        <div class="flex justify-center mt-4">
                            <img src="{{ asset('subscription/assets/icons/fin_logo.svg') }}" alt="MAIS Logo"
                                class="w-24 h-24" />
                        </div>
                        <!-- Title -->
                        <h1 class="text-center text-3xl !font-normal text-[#2624D0] mt-2 font-mont">PENGHANTARAN LAPORAN
                            KEWANGAN BARU</h1>
                        <div class='px-4'>
                            <x-alert />
                        </div>


                        <div class="box-body !p-0">
                            <div class="wizard wizard-tab horizontal" id="financial_form">
                                <aside class="wizard-content container">
                                    <div class="wizard-step" data-title="Status Penghantaran"
                                        data-id="dOM0iRAyJXsLTr9b3KZfQ2jNv4pgn6Gu" data-limit="3">
                                        <div class="grid grid-cols-12 sm:gap-x-6">
                                            <div class="xl:col-span-12 col-span-12">
                                                <div class="checkout-payment-success">
                                                    <div class="">
                                                        <h5 class="text-start"> Dihantar oleh </h5>
                                                    </div>
                                                    <div class="grid grid-cols-1 gap-x-16 gap-y-2 max-w-3xl mt-4 mb-4">

                                                        <x-show-key-value :key="'Nama Pengawal / Wakil Institusi'" :value="$institute->con1" />
                                                        <x-show-key-value :key="'Jawatan'" :value="$institute->UserPosition->prm" />
                                                        <x-show-key-value :key="'No. H/P'" :value="$institute->hp" />
                                                        <x-show-key-value :key="'Emel'" :value="$institute->mel" />
                                                        <x-show-key-value :key="'Dihantar pada '" :value="$financialStatement->submission_date" />


                                                    </div>

                                                    <div class="">
                                                        <h5 class="text-start">Status Penghantaran </h5>
                                                    </div>
                                                    <div class="grid grid-cols-1 gap-x-16 gap-y-2 max-w-3xl mt-4">
                                                        <div class="flex mb-2">
                                                            <div
                                                                class="text-black font-medium w-24 md:w-64 block text-start">
                                                                Status</div>
                                                            <div class="text-black font-medium mr-10 block">:</div>
                                                            <div class="text-black font-medium block">
                                                                <x-status-badge :column="'FIN_STATUS'" :value="$financialStatement->FIN_STATUS['val'] ?? ''"
                                                                    :text="$financialStatement->FIN_STATUS['prm'] ??
                                                                        'Unknown'" />


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
                                                            <span class="w-full text-red-500 fe fe-info text-start">
                                                                Emel makluman pengesahan akan diterima dan status
                                                                penghantaran laporan akan bertukar kepada DRAF setelah
                                                                permohonan diluluskan.
                                                            </span>
                                                        @else
                                                            <x-show-key-value :key="'Disahkan Oleh'" :value="$verifiedBy" />
                                                            <x-show-key-value :key="'Disahkan Di'" :value="$financialStatement->verified_at" />
                                                        @endif
                                                    </div>


                                                    <div
                                                        class="flex flex-col md:flex-row justify-between mt-8 space-y-3 md:space-y-0">
                                                        <!-- Back button -->
                                                        <a href="{{ route('statementList') }}"
                                                            class="text-blue-500 hover:text-blue-700 hover:cursor-pointer no-underline text-md font-bold flex items-center mb-4 md:mb-0">
                                                            <span
                                                                class="fe fe-arrow-left-circle mr-2 text-md font-bold"></span>
                                                            Kembali
                                                        </a>

                                                        <!-- Action buttons container -->
                                                        <div
                                                            class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2">
                                                            @if ($financialStatement->status == 1)
                                                                <button type="button" id="save_draft"
                                                                    href="javascript:void(0);"
                                                                    onclick="document.getElementById('successModal').style.display='flex'"
                                                                    class="w-full md:w-40 bg-gray-700 text-white py-2 px-4 rounded-full hover:bg-gray-800 transition-colors text-sm font-medium flex items-center justify-center mr-3">
                                                                    Mohon Kemaskini
                                                                </button>

                                                                <!-- Success Modal -->
                                                                <div id="successModal"
                                                                    class="hidden fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-40 z-50">
                                                                    <div
                                                                        class="bg-white rounded-xl shadow-lg p-6 max-w-3xl w-full text-center relative">
                                                                        <!-- Close Button -->
                                                                        <button
                                                                            onclick="document.getElementById('successModal').style.display='none'"
                                                                            class="absolute top-2 right-4 text-gray-500 hover:text-gray-700 text-3xl p-3">
                                                                            &times;
                                                                        </button>

                                                                        <!-- Modal Title -->
                                                                        <h2
                                                                            class="text-green-600 text-lg font-semibold mb-2 text-start">
                                                                            Alasan Permohonan Kemaskini
                                                                        </h2>
                                                                        <hr>

                                                                        <!-- Modal Content -->
                                                                        <form id="subscriptionForm" method="POST"
                                                                            action="{{ route('editRequestStatement', ['id' => $financialStatement->id]) }}">

                                                                            @csrf
                                                                            <div class="text-start mt-4">
                                                                                <label for="request_edit_reason"
                                                                                    class="text-black text-xs font-semibold">Sebab
                                                                                    Permintaan</label>
                                                                                <textarea id="request_edit_reason" name="request_edit_reason"
                                                                                    class="w-full mt-2 p-2 border rounded-md focus:ring focus:ring-blue-300" rows="4"
                                                                                    placeholder="Sila masukkan sebab permintaan anda"></textarea>
                                                                            </div>
                                                                            <hr class="mt-4">

                                                                            <!-- Action Buttons -->
                                                                            <div class="flex justify-end mt-4">
                                                                                <button type="submit"
                                                                                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
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
                                    <div class="wizard-step " data-title="Maklumat Penyata"
                                        data-id="2e8WqSV3slGIpTbnjcJzmDwBQaHrfh0Z">
                                        <div class="grid grid-cols-12 sm:gap-x-6 justify-content-center">
                                            <div class="xl:col-span-12 col-span-12">
                                                <div class="register-page">
                                                    @if ($instituteType == 2)
                                                        <div class="sm:gap-x-6 gap-y-4">
                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                                    <x-input-field level="Bagi Tahun" id="ye"
                                                                        name="fin_year" type="text" placeholder="Year"
                                                                        value="{{ $financialStatement->fin_year }}"
                                                                        disabled='true' />

                                                                    <x-input-field level="Kategori Penyata" id="statment"
                                                                        name="fin_category" type="text"
                                                                        placeholder="Pilih"
                                                                        value="{{ $financialStatement->Category->prm }}"
                                                                        disabled='true' />
                                                                </div>
                                                                <x-input-field
                                                                    level="Peratus Kemajuan Pembinaan Terkini (%)"
                                                                    id="p1" name="latest_contruction_progress"
                                                                    type="text" placeholder="00"
                                                                    value="{{ $financialStatement->latest_contruction_progress }}"
                                                                    disabled='true' />
                                                            </div>
                                                            <div class="xl:col-span-6 col-span-12 mt-4">
                                                                <p class="text-gray-800 font-medium">A. Maklumat Pembinaan
                                                                </p>
                                                            </div>
                                                            <div class="xl:col-span-6 col-span-12 mt-4">
                                                            </div>

                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                                <x-input-field level="(i) Kos Pembinaan (Asal, RM)"
                                                                    id="i1" name="ori_contruction_cost"
                                                                    type="text" placeholder="00.00" :rightAlign="true"
                                                                    value="{{ $financialStatement->ori_contruction_cost }}"
                                                                    disabled='true' />
                                                                <x-input-field
                                                                    level="(ii) Variation Order (Tambah Kurang, RM)"
                                                                    id="i2" name="variation_order" type="text"
                                                                    placeholder="00.00" :rightAlign="true"
                                                                    value="{{ $financialStatement->variation_order }}"
                                                                    disabled='true' />

                                                            </div>
                                                            <div class="xl:col-span-6 col-span-12 mt-4">
                                                                <p class="text-gray-800 font-medium">B. Jumlah Kutipan</p>
                                                            </div>
                                                            <div class="xl:col-span-6 col-span-12 mt-4">
                                                            </div>
                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                                <x-input-field level="(i) Kutipan Semasa (RM)"
                                                                    id="i3" name="current_collection"
                                                                    type="text" placeholder="00.00" :rightAlign="true"
                                                                    value="{{ $financialStatement->current_collection }}"
                                                                    disabled='true' />
                                                                <x-input-field level="(ii) Kutipan Terkumpul (RM)"
                                                                    id="i04" name="total_expenses" type="text"
                                                                    placeholder="00.00" :rightAlign="true"
                                                                    value="{{ $financialStatement->total_expenses }}"
                                                                    disabled='true' />
                                                            </div>
                                                            <div class="xl:col-span-6 col-span-12 mt-4">
                                                                <p class="text-gray-800 font-medium">C. Jumlah Perbelanjaan
                                                                </p>
                                                            </div>
                                                            <div class="xl:col-span-6 col-span-12 mt-4">
                                                            </div>
                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                                <x-input-field level="(i) Pindahan Kepada PWS (RM)"
                                                                    id="i4" name="transfer_pws" type="text"
                                                                    placeholder="00.00" :rightAlign="true"
                                                                    value="{{ $financialStatement->transfer_pws }}"
                                                                    disabled='true' />
                                                                <x-input-field
                                                                    level="(ii) Belanja Pembinaan Masjid/Surau (RM)"
                                                                    id="i5" name="contruction_expenses"
                                                                    type="text" placeholder="00.00" :rightAlign="true"
                                                                    disabled='true'
                                                                    value="{{ $financialStatement->contruction_expenses }}" />
                                                            </div>
                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                                <x-input-field level="(iii) Belanja Pembinaan PWS (RM)"
                                                                    id="i6" name="pws_expenses" type="text"
                                                                    placeholder="00.00" :rightAlign="true" disabled='true'
                                                                    value="{{ $financialStatement->pws_expenses }}" />
                                                            </div>

                                                            <div class="xl:col-span-6 col-span-12 mt-4">
                                                                <p class="text-gray-800 font-medium">D. Jumlah Lebihan</p>
                                                            </div>
                                                            <div class="xl:col-span-6 col-span-12 mt-4">
                                                            </div>
                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                                <x-input-field level="(i) Lebihan Masjid/Surau (RM)"
                                                                    id="i4" name="inst_surplus" type="text"
                                                                    placeholder="00.00" :rightAlign="true"
                                                                    value="{{ $financialStatement->inst_surplus }}"
                                                                    disabled='true' />
                                                                <x-input-field level="(ii) Lebihan PWS (RM)"
                                                                    id="i5" name="pws_surplus" type="text"
                                                                    placeholder="00.00" :rightAlign="true"
                                                                    value="{{ $financialStatement->pws_surplus }}"
                                                                    disabled='true' />
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="sm:gap-x-6 gap-y-4">
                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                                <div class="grid grid-cols-2 gap-6">
                                                                    <x-input-field level="Bagi Tahun" id="ye"
                                                                        name="fin_year" type="text" placeholder="Year"
                                                                        value="{{ $financialStatement->fin_year }}"
                                                                        disabled='true' />

                                                                    <x-input-field level="Kategori Penyata" id="statment"
                                                                        name="fin_category" type="text"
                                                                        placeholder="Pilih"
                                                                        value="{{ $financialStatement->Category->prm }}"
                                                                        disabled='true' />
                                                                </div>
                                                                <x-input-field level="(a) Baki Bawa Ke Hadapan (RM)"
                                                                    id="balance_forward" name="balance_forward"
                                                                    type="number" placeholder="00.00" :rightAlign="true"
                                                                    disabled='true'
                                                                    value="{{ $financialStatement->balance_forward }}" />
                                                            </div>
                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                                <x-input-field level="(b) Jumlah Kutipan (RM)"
                                                                    id="total_collection" name="total_collection"
                                                                    type="number" placeholder="00.00" :rightAlign="true"
                                                                    disabled='true'
                                                                    value="{{ $financialStatement->total_collection }}" />
                                                                <x-input-field level="(c) Jumlah Perbelanjaan (RM)"
                                                                    id="total_expenses" name="total_expenses"
                                                                    type="number" placeholder="00.00" :rightAlign="true"
                                                                    disabled='true'
                                                                    value="{{ $financialStatement->total_expenses }}" />
                                                            </div>

                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                                <x-input-field
                                                                    level="Jumlah Pendapatan (Auto Calculate, RM)"
                                                                    id="total_income" name="total_income" type="number"
                                                                    placeholder="00.00" :rightAlign="true" disabled='true'
                                                                    :readonly="true"
                                                                    value="{{ $financialStatement->total_income }}" />
                                                                <x-input-field level="Jumlah Lebihan (Auto Calculate, RM)"
                                                                    id="total_surplus" name="total_surplus"
                                                                    type="number" placeholder="00.00" :rightAlign="true"
                                                                    disabled='true' :readonly="true"
                                                                    value="{{ $financialStatement->total_surplus }}" />

                                                            </div>

                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                                                <x-input-field level="Maklumat Baki Bank Dan Tunai (RM)"
                                                                    id="i6" name="bank_cash_balance"
                                                                    type="number" placeholder="00.00" :rightAlign="true"
                                                                    disabled='true'
                                                                    value="{{ $financialStatement->bank_cash_balance }}" />
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-step " data-title="Lampiran"
                                        data-id="2e8WqSV3slGIpTbnjcJzmDwBQaHrfjHQ">
                                        <div class="grid grid-cols-12 sm:gap-x-6 justify-content-center">
                                            <div class="xl:col-span-12 col-span-12">
                                                <div class="register-page">
                                                    @if ($instituteType == 2)
                                                        <div class="sm:gap-x-6 gap-y-4">

                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                                <x-pdf-download title="Penyata Kewangan"
                                                                    pdfFile="{{ $financialStatement->attachment1 ?? '' }}" />
                                                                <x-pdf-download title="Penyata Bank"
                                                                    pdfFile="{{ $financialStatement->attachment2 ?? '' }}" />

                                                            </div>

                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                                <x-pdf-download
                                                                    title="Certificate
                                                                        Completion &
                                                                        Compliance (CCC)"
                                                                    pdfFile="{{ $financialStatement->attachment2 ?? '' }}" />
                                                            </div>


                                                        </div>
                                                    @else
                                                        <div class="sm:gap-x-6 gap-y-4">
                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                                <x-pdf-download title="Penyata Kewangan Dan Nota Kewangan"
                                                                    pdfFile="{{ $financialStatement->attachment1 ?? '' }}" />
                                                                <x-input-field level="Jenis Pengauditan" id="institusi"
                                                                    name="attachment1_info" type="text" placeholder=""
                                                                    value="{{ $financialStatement->AuditType->prm }}"
                                                                    disabled='true' />
                                                            </div>

                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                                <x-pdf-download title="Penyata Bank"
                                                                    pdfFile="{{ $financialStatement->attachment2 ?? '' }}" />

                                                                <x-pdf-download title="Penyata Penyesuaian Bank"
                                                                    pdfFile="{{ $financialStatement->attachment3 ?? '' }}" />
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div
                                                        class="flex flex-col md:flex-row justify-between mt-8 space-y-3 md:space-y-0">
                                                        <a href="{{ route('statementList') }}"
                                                            class="text-blue-500 hover:text-blue-700 hover:cursor-pointer no-underline text-md font-bold flex items-center">
                                                            <span
                                                                class="fe fe-arrow-left-circle mr-2 text-md font-bold"></span>
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
