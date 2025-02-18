@extends('layouts.loginLayout')

@section('content')
    <!-- Logo -->
    <div class="flex justify-center">
        <img src="{{ asset('assets/icons/fin_logo.svg') }}" alt="MAIS Logo" class="w-24 h-24" />
    </div>
    <!-- Title -->
    <h1 class="text-center text-2xl font-semibold text-blue-600">SEMAK INSTITUSI</h1>
    <div>
        @if (session('error'))
            <div class="alert alert-danger rounded-md p-4 mb-4" style="background-color: #fee2e2; color: #dc2626;">
                <div class="flex items-center">
                    <svg class="h-6 w-6 text-red-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M7 13h.01M4 4l16 16" />
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success rounded-md p-4 mb-4"
                style="background-color:rgb(241, 255, 239); color:rgb(38, 220, 53);">
                <div class="flex items-center">
                    <svg class="h-6 w-6 text-green-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4M7 13h.01M4 4l16 16" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

    </div>

    <div class="flex justify-center items-center">
        <form class="flex flex-col gap-6 md:w-1/2" action="{{ route('forgetPassword') }}" method="POST">
            @csrf
            <!-- Nama Institusi Field -->
            <div class="flex flex-col md:flex-row md:items-center gap-4">
                <label for="email" class="text-gray-800 font-medium md:w-40">Emel</label>
                <div class="flex-1 relative flex items-center">
                    <input type="email" id="email" name="email"
                        class="w-full p-2 h-[3rem] border border-[#6E829F] rounded-lg text-gray-600 bg-white"
                        placeholder="Enter Email" aria-label="Enter Email">
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-center gap-8">
                <button type="button" onclick="window.location='{{ route('login') }}'"
                    class="w-[12rem] h-[2.5rem] py-2 bg-gray-700 font-semibold text-white rounded-sm hover:bg-gray-800 transition-colors">
                    Kembali
                </button>

                <button type="submit"
                    class="w-[12rem] h-[2.5rem] py-2 bg-blue-600 font-semibold text-white rounded-sm hover:bg-blue-700 transition-colors">
                    Hantar
                </button>
            </div>
        </form>
    </div>



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
