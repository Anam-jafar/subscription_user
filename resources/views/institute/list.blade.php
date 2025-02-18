@extends('layouts.adminLayout')

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Senarai Institusi'" :breadcrumbs="[
                ['label' => 'Rekod Institusi', 'url' => 'javascript:void(0);'],
                ['label' => 'Senarai Institusi'],
            ]" />
            <div>

                <x-alert />


                <div class="py-8 px-4 rounded-lg shadow bg-white">
                    <x-filter-card :filters="[
                        [
                            'name' => 'inst_category',
                            'label' => 'Institusi',
                            'type' => 'select',
                            'options' => $commonData['institutes'],
                        ],
                        [
                            'name' => 'inst_type',
                            'label' => 'Jenis Institusi',
                            'type' => 'select',
                            'options' => $commonData['institute_types'],
                        ],
                        [
                            'name' => 'inst_district',
                            'label' => 'Daerah',
                            'type' => 'select',
                            'options' => $commonData['districts'],
                        ],
                        [
                            'name' => 'inst_sub_district',
                            'label' => 'Mukim',
                            'type' => 'select',
                            'options' => $commonData['sub_districts'],
                        ],
                        [
                            'name' => 'search',
                            'label' => 'Search by Name',
                            'type' => 'text',
                            'placeholder' => 'Carian...',
                        ],
                    ]" button-label="Daftar Baharu" :button-route="route('instituteCreate')" />


                    <x-table :headers="['Institusi', 'Jenis Institusi', 'Nama Institusi', 'Daerah', 'Mukim']" :columns="['inst_category', 'inst_type', 'inst_name', 'inst_district', 'inst_sub_district']" :rows="$institutes" route="instituteUpdate" />

                    <x-pagination :items="$institutes" label="Institutes" />
                </div>
            </div>

        </div>
    </div>
@endsection
