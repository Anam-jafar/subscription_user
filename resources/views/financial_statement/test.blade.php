@extends('layouts.loginLayout')

@section('styles')
@endsection

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Penghantaran Laporan Kewangan'" :breadcrumbs="[['label' => 'Laporan Kewangan', 'url' => 'javascript:void(0);'], ['label' => 'Baharu']]" />
            <x-alert />

            <form method="POST" id="financial_form" action="" class="bg-white sm:p-2 text-xs"
                enctype="multipart/form-data">
                @csrf

                @if ($instiuteType == 1)
                    <div>
                        <p class="text-gray-800 font-medium">Butiran Penyata :</p>
                        <div class="grid grid-cols-3 gap-6">
                            <x-input-field level="Bagi Tahun" id="ye" name="fin_year" type="select"
                                placeholder="Year" :valueList="$years" />

                            <x-input-field level="Kategori Penyata" id="statment" name="fin_category" type="select"
                                placeholder="Pilih" :valueList="$paraeters['statements']" />
                            <x-input-field level="Peratus Kemajuan Pembinaan Terkini (%)" id="p1"
                                name="latest_construction_progress" type="text" placeholder="00" />
                        </div>
                        <div class="grid grid-cols-2 gap-6 mt-4">
                            <p class="text-gray-700">A. Maklumat Pembinaan</p>
                            <p class="text-gray-700">B. Jumlah Kutipan</p>

                        </div>
                        <div class="grid grid-cols-4 gap-6">
                            <x-input-field level="(i) Kos Pembinaan (Asal, RM)" id="i1" name="ori_construction_cost"
                                type="text" placeholder="00.00" :rightAlign="true" :required="true" />

                            <x-input-field level="(ii) Variation Order (Tambah Kurang, RM)" id="i2"
                                name="variation_order" type="text" placeholder="00.00" :rightAlign="true"
                                :required="true" />

                            <x-input-field level="(i) Kutipan Semasa (RM)" id="i3" name="current_collection"
                                type="text" placeholder="00.00" :rightAlign="true" :required="true" />
                            <x-input-field level="(ii) Kutipan Terkumpul (RM)" id="i04" name="total_expenses"
                                type="text" placeholder="00.00" :rightAlign="true" :required="true" />
                        </div>
                        <div class="grid grid-cols-2 gap-6 mt-4">
                            <p class="text-gray-700 ">C. Jumlah Perbelanjaan</p>
                            <p class="text-gray-700 ">D. Jumlah Lebihan</p>

                        </div>
                        <div class="grid grid-cols-4 gap-6">
                            <x-input-field level="(i) Pindahan Kepada PWS (RM)" id="i4" name="transfer_pws"
                                type="text" placeholder="00.00" :rightAlign="true" :required="true" />
                            <x-input-field level="(ii) Belanja Pembinaan Masjid/Surau (RM)" id="i5"
                                name="construction_expenses" type="text" placeholder="00.00" :rightAlign="true"
                                :required="true" />
                            <x-input-field level="(i) Lebihan Masjid/Surau (RM)" id="i4" name="inst_surplus"
                                type="text" placeholder="00.00" :rightAlign="true" :required="true" />
                            <x-input-field level="(ii) Lebihan PWS (RM)" id="i5" name="pws_surplus" type="text"
                                placeholder="00.00" :rightAlign="true" :required="true" />
                        </div>
                        <div class="grid grid-cols-3 gap-6">
                            <x-input-field level="(iii) Belanja Pembinaan PWS (RM)" id="i6" name="pws_expenses"
                                type="text" placeholder="00.00" :rightAlign="true" :required="true" />

                        </div>
                        <p class="text-gray-800 font-medium mt-4 mb-2">Sila Lampirkan Salinan Dokumen Seperti Di Bawah :</p>

                        <div class="grid grid-cols-3 gap-6 mt-4 mb-4">
                            <div class="flex flex-col">
                                <label for="input3" class="text-gray-800 font-medium mb-2">Penyata Kewangan <span
                                        class="text-red-500 ">*</span></label>
                                <input type="file" name="fin_statement"
                                    class="block w-full h-[3rem] border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 text-textmuted dark:text-textmuted/50
                                            file:me-4 file:py-2 file:px-4
                                            file:rounded-s-sm file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-primary file:text-white file:h-[3rem]
                                            hover:file:bg-primary focus-visible:outline-none
                                        ">
                            </div>

                            <div class="flex flex-col">
                                <label for="input3" class="text-gray-800 font-medium mb-2">Penyata Bank <span
                                        class="text-red-500 ">*</span></label>
                                <input type="file" name="bank_statement"
                                    class="block w-full h-[3rem] border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 text-textmuted dark:text-textmuted/50
                                            file:me-4 file:py-2 file:px-4
                                            file:rounded-s-sm file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-primary file:text-white file:h-[3rem]
                                            hover:file:bg-primary focus-visible:outline-none
                                        ">
                            </div>
                            <div class="flex flex-col">
                                <label for="input3" class="text-gray-800 font-medium mb-2">Certificate Completion &
                                    Compliance (CCC) <span class="text-red-500 ">*</span></label>
                                <input type="file" name="ccc"
                                    class="block w-full h-[3rem] border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 text-textmuted dark:text-textmuted/50
                                            file:me-4 file:py-2 file:px-4
                                            file:rounded-s-sm file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-primary file:text-white file:h-[3rem]
                                            hover:file:bg-primary focus-visible:outline-none
                                        ">
                            </div>
                        </div>
                    </div>
                @else
                    <div>
                        <p class="text-gray-800 font-medium">Butiran Penyata :</p>
                        <div class="grid grid-col-2 md:grid-cols-3 gap-6">
                            <x-input-field level="Bagi Tahun" id="ye" name="fin_year" type="select"
                                placeholder="Year" :valueList="$years" />

                            <x-input-field level="Kategori Penyata" id="statment" name="fin_category" type="select"
                                placeholder="Pilih" :valueList="$parameters['statements']" />
                        </div>
                        <div class="grid grid-col-2 md:grid-cols-4 gap-6">
                            <x-input-field level="(a) Baki Bawa Ke Hadapan (RM)" id="balance_forward"
                                name="balance_forward" type="number" placeholder="00.00" :rightAlign="true"
                                :required="true" />

                            <x-input-field level="(b) Jumlah Kutipan (RM)" id="total_collection" name="total_collection"
                                type="number" placeholder="00.00" :rightAlign="true" :required="true" />

                            <x-input-field level="(c) Jumlah Perbelanjaan (RM)" id="total_expenses" name="total_expenses"
                                type="number" placeholder="00.00" :rightAlign="true" :required="true" />
                        </div>
                        <div class="grid grid-col-2 md:grid-cols-4 gap-6">
                            <x-input-field level="Jumlah Pendapatan (Auto Calculate, RM)" id="total_income"
                                name="total_income" type="number" placeholder="00.00" :rightAlign="true"
                                :required="true" :readonly="true" />


                            <x-input-field level="Jumlah Lebihan (Auto Calculate, RM)" id="total_surplus"
                                name="total_surplus" type="number" placeholder="00.00" :rightAlign="true"
                                :required="true" :readonly="true" />
                        </div>
                        <div class="grid grid-col-2 md:grid-cols-3 gap-6">
                            <x-input-field level="Maklumat Baki Bank Dan Tunai (RM)" id="i6"
                                name="bank_cash_balance" type="number" placeholder="00.00" :rightAlign="true"
                                :required="true" />

                        </div>
                        <p class="text-gray-800 font-medium mt-4 mb-2">Sila Lampirkan Salinan Dokumen Seperti Di Bawah :
                        </p>

                        <div class="grid grid-col-1 md:grid-cols-3 gap-6 mt-4 mb-4">
                            <div class="flex flex-col">
                                <label for="input3" class="text-gray-800 font-medium mb-2">
                                    Penyata Kewangan Dan Nota Kewangan <span class="text-red-500">*</span>
                                </label>
                                <input type="file" name="fin_statement"
                                    class="block w-full h-[3rem] border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 
                                        rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 
                                        dark:border-white/10 text-textmuted dark:text-textmuted/50
                                        file:me-4 file:h-[3rem] file:py-3 file:px-4 
                                        file:rounded-s-sm file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-primary file:text-white
                                        hover:file:bg-primary focus-visible:outline-none
                                    ">
                            </div>


                            <div class="flex flex-col">
                                <label for="input3" class="text-gray-800 font-medium mb-2">Penyata Bank <span
                                        class="text-red-500 ">*</span></label>
                                <input type="file" name="bank_statement"
                                    class="block w-full h-[3rem] border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 text-textmuted dark:text-textmuted/50
                                            file:me-4 file:py-2 file:px-4 file:h-[3rem]
                                            file:rounded-s-sm file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-primary file:text-white
                                            hover:file:bg-primary focus-visible:outline-none
                                        ">
                            </div>
                            <div class="flex flex-col">
                                <label for="input3" class="text-gray-800 font-medium mb-2">Penyata Penyesuaion Bank
                                    <span class="text-red-500 ">*</span></label>
                                <input type="file" name="bank_reconciliation"
                                    class="block w-full h-[3rem] border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 text-textmuted dark:text-textmuted/50
                                            file:me-4 file:py-2 file:px-4
                                            file:rounded-s-sm file:border-0 file:h-[3rem]
                                            file:text-sm file:font-semibold
                                            file:bg-primary file:text-white
                                            hover:file:bg-primary focus-visible:outline-none
                                        ">
                            </div>
                        </div>
                    </div>
                @endif


                <div class="grid grid-cols-1 gap-x-16 gap-y-2 max-w-3xl mt-8">

                    <x-show-key-value :key="'Nama Pengawal / Wakil Institusi'" :value="Auth::user()->fullname" />
                    <x-show-key-value :key="'Jawatan'" :value="Auth::user()->pos1" />
                    <x-show-key-value :key="'No. H/P'" :value="Auth::user()->mobile_number" />
                    <x-show-key-value :key="'Emel'" :value="Auth::user()->email" />

                </div>

                <input type="hidden" name="draft" id="draft_input" value="false">





                <label class="flex items-center mt-8">
                    <input type="checkbox" id="myCheckbox"
                        class="mr-5 w-3 h-3 border-2 border-black rounded-xs outline outline-1 outline-black focus:outline-4">
                    <span class="text-red-500 font-bold">Saya Bersetuju Dengan Terma Dan Syarat Di Bawah</span>
                </label>



                <p class="font-semibold pl-8 mt-4 mb-4">
                    SEGALA MAKLUMAT DAN LAMPIRAN YANG DIBERIKAN ADALAH BENAR DAN SAYA BERTANGGUNGJAWAB DI ATAS MAKLUMAT YANG
                    DIBERIKAN INI. JIKA TERDAPAT MAKLUMAT PALSU YANG DIRERIKAN OLEH SAYA, PIHAK MAJLIS AGAMA ISLAM SELANGOR
                    (MAIS) BERHAK MENGAMBIL TINDAKAN UNDANG-UNĎANG KE ATAS DIRI SAYA.
                </p>
                <div class="flex flex-col md:flex-row justify-between mt-8 space-y-4 md:space-y-0">
                    <!-- Back button -->
                    <button
                        class="bg-[#6E829F] ti-btn ti-btn-dark btn-wave waves-effect waves-light w-full md:w-auto text-sm md:text-base px-4 py-2 md:px-6 md:py-3">
                        Kembali
                    </button>

                    <!-- Action buttons container -->
                    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                        <button type="button" id="save_draft"
                            class="bg-[#6E829F] ti-btn ti-btn-dark btn-wave waves-effect waves-light w-full md:w-auto text-sm md:text-base px-4 py-2 md:px-6 md:py-3">
                            Simpan Sebagai Draft
                        </button>
                        <button type="submit"
                            class="bg-[#5C67F7] ti-btn ti-btn-primary btn-wave waves-effect waves-light w-full md:w-auto text-sm md:text-base px-4 py-2 md:px-6 md:py-3">
                            Hantar
                        </button>
                    </div>
                </div>


            </form>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Save draft functionality (always active)
            document.getElementById("save_draft").addEventListener("click", function() {
                document.getElementById("draft_input").value = "true"; // Set draft to true
                document.getElementById("financial_form").submit(); // Submit the form
            });

            @if ($instiuteType != 1)
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
