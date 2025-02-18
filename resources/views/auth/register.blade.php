@extends('layouts.loginLayout')

@section('content')
    <!-- Logo -->
    <div class="flex justify-center">
        <img src="{{ asset('assets/icons/fin_logo.svg') }}" alt="MAIS Logo" class="w-24 h-24" />
    </div>
    <!-- Title -->
    <h1 class="text-center text-2xl font-semibold text-blue-600">SEMAK INSTITUSI</h1>

    <x-alert />


    <!-- Your existing HTML structure remains the same until the form -->
    <form class="grid md:grid-cols-2 gap-6" action="{{ route('showInstituteProfileRegistrationDetailsForm') }}" method="GET">
        <div class="flex flex-col md:flex-row items-start space-y-2 md:space-y-0">
            <label class="block text-gray-900 font-medium md:w-40 mb-2">Institusi</label>
            <select name="institute" id="institute"
                class="w-full md:w-2/3 p-2 h-[3rem] border !border-[#6E829F] rounded-lg text-gray-600 bg-white pr-8">
                <option value="">Pilih Institusi</option>
                @foreach ($commonData['institutes'] as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex flex-col md:flex-row items-start space-y-2 md:space-y-0">
            <label class="block text-gray-800 font-medium md:w-40 mb-2">Jenis Institusi</label>
            <select name="institute_type" id="institute_type" disabled
                class="w-full md:w-2/3 p-2 h-[3rem] border !border-[#6E829F] rounded-lg text-gray-600 bg-white pr-8">
                <option value="">Pilih Jenis Institusi</option>
            </select>
        </div>

        <div class="flex flex-col md:flex-row items-start space-y-2 md:space-y-0">
            <label class="block text-gray-800 font-medium md:w-40 mb-2">Daerah</label>
            <select name="district" id="district"
                class="w-full md:w-2/3 p-2 h-[3rem] border !border-[#6E829F] rounded-lg text-gray-600 bg-white pr-8">
                <option value="">Pilih Daerah</option>
                @foreach ($commonData['districts'] as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex flex-col md:flex-row items-start space-y-2 md:space-y-0">
            <label class="block text-gray-800 font-medium md:w-40 mb-2">Mukim</label>
            <select name="sub_district" id="sub_district" disabled
                class="w-full md:w-2/3 p-2 h-[3rem] border !border-[#6E829F] rounded-lg text-gray-600 bg-white pr-8">
                <option value="">Pilih Mukim</option>
            </select>
        </div>

        <div class="flex flex-col md:flex-row items-start space-y-2 md:space-y-0">
            <label class="block text-gray-800 font-medium md:w-40 mb-2">Nama Institusi</label>
            <div class="w-full md:w-2/3 relative">
                <input type="text" id="institute_search"
                    class="w-full p-2 h-[3rem] border !border-[#6E829F] rounded-lg text-gray-600 bg-white"
                    placeholder="Cari Nama Institusi">
                <select name="instrefno" id="inst_refno" class="hidden">
                    <option value="">Pilih Nama Institusi</option>
                </select>
                <div id="search_results"
                    class="absolute w-full mt-1 bg-white border !border-[#6E829F] rounded-lg shadow-lg hidden">
                </div>
            </div>
        </div>
        <input type="hidden" name="inst_refno" id="refno_institute" value="">



        <!-- Buttons -->
        <div class="md:col-span-2 flex justify-center gap-8">
            <button type="button" onclick="window.location='{{ route('login') }}'"
                class="w-[12rem] !h-[2.5rem] py-2 bg-gray-700 font-semibold text-white rounded-sm hover:bg-gray-800 transition-colors">
                Kembali
            </button>

            <button type="submit"
                class="w-[12rem] !h-[2.5rem] py-2 bg-blue-600 font-semibold text-white rounded-sm hover:bg-blue-700 transition-colors">
                Seterusnya
            </button>
        </div>
    </form>

    <div class="text-center space-y-2 text-gray-600 text-xs">
        <p>Jika senarai Mukim dan senarai Nama Institusi tiada di dalam senarai, sila hubungi :</p>
        <p class="font-semibold">SEKTOR AUDIT DALAM DAN INTEGRITI</p>
        <p>Majlis Agama Islam Selangor</p>
        <p>Tingkat 5, Kompleks MAIS Klang, Lot 336, Jalan Meru Off Jalan Kapar,</p>
        <p>41050 Klang, Selangor Darul Ehsan</p>
        <p>T +603-3361 4000/4180 Email : auditkewm3@mais.gov.my</p>
    </div>

    <!-- Copyright -->
    <div class="flex justify-center items-center gap-2 text-sm text-gray-900">
        <img src="{{ asset('assets/icons/fin_logo_tiny.svg') }}" alt="Admin" class="w-18 h-18" />
        <p>Hakcipta terpelihara oleh Majlis Agama Islam Selangor (MAIS)</p>
    </div>
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {
            // Handle institute selection
            $('#institute').change(function() {
                const instituteCode = $(this).val();
                if (instituteCode) {
                    $.get(`get-institute-types/${instituteCode}`, function(data) {
                        $('#institute_type').prop('disabled', false).empty()
                            .append('<option value="">Pilih Jenis Institusi</option>');
                        $.each(data, function(code, name) {
                            $('#institute_type').append($('<option>', {
                                value: code,
                                text: name
                            }));
                        });
                    });
                } else {
                    $('#institute_type').prop('disabled', true).empty()
                        .append('<option value="">Pilih Jenis Institusi</option>');
                }
                //updateInstituteSearch();
            });

            // Handle district selection
            $('#district').change(function() {
                const districtCode = $(this).val();
                if (districtCode) {
                    $.get(`get-sub-districts/${districtCode}`, function(data) {
                        $('#sub_district').prop('disabled', false).empty()
                            .append('<option value="">Pilih Mukim</option>');
                        $.each(data, function(code, name) {
                            $('#sub_district').append($('<option>', {
                                value: code,
                                text: name
                            }));
                        });
                    });
                } else {
                    $('#sub_district').prop('disabled', true).empty()
                        .append('<option value="">Pilih Mukim</option>');
                }
                //updateInstituteSearch();
            });

            // Handle institute type and sub-district changes
            $('#institute_search').focus(function() {
                updateInstituteSearch();
            });


            let searchTimeout;
            $('#institute_search').on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(updateInstituteSearch, 300);
            });

            function updateInstituteSearch() {
                const searchTerm = $('#institute_search').val();
                const instituteType = $('#institute_type').val();
                const subDistrict = $('#sub_district').val();

                $.get('search-institutes/', {
                    search: searchTerm,
                    institute_type: instituteType,
                    sub_district: subDistrict
                }, function(data) {
                    const $results = $('#search_results');
                    $results.empty();

                    if (Object.keys(data).length > 0) {
                        $.each(data, function(refno, name) {
                            $results.append(
                                $('<div>', {
                                    class: 'p-2 hover:bg-gray-100 cursor-pointer',
                                    text: name,
                                    'data-refno': refno
                                })
                            );
                        });
                        $results.removeClass('hidden');
                    } else {
                        $results.addClass('hidden');
                    }
                });
            }

            // Handle search result selection
            $(document).on('click', '#search_results div', function() {
                const refno = $(this).data('refno');
                const name = $(this).text();

                console.log(refno)

                $('#institute_search').val(name);
                $('#inst_refno').val(refno);
                $('#search_results').addClass('hidden');
                $('#refno_institute').val(refno);
            });

            // Hide search results when clicking outside
            $(document).click(function(e) {
                if (!$(e.target).closest('.relative').length) {
                    $('#search_results').addClass('hidden');
                }
            });
        });
    </script>
@endsection
