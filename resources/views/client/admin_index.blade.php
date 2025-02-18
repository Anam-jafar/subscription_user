@extends('layouts.adminLayout')

@section('styles')
@endsection

@section('content')
    <!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container-fluid">
            <div class="max-w-full mx-auto  md:px-6">
                <h1 class="page-title font-medium text-[1.25rem] mb-0 ">Laman Utama</h1>

                <!-- Main Content Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-4">
                    <!-- Left Column -->
                    <div class="lg:col-span-2 space-y-8 ">

                        <div class="bg-white sm:p-6 rounded-lg shadow">
                            <!-- Bulletin Section -->
                            @if (Auth::user()->user_group == 'ADMIN')
                                <!-- Bulletin Section -->
                                <section class="mb-4">
                                    <div>
                                        @if (session('success'))
                                            <div class="alert alert-success rounded-md p-4 mb-4">
                                                <div class="flex items-center">
                                                    <svg class="h-6 w-6 text-green-600 mr-2"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M9 12l2 2 4-4M7 13h.01M4 4l16 16" />
                                                    </svg>
                                                    <span>{{ session('success') }}</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <h2 class="text-gray-600 mb-6 text-base">Buletin</h2>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                        <!-- Bulletin Card 1 -->
                                        <div class="relative bg-white rounded-lg shadow overflow-hidden group">
                                            <img src="{{ asset('assets/icons/mosque_image.jpg') }}" alt="Panduan Pengguna"
                                                class="w-full h-64 object-cover transition-opacity group-hover:opacity-85">
                                            <div
                                                class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-80">
                                                <h3 class="text-lg font-semibold text-center text-gray-800 px-4">PANDUAN
                                                    PENGGUSER
                                                </h3>
                                            </div>
                                        </div>
                                        <!-- Bulletin Card 2 -->
                                        <div class="relative bg-white rounded-lg shadow overflow-hidden group">
                                            <img src="{{ asset('assets/icons/mosque_image_2.jpg') }}" alt="Peraturan Masjid"
                                                class="w-full h-64 object-cover transition-opacity group-hover:opacity-85">
                                            <div
                                                class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-80">
                                                <h3 class="text-lg font-semibold text-center text-gray-800 px-4">
                                                    PERATURAN-PERATURAN MASJID DAN SURAU (NEGERI SELANGOR) 2017</h3>
                                            </div>
                                        </div>

                                        <!-- Bulletin Card 3 -->
                                        <div class="relative bg-white rounded-lg shadow overflow-hidden group">
                                            <img src="{{ asset('assets/icons/mosque_image_3.jpg') }}" alt="Pegawai Audit"
                                                class="w-full h-64 object-cover transition-opacity group-hover:opacity-85">
                                            <div
                                                class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-80">
                                                <h3 class="text-lg font-semibold text-center text-gray-800 px-4">PEGAWAI
                                                    AUDIT
                                                    YANG DILULUK</h3>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            @endif

                        </div>

                        <div class="bg-white sm:p-6 rounded-lg shadow">

                            @if (Auth::user()->user_group == 'ADMIN')
                                <!-- Profil Institusi Section -->
                                <section>
                                    <h2 class="text-xl font-medium mb-4">Rekod Institusi</h2>
                                    <div class="flex flex-row gap-4 mb-6">

                                        <div class="flex flex-col items-center">
                                            <!-- Icon -->
                                            <a href="{{ route('instituteList') }}">
                                                <img src="{{ asset('assets/icons/fin_rec_1.svg') }}" alt="PDF"
                                                    class="w-18 h-18" />
                                            </a>


                                            <!-- Text Container -->
                                            <div class="flex flex-col items-center text-center w-full mt-2">
                                                <p class="text-xs text-gray-600 leading-tight">Senarai</p>
                                                <p class="text-xs text-gray-600 leading-tight">Institusi</p>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-center">
                                            <!-- Icon -->
                                            <a href="">
                                                <img src="{{ asset('assets/icons/fin_rec_2.svg') }}" alt="PDF"
                                                    class="w-18 h-18" />
                                            </a>


                                            <!-- Text Container -->
                                            <div class="flex flex-col items-center text-center w-full mt-2">
                                                <p class="text-xs text-gray-600 leading-tight">Daftar</p>
                                                <p class="text-xs text-gray-600 leading-tight">Institusi</p>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-center">
                                            <!-- Icon -->
                                            <a href="{{ route('instituteProfileList') }}">
                                                <img src="{{ asset('assets/icons/fin_rec_3.svg') }}" alt="PDF"
                                                    class="w-18 h-18" />
                                            </a>


                                            <!-- Text Container -->
                                            <div class="flex flex-col items-center text-center w-full mt-2">
                                                <p class="text-xs text-gray-600 leading-tight">Profil</p>
                                                <p class="text-xs text-gray-600 leading-tight">Institusi</p>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-center">
                                            <!-- Icon -->
                                            <a href="{{ route('instituteProfileRequestList') }}">
                                                <img src="{{ asset('assets/icons/fin_rec_4.svg') }}" alt="PDF"
                                                    class="w-18 h-18" />
                                            </a>


                                            <!-- Text Container -->
                                            <div class="flex flex-col items-center text-center w-full mt-2">
                                                <p class="text-xs text-gray-600 leading-tight">Permohonan</p>
                                                <p class="text-xs text-gray-600 leading-tight">Baharu</p>
                                            </div>
                                        </div>
                                    </div>
                                </section>

                                <!-- Laporan Kewangan Section -->
                                <section>
                                    <h2 class="text-xl font-medium mb-4">Laporan Kewangan</h2>
                                    <div class="flex flex-row gap-4 mb-6">
                                        <div class="flex flex-col items-center">
                                            <!-- Icon -->
                                            <a href="">
                                                <img src="{{ asset('assets/icons/fin_lapo_1.svg') }}" alt="PDF"
                                                    class="w-18 h-18" />
                                            </a>

                                            <!-- Text Container -->
                                            <div class="flex flex-col items-center text-center w-full mt-2">
                                                <p class="text-xs text-gray-600 leading-tight">Peneyata</p>
                                                <p class="text-xs text-gray-600 leading-tight">Baharu</p>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-center">
                                            <!-- Icon -->
                                            <a href="">
                                                <img src="{{ asset('assets/icons/fin_lapo_2.svg') }}" alt="PDF"
                                                    class="w-18 h-18" />
                                            </a>

                                            <!-- Text Container -->
                                            <div class="flex flex-col items-center text-center w-full mt-2">
                                                <p class="text-xs text-gray-600 leading-tight">Senarai</p>
                                                <p class="text-xs text-gray-600 leading-tight">Penyata</p>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-center">
                                            <!-- Icon -->
                                            <a href="">
                                                <img src="{{ asset('assets/icons/fin_lapo_3.svg') }}" alt="PDF"
                                                    class="w-18 h-18" />
                                            </a>

                                            <!-- Text Container -->
                                            <div class="flex flex-col items-center text-center w-full mt-2">
                                                <p class="text-xs text-gray-600 leading-tight">Rekod</p>
                                                <p class="text-xs text-gray-600 leading-tight">Pembatalan</p>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- e-Masjid Section -->
                                <section>
                                    <h2 class="text-xl font-medium mb-4">Pengurusan Pengguna</h2>
                                    <div class="flex flex-row gap-4 mb-6">
                                        <div class="flex flex-col items-center">
                                            <!-- Icon -->
                                            <a href="{{ route('userList') }}">
                                                <img src="{{ asset('assets/icons/fin_btn_subs.svg') }}" alt="PDF"
                                                    class="w-18 h-18" />
                                            </a>

                                            <!-- Text Container -->
                                            <div class="flex flex-col items-center text-center w-full mt-2">
                                                <p class="text-xs text-gray-600 leading-tight">Senarai</p>
                                                <p class="text-xs text-gray-600 leading-tight">Admin</p>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-center">
                                            <!-- Icon -->
                                            <a href="">
                                                <img src="{{ asset('assets/icons/fin_btn_subs.svg') }}" alt="PDF"
                                                    class="w-18 h-18" />
                                            </a>

                                            <!-- Text Container -->
                                            <div class="flex flex-col items-center text-center w-full mt-2">
                                                <p class="text-xs text-gray-600 leading-tight">Daftar</p>
                                                <p class="text-xs text-gray-600 leading-tight">Admin</p>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-center">
                                            <!-- Icon -->
                                            <a href="{{ route('registerUser') }}">
                                                <img src="{{ asset('assets/icons/fin_btn_battery.svg') }}" alt="PDF"
                                                    class="w-18 h-18" />
                                            </a>

                                            <!-- Text Container -->
                                            <div class="flex flex-col items-center text-center w-full mt-2">
                                                <p class="text-xs text-gray-600 leading-tight">Pentadbir</p>
                                                <p class="text-xs text-gray-600 leading-tight">Institusi</p>
                                            </div>
                                        </div>


                                    </div>
                                </section>
                            @endif
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="lg:col-span-1 space-y-8">
                        <!-- Statement Info Section -->
                        <section class="bg-white p-6 rounded-lg shadow">
                            <h2 class="text-lg font-medium mb-4 text-center">JUMLAH PENGHANTARAN TAHUNAN
                                LAPORAN KEWANGAN</h2>
                            <div class="flex justify-center">
                                <select
                                    class="w-36 text-center px-2 border !border-[#6E829F] rounded-lg !text-gray-800 item-center mb-4">
                                    <option value="2020">2020</option>
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025" selected>2025</option>
                                </select>
                            </div>


                            <div class="xxl:col-span-4 xl:col-span-6 col-span-12">
                                <div class="overflow-hidden">
                                    <div class="pb-0 justify-between">
                                        <div class="box-title font-semibold">
                                            1 Tahuan :
                                        </div>
                                    </div>
                                    <div class="px-3">
                                        <div id="submission_01" class="my-2"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="xxl:col-span-4 xl:col-span-6 col-span-12">
                                <div class="overflow-hidden">
                                    <div class="pb-0 justify-between">
                                        <div class="box-title font-semibold">
                                            6 Bulan :
                                        </div>
                                    </div>
                                    <div class="px-3">
                                        <div id="submission_06" class="my-2"></div>
                                    </div>
                                </div>
                            </div>


                            <button class="mt-6 text-blue-600 flex items-center">
                                Lihat Semua
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </button>
                        </section>
                        <!-- Calendar Section -->
                        <section class="bg-white p-6 rounded-lg shadow">
                            <div class="text-center">
                                <h2 class="text-lg font-medium mb-4" id="month-year"></h2>
                                <div class="grid grid-cols-7 gap-2 text-sm mb-2">
                                    <div>Mo</div>
                                    <div>Tu</div>
                                    <div>We</div>
                                    <div>Th</div>
                                    <div>Fr</div>
                                    <div class="text-blue-600">Sa</div>
                                    <div class="text-blue-600">Su</div>
                                </div>
                                <div id="calendar" class="grid grid-cols-7 gap-2 text-sm">
                                    <!-- Calendar days will be populated here by JavaScript -->
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <!-- End::app-content -->
    @endsection

    @section('scripts')
        <script src="{{ asset('build/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                initializeCalendar();
                initializeCharts();
                initializePreline();
                initializeSimpleBar();
            });

            function initializeCalendar() {
                const today = new Date();
                const currentMonth = today.getMonth();
                const currentYear = today.getFullYear();
                const currentDate = today.getDate();

                // Set the month and year in the header
                const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August",
                    "September", "October", "November", "December"
                ];
                const monthYearElement = document.getElementById('month-year');

                if (monthYearElement) {
                    monthYearElement.innerText = `${monthNames[currentMonth]} ${currentYear}`;
                } else {
                    console.warn("⚠️ Warning: #month-year element not found.");
                }

                // Generate the calendar
                const firstDayOfMonth = new Date(currentYear, currentMonth, 1).getDay();
                let adjustedFirstDay = firstDayOfMonth === 0 ? 6 : firstDayOfMonth - 1; // Adjust Sunday (0) to Monday (1)

                const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
                const calendarContainer = document.getElementById('calendar');

                if (!calendarContainer) {
                    console.warn("⚠️ Warning: #calendar element not found.");
                    return;
                }

                calendarContainer.innerHTML = ''; // Clear previous content

                // Add empty placeholders for first row
                for (let i = 0; i < adjustedFirstDay; i++) {
                    const emptyDiv = document.createElement('div');
                    emptyDiv.classList.add('w-8', 'h-8'); // Maintain spacing
                    calendarContainer.appendChild(emptyDiv);
                }

                // Add the actual days
                for (let day = 1; day <= daysInMonth; day++) {
                    const dayDiv = document.createElement('div');
                    dayDiv.classList.add('w-8', 'h-8', 'flex', 'items-center', 'justify-center', 'mx-auto');
                    dayDiv.innerText = day;

                    if (day === currentDate) {
                        dayDiv.classList.add('bg-yellow-400', 'rounded-full');
                    }

                    calendarContainer.appendChild(dayDiv);
                }
            }


            function createDonutChart(elementId, series, labels, title = "Statistics") {
                // Calculate percentage for total label
                const total = series.reduce((a, b) => a + b, 0);
                const percentage = ((series[0] / total) * 100).toFixed(0);

                const options = {
                    series: series,
                    labels: labels,
                    chart: {
                        height: 175,
                        type: 'donut',
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    legend: {
                        show: true,
                        position: 'bottom',
                        horizontalAlign: 'center',
                        height: 52,
                        markers: {
                            width: 8,
                            height: 8,
                            radius: 2,
                            shape: "circle",
                            size: 4,
                            strokeWidth: 0
                        },
                        offsetY: 10,
                    },
                    stroke: {
                        show: true,
                        curve: 'smooth',
                        lineCap: 'round',
                        colors: "#fff",
                        width: 0,
                        dashArray: 0,
                    },
                    plotOptions: {
                        pie: {
                            startAngle: -90,
                            endAngle: 90,
                            offsetY: 10,
                            expandOnClick: false,
                            donut: {
                                size: '70%',
                                background: 'transparent',
                                labels: {
                                    show: true,
                                    name: {
                                        show: true,
                                        fontSize: '20px',
                                        color: '#495057',
                                        offsetY: -25
                                    },
                                    value: {
                                        show: false,
                                        fontSize: '15px',
                                        color: undefined,
                                        offsetY: -20,
                                        formatter: function(val) {
                                            return val + "%"
                                        }
                                    },
                                    total: {
                                        show: true,
                                        showAlways: true,
                                        label: `${percentage}%`,
                                        fontSize: '22px',
                                        fontWeight: 600,
                                        color: '#495057',
                                    }
                                }
                            }
                        }
                    },
                    grid: {
                        padding: {
                            bottom: -100
                        }
                    },
                    colors: ["rgb(87, 200, 77)", "rgb(217, 217, 217)"],
                    title: {
                        text: title,
                        align: 'center',
                        style: {
                            fontSize: '16px',
                            fontWeight: 'bold',
                            color: '#495057'
                        }
                    }
                };

                const chart = new ApexCharts(document.querySelector(`#${elementId}`), options);
                chart.render();

                return chart;
            }
            // Example usage:
            createDonutChart(
                'submission_01', // ID of the element where the chart will be rendered
                [1754, 634], // Series data
                ["Jumlah Penyata Dihantar", "Jumlah Penyata Belum Dihantar"], // Labels
                "" // Optional title
            );
            // Example usage:
            createDonutChart(
                'submission_06', // ID of the element where the chart will be rendered
                [300, 300], // Series data
                ["Jumlah Penyata Dihantar", "Jumlah Penyata Belum Dihantar"], // Labels
                "" // Optional title
            );
        </script>
    @endsection
