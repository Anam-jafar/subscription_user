@extends('layouts.adminLayout')

@section('styles')
@endsection

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Penghantaran Laporan Kewangan'" :breadcrumbs="[['label' => 'Laporan Kewangan', 'url' => 'javascript:void(0);'], ['label' => 'Penyata Baharu']]" />
            <x-alert />
            <div class="mt-8 sm:p-4">
                <div class="grid grid-cols-1 gap-x-16 gap-y-2 max-w-3xl">

                    <x-show-key-value :key="'No Rujukan'" :value="$financialStatement->submission_refno" />
                    <x-show-key-value :key="'Tarikh Penghantaran'" :value="$financialStatement->submission_date" />


                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div class="grid grid-cols-1 gap-x-16 gap-y-2 max-w-3xl mt-8">
                        <x-show-key-value :key="'Institusi'" :value="$financialStatement->institute_category" />
                        <x-show-key-value :key="'Jenis Institusi'" :value="$financialStatement->institute_type" />
                        <x-show-key-value :key="'Nama Institusi'" :value="$financialStatement->institute_name" />
                        <x-show-key-value :key="'Daerah'" :value="$financialStatement->institute_district" />
                        <x-show-key-value :key="'Mukim'" :value="$financialStatement->institute_district" />
                        <x-show-key-value :key="'Bandar'" :value="$financialStatement->institute_city" />
                        <x-show-key-value :key="'No. Telefon'" :value="$financialStatement->institute_telephone_no" />
                        <x-show-key-value :key="'Emel'" :value="$financialStatement->institute_email" />
                    </div>
                    <div class=" max-w-3xl mt-8 space-y-2">
                        <x-show-key-value :key="'Nama Pengawai / Waki Institusi'" :value="$financialStatement->institute_person_incharge" />
                        <x-show-key-value :key="'Jawatan'" :value="$financialStatement->institute_person_incharge_position" />
                        <x-show-key-value :key="'No. H/P'" :value="$financialStatement->institute_person_incharge_mobile_number" />
                    </div>
                </div>
                <div class="bg-white text-xs md:p-4">
                    <x-alert />

                    @if ($instituteType == 'SD')
                        <div>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                                <x-input-field level="Bagi Tahun" id="ye" disabled="true" name=""
                                    type="text" placeholder="Year" value="{{ $financialStatement->fin_year }}" />

                                <x-input-field level="Kategori Penyata" id="statment" name="fin_category" type="text"
                                    disabled="true" placeholder="Pilih"
                                    value="{{ $financialStatement->finCategory->parameter }}" />

                                <x-input-field level="Peratus Kemajuan Pembinaan Terkini (%)" id="p1"
                                    name="latest_construction_progress" type="text" placeholder="00"
                                    value="{{ $financialStatement->latest_construction_progress }}" disabled="true" />
                            </div>
                            <p class="text-gray-800 font-medium mt-4">Butiran Penyata :</p>
                            <div class="grid grid-cols-3 gap-6">

                            </div>
                            <div class="grid grid-cols-2 gap-6 mt-4">
                                <p class="text-gray-700">A. Maklumat Pembinaan</p>
                                <p class="text-gray-700">B. Jumlah Kutipan</p>

                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                <x-input-field level="(i) Kos Pembinaan (Asal, RM)" id="i1"
                                    name="ori_construction_cost" type="text" placeholder="00.00" :rightAlign="true"
                                    :required="true" value="{{ $financialStatement->ori_construction_cost }}"
                                    disabled="true" />

                                <x-input-field level="(ii) Variation Order (Tambah Kurang, RM)" id="i2"
                                    name="variation_order" type="text" placeholder="00.00" :rightAlign="true"
                                    :required="true" value="{{ $financialStatement->variation_order }}" disabled="true" />

                                <x-input-field level="(i) Kutipan Semasa (RM)" id="i3" name="current_collection"
                                    type="text" placeholder="00.00" :rightAlign="true" :required="true"
                                    value="{{ $financialStatement->current_collection }}" disabled="true" />
                                <x-input-field level="(ii) Kutipan Terkumpul (RM)" id="i04" name="total_expenses"
                                    type="text" placeholder="00.00" :rightAlign="true" :required="true"
                                    value="{{ $financialStatement->total_expenses }}" disabled="true" />
                            </div>
                            <div class="grid grid-cols-2 gap-6 mt-4">
                                <p class="text-gray-700 ">C. Jumlah Perbelanjaan</p>
                                <p class="text-gray-700 ">D. Jumlah Lebihan</p>

                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                <x-input-field level="(i) Pindahan Kepada PWS (RM)" id="i4" name="transfer_pws"
                                    type="text" placeholder="00.00" :rightAlign="true" :required="true"
                                    value="{{ $financialStatement->transfer_pws }}" disabled="true" />
                                <x-input-field level="(ii) Belanja Pembinaan Masjid/Surau (RM)" id="i5"
                                    name="construction_expenses" type="text" placeholder="00.00" :rightAlign="true"
                                    :required="true" value="{{ $financialStatement->construction_expenses }}"
                                    disabled="true" />
                                <x-input-field level="(i) Lebihan Masjid/Surau (RM)" id="i4" name="inst_surplus"
                                    type="text" placeholder="00.00" :rightAlign="true" :required="true"
                                    value="{{ $financialStatement->inst_surplus }}" disabled="true" />
                                <x-input-field level="(ii) Lebihan PWS (RM)" id="i5" name="pws_surplus"
                                    type="text" placeholder="00.00" :rightAlign="true" :required="true"
                                    value="{{ $financialStatement->pws_surplus }}" disabled="true" />
                            </div>
                            <div class="grid grid-cols-3 gap-6">
                                <x-input-field level="(iii) Belanja Pembinaan PWS (RM)" id="i6" name="pws_expenses"
                                    type="text" placeholder="00.00" :rightAlign="true" :required="true"
                                    value="{{ $financialStatement->pws_expenses }}" disabled="true" />

                            </div>
                            <p class="text-gray-800 font-medium mt-4 mb-2">Sila Lampirkan Salinan Dokumen Seperti Di
                                Bawah :</p>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4 mb-4">
                                <x-pdf-download title="Penyata Kewangan"
                                    pdfFile="{{ $attachment->fin_statement ?? '' }}" />
                                <x-pdf-download title="Penyata Bank" pdfFile="{{ $attachment->bank_statement ?? '' }}" />
                                {{-- <x-pdf-download title="Bank Reconciliation" pdfFile="{{ $attachment->bank_reconciliation ?? '' }}" /> --}}
                                <x-pdf-download title="Certificate Completion & Compliance(CCC)"
                                    pdfFile="{{ $attachment->ccc ?? '' }}" />
                            </div>
                        </div>
                    @else
                        <div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <x-input-field level="Bagi Tahun" id="ye" disabled="true" name=""
                                    type="text" placeholder="Year" value="{{ $financialStatement->fin_year }}" />

                                <x-input-field level="Kategori Penyata" id="statment" name="fin_category"
                                    type="text" disabled="true" placeholder="Pilih"
                                    value="{{ $financialStatement->finCategory->parameter }}" />
                            </div>
                            <p class="text-gray-800 font-medium mt-4">Butiran Penyata :</p>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                <x-input-field level="(a) Baki Bawa Ke Hadapan (RM)" id="i1"
                                    name="balance_forward" type="text" placeholder="00.00" :rightAlign="true"
                                    disabled="true" value="{{ $financialStatement->balance_forward }}" />
                                <x-input-field level="(b) Jumlah Kutipan (RM)" id="i2" name="total_collection"
                                    type="text" placeholder="00.00" :rightAlign="true" disabled="true"
                                    value="{{ $financialStatement->total_collection }}" />
                                <x-input-field level="(c) Jumlah Perbelanjaan (RM)" id="i3" name="total_expenses"
                                    type="text" placeholder="00.00" :rightAlign="true" disabled="true"
                                    value="{{ $financialStatement->total_expenses }}" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                <x-input-field level="Jumlah Pendapatan (Auto Calculate, RM)" id="i4"
                                    name="total_statement" type="text" placeholder="00.00" :rightAlign="true"
                                    :required="true" value="{{ $financialStatement->total_income }}" disabled="true" />
                                <x-input-field level="Jumlah Lebihan (Auto Calculate, RM)" id="i5"
                                    name="total_surplus" type="text" placeholder="00.00" :rightAlign="true"
                                    :required="true" value="{{ $financialStatement->total_surplus }}"
                                    disabled="true" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <x-input-field level="Maklumat Baki Bank Dan Tunai (RM)" id="i6"
                                    name="bank_cash_balance" type="text" placeholder="00.00" :rightAlign="true"
                                    value="{{ $financialStatement->bank_cash_balance }}" disabled="true" />
                            </div>

                            <p class="text-gray-800 font-medium mt-4 mb-2">Sila Lampirkan Salinan Dokumen Seperti Di Bawah
                                :
                            </p>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4 mb-4">
                                <x-pdf-download title="Penyata Kewangan Dan Nota Kewangan"
                                    pdfFile="{{ $attachment->fin_statement ?? '' }}" />
                                <x-pdf-download title="Penyata Bank" pdfFile="{{ $attachment->bank_statement ?? '' }}" />
                                <x-pdf-download title="Penyata Penyesuaian Bank"
                                    pdfFile="{{ $attachment->bank_reconciliation ?? '' }}" />

                            </div>
                        </div>
                    @endif
                    <div class="mt-4 mb-4">

                        <p class="font-semibold text-gray-800 mt-4 mb-4">Status Semakan Audit Dalam MAIS</p>
                        <form action="{{ route('financialStatementApprove', ['id' => $financialStatement->id]) }}"
                            method="POST" enctype="multipart/form-data">

                            @csrf
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                <x-input-field level="Status Peneriman" id="submission" name="submission_status"
                                    type="select" placeholder="Pilih" :valueList="$submission_statuses" />

                                <x-input-field level="Status Semakan" id="audit" name="audit_status" type="select"
                                    placeholder="Pilih" :valueList="$audit_statuses" />

                            </div>

                            <div class="gap-6 mt-4 mb-4">
                                <label class="text-gray-800 font-medium col-span-3" for="cancel_reason_byadmin">
                                    Alasan Pembatalan <span class="text-red-500">*</span>
                                </label>
                                <textarea name="cancel_reason_byuser" id="cancellation_reason" cols="30" rows="4"
                                    class="block w-full border !border-[#6E829F] focus:shadow-sm dark:focus:shadow-white/10 
                                        rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-[#6E829F] 
                                        dark:focus:border-white/10 text-black resize-none col-span-3 mt-2">
                                    </textarea>
                            </div>
                            <div class="gap-6 mt-4 mb-4">
                                <label class="text-gray-800 font-medium col-span-3" for="correction_proposal_byadmin">
                                    Cadangan Pembetulan <span class="text-red-500">*</span>
                                </label>
                                <textarea name="cancel_reason_byuser" id="cancellation_reason" cols="30" rows="4"
                                    class="block w-full border !border-[#6E829F] focus:shadow-sm dark:focus:shadow-white/10 
                                        rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-[#6E829F] 
                                        dark:focus:border-white/10 text-black resize-none col-span-3 mt-2">
                                    </textarea>
                            </div>

                            <div class="grid grid-col-1 md:grid-cols-3 gap-6 mt-4 mb-4">
                                <div class="flex flex-col">
                                    <label for="input3" class="text-gray-800 font-medium mb-2">
                                        Laporan Kewangan Beraudit Oleh Firma Audit <span class="text-red-500">*</span>
                                    </label>
                                    <input type="file" name="audited_fin_report"
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
                                    <label for="input3" class="text-gray-800 font-medium mb-2">Laporan Kewangan Disemak
                                        Oleh Permeriksa Kira-kira <span class="text-red-500 ">*</span></label>
                                    <input type="file" name="reviewed_fin_report"
                                        class="block w-full h-[3rem] border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 text-textmuted dark:text-textmuted/50
                                            file:me-4 file:py-2 file:px-4 file:h-[3rem]
                                            file:rounded-s-sm file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-primary file:text-white
                                            hover:file:bg-primary focus-visible:outline-none
                                        ">
                                </div>
                                <div class="flex flex-col">
                                    <label for="input3" class="text-gray-800 font-medium mb-2">Laporan Kewangan Tidak
                                        Beraudit
                                        Bank
                                        <span class="text-red-500 ">*</span></label>
                                    <input type="file" name="unaudited_fin_report"
                                        class="block w-full h-[3rem] border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 text-textmuted dark:text-textmuted/50
                                            file:me-4 file:py-2 file:px-4
                                            file:rounded-s-sm file:border-0 file:h-[3rem]
                                            file:text-sm file:font-semibold
                                            file:bg-primary file:text-white
                                            hover:file:bg-primary focus-visible:outline-none
                                        ">
                                </div>
                            </div>
                            <div class="grid grid-col-1 md:grid-cols-3 gap-6 mt-4 mb-4">
                                <div class="flex flex-col">
                                    <label for="input3" class="text-gray-800 font-medium mb-2">
                                        Serah Sijil Bersih <span class="text-red-500">*</span>
                                    </label>
                                    <input type="file" name="clean_cert"
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
                                    <label for="input3" class="text-gray-800 font-medium mb-2">Serah Sijil Audit
                                        Berteguran <span class="text-red-500 ">*</span></label>
                                    <input type="file" name="qualified_audit_cert"
                                        class="block w-full h-[3rem] border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 text-textmuted dark:text-textmuted/50
                                            file:me-4 file:py-2 file:px-4 file:h-[3rem]
                                            file:rounded-s-sm file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-primary file:text-white
                                            hover:file:bg-primary focus-visible:outline-none
                                        ">
                                </div>
                                <div class="flex flex-col">
                                    <label for="input3" class="text-gray-800 font-medium mb-2">Penyata Tidak Boleh
                                        Disahkan
                                        <span class="text-red-500 ">*</span></label>
                                    <input type="file" name="unauditable_statement"
                                        class="block w-full h-[3rem] border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 text-textmuted dark:text-textmuted/50
                                            file:me-4 file:py-2 file:px-4
                                            file:rounded-s-sm file:border-0 file:h-[3rem]
                                            file:text-sm file:font-semibold
                                            file:bg-primary file:text-white
                                            hover:file:bg-primary focus-visible:outline-none
                                        ">
                                </div>
                            </div>

                            <div class="flex justify-between mt-8">
                                <button
                                    class="bg-[#6E829F] ti-btn ti-btn-dark btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg">
                                    Kembali
                                </button>
                                <button
                                    class="bg-[#5C67F7] ti-btn ti-btn-primary btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg"
                                    type="submit">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>



                </div>
            </div>
        </div>
    </div>
@endsection
