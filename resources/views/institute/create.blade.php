@extends('layouts.adminLayout')

@section('styles')
@endsection

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Daftar Institusi'" :breadcrumbs="[
                ['label' => 'Rekod Institusi', 'url' => route('instituteList')],
                ['label' => 'Daftar Institusi'],
            ]" />
            <x-alert />

            <form method="POST" action="{{ route('instituteCreate') }}" class="bg-white sm:p-6 text-xs rounded-lg shadow">
                @csrf
                <div class="grid grid-col-1 md:grid-cols-2 gap-6">
                    <x-input-field level="Nama Institusi" id="inst_name" name="inst_name" type="text" placeholder="" />
                    <div class="grid grid-cols-2 gap-6">
                        <x-input-field level="Institusi" id="inst_category" name="inst_category" type="select"
                            placeholder="" :valueList="$commonData['institutes']" />
                        <x-input-field level="Jenis Institusi" id="inst_type" name="inst_type" type="select" placeholder=""
                            :valueList="$commonData['institute_types']" />
                    </div>
                </div>
                <div class="grid grid-col-1 md:grid-cols-2 gap-6">
                    <div class="grid grid-cols-2 gap-6">
                        <x-input-field level="Daerah" id="inst_district" name="inst_district" type="select" placeholder=""
                            :valueList="$commonData['districts']" />
                        <x-input-field level="Mukim" id="inst_sub_district" name="inst_sub_district" type="select"
                            placeholder="" :valueList="$commonData['sub_districts']" />
                    </div>
                </div>

                <div class="flex justify-between mt-8">
                    <button onclick="window.location='{{ route('instituteList') }}'" type="button"
                        class="bg-[#6E829F] ti-btn ti-btn-dark btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg">
                        Kembali
                    </button>

                    <button
                        class="bg-[#5C67F7] ti-btn ti-btn-primary btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg"
                        type="submit">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
