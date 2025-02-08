@extends('layouts.app-admin')
<title>Dashboard Admin | SR Klasifikasi</title>
@section('content')
<main id="main" class="main">
    <div class="row">
        <div class="pagetitle">
            <h1>Halo <b>{{ ucwords($user->role) }}</b> 👋</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Admin</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->


        <div class="col-12 dashboard">
            <div class="row">
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                <div class="col-12">
                    <div class="row">
                        <div class="col-xxl-6 col-md-6">
                            <div class="card info-card sales-card">
                                <div class="card-body">
                                    <h5 class="card-title">Santri <span>| Jumlah</span></h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class='bx bx-universal-access'></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>400</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-6 col-md-6 mb-3">
                            <div class="card info-card revenue-card">
                                <div class="card-body">
                                    <h5 class="card-title">Tepat Waktu <span>| Jumlah</span></h5>
                                    <div class="d-flex align-items-center">
                                        <div
                                            class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class='bx bx-child'></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6>400</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="card">
                                <div class="card-body pb-0">
                                    <h5 class="card-title">Klasifikasi</h5>

                                    <div id="trafficChart" style="min-height: 400px;" class="echart"></div>

                                    <script>
                                        document.addEventListener("DOMContentLoaded", () => {
                                              echarts.init(document.querySelector("#trafficChart")).setOption({
                                                tooltip: {
                                                  trigger: 'item'
                                                },
                                                legend: {
                                                  top: '5%',
                                                  left: 'center'
                                                },
                                                series: [{
                                                  name: 'Access From',
                                                  type: 'pie',
                                                  radius: ['40%', '70%'],
                                                  avoidLabelOverlap: false,
                                                  label: {
                                                    show: false,
                                                    position: 'center'
                                                  },
                                                  emphasis: {
                                                    label: {
                                                      show: true,
                                                      fontSize: '18',
                                                      fontWeight: 'bold'
                                                    }
                                                  },
                                                  labelLine: {
                                                    show: false
                                                  },
                                                  data: [{
                                                      value: 1048,
                                                      name: 'Tepat Waktu'
                                                    },
                                                    {
                                                      value: 735,
                                                      name: 'Terlambat'
                                                    },
                                                  ]
                                                }]
                                              });
                                            });
                                    </script>

                                </div>
                            </div><!-- End Website Traffic -->
                        </div>

                        <div class="col-xxl-6 col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title justify-content-center d-flex">Jenis Kelamin</h5>
                                    <div id="jenisKelamin"></div>
                                </div>
                            </div>
                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                                          new ApexCharts(document.querySelector("#jenisKelamin"), {
                                                            series: [{
                                                              name: 'Laki Laki',
                                                              data: [21,22,23,24,25],
                                                            }, {
                                                              name: 'Perempuan',
                                                              data: [11, 32, 45,32, 41]
                                                            }],
                                                            chart: {
                                                              height: 350,
                                                              type: 'area',
                                                              toolbar: {
                                                                show: false
                                                              },
                                                            },
                                                            markers: {
                                                              size: 4
                                                            },
                                                            colors: ['#4154f1', '#2eca6a'],
                                                            fill: {
                                                              type: "gradient",
                                                              gradient: {
                                                                shadeIntensity: 1,
                                                                opacityFrom: 0.3,
                                                                opacityTo: 0.4,
                                                                stops: [0, 90, 100]
                                                              }
                                                            },
                                                            dataLabels: {
                                                              enabled: false
                                                            },
                                                            stroke: {
                                                              curve: 'smooth',
                                                              width: 2
                                                            },
                                                            xaxis: {
                                                              type: 'year',
                                                              categories: ["2021","2022", "2023", "2024", "2025"
                                                              ]
                                                            },
                                                            tooltip: {
                                                              x: {
                                                                format: 'dd/MM/yy HH:mm'
                                                              },
                                                            }
                                                          }).render();
                                                        });
                            </script>
                            <!-- End Line Chart -->

                        </div>
                        <div class="col-xxl-6 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title justify-content-center d-flex">Asal Daerah</h5>
                                    <div id="asalDaerah"></div>
                                </div>
                            </div>
                            <script>
                                document.addEventListener("DOMContentLoaded", () => 
                                        {
                                            new ApexCharts(document.querySelector("#asalDaerah"), {
                                            series: [{
                                                name: 'Dalam Provinsi',
                                                data: [21,22,23,24,25],
                                            }, {
                                                name: 'Luar Provinsi',
                                                data: [11, 32, 45,32, 41]
                                            }],
                                            chart: {
                                                height: 350,
                                                type: 'area',
                                                toolbar: {
                                                show: false
                                                },
                                            },
                                            markers: {
                                                size: 4
                                            },
                                            colors: ['#F14141FF', '#C72ECAFF'],
                                            fill: {
                                                type: "gradient",
                                                gradient: {
                                                shadeIntensity: 1,
                                                opacityFrom: 0.3,
                                                opacityTo: 0.4,
                                                stops: [0, 90, 100]
                                                }
                                            },
                                            dataLabels: {
                                                enabled: false
                                            },
                                            stroke: {
                                                curve: 'smooth',
                                                width: 2
                                            },
                                            xaxis: {
                                                type: 'year',
                                                categories: ["2021","2022", "2023", "2024", "2025"
                                                ]
                                            },
                                            tooltip: {
                                                x: {
                                                format: 'dd/MM/yy HH:mm'
                                                },
                                            }
                                            }).render();
                                        });
                            </script>

                        </div>
                    </div>
                </div>
                <div class="col-xxl-12 col-md-12">
                    <div class="row">
                        <!-- Card Tanggal -->
                        <div class="col-md-6">
                            <div class="card info-card date-card shadow-lg"
                                style="background-color: #f8f9fa; border-left: 5px solid #007bff;">
                                <div class="card-body text-center">
                                    <h5 class="card-title text-primary fw-bold">Tanggal Hari Ini</h5>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div
                                            class="card-icon rounded-circle bg-primary text-white d-flex align-items-center justify-content-center p-3">
                                            <i class='bx bx-calendar text-white' style="font-size: 1.5rem;"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 id="current-date" class="fw-semibold " style="color: #012970">Loading...
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Waktu -->
                        <div class="col-md-6">
                            <div class="card info-card time-card shadow-lg"
                                style="background-color: #f8f9fa; border-left: 5px solid #28a745;">
                                <div class="card-body text-center">
                                    <h5 class="card-title text-success fw-bold">Waktu Saat Ini</h5>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div
                                            class="card-icon rounded-circle bg-success text-white d-flex align-items-center justify-content-center p-3">
                                            <i class='bx bx-time text-white' style="font-size: 1.5rem;"></i>
                                        </div>
                                        <div class="ps-3">
                                            <h6 id="current-time" class="fw-semibold " style="color: #012970">Loading...
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    function updateTime() {
        const now = new Date();
        document.getElementById('current-date').innerText = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
        document.getElementById('current-time').innerText = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    }
    setInterval(updateTime, 1000);
    updateTime();
</script>
@endsection