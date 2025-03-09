@extends('layouts.loginLayout')

@section('content')
    <!-- Logo -->
    <div class="flex justify-center">
        <img src="{{ asset('subscription/assets/icons/fin_logo.svg') }}" alt="MAIS Logo" class="w-32 h-32" />
    </div>
    <!-- Title -->
    <h1 class="text-center text-3xl !font-normal text-[#2624D0] mt-2 font-mont">SISTEM MAIS</h1>


    <div class="max-w-md mx-auto space-y-6">
        <!-- Header -->
        <h1 class="text-[#2624D0] text-2xl !font-extrabold text-center mt-4">
            SEMAK PENDAFTARAN
        </h1>

        <!-- Subtitle -->
        <div class="text-center space-y-1">
            <h2 class="text-black text-lg">Cari / Pilih Institusi Anda</h2>
            <p class="text-black font-normal">Carian Manual</p>
        </div>

        <form action="{{ route('instituteCheck') }}" method="POST" class="space-y-8 p-4 lg:p-0">
            @csrf
            <x-alert />

            <!-- Search Input -->
            <div class="relative">
                <input type="text" id="searchInstitute" placeholder="Nama Institusi"
                    class="w-full h-[3.5rem] py-3 px-4  !rounded-full pr-10 shadow-lg bg-white" autocomplete="off">
                <span class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-500">
                    <i class="fe fe-search"></i>
                </span>

                <!-- Search Results Dropdown -->
                <div id="searchResults"
                    class="absolute w-full bg-white border border-gray-300 rounded-lg mt-1 hidden max-h-60 overflow-y-auto shadow-lg z-10">
                </div>
            </div>
            <!-- Info Message -->
            <p class="mt-2 text-md  text-gray-800 text-center">
                <span class="fe fe-info"></span>
                Jika institusi anda tiada di dalam senarai, sila hubungi Pihak MaIS
            </p>

            <!-- Hidden Inputs -->
            <input type="hidden" id="institute_name" name="institute_name">
            <input type="hidden" id="institute_refno" name="institute_refno">

            <!-- Or Section -->
            <p class="text-center text-black font-semibold text-sm">Atau Pilih Dari Senarai</p>

            <!-- Dropdowns -->
            <div class="space-y-4">
                <!-- City Input -->
                <div class="relative">
                    <input type="text" id="city" placeholder="Pilih Daerah"
                        class="w-full  h-[3.5rem]  py-3 px-4 !rounded-full pr-10 shadow-lg bg-white" autocomplete="off">
                    <span class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-500">
                        <i class="fe fe-chevron-down"></i>
                    </span>

                    <!-- City Results Dropdown -->
                    <div id="cityResults"
                        class="absolute w-full bg-white border border-gray-300 rounded-lg mt-1 hidden max-h-60 overflow-y-auto shadow-lg z-10">
                    </div>
                </div>

                <!-- Institute Input -->
                <div class="relative">
                    <input type="text" id="institute" placeholder="Pilih Institusi"
                        class="w-full  h-[3.5rem]  py-3 px-4 !rounded-full pr-10 shadow-lg bg-white" autocomplete="off">
                    <span class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-500">
                        <i class="fe fe-chevron-down"></i>
                    </span>

                    <!-- Institute Results Dropdown -->
                    <div id="institutionResults"
                        class="absolute w-full bg-white border border-gray-300 rounded-lg mt-1 hidden max-h-60 overflow-y-auto shadow-lg z-10">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button
                class="w-full bg-[#2624D0] text-white py-3 px-6 rounded-full hover:bg-blue-700 transition-colors text-lg font-medium mt-4 shadow-lg">
                Semak
            </button>
        </form>

        <div class="text-center !mt-4 !mb-4">
            <a href="{{ route('subscriptionLogin') }}" class="text-base text-blue-600 hover:underline">Kembali ke Halaman
                Utama</a>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInstituteInput = document.getElementById("searchInstitute");
            const searchResults = document.getElementById("searchResults");

            const cityInput = document.getElementById("city");
            const cityResults = document.getElementById("cityResults");

            const instituteInput = document.getElementById("institute");
            const instituteResults = document.getElementById("institutionResults");

            const instituteNameField = document.getElementById("institute_name");
            const instituteRefNoField = document.getElementById("institute_refno");

            let selectedCity = "";

            function createNoRecordItem() {
                const noRecordItem = document.createElement("div");
                noRecordItem.classList.add("p-2", "text-gray-500", "bg-gray-100", "cursor-not-allowed");
                noRecordItem.textContent = "Tiada Rekod";
                return noRecordItem;
            }

            // ✅ Search Institute (Trigger on Focus and Input)
            searchInstituteInput.addEventListener("focus", fetchAndShowInstitutes);
            searchInstituteInput.addEventListener("input", fetchAndShowInstitutes);

            function fetchAndShowInstitutes() {
                const query = searchInstituteInput.value.trim();

                if (query.length < 2) {
                    searchResults.innerHTML = "";
                    searchResults.classList.add("hidden");
                    return;
                }

                fetch(`search-institutes?institute_name=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        searchResults.innerHTML = "";
                        if (Object.keys(data).length === 0) {
                            searchResults.appendChild(createNoRecordItem());
                            searchResults.classList.remove("hidden");
                            return;
                        }

                        Object.entries(data).forEach(([uid, name]) => {
                            const item = document.createElement("div");
                            item.classList.add("p-2", "hover:bg-gray-200", "cursor-pointer",
                                "text-gray-800");
                            item.textContent = name;
                            item.dataset.uid = uid;

                            item.addEventListener("click", function() {
                                searchInstituteInput.value = name;
                                instituteNameField.value = name;
                                instituteRefNoField.value = uid;
                                searchResults.innerHTML = "";
                                searchResults.classList.add("hidden");
                            });

                            searchResults.appendChild(item);
                        });

                        searchResults.classList.remove("hidden");
                    })
                    .catch(error => console.error("Error fetching data:", error));
            }

            // ✅ Fetch Cities (Trigger on Focus and Input)
            cityInput.addEventListener("focus", fetchAndShowCities);
            cityInput.addEventListener("input", fetchAndShowCities);

            function fetchAndShowCities() {
                const query = cityInput.value.trim();

                fetch(`get-cities`)
                    .then(response => response.json())
                    .then(data => {
                        cityResults.innerHTML = "";
                        if (data.length === 0) {
                            cityResults.appendChild(createNoRecordItem());
                            cityResults.classList.remove("hidden");
                            return;
                        }

                        data.forEach(city => {
                            if (query === "" || city.toLowerCase().includes(query.toLowerCase())) {
                                const item = document.createElement("div");
                                item.classList.add("p-2", "hover:bg-gray-200", "cursor-pointer",
                                    "text-gray-800");
                                item.textContent = city;

                                item.addEventListener("click", function() {
                                    cityInput.value = city;
                                    selectedCity = city;
                                    cityResults.innerHTML = "";
                                    cityResults.classList.add("hidden");
                                    fetchAndShowInstitutesByCity();
                                });

                                cityResults.appendChild(item);
                            }
                        });

                        cityResults.classList.remove("hidden");
                    })
                    .catch(error => console.error("Error fetching cities:", error));
            }

            // ✅ Fetch Institutes Based on City and Search Query (Trigger on Focus and Input)
            instituteInput.addEventListener("focus", fetchAndShowInstitutesByCity);
            instituteInput.addEventListener("input", fetchAndShowInstitutesByCity);

            function fetchAndShowInstitutesByCity() {
                if (!selectedCity) return;

                const query = instituteInput.value.trim();

                fetch(`get-institutes?city=${selectedCity}&search=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        instituteResults.innerHTML = "";
                        if (Object.keys(data).length === 0) {
                            instituteResults.appendChild(createNoRecordItem());
                            instituteResults.classList.remove("hidden");
                            return;
                        }

                        Object.entries(data).forEach(([uid, name]) => {
                            const item = document.createElement("div");
                            item.classList.add("p-2", "hover:bg-gray-200", "cursor-pointer",
                                "text-gray-800");
                            item.textContent = name;
                            item.dataset.uid = uid;

                            item.addEventListener("click", function() {
                                instituteInput.value = name;
                                instituteNameField.value = name;
                                instituteRefNoField.value = uid;
                                instituteResults.innerHTML = "";
                                instituteResults.classList.add("hidden");
                            });

                            instituteResults.appendChild(item);
                        });

                        instituteResults.classList.remove("hidden");
                    })
                    .catch(error => console.error("Error fetching institutes:", error));
            }

            // ✅ Close dropdowns when clicking outside
            document.addEventListener("click", function(event) {
                if (!searchInstituteInput.contains(event.target) && !searchResults.contains(event.target)) {
                    searchResults.classList.add("hidden");
                }
                if (!cityInput.contains(event.target) && !cityResults.contains(event.target)) {
                    cityResults.classList.add("hidden");
                }
                if (!instituteInput.contains(event.target) && !instituteResults.contains(event.target)) {
                    instituteResults.classList.add("hidden");
                }
            });
        });
    </script>
@endsection
