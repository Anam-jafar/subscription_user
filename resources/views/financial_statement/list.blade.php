@extends('layouts.adminLayout')

@section('content')
    <div class="">
        <div class="container-fluid">


            <div class="py-8 px-8 rounded-lg shadow bg-white">
                <!-- Logo -->
                <div class="flex justify-center mt-4">
                    <img src="{{ asset('subscription/assets/icons/fin_logo.svg') }}" alt="MAIS Logo" class="w-24 h-24" />
                </div>
                <!-- Title -->
                <h1 class="text-center text-3xl !font-normal text-[#2624D0] mt-2 mb-8 font-mont">Senarai Laporan Kewangan
                    Institusi</h1>


                <x-alert />


                <x-filter-card :filters="[
                    ['name' => 'fin_year', 'label' => 'Tahun Penyata', 'type' => 'select', 'options' => $years],
                    [
                        'name' => 'fin_category',
                        'label' => 'Kategori Penyata',
                        'type' => 'select',
                        'options' => $parameters['statements'],
                    ],
                ]" button-label="Hantar Baru" :button-route="route('createStatement', ['id' => Auth::user()->uid])" />


                <x-table :headers="['Tarikh Hantar', 'Tahun Penyata', 'Kategori Penyata', 'Status']" :columns="['SUBMISSION_DATE', 'fin_year', 'CATEGORY', 'FIN_STATUS']" :rows="$financialStatements" route="editStatement"
                    secondaryRoute="viewStatement" docIcon="true" />

                <x-pagination :items="$financialStatements" label="Penyata Kewangan" />
            </div>

        </div>
    </div>
@endsection
