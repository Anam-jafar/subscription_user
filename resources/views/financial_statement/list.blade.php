@extends('layouts.adminLayout')

@section('content')
  <div class="">
    <div class="container-fluid">

      <div class="rounded-lg bg-white px-8 py-8 shadow">
        <!-- Logo -->
        <div class="mt-4 flex justify-center">
          <img src="{{ asset('subscription/assets/icons/fin_logo.svg') }}" alt="MAIS Logo" class="h-24 w-24" />
        </div>
        <!-- Title -->
        <h1 class="mb-8 mt-2 text-center font-mont text-3xl !font-normal text-[#2624D0]">Senarai Laporan Kewangan
          Institusi</h1>

        <x-alert />

        <x-filter-card :filters="[
            [
                'name' => 'institute_type',
                'label' => $institutionHistory[$currentInstitute],
                'type' => 'select',
                'options' => $institutionHistory->except($currentInstitute),
            ],
            ['name' => 'fin_year', 'label' => 'Tahun Penyata', 'type' => 'select', 'options' => $years],
            [
                'name' => 'fin_category',
                'label' => 'Kategori Penyata',
                'type' => 'select',
                'options' => $parameters['statements'],
            ],
        ]" button-label="Hantar Baru" :button-route="route('createStatement', [
            'id' => Auth::user()->uid,
            'institute_type' => request('institute_type', $currentInstitute),
        ])" />

        <x-table :headers="['Tarikh Hantar', 'Tahun Penyata', 'Kategori Penyata', 'Status']" :columns="['SUBMISSION_DATE', 'fin_year', 'CATEGORY', 'FIN_STATUS']" :rows="$financialStatements" route="editStatement" secondaryRoute="viewStatement"
          docIcon="true" :currentInstitute="$currentInstitute" />

        <x-pagination :items="$financialStatements" label="Penyata Kewangan" />
      </div>

    </div>
  </div>
@endsection
