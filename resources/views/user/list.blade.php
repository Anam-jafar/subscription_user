@extends('layouts.adminLayout')

@section('content')
  <div class="main-content app-content">
    <div class="container-fluid">

      <x-page-header :title="'Senarai Pengguna Dalaman'" :breadcrumbs="[
          ['label' => 'Pengurusan Pengguna ', 'url' => 'javascript:void(0);'],
          ['label' => 'Senarai Pengguna Dalaman'],
      ]" />
      <x-alert />

      <div class="rounded-lg bg-white px-4 py-8 shadow">

        <x-filter-card :filters="[
            [
                'name' => 'search',
                'label' => 'Search by Name',
                'type' => 'text',
                'placeholder' => 'Carian...',
            ],
        ]" button-label="Daftar Baharu" :button-route="route('registerUser')" />

        <x-table :headers="['Nama', 'Emel', 'No. H/P', 'Peringkat Pengguna', 'Status']" :columns="['fullname', 'email', 'mobile_number', 'user_position', 'user_status']" :rows="$users" route="userUpdate" />

        <x-pagination :items="$users" label="users" />
      </div>

    </div>
  </div>
@endsection
