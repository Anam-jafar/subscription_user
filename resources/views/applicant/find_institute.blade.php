@extends('layouts.loginLayout')

@section('content')
  <!-- Logo -->
  <div class="flex justify-center">
    <img src="{{ asset('subscription/assets/icons/fin_logo.svg') }}" alt="MAIS Logo" class="h-32 w-32" />
  </div>
  <!-- Title -->
  <h1 class="mt-2 text-center font-mont text-3xl !font-normal text-[#2624D0]">SISTEM PENGURUSAN MASJID</h1>

  <div class="mx-auto max-w-md space-y-6">
    <!-- Header -->
    <h1 class="mt-4 text-center text-2xl !font-extrabold text-[#2624D0]">
      SEMAK PENDAFTARAN
    </h1>
    <!-- Info Message -->
    <!-- Clickable Text -->
    <p class="text-md !mb-4 mt-2 cursor-pointer text-center font-semibold text-blue-800 hover:text-blue-600"
      onclick="document.getElementById('successModal').style.display='flex'">
      <span class="fe fe-info text-blue-600"></span>
      Jika institusi anda tiada di dalam senarai, sila hubungi Pihak MAIS
    </p>

    <!-- Modal -->
    <div id="successModal" class="fixed inset-0 z-50 !mt-0 flex items-center justify-center bg-gray-900 bg-opacity-40"
      style="display: none;">
      <div class="relative w-full max-w-3xl rounded-xl bg-white p-6 text-center shadow-lg">
        <button onclick="document.getElementById('successModal').style.display='none'"
          class="absolute right-4 top-2 p-3 text-3xl text-gray-500 hover:text-gray-700">
          &times;
        </button>

        <h2 class="mb-2 text-start text-lg font-semibold text-green-600">
          Hubungi kami di
        </h2>
        <hr>
        <div class="p-4 text-start leading-relaxed text-gray-700">
          <p><strong>Sektor Audit Dalam dan Integriti (MAIS)</strong></p>
          <p>Tingkat 5, Kompleks MAIS Klang</p>
          <p>Lot 336, Jalan Meru Off Jalan Kapar</p>
          <p>41050 Klang, Selangor Darul Ehsan</p>
          <p><strong>Telefon:</strong> +603-3361 4000 / 4180</p>
          <p><strong>Email:</strong> <a href="mailto:auditkewms@mais.gov.my"
              class="text-blue-600 hover:underline">auditkewms@mais.gov.my</a></p>
        </div>
      </div>
    </div>

    <!-- Subtitle -->
    <div class="space-y-1 text-center">
      <h2 class="text-lg text-black">Cari / Pilih Institusi Anda</h2>
      <p class="font-normal text-black">Carian Kata Kunci</p>
    </div>

    <form action="{{ route('instituteCheck') }}" method="POST" class="space-y-8 p-4 lg:p-0">
      @csrf
      <x-alert />

      <!-- Search Input -->
      <div class="relative">
        <input type="text" id="searchInstitute" placeholder="Nama Institusi"
          class="h-[3.5rem] w-full !rounded-full bg-white px-4 py-3 pr-10 shadow-lg" autocomplete="off">
        <span class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-500">
          <i class="fe fe-search"></i>
        </span>

        <!-- Search Results Dropdown -->
        <div id="searchResults"
          class="absolute z-10 mt-1 hidden max-h-60 w-full overflow-y-auto rounded-lg border border-gray-300 bg-white shadow-lg">
        </div>
      </div>

      <!-- Hidden Inputs -->
      <input type="hidden" id="institute_name" name="institute_name">
      <input type="hidden" id="institute_refno" name="institute_refno">

      <!-- Or Section -->
      <p class="text-center text-sm font-semibold text-black">Atau Pilih Dari Senarai</p>

      <!-- Dropdowns -->
      <div class="space-y-4">
        <!-- City Input -->
        <div class="relative">
          <input type="text" id="city" placeholder="Pilih Daerah"
            class="h-[3.5rem] w-full !rounded-full bg-white px-4 py-3 pr-10 shadow-lg" autocomplete="off">
          <span class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-500">
            <i class="fe fe-chevron-down"></i>
          </span>

          <!-- City Results Dropdown -->
          <div id="cityResults"
            class="absolute z-10 mt-1 hidden max-h-60 w-full overflow-y-auto rounded-lg border border-gray-300 bg-white shadow-lg">
          </div>
        </div>

        <!-- Institute Input -->
        <div class="relative">
          <input type="text" id="institute" placeholder="Pilih Institusi"
            class="h-[3.5rem] w-full !rounded-full bg-white px-4 py-3 pr-10 shadow-lg" autocomplete="off">
          <span class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-500">
            <i class="fe fe-chevron-down"></i>
          </span>

          <!-- Institute Results Dropdown -->
          <div id="institutionResults"
            class="absolute z-10 mt-1 hidden max-h-60 w-full overflow-y-auto rounded-lg border border-gray-300 bg-white shadow-lg">
          </div>
        </div>
      </div>

      <!-- Submit Button -->
      <button id="submitButton"
        class="mt-4 w-full rounded-full bg-indigo-600 px-6 py-3 text-lg font-medium text-white shadow-lg transition-colors hover:bg-indigo-700 disabled:cursor-not-allowed disabled:opacity-50"
        disabled>
        Semak
      </button>

    </form>

    <div class="!mb-4 !mt-4 text-center">
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

      const submitButton = document.getElementById("submitButton");


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

            Object.entries(data).forEach(([uid, {
              name,
              rem8
            }]) => {
              const item = document.createElement("div");
              item.classList.add("p-2", "hover:bg-gray-200", "cursor-pointer", "text-gray-800");
              item.textContent = `${name} (${rem8})`; // ✅ Show name with rem8 in brackets
              item.dataset.uid = uid;

              item.addEventListener("click", function() {
                searchInstituteInput.value = name;
                instituteNameField.value = name;
                instituteRefNoField.value = uid;
                searchResults.innerHTML = "";
                searchResults.classList.add("hidden");
                instituteInput.value = "";
                cityInput.value = "";
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
            if (Object.keys(data).length === 0) {
              cityResults.appendChild(createNoRecordItem());
              cityResults.classList.remove("hidden");
              return;
            }

            Object.entries(data).forEach(([code,
              prm
            ]) => { // 🔹 Using prm for display, code as value
              if (query === "" || prm.toLowerCase().includes(query.toLowerCase())) {
                const item = document.createElement("div");
                item.classList.add("p-2", "hover:bg-gray-200", "cursor-pointer",
                  "text-gray-800");
                item.textContent = prm;
                item.dataset.code = code; // 🔹 Store the code value

                item.addEventListener("click", function() {
                  cityInput.value = prm; // Display prm
                  selectedCity = code; // Store code for API request
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

        fetch(`get-institutes?city=${selectedCity}&search=${query}`) // 🔹 Use selectedCity (code)
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
                searchInstituteInput.value = "";
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

      function toggleButtonState() {
        const searchValue = searchInstituteInput.value.trim();
        const instituteValue = instituteInput.value.trim();

        if (searchValue || instituteValue) {
          submitButton.disabled = false;
        } else {
          submitButton.disabled = true;
        }
      }

      // Initial check
      toggleButtonState();

      // Listen to input changes
      searchInstituteInput.addEventListener("input", toggleButtonState);
      instituteInput.addEventListener("input", toggleButtonState);
    });
  </script>
@endsection
