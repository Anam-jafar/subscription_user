@extends('layouts.adminLayout')

@section('content')
    <div class="">
        <div class="container-fluid">


            <div class="py-8 px-4 rounded-lg shadow bg-white">
                <x-page-header :title="'Senarai Laporan Kewangan Institusi'" :breadcrumbs="[
                    ['label' => 'Laporan Kewangan', 'url' => 'javascript:void(0);'],
                    ['label' => 'Senarai Penyata'],
                ]" />
                <x-alert />

                <x-filter-card :filters="[
                    ['name' => 'fin_year', 'label' => 'Tahun Penyata', 'type' => 'select', 'options' => $years],
                    [
                        'name' => 'fin_category',
                        'label' => 'Kategori Penyata',
                        'type' => 'select',
                        'options' => $parameters['statements'],
                    ],
                ]" />


                <x-table :headers="['Tarikh Hantar', 'Tahun Penyata', 'Kategori Penyata', 'Status']" :columns="['submission_date', 'fin_year', 'CATEGORY', 'status']" :rows="$financialStatements" route="editStatement" secondaryRoute=""
                    docIcon="true" />

                <x-pagination :items="$financialStatements" label="Penyata Kewangan" />
            </div>

        </div>
    </div>
@endsection
