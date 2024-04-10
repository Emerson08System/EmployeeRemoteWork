@extends('layouts.master')
@section('css')
<link href="{{URL::asset('assets/css/p.min.css')}}" rel="stylesheet" type="text/css">
@endsection
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
            Tasks
        </h5>
    </div>


    <div class="card">
        <div class="card-body">

            <div class="text-end mb-3">
                <a href="#" data-bs-toggle="modal" data-bs-target="#createProjectModal"
                    class="btn btn-primary" style="background-color: #0056b3; border-color: #0056b3;">
                    <i class="fas fa-plus-circle me-2"></i> Create Task
                </a>
            </div>

            <table class="table datatableDisplay">
                <thead>
                    <tr>
                        <th style="width: 20%;">Project Name</th>
                        <th style="width: 15%;">Employee</th>
                        <th style="width: 15%;">Task Name</th>
                        <th style="width: 30%;">Description</th>
                        <th style="width: 5%;">Progress</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 5%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $item)
                        <tr>
                            <td>{{ $item->Projects->project_name }}</td>
                            <td>{{ $item->Employee->last_name }}, {{ $item->Employee->first_name }} {{ $item->Employee->middle_name }}</td>
                            <td>{{ $item->task_name }}</td>
                            <td>{{ $item->description }}</td>
                            <td>
                                {{ $item->task_progress }} %
                            </td>

                            <td>
                                @php
                                $status = $item->task_status;
                                $badge_class = '';

                                switch ($status) {
                                    case 'Open':
                                        $badge_class = 'bg-primary';
                                        break;
                                    case 'OnProgress':
                                        $badge_class = 'bg-info';
                                        break;
                                    case 'Overdue':
                                        $badge_class = 'bg-danger';
                                        break;
                                    case 'Completed':
                                        $badge_class = 'bg-success';
                                        break;
                                    default:
                                        // Handle any other status
                                        break;
                                }
                                @endphp
                                <span class="badge <?php echo $badge_class; ?>"><?php echo $status; ?></span>
                            </td>
                            <td>
                                <a href="#"
                                    data-bs-toggle="modal" data-bs-target="#ViewProjectModal{{ $item->id }}" title="View Task"
                                    class="fw-bold h6 text-info"> <i class="ph ph-eye"></i>
                                </a>

                                <div class="modal fade" id="ViewProjectModal{{ $item->id }}" data-bs-backdrop="static" tabindex="-1" role="dialog"
                                    aria-labelledby="transferModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold " id="transferModalLabel">EDIT TASK</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="#" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                                        <div class="row mb-3">
                                                        <div class="col-md-3 fw-bold h6 mt-2">Project Name</div>
                                                            <div class="col-md-9">
                                                                <div class="mb-2 form-group">
                                                                    <input type="text" class="form-control"  value="{{ $item->Projects->project_name }}" name="project_name" placeholder="Project Name" disabled>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <hr>
                                                        <div class="row mb-3">
                                                        <div class="col-md-3 fw-bold h6 mt-2">Employee</div>
                                                            <div class="col-md-9">
                                                                <div class="mb-2 form-group">
                                                                    <input type="text" value="{{ $item->Employee->last_name }}, {{ $item->Employee->first_name }} {{ $item->Employee->middle_name }}" class="form-control" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                    <label class="fw-bold h6 mt-2">Task Name</label>
                                                                    <input type="text" name="task_name" value="{{ $item->task_name }}" class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 mb-2">
                                                            <div class="form-group">
                                                                    <label class="fw-bold h6 mt-2">Due Date</label>
                                                                    <input type="date" name="due_date" value="{{ $item->due_date }}" class="form-control">
                                                            </div>
                                                        </div>

                                                        <label class="col-md-2 fw-bold h6 mt-2">Progress</label>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <input type="number" min="0" max="100" value="{{ $item->task_progress }}" name="task_progress" class="form-control" placeholder="Progress">
                                                            </div>
                                                        </div>

                                                        <label class="col-md-2 fw-bold h6 mt-2">Status</label>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                            <select class="form-select"
                                                                    name="task_status"
                                                                    aria-label="Floating label select example"
                                                                    required>
                                                                    <option value="Open" <?php if ($item['task_status'] == 'Open') echo 'selected'; ?>>Open</option>
                                                                    <option value="OnProgress" <?php if ($item['task_status'] == 'OnProgress') echo 'selected'; ?>>OnProgress</option>
                                                                    <option value="Overdue" <?php if ($item['task_status'] == 'Overdue') echo 'selected'; ?>>Overdue</option>
                                                                    <option value="Completed" <?php if ($item['task_status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                                                            </select>
                                                            </div>
                                                        </div>

                                                        <label class="col-md-2 fw-bold h6 mt-2 mb-3">Description</label>
                                                        <div class="col-md-10">
                                                            <div class="form-group mb-3">
                                                            <textarea name="description" id="" cols="30" class="form-control"
                                                                    rows="5" style="resize: none;"><?php echo $item['description'];?>
                                                            </textarea>
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
                                </div>

                                <a href="#"
                                    data-bs-toggle="modal" data-bs-target="#EditProjectModal{{ $item->id }}" title="Edit Task"
                                    class="fw-bold h6 text-warning"> <i class="ph ph-pencil"></i>
                                </a>

                                <div class="modal fade" id="EditProjectModal{{ $item->id }}" data-bs-backdrop="static" tabindex="-1" role="dialog"
                                    aria-labelledby="transferModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold " id="transferModalLabel">EDIT TASK</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('remote.task.update')  }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                                        <div class="row mb-3">
                                                        <div class="col-md-3 fw-bold h6 mt-2">Project Name</div>
                                                            <div class="col-md-9">
                                                                <div class="mb-2 form-group">
                                                                    <input type="text" class="form-control"  value="{{ $item->Projects->project_name }}" name="project_name" placeholder="Project Name" disabled>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <hr>
                                                        <div class="row mb-3">
                                                        <div class="col-md-3 fw-bold h6 mt-2">Employee</div>
                                                            <div class="col-md-9">
                                                                <div class="mb-2 form-group">
                                                                    <input type="text" value="{{ $item->Employee->last_name }}, {{ $item->Employee->first_name }} {{ $item->Employee->middle_name }}" class="form-control" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                    <label class="fw-bold h6 mt-2">Task Name</label>
                                                                    <input type="text" name="task_name" value="{{ $item->task_name }}" class="form-control">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 mb-2">
                                                            <div class="form-group">
                                                                    <label class="fw-bold h6 mt-2">Due Date</label>
                                                                    <input type="date" name="due_date" value="{{ $item->due_date }}" class="form-control">
                                                            </div>
                                                        </div>

                                                        <label class="col-md-2 fw-bold h6 mt-2">Progress</label>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <input type="number" min="0" max="100" value="{{ $item->task_progress }}" name="task_progress" class="form-control" placeholder="Progress">
                                                            </div>
                                                        </div>

                                                        <label class="col-md-2 fw-bold h6 mt-2">Status</label>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                            <select class="form-select"
                                                                    name="task_status"
                                                                    aria-label="Floating label select example"
                                                                    required>
                                                                    <option value="Open" <?php if ($item['task_status'] == 'Open') echo 'selected'; ?>>Open</option>
                                                                    <option value="OnProgress" <?php if ($item['task_status'] == 'OnProgress') echo 'selected'; ?>>OnProgress</option>
                                                                    <option value="Overdue" <?php if ($item['task_status'] == 'Overdue') echo 'selected'; ?>>Overdue</option>
                                                                    <option value="Completed" <?php if ($item['task_status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                                                            </select>
                                                            </div>
                                                        </div>

                                                        <label class="col-md-2 fw-bold h6 mt-2 mb-3">Description</label>
                                                        <div class="col-md-10">
                                                            <div class="form-group mb-3">
                                                            <textarea name="description" id="" cols="30" class="form-control"
                                                                      rows="5" style="resize: none;"><?php echo $item['description'];?>
                                                            </textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" name="edit_task" class="btn btn-success">Update</button>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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
                    <h5 class="modal-title fw-bold " id="transferModalLabel">CREATE TASK</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('remote.task.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="item_id">
                            <div class="row mb-3">
                            <div class="col-md-3 fw-bold h6 mt-2">Project Name</div>
                                <div class="col-md-9">
                                    <div class="mb-2 form-group">
                                        <select class="form-control selectpicker" name="project_id" required>
                                            <option value="0" selected disabled>Select Project</option>
                                            @foreach ($projects as $project)
                                                <option value="{{ $project->id }}">{{ $project->project_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <hr>
                            <div class="row mb-3">
                            <div class="col-md-3 fw-bold h6 mt-2">Employee</div>
                                <div class="col-md-9">
                                    <div class="mb-2 form-group">
                                    <select class="form-select" name="employee_id" required>
                                        <option value="0" selected disabled>Select Employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->last_name .', '. $employee->first_name}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="col-md-6">
                                <div class="form-group">
                                        <label class="fw-bold h6 mt-2">Task Name</label>
                                        <input type="text" name="task_name" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                        <label class="fw-bold h6 mt-2">Due Date</label>
                                        <input type="date" name="due_date"  class="form-control">
                                </div>
                            </div>

                            <label class="col-md-2 fw-bold h6 mt-2">Progress</label>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="number" min="0" max="100" name="task_progress" class="form-control" placeholder="Progress">
                                </div>
                            </div>

                            <label class="col-md-2 fw-bold h6 mt-2">Status</label>
                            <div class="col-md-4">
                                <div class="form-group">
                                <select class="form-select"
                                        name="task_status"
                                        aria-label="Floating label select example"
                                        required>
                                        <option value="Open">Open</option>
                                        <option value="OnProgress">OnProgress</option>
                                        <option value="Overdue">Overdue</option>
                                        <option value="Complete">Complete</option>
                                </select>
                                </div>
                            </div>

                            <label class="col-md-2 fw-bold h6 mt-2 mb-3">Description</label>
                            <div class="col-md-10">
                                <div class="form-group mb-3">
                                <textarea name="description" id="" cols="30" class="form-control"
                                            rows="5" style="resize: none;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="create_task" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
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
