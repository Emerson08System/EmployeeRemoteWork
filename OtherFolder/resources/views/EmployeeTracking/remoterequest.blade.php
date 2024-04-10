@extends('layouts.master')
@section('content')

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                });
            });
        </script>
    @endif


<!-- Content area -->
<div class="content">

    <!-- Fading entrances -->
    <div class="mb-3">
        <h5 class="mb-0 text-uppercase fw-bold">
            Remote Request
        </h5>
    </div>


    <div class="card">
        <div class="card-body">
            <div class="text-end mb-3">
                <a href="#" data-bs-toggle="modal" data-bs-target="#createProjectModal"
                    class="btn btn-primary" style="background-color: #0056b3; border-color: #0056b3;">
                    <i class="fas fa-plus-circle me-2"></i> Create Remote Request
                </a>
            </div>
            <table class="table datatableDisplay">
                <thead>
                    <tr>
                        <th style="width: 20%;">Employee ID / Name</th>
                        <th style="width: 15%;">Job Name</th>
                        <th style="width: 30%;">Request Reason</th>
                        <th style="width: 20%;">Request Date</th>
                        <th style="width: 10%;">Score</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 15%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($remote as $item)
                        <tr>
                            <td>
                                <span class="fw-bold h6">{{ $item->Employee->id }}</span><br>
                                {{ $item->Employee->last_name }},
                                {{ $item->Employee->first_name }},
                            </td>
                            <td>{{ $item->Employee->position }}</td>
                            <td>{{ $item->request_reason }}</td>
                            <td>{{ date('F j, Y', strtotime($item->request_date)) }}</td>
                            <td>{{ $item->total_score }}</td>
                            <td>
                                @php
                                $status = $item->status;
                                $badge_class = '';

                                switch ($status) {
                                    case 'Approved':
                                        $badge_class = 'bg-primary';
                                        break;
                                    case 'For Reveiwing':
                                        $badge_class = 'bg-info';
                                        break;
                                    case 'Declined':
                                        $badge_class = 'bg-danger';
                                        break;
                                    case 'Pending':
                                        $badge_class = 'bg-warning';
                                        break;
                                    default:
                                        // Handle any other status
                                        break;
                                }
                                @endphp
                                <span class="badge <?php echo $badge_class; ?>"><?php echo $status; ?></span>
                            </td>
                        <td>
                            @if($item->status === 'Pending' || $item->status === 'For Reviewing')
                                <a href="#"
                                    class="text-warning mb-2 me-2 edit-request"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"
                                    data-id="{{ $item->id }}">
                                    <i class="ph ph-pen"></i>
                                </a>
                            @endif

                            @if($item->status === 'Declined' || $item->status === 'Approved')
                                <a href="#"
                                    class="text-info mb-2 me-2 view-request"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="View"
                                    data-id="{{ $item->id }}">
                                    <i class="ph ph-eye"></i>
                                </a>
                            @endif

                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

    <div class="modal fade" id="createProjectModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="transferModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold " id="transferModalLabel">CREATE REQUEST</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('remote.request.store')  }}" method="post" enctype="multipart/form-data" class="was-validated">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="item_id">
                            <div class="row mb-3">
                            <div class="col-md-3 fw-bold h6 mt-2">Total Score</div>
                                <div class="col-md-9">
                                    <div class="mb-2 form-group">
                                        <input type="text" class="form-control" name="total_score" id="rating" placeholder="Total Score" readonly>
                                    </div>
                                </div>
                            </div><hr>

                            <label class="col-md-2 fw-bold h6 mt-2 mb-3">Employee</label>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <select class="form-control" name="employee_id" required>
                                        <option value="0" selected disabled>Select Employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->last_name .', '. $employee->first_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <label class="col-md-2 fw-bold h6 mt-2 mb-3">Request Date</label>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <input type="date" class="form-control" name="request_date" required>
                                </div>
                            </div>

                            <label class="col-md-2 fw-bold h6 mt-2 mb-3">Request Reason</label>
                            <div class="col-md-10">
                                <div class="form-group mb-3">
                                    <textarea name="request_reason" id="" cols="30" rows="5" required
                                            minlength="0" maxlength="300" class="form-control" style="resize: none;"></textarea>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold h6">Criteria</label><br>
                                <label class="fw-bold">1 - Below Expectation</label><br>
                                <label class="fw-bold">2 - Meets Expectation</label><br>
                                <label class="fw-bold">3 - Satisfactory</label><br>
                                <label class="fw-bold">4 - Exceeds Expectation</label><br>
                                <label class="fw-bold">5 - Outstanding</label>
                            </div>
                            <hr>

                            <div class="row mb-3">
                                <label for="jobrole_suitability" class="col-md-3 form-label fw-bold me-1">Jobrole Suitability</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input jobrole_suitability"
                                            type="radio"
                                            id="jobrole_suitability"
                                            name="jobrole_suitability"
                                            value="1"
                                            required="required">
                                        <label class="form-check-label" for="jobrole_suitability">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input jobrole_suitability"
                                            type="radio"
                                            id="jobrole_suitability"
                                            name="jobrole_suitability"
                                            value="2"
                                            required="required">
                                        <label class="form-check-label" for="jobrole_suitability">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input jobrole_suitability"
                                            type="radio"
                                            id="jobrole_suitability"
                                            name="jobrole_suitability"
                                            value="3"
                                            required="required">
                                        <label class="form-check-label" for="jobrole_suitability">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input jobrole_suitability"
                                            type="radio"
                                            id="jobrole_suitability"
                                            name="jobrole_suitability"
                                            value="4"
                                            required="required">
                                        <label class="form-check-label" for="jobrole_suitability">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input jobrole_suitability"
                                            type="radio"
                                            id="jobrole_suitability"
                                            name="jobrole_suitability"
                                            value="5"
                                            required="required">
                                        <label class="form-check-label" for="jobrole_suitability">5</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jobrole_suitability" class="col-md-3 form-label fw-bold me-1">Performance Accountability</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline ">
                                        <input class="form-check-input performance_accountability"
                                            type="radio"
                                            id="performance_accountability"
                                            name="performance_accountability"
                                            value="1"
                                            required="required">
                                        <label class="form-check-label" for="performance_accountability">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input performance_accountability"
                                            type="radio"
                                            id="performance_accountability"
                                            name="performance_accountability"
                                            value="2"
                                            required="required">
                                        <label class="form-check-label" for="performance_accountability">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input performance_accountability"
                                            type="radio"
                                            id="performance_accountability"
                                            name="performance_accountability"
                                            value="3"
                                            required="required">
                                        <label class="form-check-label" for="performance_accountability">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input performance_accountability"
                                            type="radio"
                                            id="performance_accountability"
                                            name="performance_accountability"
                                            value="4"
                                            required="required">
                                        <label class="form-check-label" for="performance_accountability">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input performance_accountability"
                                            type="radio"
                                            id="performance_accountability"
                                            name="performance_accountability"
                                            value="5"
                                            required="required">
                                        <label class="form-check-label" for="performance_accountability">5</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jobrole_suitability" class="col-md-3 form-label fw-bold me-1">Technological Readiness</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input technological_readiness"
                                            type="radio"
                                            id="technological_readiness"
                                            name="technological_readiness"
                                            value="1"
                                            required="required">
                                        <label class="form-check-label" for="technological_readiness">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input technological_readiness"
                                            type="radio"
                                            id="technological_readiness"
                                            name="technological_readiness"
                                            value="2"
                                            required="required">
                                        <label class="form-check-label" for="technological_readiness">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input technological_readiness"
                                            type="radio"
                                            id="technological_readiness"
                                            name="technological_readiness"
                                            value="3"
                                            required="required">
                                        <label class="form-check-label">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input technological_readiness"
                                            type="radio"
                                            id="technological_readiness"
                                            name="technological_readiness"
                                            value="4"
                                            required="required">
                                        <label class="form-check-label" for="technological_readiness">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input technological_readiness"
                                            type="radio"
                                            id="technological_readiness"
                                            name="technological_readiness"
                                            value="5"
                                            required="required">
                                        <label class="form-check-label" for="technological_readiness">5</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jobrole_suitability" class="col-md-3 form-label fw-bold me-1">Work Environment</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input work_environment"
                                            type="radio"
                                            id="work_environment"
                                            name="work_environment"
                                            value="1"
                                            required="required">
                                        <label class="form-check-label" for="work_environment">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input work_environment"
                                            type="radio"
                                            id="work_environment"
                                            name="work_environment"
                                            value="2"
                                            required="required">
                                        <label class="form-check-label" for="work_environment">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input work_environment"
                                            type="radio"
                                            id="work_environment"
                                            name="work_environment"
                                            value="3"
                                            required="required">
                                        <label class="form-check-label" for="work_environment">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input work_environment"
                                            type="radio"
                                            id="work_environment"
                                            name="work_environment"
                                            value="4"
                                            required="required">
                                        <label class="form-check-label" for="work_environment">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input work_environment"
                                            type="radio"
                                            id="work_environment"
                                            name="work_environment"
                                            value="5"
                                            required="required">
                                        <label class="form-check-label" for="work_environment">5</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jobrole_suitability" class="col-md-3 form-label fw-bold me-1">Communication Skills</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input communication_skills"
                                            type="radio"
                                            id="communication_skills"
                                            name="communication_skills"
                                            value="1"
                                            required="required">
                                        <label class="form-check-label" for="communication_skills">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input communication_skills"
                                            type="radio"
                                            id="communication_skills"
                                            name="communication_skills"
                                            value="2"
                                            required="required">
                                        <label class="form-check-label" for="communication_skills">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input communication_skills"
                                            type="radio"
                                            id="communication_skills"
                                            name="communication_skills"
                                            value="3"
                                            required="required">
                                        <label class="form-check-label" for="communication_skills">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input communication_skills"
                                            type="radio"
                                            id="communication_skills"
                                            name="communication_skills"
                                            value="4"
                                            required="required">
                                        <label class="form-check-label" for="communication_skills">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input communication_skills"
                                            type="radio"
                                            id="communication_skills"
                                            name="communication_skills"
                                            value="5"
                                            required="required">
                                        <label class="form-check-label" for="communication_skills">5</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jobrole_suitability" class="col-md-3 form-label fw-bold me-1">Flexibility Adaptability</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input flexibility_adaptability"
                                            type="radio"
                                            id="flexibility_adaptability"
                                            name="flexibility_adaptability"
                                            value="1"
                                            required="required">
                                        <label class="form-check-label" for="flexibility_adaptability">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input flexibility_adaptability"
                                            type="radio"
                                            id="flexibility_adaptability"
                                            name="flexibility_adaptability"
                                            value="2"
                                            required="required">
                                        <label class="form-check-label" for="flexibility_adaptability">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input flexibility_adaptability"
                                            type="radio"
                                            id="flexibility_adaptability"
                                            name="flexibility_adaptability"
                                            value="3"
                                            required="required">
                                        <label class="form-check-label" for="flexibility_adaptability">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input flexibility_adaptability"
                                            type="radio"
                                            id="flexibility_adaptability"
                                            name="flexibility_adaptability"
                                            value="4"
                                            required="required">
                                        <label class="form-check-label" for="flexibility_adaptability">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input flexibility_adaptability"
                                            type="radio"
                                            id="flexibility_adaptability"
                                            name="flexibility_adaptability"
                                            value="5"
                                            required="required">
                                        <label class="form-check-label" for="flexibility_adaptability">5</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jobrole_suitability" class="col-md-3 form-label fw-bold me-1">Health Wellbeing</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input health_wellbeing"
                                            type="radio"
                                            id="health_wellbeing"
                                            name="health_wellbeing"
                                            value="1"
                                            required="required">
                                        <label class="form-check-label" for="health_wellbeing">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input health_wellbeing"
                                            type="radio"
                                            id="health_wellbeing"
                                            name="health_wellbeing"
                                            value="2"
                                            required="required">
                                        <label class="form-check-label" for="health_wellbeing">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input health_wellbeing"
                                            type="radio"
                                            id="health_wellbeing"
                                            name="health_wellbeing"
                                            value="3"
                                            required="required">
                                        <label class="form-check-label" for="health_wellbeing">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input health_wellbeing"
                                            type="radio"
                                            id="health_wellbeing"
                                            name="health_wellbeing"
                                            value="4"
                                            required="required">
                                        <label class="form-check-label" for="health_wellbeing">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input health_wellbeing"
                                            type="radio"
                                            id="health_wellbeing"
                                            name="health_wellbeing"
                                            value="5"
                                            required="required">
                                        <label class="form-check-label" for="health_wellbeing">5</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jobrole_suitability" class="col-md-3 form-label fw-bold me-1">Organizational Needs</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input organizational_needs"
                                            type="radio"
                                            id="organizational_needs"
                                            name="organizational_needs"
                                            value="1"
                                            required="required">
                                        <label class="form-check-label" for="organizational_needs">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input organizational_needs"
                                            type="radio"
                                            id="organizational_needs"
                                            name="organizational_needs"
                                            value="2"
                                            required="required">
                                        <label class="form-check-label" for="organizational_needs">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input organizational_needs"
                                            type="radio"
                                            id="organizational_needs"
                                            name="organizational_needs"
                                            value="3"
                                            required="required">
                                        <label class="form-check-label" for="organizational_needs">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input organizational_needs"
                                            type="radio"
                                            id="organizational_needs"
                                            name="organizational_needs"
                                            value="4"
                                            required="required">
                                        <label class="form-check-label" for="organizational_needs">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input organizational_needs"
                                            type="radio"
                                            id="organizational_needs"
                                            name="organizational_needs"
                                            value="5"
                                            required="required">
                                        <label class="form-check-label" for="organizational_needs">5</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jobrole_suitability" class="col-md-3 form-label fw-bold me-1">Legal Compliance</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input legal_compliance"
                                            type="radio"
                                            id="legal_compliance"
                                            name="legal_compliance"
                                            value="1"
                                            required="required">
                                        <label class="form-check-label" for="legal_compliance">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input legal_compliance"
                                            type="radio"
                                            id="legal_compliance"
                                            name="legal_compliance"
                                            value="2"
                                            required="required">
                                        <label class="form-check-label" for="legal_compliance">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input legal_compliance"
                                            type="radio"
                                            id="legal_compliance"
                                            name="legal_compliance"
                                            value="3"
                                            required="required">
                                        <label class="form-check-label" for="legal_compliance">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input legal_compliance"
                                            type="radio"
                                            id="legal_compliance"
                                            name="legal_compliance"
                                            value="4"
                                            required="required">
                                        <label class="form-check-label" for="legal_compliance">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input legal_compliance"
                                            type="radio"
                                            id="legal_compliance"
                                            name="legal_compliance"
                                            value="5"
                                            required="required">
                                        <label class="form-check-label" for="legal_compliance">5</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="create" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="EditProjectModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="transferModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold " id="transferModalLabel">EDIT REQUEST</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('remote.request.update')  }}" method="post" enctype="multipart/form-data" class="was-validated">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="item_id" id="item_id">
                            <div class="row mb-3">
                            <div class="col-md-3 fw-bold h6 mt-2">Total Score</div>
                                <div class="col-md-9">
                                    <div class="mb-2 form-group">
                                        <input type="text" class="form-control" name="total_score" id="total_score" placeholder="Total Score" readonly>
                                    </div>
                                </div>
                            </div><hr>

                            <label class="col-md-2 fw-bold h6 mt-2 mb-3">Employee</label>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <input type="text" id="employee" class="form-control" readonly>
                                </div>
                            </div>

                            <label class="col-md-2 fw-bold h6 mt-2 mb-3">Request Date</label>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <input type="date" class="form-control" name="request_date" id="request_date" required>
                                </div>
                            </div>

                            <label class="col-md-2 fw-bold h6 mt-2 mb-3">Request Reason</label>
                            <div class="col-md-10">
                                <div class="form-group mb-3">
                                    <textarea name="request_reason" id="request_reason" cols="30" rows="5" required
                                            minlength="0" maxlength="300" class="form-control" style="resize: none;"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-bold h6">Criteria</label><br>
                                    <label class="fw-bold">1 - Below Expectation</label><br>
                                    <label class="fw-bold">2 - Meets Expectation</label><br>
                                    <label class="fw-bold">3 - Satisfactory</label><br>
                                    <label class="fw-bold">4 - Exceeds Expectation</label><br>
                                    <label class="fw-bold">5 - Outstanding</label>
                                </div>
                            </div>

                            <label class="col-md-2 fw-bold h6 mt-2">Status</label>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select class="form-select"
                                            name="status"
                                            aria-label="Floating label select example"
                                            required>
                                        <option value="Approved">Approved</option>
                                        <option value="For Reveiwing">For Reveiwing</option>
                                        <option value="Declined">Declined</option>
                                        <option value="Pending">Pending</option>
                                    </select>
                                </div>
                            </div>
                            <hr>

                            <div class="row mb-3">
                                <label for="jobrole_suitability" class="col-md-3 form-label fw-bold me-1">Jobrole Suitability</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input jobrole_suitability"
                                            type="radio"
                                            id="jobrole_suitability"
                                            name="jobrole_suitability"
                                            value="1"
                                            required="required">
                                        <label class="form-check-label" for="jobrole_suitability">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input jobrole_suitability"
                                            type="radio"
                                            id="jobrole_suitability"
                                            name="jobrole_suitability"
                                            value="2"
                                            required="required">
                                        <label class="form-check-label" for="jobrole_suitability">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input jobrole_suitability"
                                            type="radio"
                                            id="jobrole_suitability"
                                            name="jobrole_suitability"
                                            value="3"
                                            required="required">
                                        <label class="form-check-label" for="jobrole_suitability">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input jobrole_suitability"
                                            type="radio"
                                            id="jobrole_suitability"
                                            name="jobrole_suitability"
                                            value="4"
                                            required="required">
                                        <label class="form-check-label" for="jobrole_suitability">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input jobrole_suitability"
                                            type="radio"
                                            id="jobrole_suitability"
                                            name="jobrole_suitability"
                                            value="5"
                                            required="required">
                                        <label class="form-check-label" for="jobrole_suitability">5</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jobrole_suitability" class="col-md-3 form-label fw-bold me-1">Performance Accountability</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline ">
                                        <input class="form-check-input performance_accountability"
                                            type="radio"
                                            id="performance_accountability"
                                            name="performance_accountability"
                                            value="1"
                                            required="required">
                                        <label class="form-check-label" for="performance_accountability">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input performance_accountability"
                                            type="radio"
                                            id="performance_accountability"
                                            name="performance_accountability"
                                            value="2"
                                            required="required">
                                        <label class="form-check-label" for="performance_accountability">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input performance_accountability"
                                            type="radio"
                                            id="performance_accountability"
                                            name="performance_accountability"
                                            value="3"
                                            required="required">
                                        <label class="form-check-label" for="performance_accountability">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input performance_accountability"
                                            type="radio"
                                            id="performance_accountability"
                                            name="performance_accountability"
                                            value="4"
                                            required="required">
                                        <label class="form-check-label" for="performance_accountability">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input performance_accountability"
                                            type="radio"
                                            id="performance_accountability"
                                            name="performance_accountability"
                                            value="5"
                                            required="required">
                                        <label class="form-check-label" for="performance_accountability">5</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jobrole_suitability" class="col-md-3 form-label fw-bold me-1">Technological Readiness</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input technological_readiness"
                                            type="radio"
                                            id="technological_readiness"
                                            name="technological_readiness"
                                            value="1"
                                            required="required">
                                        <label class="form-check-label" for="technological_readiness">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input technological_readiness"
                                            type="radio"
                                            id="technological_readiness"
                                            name="technological_readiness"
                                            value="2"
                                            required="required">
                                        <label class="form-check-label" for="technological_readiness">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input technological_readiness"
                                            type="radio"
                                            id="technological_readiness"
                                            name="technological_readiness"
                                            value="3"
                                            required="required">
                                        <label class="form-check-label" for="technological_readiness">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input technological_readiness"
                                            type="radio"
                                            id="technological_readiness"
                                            name="technological_readiness"
                                            value="4"
                                            required="required">
                                        <label class="form-check-label" for="technological_readiness">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input technological_readiness"
                                            type="radio"
                                            id="technological_readiness"
                                            name="technological_readiness"
                                            value="5"
                                            required="required">
                                        <label class="form-check-label" for="technological_readiness">5</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jobrole_suitability" class="col-md-3 form-label fw-bold me-1">Work Environment</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input work_environment"
                                            type="radio"
                                            id="work_environment"
                                            name="work_environment"
                                            value="1"
                                            required="required">
                                        <label class="form-check-label" for="work_environment">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input work_environment"
                                            type="radio"
                                            id="work_environment"
                                            name="work_environment"
                                            value="2"
                                            required="required">
                                        <label class="form-check-label" for="work_environment">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input work_environment"
                                            type="radio"
                                            id="work_environment"
                                            name="work_environment"
                                            value="3"
                                            required="required">
                                        <label class="form-check-label" for="work_environment">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input work_environment"
                                            type="radio"
                                            id="work_environment"
                                            name="work_environment"
                                            value="4"
                                            required="required">
                                        <label class="form-check-label" for="work_environment">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input work_environment"
                                            type="radio"
                                            id="work_environment"
                                            name="work_environment"
                                            value="5"
                                            required="required">
                                        <label class="form-check-label" for="work_environment">5</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jobrole_suitability" class="col-md-3 form-label fw-bold me-1">Communication Skills</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input communication_skills"
                                            type="radio"
                                            id="communication_skills"
                                            name="communication_skills"
                                            value="1"
                                            required="required">
                                        <label class="form-check-label" for="communication_skills">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input communication_skills"
                                            type="radio"
                                            id="communication_skills"
                                            name="communication_skills"
                                            value="2"
                                            required="required">
                                        <label class="form-check-label" for="communication_skills">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input communication_skills"
                                            type="radio"
                                            id="communication_skills"
                                            name="communication_skills"
                                            value="3"
                                            required="required">
                                        <label class="form-check-label" for="communication_skills">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input communication_skills"
                                            type="radio"
                                            id="communication_skills"
                                            name="communication_skills"
                                            value="4"
                                            required="required">
                                        <label class="form-check-label" for="communication_skills">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input communication_skills"
                                            type="radio"
                                            id="communication_skills"
                                            name="communication_skills"
                                            value="5"
                                            required="required">
                                        <label class="form-check-label" for="communication_skills">5</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jobrole_suitability" class="col-md-3 form-label fw-bold me-1">Flexibility Adaptability</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input flexibility_adaptability"
                                            type="radio"
                                            id="flexibility_adaptability"
                                            name="flexibility_adaptability"
                                            value="1"
                                            required="required">
                                        <label class="form-check-label" for="flexibility_adaptability">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input flexibility_adaptability"
                                            type="radio"
                                            id="flexibility_adaptability"
                                            name="flexibility_adaptability"
                                            value="2"
                                            required="required">
                                        <label class="form-check-label" for="flexibility_adaptability">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input flexibility_adaptability"
                                            type="radio"
                                            id="flexibility_adaptability"
                                            name="flexibility_adaptability"
                                            value="3"
                                            required="required">
                                        <label class="form-check-label" for="flexibility_adaptability">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input flexibility_adaptability"
                                            type="radio"
                                            id="flexibility_adaptability"
                                            name="flexibility_adaptability"
                                            value="4"
                                            required="required">
                                        <label class="form-check-label" for="flexibility_adaptability">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input flexibility_adaptability"
                                            type="radio"
                                            id="flexibility_adaptability"
                                            name="flexibility_adaptability"
                                            value="5"
                                            required="required">
                                        <label class="form-check-label" for="flexibility_adaptability">5</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jobrole_suitability" class="col-md-3 form-label fw-bold me-1">Health Wellbeing</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input health_wellbeing"
                                            type="radio"
                                            id="health_wellbeing"
                                            name="health_wellbeing"
                                            value="1"
                                            required="required">
                                        <label class="form-check-label" for="health_wellbeing">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input health_wellbeing"
                                            type="radio"
                                            id="health_wellbeing"
                                            name="health_wellbeing"
                                            value="2"
                                            required="required">
                                        <label class="form-check-label" for="health_wellbeing">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input health_wellbeing"
                                            type="radio"
                                            id="health_wellbeing"
                                            name="health_wellbeing"
                                            value="3"
                                            required="required">
                                        <label class="form-check-label" for="health_wellbeing">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input health_wellbeing"
                                            type="radio"
                                            id="health_wellbeing"
                                            name="health_wellbeing"
                                            value="4"
                                            required="required">
                                        <label class="form-check-label" for="health_wellbeing">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input health_wellbeing"
                                            type="radio"
                                            id="health_wellbeing"
                                            name="health_wellbeing"
                                            value="5"
                                            required="required">
                                        <label class="form-check-label" for="health_wellbeing">5</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jobrole_suitability" class="col-md-3 form-label fw-bold me-1">Organizational Needs</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input organizational_needs"
                                            type="radio"
                                            id="organizational_needs"
                                            name="organizational_needs"
                                            value="1"
                                            required="required">
                                        <label class="form-check-label" for="organizational_needs">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input organizational_needs"
                                            type="radio"
                                            id="organizational_needs"
                                            name="organizational_needs"
                                            value="2"
                                            required="required">
                                        <label class="form-check-label" for="organizational_needs">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input organizational_needs"
                                            type="radio"
                                            id="organizational_needs"
                                            name="organizational_needs"
                                            value="3"
                                            required="required">
                                        <label class="form-check-label" for="organizational_needs">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input organizational_needs"
                                            type="radio"
                                            id="organizational_needs"
                                            name="organizational_needs"
                                            value="4"
                                            required="required">
                                        <label class="form-check-label" for="organizational_needs">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input organizational_needs"
                                            type="radio"
                                            id="organizational_needs"
                                            name="organizational_needs"
                                            value="5"
                                            required="required">
                                        <label class="form-check-label" for="organizational_needs">5</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jobrole_suitability" class="col-md-3 form-label fw-bold me-1">Legal Compliance</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input legal_compliance"
                                            type="radio"
                                            id="legal_compliance"
                                            name="legal_compliance"
                                            value="1"
                                            required="required">
                                        <label class="form-check-label" for="legal_compliance">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input legal_compliance"
                                            type="radio"
                                            id="legal_compliance"
                                            name="legal_compliance"
                                            value="2"
                                            required="required">
                                        <label class="form-check-label" for="legal_compliance">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input legal_compliance"
                                            type="radio"
                                            id="legal_compliance"
                                            name="legal_compliance"
                                            value="3"
                                            required="required">
                                        <label class="form-check-label" for="legal_compliance">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input legal_compliance"
                                            type="radio"
                                            id="legal_compliance"
                                            name="legal_compliance"
                                            value="4"
                                            required="required">
                                        <label class="form-check-label" for="legal_compliance">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input legal_compliance"
                                            type="radio"
                                            id="legal_compliance"
                                            name="legal_compliance"
                                            value="5"
                                            required="required">
                                        <label class="form-check-label" for="legal_compliance">5</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="create" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
    </div>

    <div class="modal fade" id="viewProjectModal" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="transferModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold " id="transferModalLabel">VIEW REQUEST</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" enctype="multipart/form-data" class="was-validated">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="item_id" id="item_id">
                            <div class="row mb-3">
                            <div class="col-md-3 fw-bold h6 mt-2">Total Score</div>
                                <div class="col-md-9">
                                    <div class="mb-2 form-group">
                                        <input type="text" class="form-control" name="total_score" id="view_total_score" placeholder="Total Score" readonly>
                                    </div>
                                </div>
                            </div><hr>

                            <label class="col-md-2 fw-bold h6 mt-2 mb-3">Employee</label>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <input type="text" id="view_employee" class="form-control" readonly>
                                </div>
                            </div>

                            <label class="col-md-2 fw-bold h6 mt-2 mb-3">Request Date</label>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="request_date" id="view_request_date" readonly>
                                </div>
                            </div>

                            <label class="col-md-2 fw-bold h6 mt-2 mb-3">Request Reason</label>
                            <div class="col-md-10">
                                <div class="form-group mb-3">
                                    <textarea name="request_reason" id="view_request_reason" cols="30" rows="5" readonly
                                            minlength="0" maxlength="300" class="form-control" style="resize: none;"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="fw-bold h6">Criteria</label><br>
                                    <label class="fw-bold">1 - Below Expectation</label><br>
                                    <label class="fw-bold">2 - Meets Expectation</label><br>
                                    <label class="fw-bold">3 - Satisfactory</label><br>
                                    <label class="fw-bold">4 - Exceeds Expectation</label><br>
                                    <label class="fw-bold">5 - Outstanding</label>
                                </div>
                            </div>

                            <label class="col-md-2 fw-bold h6 mt-2">Status</label>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select class="form-select"
                                            id="view_status"
                                            name="status"
                                            aria-label="Floating label select example"
                                            disabled>
                                        <option value="Approved">Approved</option>
                                        <option value="For Reveiwing">For Reveiwing</option>
                                        <option value="Declined">Declined</option>
                                        <option value="Pending">Pending</option>
                                    </select>
                                </div>
                            </div>
                            <hr>

                            <div class="row mb-3">
                                <label for="jobrole_suitability" class="col-md-3 form-label fw-bold me-1">Jobrole Suitability</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input jobrole_suitability"
                                            type="radio"
                                            id="jobrole_suitability"
                                            name="jobrole_suitability"
                                            value="1"
                                            disabled>
                                        <label class="form-check-label" for="jobrole_suitability">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input jobrole_suitability"
                                            type="radio"
                                            id="jobrole_suitability"
                                            name="jobrole_suitability"
                                            value="2"
                                            disabled>
                                        <label class="form-check-label" for="jobrole_suitability">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input jobrole_suitability"
                                            type="radio"
                                            id="jobrole_suitability"
                                            name="jobrole_suitability"
                                            value="3"
                                            disabled>
                                        <label class="form-check-label" for="jobrole_suitability">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input jobrole_suitability"
                                            type="radio"
                                            id="jobrole_suitability"
                                            name="jobrole_suitability"
                                            value="4"
                                            disabled>
                                        <label class="form-check-label" for="jobrole_suitability">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input jobrole_suitability"
                                            type="radio"
                                            id="jobrole_suitability"
                                            name="jobrole_suitability"
                                            value="5"
                                            disabled>
                                        <label class="form-check-label" for="jobrole_suitability">5</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jobrole_suitability" class="col-md-3 form-label fw-bold me-1">Performance Accountability</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline ">
                                        <input class="form-check-input performance_accountability"
                                            type="radio"
                                            id="performance_accountability"
                                            name="performance_accountability"
                                            value="1"
                                            disabled>
                                        <label class="form-check-label" for="performance_accountability">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input performance_accountability"
                                            type="radio"
                                            id="performance_accountability"
                                            name="performance_accountability"
                                            value="2"
                                            disabled>
                                        <label class="form-check-label" for="performance_accountability">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input performance_accountability"
                                            type="radio"
                                            id="performance_accountability"
                                            name="performance_accountability"
                                            value="3"
                                            disabled>
                                        <label class="form-check-label" for="performance_accountability">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input performance_accountability"
                                            type="radio"
                                            id="performance_accountability"
                                            name="performance_accountability"
                                            value="4"
                                            disabled>
                                        <label class="form-check-label" for="performance_accountability">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input performance_accountability"
                                            type="radio"
                                            id="performance_accountability"
                                            name="performance_accountability"
                                            value="5"
                                            disabled>
                                        <label class="form-check-label" for="performance_accountability">5</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jobrole_suitability" class="col-md-3 form-label fw-bold me-1">Technological Readiness</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input technological_readiness"
                                            type="radio"
                                            id="technological_readiness"
                                            name="technological_readiness"
                                            value="1"
                                            disabled>
                                        <label class="form-check-label" for="technological_readiness">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input technological_readiness"
                                            type="radio"
                                            id="technological_readiness"
                                            name="technological_readiness"
                                            value="2"
                                            disabled>
                                        <label class="form-check-label" for="technological_readiness">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input technological_readiness"
                                            type="radio"
                                            id="technological_readiness"
                                            name="technological_readiness"
                                            value="3"
                                            disabled>
                                        <label class="form-check-label" for="technological_readiness">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input technological_readiness"
                                            type="radio"
                                            id="technological_readiness"
                                            name="technological_readiness"
                                            value="4"
                                            disabled>
                                        <label class="form-check-label" for="technological_readiness">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input technological_readiness"
                                            type="radio"
                                            id="technological_readiness"
                                            name="technological_readiness"
                                            value="5"
                                            disabled>
                                        <label class="form-check-label" for="technological_readiness">5</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jobrole_suitability" class="col-md-3 form-label fw-bold me-1">Work Environment</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input work_environment"
                                            type="radio"
                                            id="work_environment"
                                            name="work_environment"
                                            value="1"
                                            disabled>
                                        <label class="form-check-label" for="work_environment">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input work_environment"
                                            type="radio"
                                            id="work_environment"
                                            name="work_environment"
                                            value="2"
                                            disabled>
                                        <label class="form-check-label" for="work_environment">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input work_environment"
                                            type="radio"
                                            id="work_environment"
                                            name="work_environment"
                                            value="3"
                                            disabled>
                                        <label class="form-check-label" for="work_environment">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input work_environment"
                                            type="radio"
                                            id="work_environment"
                                            name="work_environment"
                                            value="4"
                                            disabled>
                                        <label class="form-check-label" for="work_environment">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input work_environment"
                                            type="radio"
                                            id="work_environment"
                                            name="work_environment"
                                            value="5"
                                            disabled>
                                        <label class="form-check-label" for="work_environment">5</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jobrole_suitability" class="col-md-3 form-label fw-bold me-1">Communication Skills</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input communication_skills"
                                            type="radio"
                                            id="communication_skills"
                                            name="communication_skills"
                                            value="1"
                                            disabled>
                                        <label class="form-check-label" for="communication_skills">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input communication_skills"
                                            type="radio"
                                            id="communication_skills"
                                            name="communication_skills"
                                            value="2"
                                            disabled>
                                        <label class="form-check-label" for="communication_skills">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input communication_skills"
                                            type="radio"
                                            id="communication_skills"
                                            name="communication_skills"
                                            value="3"
                                            disabled>
                                        <label class="form-check-label" for="communication_skills">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input communication_skills"
                                            type="radio"
                                            id="communication_skills"
                                            name="communication_skills"
                                            value="4"
                                            disabled>
                                        <label class="form-check-label" for="communication_skills">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input communication_skills"
                                            type="radio"
                                            id="communication_skills"
                                            name="communication_skills"
                                            value="5"
                                            disabled>
                                        <label class="form-check-label" for="communication_skills">5</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jobrole_suitability" class="col-md-3 form-label fw-bold me-1">Flexibility Adaptability</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input flexibility_adaptability"
                                            type="radio"
                                            id="flexibility_adaptability"
                                            name="flexibility_adaptability"
                                            value="1"
                                            disabled>
                                        <label class="form-check-label" for="flexibility_adaptability">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input flexibility_adaptability"
                                            type="radio"
                                            id="flexibility_adaptability"
                                            name="flexibility_adaptability"
                                            value="2"
                                            disabled>
                                        <label class="form-check-label" for="flexibility_adaptability">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input flexibility_adaptability"
                                            type="radio"
                                            id="flexibility_adaptability"
                                            name="flexibility_adaptability"
                                            value="3"
                                            disabled>
                                        <label class="form-check-label" for="flexibility_adaptability">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input flexibility_adaptability"
                                            type="radio"
                                            id="flexibility_adaptability"
                                            name="flexibility_adaptability"
                                            value="4"
                                            disabled>
                                        <label class="form-check-label" for="flexibility_adaptability">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input flexibility_adaptability"
                                            type="radio"
                                            id="flexibility_adaptability"
                                            name="flexibility_adaptability"
                                            value="5"
                                            disabled>
                                        <label class="form-check-label" for="flexibility_adaptability">5</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jobrole_suitability" class="col-md-3 form-label fw-bold me-1">Health Wellbeing</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input health_wellbeing"
                                            type="radio"
                                            id="health_wellbeing"
                                            name="health_wellbeing"
                                            value="1"
                                            disabled>
                                        <label class="form-check-label" for="health_wellbeing">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input health_wellbeing"
                                            type="radio"
                                            id="health_wellbeing"
                                            name="health_wellbeing"
                                            value="2"
                                            disabled>
                                        <label class="form-check-label" for="health_wellbeing">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input health_wellbeing"
                                            type="radio"
                                            id="health_wellbeing"
                                            name="health_wellbeing"
                                            value="3"
                                            disabled>
                                        <label class="form-check-label" for="health_wellbeing">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input health_wellbeing"
                                            type="radio"
                                            id="health_wellbeing"
                                            name="health_wellbeing"
                                            value="4"
                                            disabled>
                                        <label class="form-check-label" for="health_wellbeing">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input health_wellbeing"
                                            type="radio"
                                            id="health_wellbeing"
                                            name="health_wellbeing"
                                            value="5"
                                            disabled>
                                        <label class="form-check-label" for="health_wellbeing">5</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jobrole_suitability" class="col-md-3 form-label fw-bold me-1">Organizational Needs</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input organizational_needs"
                                            type="radio"
                                            id="organizational_needs"
                                            name="organizational_needs"
                                            value="1"
                                            disabled>
                                        <label class="form-check-label" for="organizational_needs">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input organizational_needs"
                                            type="radio"
                                            id="organizational_needs"
                                            name="organizational_needs"
                                            value="2"
                                            disabled>
                                        <label class="form-check-label" for="organizational_needs">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input organizational_needs"
                                            type="radio"
                                            id="organizational_needs"
                                            name="organizational_needs"
                                            value="3"
                                            disabled>
                                        <label class="form-check-label" for="organizational_needs">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input organizational_needs"
                                            type="radio"
                                            id="organizational_needs"
                                            name="organizational_needs"
                                            value="4"
                                            disabled>
                                        <label class="form-check-label" for="organizational_needs">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input organizational_needs"
                                            type="radio"
                                            id="organizational_needs"
                                            name="organizational_needs"
                                            value="5"
                                            disabled>
                                        <label class="form-check-label" for="organizational_needs">5</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="jobrole_suitability" class="col-md-3 form-label fw-bold me-1">Legal Compliance</label>
                                <div class="col-md-8">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input legal_compliance"
                                            type="radio"
                                            id="legal_compliance"
                                            name="legal_compliance"
                                            value="1"
                                            disabled>
                                        <label class="form-check-label" for="legal_compliance">1</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input legal_compliance"
                                            type="radio"
                                            id="legal_compliance"
                                            name="legal_compliance"
                                            value="2"
                                            disabled>
                                        <label class="form-check-label" for="legal_compliance">2</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input legal_compliance"
                                            type="radio"
                                            id="legal_compliance"
                                            name="legal_compliance"
                                            value="3"
                                            disabled>
                                        <label class="form-check-label" for="legal_compliance">3</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input legal_compliance"
                                            type="radio"
                                            id="legal_compliance"
                                            name="legal_compliance"
                                            value="4"
                                            disabled>
                                        <label class="form-check-label" for="legal_compliance">4</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input legal_compliance"
                                            type="radio"
                                            id="legal_compliance"
                                            name="legal_compliance"
                                            value="5"
                                            disabled>
                                        <label class="form-check-label" for="legal_compliance">5</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
    </div>

    <script>
        $(document).ready(function() {
            // When the selection changes
            $('select[name="employee_id"]').change(function() {
                // Get the selected employee's ID
                var selectedEmployeeID = $(this).val();
                // Set the value of the input field
                $('#getEmployeeID').val(selectedEmployeeID);
            });
        });

        $(document).ready(function() {
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

            function updateTotalScore() {
                var totalScoreUpdate = 0;
                $('.jobrole_suitability:checked').each(function() { totalScoreUpdate += parseInt($(this).val()); });
                $('.performance_accountability:checked').each(function() { totalScoreUpdate += parseInt($(this).val()); });
                $('.technological_readiness:checked').each(function() { totalScoreUpdate += parseInt($(this).val()); });
                $('.work_environment:checked').each(function() { totalScoreUpdate += parseInt($(this).val()); });
                $('.communication_skills:checked').each(function() { totalScoreUpdate += parseInt($(this).val()); });
                $('.flexibility_adaptability:checked').each(function() { totalScoreUpdate += parseInt($(this).val()); });
                $('.health_wellbeing:checked').each(function() { totalScoreUpdate += parseInt($(this).val()); });
                $('.organizational_needs:checked').each(function() { totalScoreUpdate += parseInt($(this).val()); });
                $('.legal_compliance:checked').each(function() { totalScoreUpdate += parseInt($(this).val()); });

                // Update the value of the total score input field
                $('#total_score').val(totalScoreUpdate);
            }

            // Attach change event listener to all relevant radio buttons
            $('.jobrole_suitability, .performance_accountability, .technological_readiness, .work_environment, .communication_skills, .flexibility_adaptability, .health_wellbeing, .organizational_needs, .legal_compliance').change(function() {
                // Call updateTotalScore function whenever any relevant radio button is clicked
                updateTotalScore();
            });

            $('.view-request').on('click', function(e) {
                e.preventDefault();
                var itemID = $(this).data('id');

                var url = "/EmployeeTracking/remote/request/get/" + itemID;

                $.get(url, function(data) {
                    var firstname = data.employee.first_name;
                    var lastname = data.employee.last_name;
                    var middlename = data.employee.middle_name;
                    var fullname = lastname + ', ' + firstname + ' ' + middlename;

                    $('#view_employee').val(fullname);

                    $('#view_request_reason').val(data.request_reason);
                    $('#view_request_date').val(formatDate(data.request_date));
                    $('#view_total_score').val(data.total_score);
                    $('.jobrole_suitability').filter(function() {
                        return $(this).val() == data.jobrole_suitability;
                    }).prop('checked', true);

                    $('.performance_accountability').filter(function() {
                        return $(this).val() == data.performance_accountability;
                    }).prop('checked', true);

                    $('.technological_readiness').filter(function() {
                        return $(this).val() == data.technological_readiness;
                    }).prop('checked', true);

                    $('.communication_skills').filter(function() {
                        return $(this).val() == data.communication_skills;
                    }).prop('checked', true);

                    $('.work_environment').filter(function() {
                        return $(this).val() == data.work_environment;
                    }).prop('checked', true);

                    $('.flexibility_adaptability').filter(function() {
                        return $(this).val() == data.flexibility_adaptability;
                    }).prop('checked', true);

                    $('.health_wellbeing').filter(function() {
                        return $(this).val() == data.health_wellbeing;
                    }).prop('checked', true);

                    $('.organizational_needs').filter(function() {
                        return $(this).val() == data.organizational_needs;
                    }).prop('checked', true);

                    $('.legal_compliance').filter(function() {
                        return $(this).val() == data.legal_compliance;
                    }).prop('checked', true);

                    $('#view_status').val(data.status);

                    $('#viewProjectModal').modal('show');
                });

                function formatDate(rawDate) {
                    var options = {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                    };
                    return new Date(rawDate).toLocaleDateString('en-US', options);
                }
            });

            $('.edit-request').on('click', function(e) {
                e.preventDefault();
                var itemID = $(this).data('id');


                var url = "/EmployeeTracking/remote/request/get/" + itemID;

                $.get(url, function(data) {
                    console.log(data);
                    $('#item_id').val(data.id);

                    var firstname = data.employee.first_name;
                    var lastname = data.employee.last_name;
                    var middlename = data.employee.middle_name;
                    var fullname = lastname + ', ' + firstname + ' ' + middlename;

                    $('#employee').val(fullname);

                    $('#request_reason').val(data.request_reason);
                    $('#request_date').val(data.request_date);
                    $('#total_score').val(data.total_score);
                    $('.jobrole_suitability').filter(function() {
                        return $(this).val() == data.jobrole_suitability;
                    }).prop('checked', true);

                    $('.performance_accountability').filter(function() {
                        return $(this).val() == data.performance_accountability;
                    }).prop('checked', true);

                    $('.technological_readiness').filter(function() {
                        return $(this).val() == data.technological_readiness;
                    }).prop('checked', true);

                    $('.communication_skills').filter(function() {
                        return $(this).val() == data.communication_skills;
                    }).prop('checked', true);

                    $('.work_environment').filter(function() {
                        return $(this).val() == data.work_environment;
                    }).prop('checked', true);

                    $('.flexibility_adaptability').filter(function() {
                        return $(this).val() == data.flexibility_adaptability;
                    }).prop('checked', true);

                    $('.health_wellbeing').filter(function() {
                        return $(this).val() == data.health_wellbeing;
                    }).prop('checked', true);

                    $('.organizational_needs').filter(function() {
                        return $(this).val() == data.organizational_needs;
                    }).prop('checked', true);

                    $('.legal_compliance').filter(function() {
                        return $(this).val() == data.legal_compliance;
                    }).prop('checked', true);

                    $('#status').val(data.status);

                    $('#EditProjectModal').modal('show');
                });

                function formatDate(rawDate) {
                    var options = {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: 'numeric',
                        minute: 'numeric'
                    };
                    return new Date(rawDate).toLocaleDateString('en-US', options);
                }
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
