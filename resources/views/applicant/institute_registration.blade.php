@extends('layouts.loginLayout_')

@section('styles')
    <!-- FlatPickr CSS -->
    <link rel="stylesheet" href="{{ asset('subscription/build/assets/libs/flatpickr/flatpickr.min.css') }}">
@endsection

@section('content')
    <!-- Start::app-content -->
    <div class="main-content app-content m-0 p-0">
        <div class="container-fluid p-0">
            @if (session('success'))
                <div id="successModal"
                    class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-40 !mt-0 z-50">
                    <div class="bg-white rounded-xl shadow-lg p-6 max-w-md w-full text-center relative">
                        <!-- Rest of your modal content -->
                        <button onclick="document.getElementById('successModal').style.display='none'"
                            class="absolute top-2 right-4 text-gray-500 hover:text-gray-700 text-3xl p-3">
                            &times;
                        </button>


                        <!-- Title -->
                        <h2 class="text-green-600 text-lg font-semibold mb-2 text-start">Permohonan Pendaftaran Berjaya
                            Dihantar !</h2>
                        <hr class="">

                        <!-- Message -->
                        <p class="text-black text-xs mt-4 mb-8">Terima kasih kerana mendaftar dengan kami.
                            Pihak kami sedang menyemak permohonan. Sila semak emel anda dalam masa tiga(03) hari bekerja
                            untuk status kelulusan.
                        </p>
                        <hr>

                        <!-- Button Container -->
                        <div class="flex justify-end">
                            <button onclick="window.location.href='{{ route('subscriptionLogin') }}'"
                                class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 mt-2">
                                Tutup
                            </button>
                        </div>

                    </div>
                </div>
            @endif

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
                        <h1 class="text-center text-3xl !font-normal text-[#2624D0] mt-2 font-mont">PENDAFTARAN PROFIL
                            MASJID</h1>
                        {{-- <div class="box-header">
                            <div class="box-title mt-4">
                                Pendaftaran Profil Masjid
                            </div>
                        </div> --}}
                        <div class="box-body !p-0">
                            <form class="wizard wizard-tab horizontal" method="POST"
                                action="{{ route('instituteRegistration', ['id' => $institute->id]) }}">
                                @csrf
                                <aside class="wizard-content container">
                                    <div class="wizard-step " data-title="Maklumat Institusi"
                                        data-id="2e8WqSV3slGIpTbnjcJzmDwBQaHrfh0Z">
                                        <div class="grid grid-cols-12 sm:gap-x-6 justify-content-center">
                                            <div class="xl:col-span-12 col-span-12">
                                                <div class="register-page">
                                                    {{-- <h6 class="mb-3 font-medium">Registration :</h6> --}}
                                                    <div class="grid grid-cols-12 sm:gap-x-6 gap-y-4">
                                                        <div class="xl:col-span-6 col-span-12">
                                                            <div class="grid grid-cols-2 gap-4">
                                                                <x-input-field level="Institusi" id="institusi"
                                                                    name="" type="text" placeholder="Institusi"
                                                                    value="{{ $institute->Type->prm }}" disabled="true" />

                                                                <x-input-field level="Jenis Institusi" id="institusi"
                                                                    name="" type="text" placeholder="Institusi"
                                                                    value="{{ $institute->Category->prm }}"
                                                                    disabled="true" />
                                                            </div>

                                                        </div>
                                                        <div class="xl:col-span-6 col-span-12">
                                                            <x-input-field level="Nama Institusi" id="institusi"
                                                                name="name" type="text" placeholder="Institusi"
                                                                value="{{ $institute->name }}" disabled="true" />
                                                        </div>

                                                        <div class="xl:col-span-6 col-span-12">
                                                            <x-input-field level="Emel (Rasmi)" id="poskod"
                                                                name="mel" type="text" placeholder=""
                                                                :required='true' />
                                                        </div>
                                                        <div class="xl:col-span-6 col-span-12">
                                                            <div class="grid grid-cols-2 gap-4">
                                                                {{-- <x-input-field level="Poskod" id="poskod" name="pcode"
                                                                    type="text" placeholder="" /> --}}
                                                                <x-input-field level="Nombor Telefon (Rasmi)" id="poskod"
                                                                    name="hp" type="text" placeholder=""
                                                                    :required='true' />
                                                                <x-input-field level="Nombor Fax" id="poskod"
                                                                    name="fax" type="text" placeholder="" />

                                                            </div>
                                                        </div>
                                                        {{-- <div class="xl:col-span-6 col-span-12">
                                                            <x-input-field level="Total Area" id="institusi" name="rem13"
                                                                type="text" placeholder="" />
                                                        </div>
                                                        <div class="xl:col-span-6 col-span-12">
                                                            <x-input-field level="Total Capacity" id="institusi"
                                                                name="rem14" type="text" placeholder="" />
                                                        </div>
                                                        <div class="xl:col-span-6 col-span-12">
                                                            <x-input-field level="Location" id="institusi" name="location"
                                                                type="text" placeholder="" />
                                                        </div> --}}

                                                        <div class="xl:col-span-6 col-span-12">
                                                            <x-input-field level="Tarikh Kelulusan Jawatankuasa (JATUMS)"
                                                                id="institusi" name="rem15" type="date" placeholder=""
                                                                :required='true' />
                                                        </div>
                                                        <div class="xl:col-span-6 col-span-12">
                                                            <x-input-field level="Website" id="social" name="web"
                                                                type="text" placeholder="" />

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-step " data-title="Maklumat Tambahan"
                                        data-id="2e8WqSV3slGIpTbnjcJzmDwBQaHrfjHQ">
                                        <div class="grid grid-cols-12 sm:gap-x-6 justify-content-center">
                                            <div class="xl:col-span-12 col-span-12">
                                                <div class="register-page">
                                                    {{-- <h6 class="mb-3 font-medium">Registration :</h6> --}}
                                                    <div class="grid grid-cols-12 sm:gap-x-6 gap-y-4">

                                                        <div class="xl:col-span-6 col-span-12">
                                                            <x-input-field level="Dun" id="institusi" name="rem11"
                                                                type="text" placeholder="" />
                                                        </div>
                                                        <div class="xl:col-span-6 col-span-12">
                                                            <x-input-field level="Parlimen" id="institusi" name="rem12"
                                                                type="text" placeholder="" />
                                                        </div>
                                                        <div class="xl:col-span-6 col-span-12">
                                                            <div class="grid grid-cols-2 gap-4">
                                                                <x-input-field level="Keluasan Institusi" id="institusi"
                                                                    name="rem13" type="text" placeholder="" />
                                                                <x-input-field level="Kapasiti Institusi Jemaah"
                                                                    id="institusi" name="rem14" type="text"
                                                                    placeholder="" />
                                                            </div>

                                                        </div>
                                                        <div class="xl:col-span-6 col-span-12">
                                                            <x-input-field level="Media Sosial" id="social"
                                                                name="rem10" type="text" placeholder="" />

                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="wizard-step" data-title="Alamat Institusi"
                                        data-id="H53WJiv9blN17MYTztq4g8U6eSVkaZDx">
                                        <div class="grid grid-cols-12 sm:gap-x-6 justify-content-center">
                                            <div class="xl:col-span-12 col-span-12">
                                                <div class="register-page">
                                                    <div class="grid grid-cols-12 sm:gap-x-6 gap-y-4">
                                                        <div class="xl:col-span-6 col-span-12">
                                                            <x-input-field level="Alamat (Baris 1)" id="institusi"
                                                                name="addr" type="text" placeholder=""
                                                                :required='true' />
                                                        </div>
                                                        <div class="xl:col-span-6 col-span-12">
                                                            <x-input-field level="Alamat (Baris 2)" id="institusi"
                                                                name="addr1" type="text" placeholder="" />
                                                        </div>
                                                        <div class="xl:col-span-6 col-span-12">
                                                            <div class="grid grid-cols-2 gap-4">
                                                                <x-input-field level="Bandar" id="institusi"
                                                                    name="city" type="select" :valueList="$parameters['cities']"
                                                                    placeholder="Pilih" :required='true' />

                                                                <x-input-field level="Mukim" id="institusi"
                                                                    name="rem9" type="text" placeholder="Institusi"
                                                                    value="{{ $institute->Subdistrict->prm }}"
                                                                    disabled="true" />


                                                            </div>
                                                        </div>
                                                        <div class="xl:col-span-6 col-span-12">
                                                            <div class="grid grid-cols-2 gap-4">
                                                                <x-input-field level="Daerah" id="negeri"
                                                                    name="rem8" type="text"
                                                                    placeholder="Enter negeri"
                                                                    value="{{ $institute->District->prm }}"
                                                                    disabled="true" />
                                                                <x-input-field level="Negeri" id="negeri"
                                                                    name="state" type="text"
                                                                    placeholder="Enter negeri"
                                                                    value="{{ $institute->state }}" disabled="true" />
                                                            </div>
                                                        </div>

                                                        <div class="xl:col-span-6 col-span-12">
                                                            <x-input-field level="Poskod" id="poskod" name="pcode"
                                                                type="text" placeholder="" :required='true' />
                                                        </div>

                                                        <div class="xl:col-span-6 col-span-12">
                                                            <x-input-field level="Koordinat Institusi" id="institusi"
                                                                name="location" type="text" placeholder=""
                                                                :required='true' />
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" wizard-step active" data-title="Pegawai/Wakil Institusi"
                                        data-id="2e8WqSV3slGIpTbnjcJzmDwBQaHrfh0Z">
                                        <div class="grid grid-cols-12 sm:gap-x-6 justify-content-center">
                                            <div class="xl:col-span-12 col-span-12">
                                                <div class="register-page">
                                                    <div class="grid grid-cols-12 sm:gap-x-6 gap-y-4">
                                                        <div class="xl:col-span-6 col-span-12">
                                                            <x-input-field level="Nama Pegawai/Wakil Institusi"
                                                                id="institusi" name="con1" type="text"
                                                                placeholder="" :required='true' />
                                                        </div>
                                                        <div class="xl:col-span-6 col-span-12">
                                                            <x-input-field level="No. Kad Pengenalan" id="institusi"
                                                                name="ic" type="text" placeholder=""
                                                                :required='true' />
                                                        </div>
                                                        <div class="xl:col-span-6 col-span-12">
                                                            <x-input-field level="Jawatan" id="institusi" name="pos1"
                                                                type="select" placeholder="pilih" :valueList="$parameters['user_positions']"
                                                                :required='true' />
                                                        </div>
                                                        <div class="xl:col-span-6 col-span-12">
                                                            <x-input-field level="Nombor Telefon" id="institusi"
                                                                name="tel1" type="text" placeholder=""
                                                                :required='true' />
                                                        </div>

                                                    </div>
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
                                                        {{-- <h5 class="text-success font-medium">Appointment Booked...</h5> --}}
                                                    </div>
                                                    {{-- <div class="mb-4">
                                                        <img src="{{ asset('subscription/assets/icons/fin_logo.svg') }}"
                                                            alt="" class="img-fluid !inline-flex">
                                                    </div> --}}
                                                    <label class="flex items-center mt-8">
                                                        <input type="checkbox" id="myCheckbox"
                                                            class="mr-5 w-3 h-3 border-2 border-black rounded-xs outline outline-1 outline-black focus:outline-4">
                                                        <span
                                                            class="sm:text-left text-red-500 font-bold text-[0.875rem]">Saya
                                                            Bersetuju
                                                            Dengan Terma
                                                            Dan Syarat Di Bawah</span>
                                                    </label>


                                                    <p class="font-semibold pl-8 mt-4 mb-4 text-left text-[0.875rem]">
                                                        SEGALA MAKLUMAT DAN LAMPIRAN YANG DIBERIKAN ADALAH BENAR DAN SAYA
                                                        BERTANGGUNGJAWAB DI ATAS MAKLUMAT YANG
                                                        DIBERIKAN INI. JIKA TERDAPAT MAKLUMAT PALSU YANG DIBERIKAN OLEH
                                                        SAYA, PIHAK MAJLIS AGAMA ISLAM SELANGOR
                                                        (MAIS) BERHAK MENGAMBIL TINDAKAN UNDANG-UNDANG KE ATAS DIRI SAYA.
                                                    </p>

                                                    <button class="ti-btn ti-btn-success opacity-50 cursor-not-allowed"
                                                        type="submit" disabled>
                                                        Hantar
                                                    </button>
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
            const submitButton = document.querySelector('.ti-btn-success');

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
        });
    </script>
@endsection
