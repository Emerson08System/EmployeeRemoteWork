@extends('layouts.master')
@section('css')
<link href="{{URL::asset('assets/css/animate.min.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('content')




<!-- Content area -->
<div class="content">

    <!-- Fading entrances -->
    <div class="mb-3">
        <h5 class="mb-0 text-uppercase fw-bold">
            Lists of Schedule
        </h5>
    </div>


    <div class="card">
        <div class="card-body">

            <div class="text-end mb-3">

            </div>

            <table class="table datatableDisplay">
                <thead>
                    <tr>
                        <th>Schedule Date</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Shift Type</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($schedule as $item)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($item->schedule_date)->format('F j, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->in_time)->format('g:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->out_time)->format('g:i A') }}</td>
                            <td>{{ $item->shift_type }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <style>
        .progress-bar {
            width: 100%;
            background-color: #ddd;
            height: 20px;
            border-radius: 5px;
            overflow: hidden;
        }

        .progress {
            background-color: #4caf50;
            height: 100%;
            transition: width 0.3s ease-in-out;
        }
    </style>



</div>

@endsection
