@extends('layouts.app')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Maklumat Masjid/Institusi'" :breadcrumbs="[
                ['label' => 'Profile Institusi', 'url' => 'javascript:void(0);'],
                ['label' => 'Profile Institusi'],
            ]" />
            <x-alert />
            <div class="bg-white p-4 md:p-6 rounded-lg shadow">

                <form action="" method="POST">
                    @csrf <!-- Add CSRF token for security -->
                    <div class="flex flex-col gap-4">
                        <h2 class="text-base font-medium">Profile Picture</h2>

                        <div class="flex flex-row gap-4">
                            <div
                                class="w-[150px] h-[150px] border border-dashed border-gray-300 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                </svg>
                            </div>
                            <div class="flex flex-col justify-end gap-2">
                                <button
                                    class="w-[12rem] h-[3rem] bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    Muat Naik Imej
                                </button>
                                <p class="text-sm text-gray-500 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 10l7-7m0 0l7 7m-7-7v18" />
                                    </svg>
                                    use JPEG and PNG, best size 150x150 pixels. Keep it under 3MB
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="grid grid-cols-2 gap-4">
                            <x-input-field level="Institusi" id="institusi" name="" type="text"
                                placeholder="Institusi" value="{{ $institute->institute->instituteCategory->parameter }}"
                                disabled="true" />
                            <x-input-field level="Jenis Institusi" id="jenis_institusi" name="" type="text"
                                placeholder="" value="{{ $institute->institute->instituteType->parameter }} "
                                disabled="true" />

                        </div>

                        <x-input-field level="Nama Institusi" id="nama_institusi" name="" type="text"
                            placeholder="" value="{{ $institute->institute->inst_name }}" disabled="true" />

                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <x-input-field level="Alamat (Baris 1)" id="address1" name="address_line_1" type="text"
                            placeholder="" value="{{ $institute->address_line_1 ?? null }}" />
                        <x-input-field level="Alamat (Baris 2)" id="address2" name="address_line_2" type="text"
                            placeholder="" value="{{ $institute->address_line_2 ?? null }}" />

                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                        <div class="grid grid-cols-3 gap-4">
                            <x-input-field level="Poskod" id="poskod" name="postcode" type="text" placeholder=""
                                value="{{ $institute->postcode ?? null }}" />

                            <x-input-field level="Bandar" id="city" name="" type="text" placeholder=""
                                value="{{ $institute->instituteCity->parameter ?? null }}" />

                            <x-input-field level="Negeri" id="negeri" name="state" type="text" placeholder=""
                                value="{{ $institute->instituteState->parameter ?? null }}" disabled="true" />

                        </div>


                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="grid grid-cols-2 gap-6">
                                <x-input-field level="No. Telefon" id="tel" name="telephone_no" type="text"
                                    placeholder="" value="{{ $institute->telephone_no ?? null }}" />
                                <x-input-field level="No. Fax" id="fax" name="fax_no" type="text"
                                    placeholder="" value="{{ $institute->fax_no ?? null }}" />

                            </div>
                            <x-input-field level="Emel" id="emel" name="email" type="text" placeholder=""
                                value="{{ $institute->email }}" disabled="true" />

                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Website" id="web" name="web_url" type="text" placeholder=""
                                value="{{ $institute->web_url }}" />
                            <x-input-field level="Media Social" id="social" name="media_social" type="text"
                                placeholder="" value="{{ $institute->media_social ?? null }}" />

                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Mukim" id="mukim" name="" type="text" placeholder=""
                                value="{{ $institute->dun ?? null }}" disabled="true" />

                            <x-input-field level="Daerah" id="daerah" name="" type="text" placeholder=""
                                value="{{ $institute->parliament ?? null }}" disabled="true" />

                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Dun" id="dun" name="dun" type="text" placeholder=""
                                value="{{ $institute->dun ?? null }}" />

                            <x-input-field level="Parliament" id="parlimen" name="parliament" type="text"
                                placeholder="" value="{{ $institute->parliament ?? null }}" />

                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Keluasan Institusi" id="area" name="institutional_area"
                                type="number" placeholder="" value="{{ $institute->institutional_area }}" />
                            <x-input-field level="Kapasiti Institusi Jemaah" id="capacity" name="total_capacity"
                                type="number" placeholder="" value="{{ $institute->total_capacity ?? null }}" />

                        </div>

                        <x-input-field level="Koordinat Institusi" id="coordinates" name="inst_coordinate"
                            type="text" placeholder="" value="{{ $institute->inst_coordinate ?? null }}" />

                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Tarikh Kelulusan Jawatankuasa (JATUMS)" id="jatums" name=""
                                type="text" placeholder="" value="{{ $institute->jatums_date ?? null }}" />

                        </div>

                        <div></div>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Nama Pegawai/Wakil Institusi" id="incharge" name=""
                                type="text" placeholder="" value="{{ $institute->personIncharge->fullname }}"
                                disabled="true" />
                            <x-input-field level="No. Kod Pengenalam" id="nric" name="" type="text"
                                placeholder="" value="{{ $institute->personIncharge->nric_number }}" disabled="true" />

                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Jawatan" id="pos" name="" type="text" placeholder=""
                                value="{{ $institute->personIncharge->userPosition->parameter }}" disabled="true" />
                            <x-input-field level="No. H/P" id="hp" name="" type="text" placeholder=""
                                value="{{ $institute->personIncharge->mobile_number }}" disabled="true" />

                        </div>
                    </div>

                    <div class="flex justify-between mt-8">
                        <button type="button" onclick="window.location='{{ route('index') }}'"
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
@endsection
