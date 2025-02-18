@extends('layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="main-content app-content">
        <div class="container-fluid">

            <x-page-header :title="'Tambah Masjid Baru'" :breadcrumbs="[['label' => 'Masjid', 'url' => 'javascript:void(0);'], ['label' => 'Tambah Masjid']]" />
            <x-alert />

            <!-- User Information Grid -->
            <div class="grid grid-cols-1 gap-x-16 gap-y-4 max-w-3xl  mt-4">
                <div class="flex">
                    <span class="text-gray-900 font-medium w-24">Name:</span>
                    <span class="text-gray-600">KHAIRUL HAKIMIN BIN MOHD YUSOFF</span>
                </div>
                <div class="flex">
                    <span class="text-gray-900 font-medium w-24">Jawatan:</span>
                    <span class="text-gray-600">NAZIR</span>
                </div>
                <div class="flex">
                    <span class="text-gray-900 font-medium w-24">No H/P:</span>
                    <span class="text-gray-600">00123456789</span>
                </div>
                <div class="flex">
                    <span class="text-gray-900 font-medium w-24">Emel:</span>
                    <span class="text-gray-600">mdm@gmail.com</span>
                </div>
            </div>

            <form method="POST" action="" class="bg-white sm:p-2 text-xs">
                @csrf
                <div class="grid grid-cols-3 gap-6">
                    <!-- Left Side (First Input) -->
                    <x-input-field level="Input 2" id="input2" name="input2" type="text"
                        placeholder="Enter Input 2" />


                    <!-- Right Side (3ne Input) -->
                    <x-input-field level="Input 2" id="input2" name="input2" type="text"
                        placeholder="Enter Input 2" />

                </div>
                <div class="grid grid-cols-4 gap-6">
                    <!-- Left Side (First Input) -->
                    <x-input-field level="Input 2" id="input2" name="input2" type="text"
                        placeholder="Enter Input 2" />
                    <x-input-field level="Input 2" id="input2" name="input2" type="text"
                        placeholder="Enter Input 2" />
                    <x-input-field level="Input 2" id="input2" name="input2" type="text"
                        placeholder="Enter Input 2" />


                </div>
                <div class="grid grid-cols-4 gap-6">
                    <!-- Left Side (First Input) -->
                    <x-input-field level="Input 2" id="input2" name="input2" type="text"
                        placeholder="Enter Input 2" />
                    <x-input-field level="Input 2" id="input2" name="input2" type="text"
                        placeholder="Enter Input 2" />



                </div>
                <div class="grid grid-cols-3 gap-6">
                    <!-- Left Side (First Input) -->
                    <x-input-field level="Input 2" id="input2" name="input2" type="text"
                        placeholder="Enter Input 2" />

                </div>

                <div class="grid grid-cols-3 gap-6">
                    <!-- Left Side (First Input) -->
                    <div class="flex flex-col">
                        <label for="input3" class="text-gray-800 font-medium mb-2">Input 3</label>
                        <input type="file"
                            class="block w-full border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 text-textmuted dark:text-textmuted/50
                                            file:me-4 file:py-2 file:px-4
                                            file:rounded-s-sm file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-primary file:text-white
                                            hover:file:bg-primary focus-visible:outline-none
                                        ">
                    </div>

                    <!-- Right Side (3ne Input) -->
                    <div class="flex flex-col">
                        <label for="input3" class="text-gray-800 font-medium mb-2">Input 3</label>
                        <input type="file"
                            class="block w-full border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 text-textmuted dark:text-textmuted/50
                                            file:me-4 file:py-2 file:px-4
                                            file:rounded-s-sm file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-primary file:text-white
                                            hover:file:bg-primary focus-visible:outline-none
                                        ">
                    </div>
                    <!-- Right Side (3ne Input) -->
                    <div class="flex flex-col">
                        <label for="input3" class="text-gray-800 font-medium mb-2">Input 3</label>
                        <input type="file"
                            class="block w-full border border-gray-200 focus:shadow-sm dark:focus:shadow-white/10 rounded-sm text-sm focus:z-10 focus:outline-0 focus:border-gray-200 dark:focus:border-white/10 dark:border-white/10 text-textmuted dark:text-textmuted/50
                                            file:me-4 file:py-2 file:px-4
                                            file:rounded-s-sm file:border-0
                                            file:text-sm file:font-semibold
                                            file:bg-primary file:text-white
                                            hover:file:bg-primary focus-visible:outline-none
                                        ">
                    </div>
                </div>



                <p class="mr-2 border-3 border-gray-900 rounded p-1">
                    **This is the text<br>
                    **This is a different <br>
                </p>
                <input type="text"
                    class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    style="height: calc(3 * 1.5em);" placeholder="Enter your text here..." />


                <div class="flex justify-between">
                    <!-- Left Button -->
                    <button class="bg-blue-500 text-white py-2 px-4 rounded">
                        Left Button
                    </button>

                    <!-- Right Buttons -->
                    <button class="bg-green-500 text-white py-2 px-4 rounded">
                        Right Button 1
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
