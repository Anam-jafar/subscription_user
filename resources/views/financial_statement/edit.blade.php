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
                        <div class="box-body !p-0">
                            <form class="wizard wizard-tab horizontal" id="financial_form" method="POST"
                                action="{{ route('editStatement', ['id' => $financialStatement->id]) }}">
                                @csrf
                                <aside class="wizard-content container">
                                    <div class="wizard-step " data-title="Butiran Penyata"
                                        data-id="2e8WqSV3slGIpTbnjcJzmDwBQaHrfh0Z">
                                        <div class="grid grid-cols-12 sm:gap-x-6 justify-content-center">
                                            <div class="xl:col-span-12 col-span-12">
                                                <div class="register-page">
                                                    @if ($instituteType == 2)
                                                        <div class="sm:gap-x-6 gap-y-4">
                                                            <div class="grid grid-cols1 md:grid-cols-2 gap-6">
                                                                <div class="grid grid-cols-2 gap-6">
                                                                    <x-input-field level="Bagi Tahun" id="ye"
                                                                        name="fin_year" type="select" placeholder="Year"
                                                                        :valueList="$years"
                                                                        value="{{ $financialStatement->fin_year }}" />

                                                                    <x-input-field level="Kategori Penyata" id="statment"
                                                                        name="fin_category" type="select"
                                                                        placeholder="Pilih" :valueList="$parameters['statements']"
                                                                        value="{{ $financialStatement->fin_category }}" />
                                                                </div>
                                                                <x-input-field
                                                                    level="Peratus Kemajuan Pembinaan Terkini (%)"
                                                                    id="p1" name="latest_contruction_progress"
                                                                    type="text" placeholder="00"
                                                                    value="{{ $financialStatement->latest_contruction_progress }}" />

                                                            </div>

                                                            <div class="xl:col-span-6 col-span-12 mt-4">
                                                                <p class="text-gray-800 font-medium">A. Maklumat Pembinaan
                                                                </p>
                                                            </div>
                                                            <div class="xl:col-span-6 col-span-12 mt-4">
                                                            </div>

                                                            <div class="grid grid-cols1 md:grid-cols-2 gap-6">
                                                                <x-input-field level="(i) Kos Pembinaan (Asal, RM)"
                                                                    id="i1" name="ori_contruction_cost"
                                                                    type="text" placeholder="00.00" :rightAlign="true"
                                                                    :required="true"
                                                                    value="{{ $financialStatement->ori_contruction_cost }}" />
                                                                <x-input-field
                                                                    level="(ii) Variation Order (Tambah Kurang, RM)"
                                                                    id="i2" name="variation_order" type="text"
                                                                    placeholder="00.00" :rightAlign="true" :required="true"
                                                                    value="{{ $financialStatement->variation_order }}" />
                                                            </div>
                                                            <div class="xl:col-span-6 col-span-12 mt-4">
                                                                <p class="text-gray-800 font-medium">B. Jumlah Kutipan</p>
                                                            </div>
                                                            <div class="xl:col-span-6 col-span-12 mt-4">
                                                            </div>
                                                            <div class="grid grid-cols1 md:grid-cols-2 gap-6">
                                                                <x-input-field level="(i) Kutipan Semasa (RM)"
                                                                    id="i3" name="current_collection" type="text"
                                                                    placeholder="00.00" :rightAlign="true" :required="true"
                                                                    value="{{ $financialStatement->current_collection }}" />
                                                                <x-input-field level="(ii) Kutipan Terkumpul (RM)"
                                                                    id="i04" name="total_expenses" type="text"
                                                                    placeholder="00.00" :rightAlign="true" :required="true"
                                                                    value="{{ $financialStatement->total_expenses }}" />
                                                            </div>

                                                            <div class="xl:col-span-6 col-span-12 mt-4">
                                                                <p class="text-gray-800 font-medium">C. Jumlah Perbelanjaan
                                                                </p>
                                                            </div>
                                                            <div class="xl:col-span-6 col-span-12 mt-4">
                                                            </div>
                                                            <div class="grid grid-cols1 md:grid-cols-2 gap-6">
                                                                <x-input-field level="(i) Pindahan Kepada PWS (RM)"
                                                                    id="i4" name="transfer_pws" type="text"
                                                                    placeholder="00.00" :rightAlign="true"
                                                                    :required="true"
                                                                    value="{{ $financialStatement->transfer_pws }}" />
                                                                <x-input-field
                                                                    level="(ii) Belanja Pembinaan Masjid/Surau (RM)"
                                                                    id="i5" name="contruction_expenses"
                                                                    type="text" placeholder="00.00" :rightAlign="true"
                                                                    :required="true"
                                                                    value="{{ $financialStatement->contruction_expenses }}" />
                                                            </div>

                                                            <div class="grid grid-cols1 md:grid-cols-2 gap-6">
                                                                <x-input-field level="(iii) Belanja Pembinaan PWS (RM)"
                                                                    id="i6" name="pws_expenses" type="text"
                                                                    placeholder="00.00" :rightAlign="true"
                                                                    :required="true"
                                                                    value="{{ $financialStatement->pws_expenses }}" />
                                                            </div>
                                                            <div class="xl:col-span-6 col-span-12 mt-4">
                                                                <p class="text-gray-800 font-medium">D. Jumlah Lebihan</p>
                                                            </div>
                                                            <div class="xl:col-span-6 col-span-12 mt-4">
                                                            </div>
                                                            <div class="grid grid-cols1 md:grid-cols-2 gap-6">
                                                                <x-input-field level="(i) Lebihan Masjid/Surau (RM)"
                                                                    id="i4" name="inst_surplus" type="text"
                                                                    placeholder="00.00" :rightAlign="true"
                                                                    :required="true"
                                                                    value="{{ $financialStatement->inst_surplus }}" />
                                                                <x-input-field level="(ii) Lebihan PWS (RM)"
                                                                    id="i5" name="pws_surplus" type="text"
                                                                    placeholder="00.00" :rightAlign="true"
                                                                    :required="true"
                                                                    value="{{ $financialStatement->pws_surplus }}" />
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="grid grid-cols-12 sm:gap-x-6 gap-y-4">
                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                                <div class="grid grid-cols-2 gap-6">
                                                                    <x-input-field level="Bagi Tahun" id="ye"
                                                                        name="fin_year" type="select" placeholder="Year"
                                                                        :valueList="$years"
                                                                        value="{{ $financialStatement->fin_year }}" />

                                                                    <x-input-field level="Kategori Penyata" id="statment"
                                                                        name="fin_category" type="select"
                                                                        placeholder="Pilih" :valueList="$parameters['statements']"
                                                                        value="{{ $financialStatement->fin_category }}" />
                                                                </div>
                                                                <x-input-field level="(a) Baki Bawa Ke Hadapan (RM)"
                                                                    id="balance_forward" name="balance_forward"
                                                                    type="number" placeholder="00.00" :rightAlign="true"
                                                                    :required="true"
                                                                    value="{{ $financialStatement->balance_forward }}" />

                                                            </div>

                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                                <x-input-field level="(b) Jumlah Kutipan (RM)"
                                                                    id="total_collection" name="total_collection"
                                                                    type="number" placeholder="00.00" :rightAlign="true"
                                                                    :required="true"
                                                                    value="{{ $financialStatement->total_collection }}" />
                                                                <x-input-field level="(c) Jumlah Perbelanjaan (RM)"
                                                                    id="total_expenses" name="total_expenses"
                                                                    type="number" placeholder="00.00" :rightAlign="true"
                                                                    :required="true"
                                                                    value="{{ $financialStatement->total_expenses }}" />
                                                            </div>

                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                                <x-input-field
                                                                    level="Jumlah Pendapatan (Auto Calculate, RM)"
                                                                    id="total_income" name="total_income" type="number"
                                                                    placeholder="00.00" :rightAlign="true"
                                                                    :required="true" :readonly="true"
                                                                    value="{{ $financialStatement->total_income }}" />

                                                                <x-input-field level="Jumlah Lebihan (Auto Calculate, RM)"
                                                                    id="total_surplus" name="total_surplus"
                                                                    type="number" placeholder="00.00" :rightAlign="true"
                                                                    :required="true" :readonly="true"
                                                                    value="{{ $financialStatement->total_surplus }}" />

                                                            </div>

                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                                                <x-input-field level="Maklumat Baki Bank Dan Tunai (RM)"
                                                                    id="i6" name="bank_cash_balance"
                                                                    type="number" placeholder="00.00" :rightAlign="true"
                                                                    :required="true"
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

                                                            <div class="grid grid-cols1 md:grid-cols-2 gap-6">
                                                                <div class="flex flex-col mt-4">
                                                                    <label for="input3"
                                                                        class="text-gray-800 mb-2">Penyata
                                                                        Kewangan
                                                                        <span class="text-red-500 ">*</span></label>

                                                                    <input type="file" name="attachment1"
                                                                        class="block w-full h-[3rem] border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 text-textmuted dark:text-textmuted/50
                                                                            file:me-4 file:py-2 file:px-4
                                                                            file:rounded-s-sm file:border-0
                                                                            file:text-sm file:font-semibold
                                                                            file:bg-primary file:text-white file:h-[3rem]
                                                                            hover:file:bg-primary focus-visible:outline-none
                                                                    ">
                                                                    @if (!empty($financialStatement->attachment1))
                                                                        <span class="text-xs text-gray-600 mb-1 italic">
                                                                            Current file:
                                                                            {{ basename($financialStatement->attachment1) }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                <div class="flex flex-col mt-4">
                                                                    <label for="input3"
                                                                        class="text-gray-800  mb-2">Penyata
                                                                        Bank
                                                                        <span class="text-red-500 ">*</span></label>

                                                                    <input type="file" name="attachment2"
                                                                        class="block w-full h-[3rem] border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 text-textmuted dark:text-textmuted/50
                                                                            file:me-4 file:py-2 file:px-4
                                                                            file:rounded-s-sm file:border-0
                                                                            file:text-sm file:font-semibold
                                                                            file:bg-primary file:text-white file:h-[3rem]
                                                                            hover:file:bg-primary focus-visible:outline-none
                                                                    ">
                                                                    @if (!empty($financialStatement->attachment2))
                                                                        <span class="text-xs text-gray-600 mb-1 italic">
                                                                            Current file:
                                                                            {{ basename($financialStatement->attachment2) }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <div class="grid grid-cols1 md:grid-cols-2 gap-6">
                                                                <div class="flex flex-col mt-4">
                                                                    <label for="input3"
                                                                        class="text-gray-800 mb-2">Certificate
                                                                        Completion &
                                                                        Compliance (CCC) <span
                                                                            class="text-red-500 ">*</span></label>

                                                                    <input type="file" name="attachment3"
                                                                        class="block w-full h-[3rem] border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 text-textmuted dark:text-textmuted/50
                                                                    file:me-4 file:py-2 file:px-4
                                                                    file:rounded-s-sm file:border-0
                                                                    file:text-sm file:font-semibold
                                                                    file:bg-primary file:text-white file:h-[3rem]
                                                                    hover:file:bg-primary focus-visible:outline-none
                                                                ">
                                                                    @if (!empty($financialStatement->attachment3))
                                                                        <span class="text-xs text-gray-600 mb-1 italic">
                                                                            Current file:
                                                                            {{ basename($financialStatement->attachment3) }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>


                                                        </div>
                                                    @else
                                                        <div class="sm:gap-x-6 gap-y-4">

                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                                <div class="flex flex-col mt-4">
                                                                    <label for="input3"
                                                                        class="text-gray-800 mb-2">Penyata Kewangan Dan
                                                                        Nota Kewangan
                                                                        <span class="text-red-500 ">*</span></label>

                                                                    <input type="file" name="attachment1"
                                                                        class="block w-full h-[3rem] border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 text-textmuted dark:text-textmuted/50
                                                                            file:me-4 file:py-2 file:px-4
                                                                            file:rounded-s-sm file:border-0
                                                                            file:text-sm file:font-semibold
                                                                            file:bg-primary file:text-white file:h-[3rem]
                                                                            hover:file:bg-primary focus-visible:outline-none
                                                                    ">
                                                                    @if (!empty($financialStatement->attachment1))
                                                                        <span class="text-xs text-gray-600 mb-1 italic">
                                                                            Current file:
                                                                            {{ basename($financialStatement->attachment1) }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                <x-input-field level="Jenis Pengauditan" id="institusi"
                                                                    name="attachment1_info" type="select" placeholder=""
                                                                    :valueList="$parameters['audit_types']"
                                                                    value="{{ $financialStatement->AuditType->prm }}" />

                                                            </div>

                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                                <div class="flex flex-col mt-4">
                                                                    <label for="input3"
                                                                        class="text-gray-800  mb-2">Penyata
                                                                        Bank
                                                                        <span class="text-red-500 ">*</span></label>

                                                                    <input type="file" name="attachment2"
                                                                        class="block w-full h-[3rem] border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 text-textmuted dark:text-textmuted/50
                                                                            file:me-4 file:py-2 file:px-4
                                                                            file:rounded-s-sm file:border-0
                                                                            file:text-sm file:font-semibold
                                                                            file:bg-primary file:text-white file:h-[3rem]
                                                                            hover:file:bg-primary focus-visible:outline-none
                                                                    ">
                                                                    @if (!empty($financialStatement->attachment2))
                                                                        <span class="text-xs text-gray-600 mb-1 italic">
                                                                            Current file:
                                                                            {{ basename($financialStatement->attachment2) }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                                <div class="flex flex-col mt-4">
                                                                    <label for="input3"
                                                                        class="text-gray-800 mb-2">Penyata Penyesuaian Bank
                                                                        <span class="text-red-500 ">*</span></label>

                                                                    <input type="file" name="attachment3"
                                                                        class="block w-full h-[3rem] border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 text-textmuted dark:text-textmuted/50
                                                                    file:me-4 file:py-2 file:px-4
                                                                    file:rounded-s-sm file:border-0
                                                                    file:text-sm file:font-semibold
                                                                    file:bg-primary file:text-white file:h-[3rem]
                                                                    hover:file:bg-primary focus-visible:outline-none
                                                                ">
                                                                    @if (!empty($financialStatement->attachment3))
                                                                        <span class="text-xs text-gray-600 mb-1 italic">
                                                                            Current file:
                                                                            {{ basename($financialStatement->attachment3) }}
                                                                        </span>
                                                                    @endif
                                                                </div>

                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="wizard-step" data-title="Pengesahan"
                                        data-id="dOM0iRAyJXsLTr9b3KZfQ2jNv4pgn6Gu" data-limit="3">
                                        <div class="grid grid-cols-12 sm:gap-x-6">
                                            <div class="xl:col-span-12 col-span-12">
                                                <div class="checkout-payment-success">
                                                    <div class="mb-4">
                                                    </div>
                                                    <div class="grid grid-cols-1 gap-x-16 gap-y-2 max-w-3xl mt-8">

                                                        <x-show-key-value :key="'Nama Pengawal / Wakil Institusi'" :value="$institute->con1" />
                                                        <x-show-key-value :key="'Jawatan'" :value="$institute->UserPosition->prm" />
                                                        <x-show-key-value :key="'No. H/P'" :value="$institute->hp" />
                                                        <x-show-key-value :key="'Emel'" :value="$institute->mel" />

                                                    </div>

                                                    <input type="hidden" name="draft" id="draft_input"
                                                        value="false">
                                                    <input type="hidden" name="inst_refno"
                                                        value="{{ $institute->uid }}">

                                                    <label class="flex items-start md:items-center mt-8">
                                                        <input type="checkbox" id="myCheckbox"
                                                            class="mr-5 w-3 h-3 border-2 border-black rounded-xs outline outline-1 outline-black focus:outline-4">
                                                        <span
                                                            class="sm:text-left text-red-500 font-bold text-[0.875rem]">Saya
                                                            Bersetuju
                                                            Dengan Terma
                                                            Dan Syarat Di Bawah</span>
                                                    </label>


                                                    <p class="font-semibold md:pl-8 mt-4 mb-4 text-left text-[0.875rem]">
                                                        SEGALA MAKLUMAT DAN LAMPIRAN YANG DIBERIKAN ADALAH BENAR DAN SAYA
                                                        BERTANGGUNGJAWAB DI ATAS MAKLUMAT YANG
                                                        DIBERIKAN INI. JIKA TERDAPAT MAKLUMAT PALSU YANG DIBERIKAN OLEH
                                                        SAYA, PIHAK MAJLIS AGAMA ISLAM SELANGOR
                                                        (MAIS) BERHAK MENGAMBIL TINDAKAN UNDANG-UNDANG KE ATAS DIRI SAYA.
                                                    </p>
                                                    <div
                                                        class="flex flex-col md:flex-row justify-between mt-8 space-y-3 md:space-y-0">
                                                        <!-- Back button -->
                                                        <a href="{{ route('statementList') }}"
                                                            class="text-blue-500 hover:text-blue-700 hover:cursor-pointer no-underline text-md font-bold flex items-center mb-4 md:mb-0">
                                                            <span
                                                                class="fe fe-arrow-left-circle mr-2 text-md font-bold"></span>
                                                            Senarai Penghantaran
                                                        </a>

                                                        <!-- Action buttons container -->
                                                        <div
                                                            class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-2">
                                                            <button type="button" id="save_draft"
                                                                class="w-full md:w-40 bg-gray-700 text-white py-2 px-4 rounded-full hover:bg-gray-800 transition-colors text-sm font-medium flex items-center justify-center mr-3">
                                                                Simpan Draft
                                                            </button>
                                                            <button type="submit" id="submit"
                                                                class="w-full md:w-40 bg-blue-600 text-white py-2 px-4 rounded-full hover:bg-blue-700 transition-colors text-sm font-medium flex items-center justify-center">
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
