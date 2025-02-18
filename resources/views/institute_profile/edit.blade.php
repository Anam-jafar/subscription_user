@extends('layouts.adminLayout')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">
            <x-page-header :title="'Semakan Permohonan Baharu'" :breadcrumbs="[
                ['label' => 'Rekod Institusi', 'url' => 'javascript:void(0);'],
                ['label' => 'Permohonan Baharu'],
            ]" />
            <x-alert />
            <div class="bg-white p-4 md:p-6 rounded-lg shadow">
                <form action="{{ route('instituteProfileUpdate', ['id' => $institute->id]) }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                        <x-input-field level="Tarikh Mohon" id="tarikh_mohon" name="" type="text"
                            placeholder="Tarik Mohon" value="{{ $institute->created_at ?? '' }}" disabled="true" />
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="grid grid-cols-2 gap-4">
                            <x-input-field level="Institusi" id="institusi" name="" type="text"
                                placeholder="Institusi"
                                value="{{ $institute->institute->instituteCategory->parameter ?? '' }}" disabled="true" />
                            <x-input-field level="Jenis Institusi" id="jenis_institusi" name="" type="text"
                                placeholder="" value="{{ $institute->institute->instituteType->parameter ?? '' }}"
                                disabled="true" />
                        </div>

                        <x-input-field level="Nama Institusi" id="nama_institusi" name="" type="text"
                            placeholder="" value="{{ $institute->institute->inst_name ?? '' }}" disabled="true" />
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <x-input-field level="Alamat (Baris 1)" id="address1" name="" type="text" placeholder=""
                            value="{{ $institute->address_line_1 ?? '' }}" disabled="true" />
                        <x-input-field level="" id="address2" name="" type="text" placeholder=""
                            value="{{ $institute->address_line_2 ?? '' }}" disabled="true" />


                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="grid grid-cols-3 gap-4">
                            <x-input-field level="Poskod" id="poskod" name="" type="text" placeholder=""
                                value="{{ $institute->postcode ?? '' }}" disabled="true" />

                            <x-input-field level="Bandar" id="city" name="" type="text" placeholder=""
                                value="{{ $institute->instituteCity->parameter ?? '' }}" disabled="true" />

                            <x-input-field level="Negeri" id="negeri" name="" type="text" placeholder=""
                                value="{{ $institute->instituteState->parameter ?? '' }}" disabled="true" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="grid grid-cols-2 gap-6">
                                <x-input-field level="No. Telefon" id="tel" name="" type="text"
                                    placeholder="" value="{{ $institute->telephone_no ?? '' }}" disabled="true" />
                                <x-input-field level="No. Fax" id="fax" name="" type="text" placeholder=""
                                    value="{{ $institute->fax_no ?? '' }}" disabled="true" />
                            </div>
                            <x-input-field level="Emel" id="emel" name="email" type="email" placeholder=""
                                value="{{ $institute->email ?? '' }}" />
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Website" id="web" name="" type="text" placeholder=""
                                value="{{ $institute->web_url ?? '' }}" disabled="true" />
                            <x-input-field level="Media Social" id="social" name="" type="text"
                                placeholder="" value="{{ $institute->media_social ?? '' }}" disabled="true" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Mukim" id="mukim" name="" type="text" placeholder=""
                                value="{{ $institute->dun ?? '' }}" disabled="true" />

                            <x-input-field level="Daerah" id="daerah" name="" type="text" placeholder=""
                                value="{{ $institute->parliament ?? '' }}" disabled="true" />
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Dun" id="dun" name="" type="text" placeholder=""
                                value="{{ $institute->dun ?? '' }}" disabled="true" />

                            <x-input-field level="Parliament" id="parliament" name="" type="text"
                                placeholder="" value="{{ $institute->parliament ?? '' }}" disabled="true" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Keluasan Institusi" id="area" name="" type="text"
                                placeholder="" value="{{ $institute->institutional_area ?? '' }}" disabled="true" />
                            <x-input-field level="Kapasiti Institusi Jemaah" id="capacity" name=""
                                type="text" placeholder="" value="{{ $institute->total_capacity ?? '' }}"
                                disabled="true" />
                        </div>

                        <x-input-field level="Koordinat Institusi" id="coordinates" name="" type="text"
                            placeholder="" value="{{ $institute->inst_coordinate ?? '' }}" disabled="true" />
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Tarikh Kelulusan Jawatankuasa (JATUMS)" id="jatums" name=""
                                type="text" placeholder="" value="{{ $institute->jatums_date ?? '' }}"
                                disabled="true" />
                        </div>
                        <div></div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Nama Pegawai/Wakil Institusi" id="incharge" name=""
                                type="text" placeholder="" value="{{ $institute->personIncharge->fullname ?? '' }}"
                                disabled="true" />
                            <x-input-field level="No. Kod Pengenalam" id="nric" name="" type="text"
                                placeholder="" value="{{ $institute->personIncharge->nric_number ?? '' }}"
                                disabled="true" />
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <x-input-field level="Jawatan" id="pos" name="" type="text" placeholder=""
                                value="{{ $institute->personIncharge->userPosition->parameter ?? '' }}"
                                disabled="true" />
                            <x-input-field level="No. H/P" id="hp" name="" type="text" placeholder=""
                                value="{{ $institute->personIncharge->mobile_number ?? '' }}" disabled="true" />
                        </div>
                    </div>

                    <div class="flex justify-between mt-8">
                        <button type="button" onclick="window.location='{{ route('instituteProfileList') }}'"
                            class="bg-[#6E829F] ti-btn ti-btn-dark btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg">
                            Kembali
                        </button>

                        <button
                            class="bg-[#24B24B] ti-btn ti-btn-success btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg"
                            type="submit">
                            Kemanskini & Diluluskan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
