@extends('layouts.master')
@section('content')

<div class="content">

    <!-- Fading entrances -->
    <div class="mb-3">
        <h5 class="mb-0 text-uppercase fw-bold">
            Projects
        </h5>
    </div>

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


    <div class="card">
        <div class="card-body">
            <div class="text-end mb-3">
                <a href="#" data-bs-toggle="modal" data-bs-target="#createProjectModal"
                    class="btn btn-primary" style="background-color: #0056b3; border-color: #0056b3;">
                    <i class="fas fa-plus-circle me-2"></i> Create Project
                </a>
            </div>
            <table class="table datatableDisplay">
                <thead>
                    <tr>
                        <th style="width: 20%;">Project Name</th>
                        <th style="width: 25%;">Description</th>
                        <th style="width: 10%;">Date Start</th>
                        <th style="width: 10%;">Date End</th>
                        <th style="width: 20%;">Progress</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 5%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($projects as $item)
                        <tr>
                            <td>{{ $item->project_name }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ date('F j, Y', strtotime($item->date_start)) }}</td>
                            <td>{{ date('F j, Y', strtotime($item->date_end)) }}</td>
                            <td>
                                {{ $item->progress }} %
                                <div class="progress-bar">
                                    <div class="progress" style="width: {{ $item->progress }}%;"></div>
                                </div>
                            </td>

                            <td>
                                @php
                                $status = $item->status;
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
                                    case 'Complete':
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
                                    data-bs-toggle="modal" data-bs-target="#viewProjectModal{{ $item->id }}" title="View Project"
                                    class="fw-bold h6 text-info"> <i class="ph ph-eye"></i>
                                </a>

                                <div class="modal fade" id="viewProjectModal{{ $item->id }}" data-bs-backdrop="static" tabindex="-1" role="dialog"
                                    aria-labelledby="transferModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold " id="transferModalLabel">VIEW PROJECT</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="#" method="post" enctype="multipart/form-data">
                                                    <div class="row">
                                                        <input type="hidden" name="item_id">
                                                        <div class="row mb-3">
                                                        <div class="col-md-3 fw-bold h6 mt-2">Project Name</div>
                                                            <div class="col-md-9">
                                                                <div class="mb-2 form-group">
                                                                    <input type="text" class="form-control" name="project_name" value="{{ $item->project_name }}" placeholder="Project Name" required>
                                                                </div>
                                                            </div>
                                                        </div><hr>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                    <label class="fw-bold h6 mt-2">Date Start</label>
                                                                    <input type="date" name="date_start" value="{{ $item->date_start }}" class="form-control" placeholder="Address">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 mb-2">
                                                            <div class="form-group">
                                                                    <label class="fw-bold h6 mt-2">Date End</label>
                                                                    <input type="date" name="date_end" value="{{ $item->date_end }}" class="form-control" placeholder="Address">
                                                            </div>
                                                        </div>

                                                        <label class="col-md-2 fw-bold h6 mt-2">Progress</label>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <input type="number" min="0" max="100" name="progress" value="{{ $item->progress }}" class="form-control" placeholder="Progress">
                                                            </div>
                                                        </div>

                                                        <label class="col-md-2 fw-bold h6 mt-2">Status</label>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                    <select class="form-select"
                                                                    name="status"
                                                                    aria-label="Floating label select example"
                                                                    required>

                                                                <option value="Open" {{ $item->status == 'Open' ? 'selected' : '' }}>Open</option>
                                                                <option value="OnProgress" {{ $item->status == 'OnProgress' ? 'selected' : '' }}>OnProgress</option>
                                                                <option value="Overdue" {{ $item->status == 'Overdue' ? 'selected' : '' }}>Overdue</option>
                                                                <option value="Complete" {{ $item->status == 'Complete' ? 'selected' : '' }}>Complete</option>
                                                            </select>

                                                            </div>
                                                        </div>

                                                        <label class="col-md-2 fw-bold h6 mt-2 mb-3">Description</label>
                                                        <div class="col-md-10">
                                                            <div class="form-group mb-3">
                                                            <textarea name="description" id="" cols="30" class="form-control"
                                                                      rows="5" style="resize: none;">{{ $item->description }}</textarea>
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
                                    data-bs-toggle="modal" data-bs-target="#editProjectModal{{ $item->id }}" title="View Project"
                                    class="fw-bold h6 text-warning">  <i class="ph ph-pen"></i>
                                </a>

                                <div class="modal fade" id="editProjectModal{{ $item->id }}" data-bs-backdrop="static" tabindex="-1" role="dialog"
                                    aria-labelledby="transferModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold " id="transferModalLabel">EDIT PROJECT</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{  route('remote.projects.update')  }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                                        <div class="row mb-3">
                                                        <div class="col-md-3 fw-bold h6 mt-2">Project Name</div>
                                                            <div class="col-md-9">
                                                                <div class="mb-2 form-group">
                                                                    <input type="text" class="form-control" name="project_name" value="{{ $item->project_name }}" placeholder="Project Name" required>
                                                                </div>
                                                            </div>
                                                        </div><hr>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                    <label class="fw-bold h6 mt-2">Date Start</label>
                                                                    <input type="date" name="date_start" value="{{ $item->date_start }}" class="form-control" placeholder="Address">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 mb-2">
                                                            <div class="form-group">
                                                                    <label class="fw-bold h6 mt-2">Date End</label>
                                                                    <input type="date" name="date_end" value="{{ $item->date_end }}" class="form-control" placeholder="Address">
                                                            </div>
                                                        </div>

                                                        <label class="col-md-2 fw-bold h6 mt-2">Progress</label>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <input type="number" min="0" max="100" name="progress" value="{{ $item->progress }}" class="form-control" placeholder="Progress">
                                                            </div>
                                                        </div>

                                                        <label class="col-md-2 fw-bold h6 mt-2">Status</label>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                    <select class="form-select"
                                                                    name="status"
                                                                    aria-label="Floating label select example"
                                                                    required>

                                                                <option value="Open" {{ $item->status == 'Open' ? 'selected' : '' }}>Open</option>
                                                                <option value="OnProgress" {{ $item->status == 'OnProgress' ? 'selected' : '' }}>OnProgress</option>
                                                                <option value="Overdue" {{ $item->status == 'Overdue' ? 'selected' : '' }}>Overdue</option>
                                                                <option value="Complete" {{ $item->status == 'Complete' ? 'selected' : '' }}>Complete</option>
                                                            </select>

                                                            </div>
                                                        </div>

                                                        <label class="col-md-2 fw-bold h6 mt-2 mb-3">Description</label>
                                                        <div class="col-md-10">
                                                            <div class="form-group mb-3">
                                                            <textarea name="description" id="" cols="30" class="form-control"
                                                                      rows="5" style="resize: none;">{{ $item->description }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" name="create_project" class="btn btn-success">Update</button>
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
                    <h5 class="modal-title fw-bold " id="transferModalLabel">CREATE PROJECT</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{  route('remote.projects.store')  }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="row mb-3">
                            <div class="col-md-3 fw-bold h6 mt-2">Project Name</div>
                                <div class="col-md-9">
                                    <div class="mb-2 form-group">
                                        <input type="text" class="form-control" name="project_name" placeholder="Project Name" required>
                                    </div>
                                </div>
                            </div><hr>

                            <div class="col-md-6">
                                <div class="form-group">
                                        <label class="fw-bold h6 mt-2">Date Start</label>
                                        <input type="date" name="date_start" class="form-control" placeholder="Address">
                                </div>
                            </div>

                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                        <label class="fw-bold h6 mt-2">Date End</label>
                                        <input type="date" name="date_end" class="form-control" placeholder="Address">
                                </div>
                            </div>

                            <label class="col-md-2 fw-bold h6 mt-2">Progress</label>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="number" min="0" max="100" name="progress" class="form-control" placeholder="Progress">
                                </div>
                            </div>

                            <label class="col-md-2 fw-bold h6 mt-2">Status</label>
                            <div class="col-md-4">
                                <div class="form-group">
                                <select class="form-select"
                                        name="status"
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
                                <textarea name="description" id="" cols="30" class="form-control" rows="5" style="resize: none;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="create_project" class="btn btn-primary">Submit</button>
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
