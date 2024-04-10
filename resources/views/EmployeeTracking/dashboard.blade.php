@extends('layouts.master')
@section('css')
<link href="{{URL::asset('assets/css/animate.min.css')}}" rel="stylesheet" type="text/css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.48.0/apexcharts.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.48.0/apexcharts.min.css" rel="stylesheet" type="text/css">

@endsection
@section('content')
{{-- @component('components.breadcrumb')
@slot('title') Animations @endslot
@slot('subtitle') CSS Animations @endslot
@endcomponent --}}

<!-- Content area -->
<div class="content">




    <!-- Fading entrances -->
    <div class="mb-3">
        <h5 class="mb-0 text-uppercase fw-bold">
            Dashboard
        </h5>
    </div>

    <div class="row">
        <div class="col-lg-3">
            <div class="card card-secondary border-left-secondary shadow h-40 py-4">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-12 col-md-8 col-lg-9">
                            <h5 class="fw-bold text-secondary text-uppercase mb-1">Remote Monitoring</h5>
                            <div class="h4 mb-0 fw-bold text-gray-800">{{ $RemoteMonitoring }}</div>
                            <div class="col-12 col-md-4 col-lg-1 text-center">
                            <i class="fas fa-users fa-4x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="col-lg-3">
            <div class="card card-success border-left-success shadow h-40 py-4">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-12 col-md-8 col-lg-9">
                            <h5 class="fw-bold text-success text-uppercase mb-1">Remote Request</h5>
                            <div class="h4 mb-0 fw-bold text-gray-800">{{  $RemoteRequest }}</div>
                            <div class="col-12 col-md-4 col-lg-1 text-center">
                            <i class="fas fa-users fa-4x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card card-danger border-left-danger shadow h-40 py-4">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-12 col-md-8 col-lg-9">
                            <h5 class="fw-bold text-danger text-uppercase mb-1">Total Meetings</h5>
                            <div class="h4 mb-0 fw-bold text-gray-800">{{  $RemoteMeetings }}</div>
                            <div class="col-12 col-md-4 col-lg-1 text-center">
                            <i class="fas fa-users fa-4x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card card-info border-left-info shadow h-40 py-4">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col-12 col-md-8 col-lg-9">
                            <h5 class="fw-bold text-info text-uppercase mb-1">Total Projects</h5>
                            <div class="h4 mb-0 fw-bold text-gray-800">{{ $Projects }}</div>
                            <div class="col-12 col-md-4 col-lg-1 text-center">
                            <i class="fas fa-users fa-4x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card w-100">
                <div class="card-body d-flex flex-column">
                    <h6 class="card-title text-center fw-bold">PROJECT ANALYTICS</h6>
                    <div class="border bg-white rounded" id="projects"></div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card w-100">
                <div class="card-body d-flex flex-column">
                    <h6 class="card-title text-center fw-bold">TASK ANALYTICS</h6>
                    <div class="border bg-white rounded" id="task"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="fw-bold text-center text-uppercase">Remote Schedule</h5><hr>
            <table class="table datatableDisplay">
                <thead>
                    <tr>
                        <th>Employee ID / Name</th>
                        <th>Schedule</th>
                        <th>Project / Task</th>
                        <th>Meeting</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($RemoteMonitoringDisplay as $item)
                        <tr>
                            <td>
                                <span class="fw-bold h6">{{ $item->Employee->employee_id }}</span><br>
                                 {{ $item->Employee->last_name }},
                                 {{ $item->Employee->first_name }}
                                 {{ $item->Employee->middle_name }}
                            </td>
                            <td>
                                <span class="fw-bold h6">{{ \Carbon\Carbon::parse($item->Schedule->schedule_date)->format('F j, Y') }}</span><br>
                                {{ \Carbon\Carbon::parse($item->Schedule->in_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($item->Schedule->out_time)->format('g:i A') }}<br>
                                {{ $item->Schedule->shift_type }}
                            </td>
                            <td>
                                <span class="fw-bold h6">{{ $item->Tasks->Projects->project_name }}</span><br>

                                {{ $item->Tasks->task_name }}
                            </td>
                            <td>{{ $item->Meetings->title }}</td>
                            <td>
                                @php
                                    $status = $item->status;
                                    $badge_class = '';

                                    switch ($status) {
                                        case 'Completed':
                                            $badge_class = 'bg-success';
                                            break;
                                        case 'On Progress':
                                            $badge_class = 'bg-info';
                                            break;
                                        case 'Cancelled':
                                            $badge_class = 'bg-danger';
                                            break;
                                    }
                                    @endphp
                                <span class="badge <?php echo $badge_class; ?>"><?php echo $status; ?></span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const data = @json($projectStats); // Convert PHP data to JavaScript

            // Function to get abbreviated month name
            const getMonthAbbreviation = (month) => {
                const monthNames = [
                    "January", "February", "March", "April", "May", "Jun",
                    "July", "August", "September", "October", "November", "December"
                ];
                return monthNames[month - 1];
            };

            const options = {
                chart: {
                    type: 'area',
                    height: 350,
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded',
                        borderRadius: 10,
                    },
                },
                xaxis: {
                    categories: data.map(item => getMonthAbbreviation(item.month) + ', ' + item.year),
                },
                colors: ['#1E90FF'],
                series: [
                    {
                        name: 'Project Completed',
                        data: data.map(item => item.projects_completed),
                        color: '#0F9CF3',
                    },
                ],
            };

            const chart = new ApexCharts(document.querySelector("#projects"), options);
            chart.render();
        });

        document.addEventListener("DOMContentLoaded", function () {
            const data = @json($TaskStats); // Convert PHP data to JavaScript

            // Function to get abbreviated month name
            const getMonthAbbreviation = (month) => {
                const monthNames = [
                    "January", "February", "March", "April", "May", "Jun",
                    "July", "August", "September", "October", "November", "December"
                ];
                return monthNames[month - 1];
            };

            const options = {
                chart: {
                    type: 'area',
                    height: 350,
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded',
                        borderRadius: 10,
                    },
                },
                xaxis: {
                    categories: data.map(item => getMonthAbbreviation(item.month) + ', ' + item.year),
                },
                colors: ['#059669'],
                series: [
                    {
                        name: 'Task Completed',
                        data: data.map(item => item.tasks_completed),
                        color: '#059669',
                    },
                ],
            };

            const chart = new ApexCharts(document.querySelector("#task"), options);
            chart.render();
        });

    </script>

	<style>
        .border-left-main {
            border-left: 0.25rem solid #072A40 !important;
        }
        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }
		.border-left-danger {
            border-left: 0.25rem solid #d9534f !important;
        }

        .text-main{
            color: #072A40;
        }

        .border-left-secondary {
            border-left: 0.25rem solid #6C757D !important;
        }

        .border-left-success {
            border-left: 0.25rem solid #28A745 !important;
        }

        .border-left-info {
            border-left: 0.25rem solid #049AAD !important;
        }

        .card-body {
            flex: 1 1 auto;
            min-height: 1px;
            padding: 1.25rem;
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid #e3e6f0;
            border-radius: 0.35rem;
        }

        .card .card-header[data-toggle="collapse"] {
            text-decoration: none;
            position: relative;
            padding: 0.75rem 3.25rem 0.75rem 1.25rem;
        }

        .card .card-header[data-toggle="collapse"]::after {
            position: absolute;
            right: 0;
            top: 0;
            padding-right: 1.725rem;
            line-height: 51px;
            font-weight: 900;
            content: '\f107';
            font-family: 'Font Awesome 5 Free';
            color: #d1d3e2;
        }

        .card-main:hover {
            border-bottom: 4px solid #072A40 !important;
        }

        .card-info:hover {
            border-bottom: 4px solid #049AAD !important;
        }

        .card-success:hover {
            border-bottom: 4px solid #28A745 !important;
        }

		.card-danger:hover {
            border-bottom: 4px solid #d9534f !important;
        }


        .card-secondary:hover {
            border-bottom: 4px solid #6C757D !important;
        }

        .card-primary:hover {
            border-bottom: 4px solid #007BFF !important;
        }




    </style>



</div>
<!-- /content area -->

@endsection
@section('scripts')
<!-- Theme JS files -->
<script src="{{URL::asset('assets/demo/pages/animations_css3.js')}}"></script>

@endsection
