@extends('layouts.adminLayout')

@section('styles')
@endsection

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Senarai Pentadbir'" :breadcrumbs="[['label' => 'Pentadbir', 'url' => 'javascript:void(0);'], ['label' => 'Senarai Pentadbir']]" />
            <x-alert />

            <form method="POST" action="{{ route('instituteUpdate', ['id' => $institute->id]) }}"
                class="bg-white p-4 md:p-6 rounded-lg shadow">
                @csrf
                <div class="grid grid-col-2 md:grid-cols-4 gap-6">
                    <div class="col-span-1">
                        <x-input-field level="ID Masjid" id="inst_refno" name="inst_refno" type="text"
                            placeholder="Enter Institute Ref No" value="{{ $institute->inst_refno }}" readonly="true" />
                    </div>
                    <div class="col-span-2">
                        <x-input-field level="Institute Name" id="inst_name" name="inst_name" type="text"
                            placeholder="Enter Institute Name" value="{{ $institute->inst_name }}" />
                    </div>
                </div>


                <div class="grid grid-col-1 md:grid-cols-2 gap-6">
                    <div class="grid grid-cols-2 gap-6">
                        <x-input-field level="Institute Category" id="inst_category" name="inst_category" type="select"
                            placeholder="-- Category --" value="{{ $institute->inst_category }}" :valueList="$commonData['institutes']" />
                        <x-input-field level="Institute Type" id="inst_type" name="inst_type" type="select"
                            placeholder="-- Type --" value="{{ $institute->inst_type }}" :valueList="$commonData['institute_types']" />
                    </div>
                </div>
                <div class="grid grid-col-1 md:grid-cols-2 gap-6">
                    <div class="grid grid-cols-2 gap-6">
                        <x-input-field level="District" id="inst_district" name="inst_district" type="select"
                            placeholder="-- District --" value="{{ $institute->inst_district }}" :valueList="$commonData['districts']" />
                        <x-input-field level="Sub District" id="inst_sub_district" name="inst_sub_district" type="select"
                            placeholder="-- Sub District --" value="{{ $institute->inst_sub_district }}"
                            :valueList="$commonData['sub_districts']" />
                    </div>
                </div>

                <div class="flex justify-between mt-8">
                    <button class="bg-[#6E829F] ti-btn ti-btn-dark btn-wave waves-effect waves-light ti-btn-w-lg ti-btn-lg">
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
