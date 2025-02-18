@extends('layouts.loginLayout')

@section('content')
    <x-page-header :title="'Pendaftaran Baharu'" :breadcrumbs="[
        ['label' => 'Pendaftaran Institusi', 'url' => route('registerInstitute')],
        ['label' => 'Maklumat Masjid/Institusi'],
    ]" />
    @if (session('error'))
        <div class="alert alert-danger bg-red-600 text-white rounded-md p-4 mb-4 animate-fade-out">
            <div class="flex items-center">
                <svg class="h-6 w-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9l-6 6m0-6l6 6" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif



    <form method="POST" action="{{ route('instituteProfileRegister') }}">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Side: A & B together -->
            <div class="grid grid-cols-2 gap-4">
                <x-input-field level="Institusi" id="institusi" name="" type="text" placeholder="Institusi"
                    value="{{ $institute->instituteCategory->parameter }}" disabled="true" />
                <x-input-field level="Jenis Institusi" id="jenis_institusi" name="" type="text" placeholder=""
                    value="{{ $institute->instituteType->parameter }}" disabled="true" />
            </div>

            <!-- Right Side: C -->
            <x-input-field level="Nama Institusi" id="nama_institusi" name="" type="text" placeholder=""
                value="{{ $institute->inst_name }}" disabled="true" />

            <input type="hidden" name="inst_refno" value="{{ $institute->inst_refno }}" />
        </div>


        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <x-input-field level="Alamat (Baris 1)" id="address1" name="address_line_1" type="text" placeholder="" />
            <x-input-field level="Alamat (Baris 2)" id="address2" name="address_line_2" type="text" placeholder="" />



        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="grid grid-cols-3 gap-4">
                <x-input-field level="Poskod" id="poskod" name="postcode" type="text" placeholder="" />

                <x-input-field level="Bandar" id="city" name="city" type="select" placeholder=""
                    :valueList="$commonData['cities']" />

                <x-input-field level="Negeri" id="negeri" name="state" type="text" placeholder="Enter negeri"
                    value="{{ $negeri }}" disabled="true" />

            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="grid grid-cols-2 gap-6">
                    <x-input-field level="No. Telefon" id="tel" name="telephone_no" type="text" placeholder="" />
                    <x-input-field level="No. Fax" id="fax" name="fax_no" type="text" placeholder="" />

                </div>
                <x-input-field level="Emel" id="emel" name="email" type="email" placeholder=""
                    :required="true" />

            </div>

            <div class="grid grid-cols-2 gap-6">
                <x-input-field level="Website" id="web" name="web_url" type="text" placeholder="" />
                <x-input-field level="Media Social" id="social" name="media_social" type="text" placeholder="" />

            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="grid grid-cols-2 gap-6">
                <x-input-field level="Mukim" id="mukim" name="" type="text" placeholder="Enter Mukim"
                    value="{{ $subDistrict }}" disabled="true" />

                <x-input-field level="Daerah" id="daerah" name="" type="text" placeholder="Enter Daerah"
                    value="{{ $district }}" disabled="true" />

            </div>

            <div class="grid grid-cols-2 gap-6">
                <x-input-field level="Dun" id="dun" name="dun" type="text" placeholder="" />

                <x-input-field level="Parliament" id="parliament" name="parliament" type="text" placeholder="" />

            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="grid grid-cols-2 gap-6">
                <x-input-field level="Keluasan Institusi" id="area" name="institutional_area" type="number"
                    placeholder="" />
                <x-input-field level="Kapasiti Institusi Jemaah" id="capacity" name="total_capacity" type="number"
                    placeholder="" />

            </div>

            <x-input-field level="Koordinat Institusi" id="coordinates" name="inst_coordinate" type="text"
                placeholder="" />

        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="grid grid-cols-2 gap-6">
                <x-input-field level="Tarikh Kelulusan Jawatankuasa (JATUMS)" id="jatums" name="jatums_date"
                    placeholder="" type="date" />

            </div>

            <div></div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="grid grid-cols-2 gap-6">
                <x-input-field level="Nama Pegawai/Wakil Institusi" id="incharge" name="incharge_name" type="text"
                    placeholder="" :required="true" />
                <x-input-field level="No. Kod Pengenalam" id="nric" name="incharge_nric" type="text"
                    placeholder="" :required="true" />

            </div>

            <div class="grid grid-cols-2 gap-6">
                <x-input-field level="Jawatan" id="pos" name="incharge_position" type="select" placeholder=""
                    :valueList="$commonData['positions']" :required="true" />
                <x-input-field level="No. H/P" id="hp" name="incharge_mobile_no" type="text" placeholder=""
                    :required="true" />

            </div>
        </div>

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
        <div class="text-right mt-6">
            <button class="bg-[#5C67F7] ti-btn ti-btn-primary btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg"
                type="submit">
                Hantar
            </button>
        </div>
    </form>

    <!-- Success Modal -->
    @if (session('success'))
        <!-- Success Modal -->
        @if (session('success'))
            <div id="successModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-40 !mt-0">
                <div class="bg-white rounded-xl shadow-lg p-6 max-w-md w-full text-center relative">
                    <!-- Close Button -->
                    <button onclick="document.getElementById('successModal').style.display='none'"
                        class="absolute top-2 right-4 text-gray-500 hover:text-gray-700 text-3xl p-3">
                        &times;
                    </button>


                    <!-- Title -->
                    <h2 class="text-green-600 text-lg font-semibold mb-2 text-start">Penghantaran Berjaya !</h2>
                    <hr class="">

                    <!-- Message -->
                    <p class="text-black text-xs mt-4 mb-8">Email bersama OTP akan dihantar setelah permohonan diluluskan
                    </p>
                    <hr>

                    <!-- Button Container -->
                    <div class="flex justify-end">
                        <button onclick="window.location.href='{{ route('login') }}'"
                            class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 mt-2">
                            Tutup
                        </button>
                    </div>

                </div>
            </div>
        @endif
    @endif
@endsection
