@extends('layouts.adminLayout')

@section('content')
    <div class="main-content app-content ">
        <div class="container-fluid">

            <x-page-header :title="'Senarai Semakan Permohonan Baharu'" :breadcrumbs="[
                ['label' => 'Rekod Institusi', 'url' => 'javascript:void(0);'],
                ['label' => 'Permohonan Baharu'],
            ]" />

            <div class="py-8 px-4 rounded-lg shadow bg-white">
                <x-alert />

                <x-filter-card :filters="[
                    ['name' => 'search', 'label' => 'Search by Name', 'type' => 'text', 'placeholder' => 'Carian...'],
                ]" />


                <x-table :headers="['Tarikh Mohon', 'Nama Institusi', 'Jenis Institusi', 'Nama Pemohon']" :columns="['created', 'name', 'type', 'incharge']" :rows="$institutes" route="instituteProfileUpdate" />

                <x-pagination :items="$institutes" label="Institutes" />
            </div>

        </div>
    </div>
@endsection
