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
                        <h1 class="text-center text-3xl !font-normal text-[#2624D0] mt-2 font-mont">KEMASKINI PROFIL MASJID
                        </h1>

                        <div class="box-body !p-0">
                            <form class="wizard wizard-tab horizontal" method="POST" action="{{ route('instituteEdit') }}">
                                @csrf
                                <aside class="wizard-content container">
                                    <div class="wizard-step " data-title="Maklumat Institusi"
                                        data-id="2e8WqSV3slGIpTbnjcJzmDwBQaHrfh0Z">
                                        <div class="grid grid-cols-12 sm:gap-x-6 justify-content-center">
                                            <div class="xl:col-span-12 col-span-12">
                                                <div class="register-page">
                                                    <div class="gap-y-4">
                                                        <x-required-warning-text />

                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <div class="grid grid-cols-2 gap-4">
                                                                <x-input-field level="Institusi" id="institusi"
                                                                    name="" type="text" placeholder="Institusi"
                                                                    value="{{ $institute->Type->prm }}" disabled="true" />

                                                                <x-input-field level="Jenis Institusi" id="institusi"
                                                                    name="" type="text" placeholder="Institusi"
                                                                    value="{{ $institute->Category->prm }}"
                                                                    disabled="true" />
                                                            </div>
                                                            <x-input-field level="Nama Institusi" id="institusi"
                                                                name="name" type="text" placeholder="Institusi"
                                                                value="{{ $institute->name }}" disabled="true" />
                                                        </div>
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <x-input-field level="Emel" id="poskod" spanText="Rasmi"
                                                                name="mel" type="text" placeholder="masjid@gmail.com"
                                                                :required='true' value="{{ $institute->mel }}" />
                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                                <x-input-field level="Nombor Telefon" id="poskod"
                                                                    spanText="Rasmi" name="hp" type="number"
                                                                    placeholder="012345678901" :required='true'
                                                                    value="{{ $institute->hp }}" />
                                                                <x-input-field level="Nombor Fax" id="poskod"
                                                                    name="fax" type="number" placeholder="031234567"
                                                                    value="{{ $institute->Category->fax }}" />

                                                            </div>
                                                        </div>



                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <x-input-field level="Tarikh Kelulusan Jawatankuasa (JATUMS)"
                                                                id="institusi" name="rem15" type="date" placeholder=""
                                                                :required='true' value="{{ $institute->rem15 }}" />
                                                            <x-input-field level="Website" id="social" name="web"
                                                                type="text" placeholder=""
                                                                value="{{ $institute->web }}" />
                                                        </div>

                                                        <div
                                                            class="flex flex-col md:flex-row justify-between mt-8 space-y-3 md:space-y-0">
                                                            <a href="{{ route('home') }}"
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
                                    </div>
                                    <div class="wizard-step " data-title="Maklumat Tambahan"
                                        data-id="2e8WqSV3slGIpTbnjcJzmDwBQaHrfjHQ">
                                        <div class="grid grid-cols-12 sm:gap-x-6 justify-content-center">
                                            <div class="xl:col-span-12 col-span-12">
                                                <div class="register-page">
                                                    {{-- <h6 class="mb-3 font-medium">Registration :</h6> --}}
                                                    <div class="gap-y-4">

                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <x-input-field level="Dun" id="institusi" name="rem11"
                                                                type="text" placeholder=""
                                                                value="{{ $institute->rem11 }}" />
                                                            <x-input-field level="Parlimen" id="institusi" name="rem12"
                                                                type="text" placeholder=""
                                                                value="{{ $institute->rem12 }}" />
                                                        </div>

                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <div class="grid grid-cols-2 gap-4">
                                                                <x-input-field level="Keluasan Institusi" id="institusi"
                                                                    name="rem13" type="number" placeholder="1000 sqt"
                                                                    value="{{ $institute->rem13 }}" />
                                                                <x-input-field level="Kapasiti Jemaah" id="institusi"
                                                                    name="rem14" type="number" placeholder="1000"
                                                                    value="{{ $institute->rem14 }}" />
                                                            </div>
                                                            <x-input-field level="Media Sosial" id="social"
                                                                name="rem10" type="text" placeholder=""
                                                                value="{{ $institute->rem10 }}" />
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
                                                    <div class="gap-y-4">
                                                        <x-required-warning-text />

                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <x-input-field level="Alamat (Baris 1)" id="institusi"
                                                                name="addr" type="text" placeholder=""
                                                                :required='true' value="{{ $institute->addr }}" />
                                                            <x-input-field level="Alamat (Baris 2)" id="institusi"
                                                                name="addr1" type="text" placeholder=""
                                                                value="{{ $institute->addr1 }}" />
                                                        </div>
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <div class="grid grid-cols-2 gap-4">
                                                                <div class="flex flex-col mt-4">
                                                                    <label for="citySearch"
                                                                        class="text-gray-800 font-normal mb-2">
                                                                        Bandar
                                                                    </label>

                                                                    <div class="relative">
                                                                        <!-- Search Input -->
                                                                        <input type="text" id="citySearch"
                                                                            autocomplete="off"
                                                                            placeholder="Cari Bandar..."
                                                                            class="p-2 border !border-[#6E829F] rounded-lg !text-gray-800 w-full h-[3rem]"
                                                                            value="{{ $parameters['cities'][$institute->city] ?? '' }}">

                                                                        <!-- Hidden Select (To store actual value for form submission) -->
                                                                        <select id="city" name="city"
                                                                            class="hidden">
                                                                            <option value="" disabled
                                                                                {{ old('city', $institute->city) === null ? 'selected' : '' }}>
                                                                                Pilih
                                                                            </option>
                                                                            @foreach ($parameters['cities'] as $key => $displayValue)
                                                                                <option value="{{ $key }}"
                                                                                    {{ old('city', $institute->city) == $key ? 'selected' : '' }}>
                                                                                    {{ $displayValue }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>

                                                                        <!-- Search Results -->
                                                                        <ul id="cityResults"
                                                                            class="absolute z-10 bg-white border border-gray-300 rounded-lg w-full mt-1 hidden max-h-48 overflow-auto">
                                                                        </ul>
                                                                    </div>
                                                                </div>

                                                                <x-input-field level="Mukim" id="institusi"
                                                                    name="rem9" type="text" placeholder="Institusi"
                                                                    value="{{ $institute->Subdistrict->prm }}"
                                                                    disabled="true" />
                                                            </div>
                                                            <div class="grid grid-cols-2 gap-4">
                                                                <x-input-field level="Daerah" id="negeri"
                                                                    name="rem8" type="text"
                                                                    placeholder="Enter negeri"
                                                                    value="{{ $institute->District->prm }}"
                                                                    disabled="true" />
                                                                <x-input-field level="Negeri" id="negeri"
                                                                    name="state" type="text"
                                                                    placeholder="Enter negeri"
                                                                    value="{{ $institute->State->prm }}"
                                                                    disabled="true" />
                                                            </div>
                                                        </div>

                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <x-input-field level="Poskod" id="poskod" name="pcode"
                                                                type="number" placeholder="" :required='true'
                                                                value="{{ $institute->pcode }}" />
                                                            <div class="flex flex-col mt-4">
                                                                <label for="location"
                                                                    class="text-gray-800 font-normal mb-2">
                                                                    Koordinat Institusi <span class="text-red-500">*</span>
                                                                </label>
                                                                <div class="relative">
                                                                    <!-- Input Field -->
                                                                    <input type="text" id="location" name="location"
                                                                        class="p-2 w-full border !border-[#6E829F] rounded-lg !text-gray-800 h-[3rem] pr-12"
                                                                        placeholder="Pilih lokasi" required
                                                                        value="{{ $institute->location }}">

                                                                    <!-- Location Icon (Fixed Alignment) -->
                                                                    <span id="openMapModal"
                                                                        class="absolute top-1/2 right-3 transform -translate-y-1/2 flex items-center cursor-pointer text-gray-600">
                                                                        <i class="fe fe-map-pin text-xl"></i>
                                                                    </span>
                                                                </div>
                                                            </div>


                                                            <!-- Location Picker Modal -->
                                                            <div id="mapModal"
                                                                class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden z-[9999]">
                                                                <div
                                                                    class="bg-white p-4 rounded-lg shadow-lg w-full max-w-3xl relative">
                                                                    <!-- Close Button (Cross Icon) -->
                                                                    <button id="closeMapModal" type="button"
                                                                        class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl font-bold">
                                                                        &times;
                                                                    </button>

                                                                    <h2 class="text-lg font-semibold">Pilih Lokasi
                                                                    </h2>
                                                                    <span class="text-gray-500 text-normal">Sila
                                                                        masukkan
                                                                        nama
                                                                        jalan dan tekan cari</span>

                                                                    <div id="map"
                                                                        class="h-[400px] w-full rounded-md"></div>
                                                                    <div class="flex justify-end mt-4">
                                                                        <button id="closeMapModalFooter" type="button"
                                                                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                                                                            Tutup
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>

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
                                                    <div class="gap-y-4">
                                                        <x-required-warning-text />

                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <x-input-field level="Nama Pegawai/Wakil Institusi"
                                                                id="institusi" name="con1" type="text"
                                                                placeholder="" :required='true'
                                                                value="{{ $institute->con1 }}" />
                                                            <x-input-field level="No. Kad Pengenalan" id="institusi"
                                                                name="ic" type="number" placeholder=""
                                                                :required='true' value="{{ $institute->ic }}" />
                                                        </div>
                                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                            <x-input-field level="Jawatan" id="institusi" name="pos1"
                                                                type="select" placeholder="pilih" :valueList="$parameters['user_positions']"
                                                                :required='true' value="{{ $institute->pos1 }}" />
                                                            <x-input-field level="Nombor Telefon" id="institusi"
                                                                name="tel1" type="number" placeholder=""
                                                                :required='true' value="{{ $institute->tel1 }}" />
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

                                                    <button
                                                        class="ti-btn ti-btn-success opacity-50 py-2 px-4 rounded-full cursor-not-allowed w-24"
                                                        type="submit" disabled>
                                                        Kemaskini
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

            let modal = document.getElementById("mapModal");
            let openButton = document.getElementById("openMapModal");
            let closeButton = document.getElementById("closeMapModal");
            let locationInput = document.getElementById("location");
            let map, marker;

            openButton.addEventListener("click", function() {
                modal.classList.remove("hidden");

                if (!map) {
                    map = L.map('map').setView([3.0738, 101.5183], 10); // Selangor, Malaysia

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(map);

                    marker = L.marker([3.0738, 101.5183], {
                        draggable: true
                    }).addTo(map);

                    // Add Geocoder Search
                    L.Control.geocoder({
                        defaultMarkGeocode: false
                    }).on('markgeocode', function(e) {
                        let latlng = e.geocode.center;
                        map.setView(latlng, 15); // Zoom to selected location
                        marker.setLatLng(latlng);
                        locationInput.value = latlng.lat + ", " + latlng.lng;
                    }).addTo(map);

                    // Drag event to update location
                    marker.on("dragend", function(e) {
                        let latlng = marker.getLatLng();
                        locationInput.value = latlng.lat + ", " + latlng.lng;
                    });

                    // Click event to move marker
                    map.on("click", function(e) {
                        marker.setLatLng(e.latlng);
                        locationInput.value = e.latlng.lat + ", " + e.latlng.lng;
                    });
                }
            });

            document.getElementById("closeMapModal").addEventListener("click", function() {
                document.getElementById("mapModal").classList.add("hidden");
            });

            document.getElementById("closeMapModalFooter").addEventListener("click", function() {
                document.getElementById("mapModal").classList.add("hidden");
            });

            const citySearchInput = document.getElementById("citySearch");
            const cityDropdown = document.getElementById("city");
            const cityResults = document.getElementById("cityResults");

            function fetchCities(searchValue = "") {
                fetch(`/subscription/search-bandar?query=${searchValue}`)
                    .then(response => response.json())
                    .then(data => {
                        cityResults.innerHTML = "";
                        Object.keys(data).forEach(key => {
                            const listItem = document.createElement("li");
                            listItem.textContent = data[key];
                            listItem.classList.add("p-2", "cursor-pointer", "hover:bg-gray-200");
                            listItem.dataset.value = key;

                            listItem.addEventListener("click", function() {
                                citySearchInput.value = data[key];
                                cityDropdown.value = key;
                                cityResults.classList.add("hidden");
                            });

                            cityResults.appendChild(listItem);
                        });

                        if (Object.keys(data).length > 0) {
                            cityResults.classList.remove("hidden");
                        } else {
                            cityResults.classList.add("hidden");
                        }
                    })
                    .catch(error => console.error("Error fetching bandar:", error));
            }

            citySearchInput.addEventListener("focus", function() {
                fetchCities();
            });

            citySearchInput.addEventListener("input", function() {
                const searchValue = this.value.trim();
                fetchCities(searchValue);
            });

            document.addEventListener("click", function(event) {
                if (!citySearchInput.contains(event.target) && !cityResults.contains(event.target)) {
                    cityResults.classList.add("hidden");
                }
            });


        });
    </script>
@endsection
