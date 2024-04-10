@extends('layouts.master')
@section('content')


<!-- Content area -->
<div class="content">

    <!-- Fading entrances -->
    <div class="mb-3">
        <h5 class="mb-0 text-uppercase fw-bold">
            Remote Monitoring
        </h5>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="text-end mb-3">
                <a href="#" data-bs-toggle="modal" data-bs-target="#createProjectModal"
                    class="btn btn-primary" style="background-color: #0056b3; border-color: #0056b3;">
                    <i class="fas fa-plus-circle me-2"></i> Create Remote
                </a>
            </div>
            <table class="table datatableDisplay">
                <thead>
                    <tr>
                        <th>Employee ID / Name</th>
                        <th>Schedule</th>
                        <th>Project / Task</th>
                        <th>Meeting</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($RemoteMonitoring as $item)
                        <tr>
                            <td>
                                <span class="fw-bold h6">{{ $item->Employee->id }}</span><br>
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
                                <a href="#"
                                    data-bs-toggle="modal" data-bs-target="#viewProjectModal{{ $item->id }}" title="View Project"
                                    class="fw-bold h6 text-info"> <i class="ph ph-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


    {{-- <div class="card">
        <div class="card-body">
            <div class="text-end mb-3">
                <a href="#" data-bs-toggle="modal" data-bs-target="#createProjectModal"
                    class="btn btn-primary" style="background-color: #0056b3; border-color: #0056b3;">
                    <i class="fas fa-plus-circle me-2"></i> Create Remote
                </a>
            </div>
            <table class="table datatableDisplay">
                <thead>
                    <tr>
                        <th>Employee ID / Name</th>
                        <th>Schedule</th>
                        <th>Project / Task</th>
                        <th>Meeting</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($RemoteMonitoring as $item)
                        <tr>
                            <td>
                                <span class="fw-bold h6">{{ $item->Employee->employee_id }}</span><br>
                                 {{ $item->Employee->last_name }},
                                 {{ $item->Employee->first_name }}
                                 {{ $item->Employee->middle_name }}
                            </td>
                            <td>8:00 AM - 5:00 PM</td>
                            <td>
                                <span class="fw-bold h6">{{ $item->Tasks->Projects->project_name }}</span><br>

                                {{ $item->Tasks->task_name }}
                            </td>
                            <td>{{ $item->Meetings->title }}</td>
                            <td>
                                <a href="#"
                                    data-bs-toggle="modal" data-bs-target="#viewProjectModal{{ $item->id }}" title="View Project"
                                    class="fw-bold h6 text-info"> <i class="ph ph-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div> --}}

    <div class="modal fade" id="createProjectModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="transferModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold " id="transferModalLabel">CREATE MONITORING</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <input type="hidden" name="item_id">

                            <label class="col-md-3 fw-bold h6 mt-2">Employee Name</label>
                            <div class="col-md-9">
                                <div class="mb-2 form-group">
                                    <select class="form-control select2" id="selectEmployee" name="employee_id" required>
                                        <option value="0" selected disabled>Select Employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->last_name}}, {{ $employee->first_name}} {{ $employee->middlename}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <label class="col-md-3 fw-bold h6 mt-2">Schedule</label>
                            <div class="col-md-9">
                                <div class="mb-2 form-group">
                                    <select class="form-control selectpicker" name="schedule_id" required>
                                        <option value="0" selected disabled>Select Schedule</option>
                                    </select>
                                </div>
                            </div>

                            <label class="col-md-3 fw-bold h6 mt-2">Task Name</label>
                            <div class="col-md-9">
                                <div class="mb-2 form-group">
                                    <select class="form-control selectpicker" name="task_id" required>
                                        <option value="0" selected disabled>Select Project</option>
                                        @foreach ($tasks as $task)
                                            <option value="{{ $task->id }}">{{ $task->task_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <label class="col-md-3 fw-bold h6 mt-2">Meeting Name</label>
                            <div class="col-md-9">
                                <div class="mb-2 form-group">
                                    <select class="form-control selectpicker" name="meeting_id" required>
                                        <option value="0" selected disabled>Select Meeting</option>
                                        @foreach ($meetings as $meeting)
                                            <option value="{{ $meeting->id }}">{{ $meeting->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="create_meeting" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#selectEmployee').select2({ dropdownParent: $('#createProjectModal') });
            // Function to compute total score
            function computeTotalScore() {
                var totalScore = 0;

                // Loop through each radio input and add its value to the total score
                $('.jobrole_suitability, .performance_accountability, .technological_readiness, .work_environment, .communication_skills, .flexibility_adaptability, .health_wellbeing, .organizational_needs, .legal_compliance').each(function() {
                    if ($(this).is(':checked')) {
                        totalScore += parseInt($(this).val());
                    }
                });

                // Update the input field with the computed total score
                $('#rating').val(totalScore);
            }

            // Call computeTotalScore function initially and whenever any radio input changes
            computeTotalScore();
            $('.jobrole_suitability, .performance_accountability, .technological_readiness, .work_environment, .communication_skills, .flexibility_adaptability, .health_wellbeing, .organizational_needs, .legal_compliance').change(function() {
                computeTotalScore();
            });
        });
    </script>


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
