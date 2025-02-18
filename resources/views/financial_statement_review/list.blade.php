@extends('layouts.adminLayout')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Senarai Laporan Kewangan Institusi'" :breadcrumbs="[
                ['label' => 'Laporan Kewangan', 'url' => 'javascript:void(0);'],
                ['label' => 'Senarai Penyata'],
            ]" />
            <div class="py-8 px-4 rounded-lg shadow bg-white">
                <x-alert />

                <x-filter-card :filters="[
                    ['name' => 'fin_year', 'label' => 'Tahun Penyata', 'type' => 'select', 'options' => $years],
                    [
                        'name' => 'fin_category',
                        'label' => 'Kategori Penyata',
                        'type' => 'select',
                        'options' => $statements,
                    ],
                    ['name' => 'search', 'label' => 'Search by Name', 'type' => 'text', 'placeholder' => 'Carian...'],
                ]" />


                <x-table :headers="[
                    'Tahun Penyata',
                    'Kategori Penyata',
                    'Tarikh Hantar',
                    'Nama Institusi',
                    'Nama Pengawai',
                    'Status Penerimaan',
                    'Status Semakan',
                ]" :columns="[
                    'fin_year',
                    'fin_category',
                    'submission_date',
                    'institute_name',
                    'in_charge',
                    'submission_status_',
                    'audit_status',
                ]" :rows="$financialStatements" route="financialStatementReview"
                    secondaryRoute="financialStatementEdit" docIcon="true" />

                <x-pagination :items="$financialStatements" label="Penyata Kewangan" />
            </div>

        </div>
    </div>
@endsection
