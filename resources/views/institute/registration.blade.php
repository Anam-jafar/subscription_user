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
        <div id="successModal" class="fixed inset-0 z-50 !mt-0 flex items-center justify-center bg-gray-900 bg-opacity-40">
          <div class="relative w-full max-w-3xl rounded-xl bg-white p-6 text-center shadow-lg">
            <button onclick="document.getElementById('successModal').style.display='none'"
              class="absolute right-4 top-2 p-3 text-3xl text-gray-500 hover:text-gray-700">
              &times;
            </button>

            <h2 class="mb-2 text-start text-lg font-semibold text-green-600">
              Permohonan Pendaftaran Berjaya Dihantar!
            </h2>
            <hr>

            <p class="mb-8 mt-4 text-xs text-black">
              Terima kasih kerana mendaftar dengan kami.
              Pihak kami sedang menyemak permohonan. Sila semak emel anda dalam masa tiga (03) hari bekerja
              untuk status kelulusan.
            </p>
            <hr>

            <div class="flex justify-end">
              <button onclick="window.location.href='{{ route('subscriptionLogin') }}'" type="button"
                class="mt-2 rounded-lg bg-gray-500 px-6 py-2 text-white hover:bg-gray-600">
                Tutup
              </button>
            </div>
          </div>
        </div>
      @endif

      <!-- Start::row-1 -->
      <div class="grid grid-cols-12 gap-x-6">
        <div class="col-span-12 xl:col-span-12">
          <div class="box">
            <!-- Logo -->
            <div class="mt-4 flex justify-center">
              <img src="{{ asset('subscription/assets/icons/fin_logo.svg') }}" alt="MAIS Logo" class="h-24 w-24" />
            </div>
            <!-- Title -->
            <h1 class="mt-2 text-center font-mont text-3xl !font-normal text-[#2624D0]">PENDAFTARAN PROFIL
              MASJID</h1>
            <div class="md:px-6">
              <x-alert />
            </div>
            <div class="box-body !p-0">
              <form class="wizard wizard-tab horizontal" method="POST"
                action="{{ route('instituteRegistration', ['id' => $institute->id]) }}">
                @csrf
                <aside class="wizard-content container">
                  <div class="wizard-step" data-title="Maklumat Institusi" data-id="2e8WqSV3slGIpTbnjcJzmDwBQaHrfh0Z">
                    <div class="justify-content-center grid grid-cols-12 sm:gap-x-6">
                      <div class="col-span-12 xl:col-span-12">
                        <div class="register-page">
                          <div class="gap-y-4">
                            <x-required-warning-text />

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                              <div class="grid grid-cols-2 gap-4">
                                <x-input-field level="Institusi" id="institusi" name="" type="text"
                                  placeholder="Institusi" value="{{ $institute->Type->prm }}" disabled="true" />

                                <x-input-field level="Jenis Institusi" id="institusi" name="" type="text"
                                  placeholder="Institusi" value="{{ $institute->Category->prm }}" disabled="true" />
                              </div>
                              <x-input-field level="Nama Institusi" id="institusi" name="name" type="text"
                                placeholder="Institusi" value="{{ $institute->name }}" disabled="true" />
                            </div>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                              <x-input-field level="Emel" id="poskod" spanText="Rasmi" name="mel" type="email"
                                placeholder="masjid@gmail.com" :required='true' value="{{ $institute->mel }}" />
                              <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <x-input-field level="Nombor Telefon" id="poskod" spanText="Rasmi" name="hp"
                                  type="number" placeholder="012345678901" :required='true'
                                  value="{{ $institute->hp }}" />
                                <x-input-field level="Nombor Fax" id="poskod" name="fax" type="number"
                                  placeholder="031234567" value="{{ $institute->fax }}" />

                              </div>
                            </div>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                              <x-input-field level="Tarikh Kelulusan Jawatankuasa (JATUMS)" id="institusi" name="rem15"
                                type="date" placeholder="" :required='true' value="{{ $institute->rem15 }}" />
                              <x-input-field level="Website" id="social" name="web" type="text" placeholder=""
                                value="{{ $institute->web }}" />
                            </div>

                            <div class="mt-8 flex flex-col justify-between space-y-3 md:flex-row md:space-y-0">
                              <a href="{{ route('subscriptionLogin') }}"
                                class="text-md flex items-center font-bold text-blue-500 no-underline hover:cursor-pointer hover:text-blue-700">
                                <span class="fe fe-arrow-left-circle text-md mr-2 font-bold"></span>
                                Kembali
                              </a>

                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="wizard-step" data-title="Maklumat Tambahan" data-id="2e8WqSV3slGIpTbnjcJzmDwBQaHrfjHQ">
                    <div class="justify-content-center grid grid-cols-12 sm:gap-x-6">
                      <div class="col-span-12 xl:col-span-12">
                        <div class="register-page">
                          {{-- <h6 class="mb-3 font-medium">Registration :</h6> --}}
                          <div class="gap-y-4">

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                              <x-input-field level="Dun" id="institusi" name="rem11" type="text"
                                placeholder="" value="{{ $institute->rem11 }}" />
                              <x-input-field level="Parlimen" id="institusi" name="rem12" type="text"
                                placeholder="" value="{{ $institute->rem12 }}" />
                            </div>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                              <div class="grid grid-cols-2 gap-4">
                                <x-input-field level="Keluasan Institusi" id="institusi" name="rem13" type="number"
                                  placeholder="1000 sqt" value="{{ $institute->rem13 }}" />
                                <x-input-field level="Kapasiti Jemaah" id="institusi" name="rem14" type="number"
                                  placeholder="1000" value="{{ $institute->rem14 }}" />
                              </div>
                              <x-input-field level="Media Sosial" id="social" name="rem10" type="text"
                                placeholder="" value="{{ $institute->rem10 }}" />
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="wizard-step" data-title="Alamat Institusi" data-id="H53WJiv9blN17MYTztq4g8U6eSVkaZDx">
                    <div class="justify-content-center grid grid-cols-12 sm:gap-x-6">
                      <div class="col-span-12 xl:col-span-12">
                        <div class="register-page">
                          <div class="gap-y-4">
                            <x-required-warning-text />

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                              <x-input-field level="Alamat (Baris 1)" id="institusi" name="addr" type="text"
                                placeholder="" :required='true' value="{{ $institute->addr }}" />
                              <x-input-field level="Alamat (Baris 2)" id="institusi" name="addr1" type="text"
                                placeholder="" value="{{ $institute->addr1 }}" />
                            </div>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                              <div class="grid grid-cols-2 gap-4">
                                <div class="mt-4 flex flex-col">
                                  <label for="citySearch" class="mb-2 font-normal text-gray-800">
                                    Bandar
                                  </label>

                                  <div class="relative">
                                    <!-- Search Input -->
                                    <input type="text" id="citySearch" autocomplete="off"
                                      placeholder="Cari Bandar..."
                                      class="h-[3rem] w-full rounded-lg border !border-[#6E829F] p-2 !text-gray-800"
                                      value="{{ $parameters['cities'][$institute->city] ?? '' }}">

                                    <!-- Hidden Select (To store actual value for form submission) -->
                                    <select id="city" name="city" class="hidden">
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
                                      class="absolute z-10 mt-1 hidden max-h-48 w-full overflow-auto rounded-lg border border-gray-300 bg-white">
                                    </ul>
                                  </div>
                                </div>

                                <x-input-field level="Mukim" id="institusi" name="rem9" type="text"
                                  placeholder="Institusi" value="{{ $institute->Subdistrict->prm }}"
                                  disabled="true" />
                              </div>
                              <div class="grid grid-cols-2 gap-4">
                                <x-input-field level="Daerah" id="negeri" name="rem8" type="text"
                                  placeholder="Enter negeri" value="{{ $institute->District->prm }}"
                                  disabled="true" />
                                <x-input-field level="Negeri" id="negeri" name="state" type="text"
                                  placeholder="Enter negeri" value="{{ $institute->State->prm }}" disabled="true" />
                              </div>
                            </div>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                              <x-input-field level="Poskod" id="poskod" name="pcode" type="number"
                                placeholder="" :required='true' value="{{ $institute->pcode }}" />

                              <div class="mt-4 flex flex-col">
                                <label for="location" class="mb-2 font-normal text-gray-800">
                                  Koordinat Institusi <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                  <!-- Input Field -->
                                  <input type="text" id="location" name="location"
                                    class="h-[3rem] w-full rounded-lg border !border-[#6E829F] p-2 pr-12 !text-gray-800"
                                    placeholder="Pilih lokasi" required value="{{ $institute->location }}">

                                  <!-- Location Icon (Fixed Alignment) -->
                                  <span id="openMapModal"
                                    class="absolute right-3 top-1/2 flex -translate-y-1/2 transform cursor-pointer items-center text-gray-600">
                                    <i class="fe fe-map-pin text-xl"></i>
                                  </span>
                                </div>
                              </div>

                              <!-- Location Picker Modal -->
                              <div id="mapModal"
                                class="fixed inset-0 z-[9999] flex hidden items-center justify-center bg-gray-900 bg-opacity-50">
                                <div class="relative w-full max-w-3xl rounded-lg bg-white p-4 shadow-lg">
                                  <!-- Close Button (Cross Icon) -->
                                  <button id="closeMapModal" type="button"
                                    class="absolute right-3 top-3 text-xl font-bold text-gray-500 hover:text-gray-700">
                                    &times;
                                  </button>

                                  <h2 class="text-lg font-semibold">Pilih Lokasi
                                  </h2>
                                  <span class="text-normal text-gray-500">Sila
                                    masukkan
                                    nama
                                    jalan dan tekan cari</span>
                                  <div id="map" class="h-[400px] w-full rounded-md"></div>
                                  <div class="mt-4 flex justify-end">
                                    <button id="closeMapModalFooter" type="button"
                                      class="rounded-md bg-gray-500 px-4 py-2 text-white hover:bg-gray-600">
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
                  <div class="wizard-step active" data-title="Pegawai/Wakil Institusi"
                    data-id="2e8WqSV3slGIpTbnjcJzmDwBQaHrfh0Z">
                    <div class="justify-content-center grid grid-cols-12 sm:gap-x-6">
                      <div class="col-span-12 xl:col-span-12">
                        <div class="register-page">
                          <div class="gap-y-4">
                            <x-required-warning-text />

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                              <x-input-field level="Nama Pegawai/Wakil Institusi" id="institusi" name="con1"
                                type="text" placeholder="" :required='true' value="{{ $institute->con1 }}" />
                              <x-input-field level="No. Kad Pengenalan" id="institusi" name="ic" type="number"
                                placeholder="" :required='true' value="{{ $institute->ic }}" />
                            </div>
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                              <x-input-field level="Jawatan" id="institusi" name="pos1" type="select"
                                placeholder="pilih" :valueList="$parameters['user_positions']" :required='true'
                                value="{{ $institute->pos1 }}" />
                              <x-input-field level="Nombor Telefon" id="institusi" name="tel1" type="number"
                                placeholder="" :required='true' value="{{ $institute->tel1 }}" />
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="wizard-step" data-title="Pengesahan" data-id="dOM0iRAyJXsLTr9b3KZfQ2jNv4pgn6Gu"
                    data-limit="3">
                    <div class="grid grid-cols-12 sm:gap-x-6">
                      <div class="col-span-12 xl:col-span-12">
                        <div class="checkout-payment-success">
                          <div class="mb-4">
                            {{-- <h5 class="text-success font-medium">Appointment Booked...</h5> --}}
                          </div>
                          {{-- <div class="mb-4">
                                                        <img src="{{ asset('subscription/assets/icons/fin_logo.svg') }}"
                                                            alt="" class="img-fluid !inline-flex">
                                                    </div> --}}
                          <label class="mt-8 flex items-center">
                            <input type="checkbox" id="myCheckbox"
                              class="rounded-xs mr-5 h-3 w-3 border-2 border-black outline outline-1 outline-black focus:outline-4">
                            <span class="text-[0.875rem] font-bold text-red-500 sm:text-left">Saya
                              Bersetuju
                              Dengan Terma
                              Dan Syarat Di Bawah</span>
                          </label>

                          <p class="mb-4 mt-4 pl-8 text-left text-[0.875rem] font-semibold">
                            SEGALA MAKLUMAT DAN LAMPIRAN YANG DIBERIKAN ADALAH BENAR DAN SAYA
                            BERTANGGUNGJAWAB DI ATAS MAKLUMAT YANG
                            DIBERIKAN INI. JIKA TERDAPAT MAKLUMAT PALSU YANG DIBERIKAN OLEH
                            SAYA, PIHAK MAJLIS AGAMA ISLAM SELANGOR
                            (MAIS) BERHAK MENGAMBIL TINDAKAN UNDANG-UNDANG KE ATAS DIRI SAYA.
                          </p>

                          <div class="mt-8 flex flex-col justify-between space-y-3 md:flex-row md:space-y-0">
                            <!-- Back button -->
                            <a href="{{ route('subscriptionLogin') }}"
                              class="text-md mb-4 flex items-center font-bold text-blue-500 no-underline hover:cursor-pointer hover:text-blue-700 md:mb-0">
                              <span class="fe fe-arrow-left-circle text-md mr-2 font-bold"></span>
                              Kembali
                            </a>

                            <!-- Action buttons container -->
                            <div class="flex flex-col space-y-2 md:flex-row md:space-x-2 md:space-y-0">
                              <button
                                class="flex w-full cursor-not-allowed items-center justify-center rounded-full bg-blue-600 px-4 py-2 text-sm font-medium text-white opacity-50 transition-colors hover:bg-blue-700 md:w-40"
                                type="submit" id="submit">
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
      const submitButton = document.getElementById('submit');

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
