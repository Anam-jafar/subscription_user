@extends('layouts.adminLayout')

@section('content')
    <div class="main-content app-content ">
        <div class="container-fluid">

            <x-page-header :title="'Profil Institusi'" :breadcrumbs="[
                ['label' => 'Rekod Institusi', 'url' => 'javascript:void(0);'],
                ['label' => 'Profil Institusi'],
            ]" />
            <x-alert />


            <div class="py-8 px-4 rounded-lg shadow bg-white">


                <x-filter-card :filters="[
                    [
                        'name' => 'search',
                        'label' => 'Search by Name',
                        'type' => 'text',
                        'placeholder' => 'Carian...',
                    ],
                ]" />


                <x-table :headers="[
                    'Nama Institusi',
                    'Jenis Institusi',
                    'Nama',
                    'No. H/P',
                    'Emel',
                    'Daerah',
                    'Mukim',
                    'Status',
                ]" :columns="['name', 'incharge', 'type', 'number', 'email', 'daerah', 'mukim', 'profile_status']" :rows="$institutes" route="instituteProfileUpdate" />


                <x-pagination :items="$institutes" label="Institutes" />
            </div>

        </div>
    </div>
@endsection
