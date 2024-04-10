@extends('layouts.master')
@section('content')

<div class="content">

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


    <!-- Fading entrances -->
    <div class="mb-3">
        <h5 class="mb-0 text-uppercase fw-bold">
            Meetings
        </h5>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="text-end mb-3">
                <a href="#" data-bs-toggle="modal" data-bs-target="#createProjectModal"
                    class="btn btn-primary" style="background-color: #0056b3; border-color: #0056b3;">
                    <i class="fas fa-plus-circle me-2"></i> Create Meeting
                </a>
            </div>
            <table class="table datatableDisplay">
                <thead>
                    <tr>
                        <th style="width: 20%;">Title</th>
                        <th style="width: 18%;">Meeting Date</th>
                        <th style="width: 17%;">Start Date / End Date</th>
                        <th style="width: 28%;">Description</th>
                        <th style="width: 7%;">Status</th>
                        <th style="width: 10%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($meetings as $item)
                        <tr>
                            <td>{{ $item->title }}</td>
                            <td>{{ date('F j, Y', strtotime($item->meeting_date)) }}</td>
                            <td>
                                {{ date('F j, Y', strtotime($item->date_start)) }} -
                                {{ date('F j, Y', strtotime($item->date_end)) }}
                            </td>
                            <td>{{ $item->description }}</td>

                            <td>
                                @php
                                    $status = $item->status;
                                    $badge_class = '';

                                    switch ($status) {
                                        case 'Approved':
                                            $badge_class = 'bg-success';
                                            break;
                                        case 'Declined':
                                            $badge_class = 'bg-danger';
                                            break;
                                        case 'Pending':
                                            $badge_class = 'bg-warning';
                                            break;
                                    }
                                    @endphp
                                <span class="badge <?php echo $badge_class; ?>"><?php echo $status; ?></span>
                            </td>
                            <td>
                                {{-- <a href="#"
                                    data-bs-toggle="modal" data-bs-target="#viewProjectModal{{ $item->id }}" title="View Project"
                                    class="fw-bold h6 text-info"> <i class="ph ph-eye"></i>
                                </a>

                                <div class="modal fade" id="viewProjectModal{{ $item->id }}" data-bs-backdrop="static" tabindex="-1" role="dialog"
                                    aria-labelledby="transferModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold " id="transferModalLabel">VIEW MEETINGS</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="#" method="post" enctype="multipart/form-data">
                                                    <div class="row">

                                                        <div class="row mb-3">
                                                        <div class="col-md-3 fw-bold h6 mt-2">Project Name</div>
                                                            <div class="col-md-9">
                                                                <div class="mb-2 form-group">
                                                                    <input type="text" class="form-control" name="title" value="{{ $item->title }}" placeholder="Project Name" disabled>
                                                                </div>
                                                            </div>
                                                        </div><hr>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="fw-bold h6 mt-2">Date Start</label>
                                                                <input type="text" name="date_start" class="form-control" placeholder="Address" value="{{ $item->date_start ? \Carbon\Carbon::parse($item->date_start)->format('F j, Y - h:i A') : '' }}" disabled>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 mb-2">
                                                            <div class="form-group">
                                                                <label class="fw-bold h6 mt-2">Date End</label>
                                                                <input type="text" name="date_end" class="form-control" placeholder="Address" value="{{ $item->date_end ? \Carbon\Carbon::parse($item->date_end)->format('F j, Y - h:i A') : '' }}" disabled>
                                                            </div>
                                                        </div>


                                                        <label class="col-md-2 fw-bold h6 mt-2">Progress</label>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <input type="number" min="0" max="100" name="progress" value="{{ $item->progress }}" class="form-control" placeholder="Progress" disabled>
                                                            </div>
                                                        </div>

                                                        <label class="col-md-2 fw-bold h6 mt-2">Status</label>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                    <select class="form-select"
                                                                    name="status"
                                                                    aria-label="Floating label select example"
                                                                    disabled>

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
                                                                      rows="5" style="resize: none;" disabled>{{ $item->description }}</textarea>
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
                                </div> --}}


                                <a href="#"
                                    data-bs-toggle="modal" data-bs-target="#editProjectModal{{ $item->id }}" title="View Project"
                                    class="fw-bold h6 text-warning">  <i class="ph ph-pen"></i>
                                </a>

                                <div class="modal fade" id="editProjectModal{{ $item->id }}" data-bs-backdrop="static" tabindex="-1" role="dialog"
                                    aria-labelledby="transferModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold " id="transferModalLabel">UPDATE MEETING</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('remote.meetings.update')  }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                                        <div class="col-md-3 fw-bold h6 mt-2">Title</div>
                                                            <div class="col-md-9">
                                                                <div class="mb-2 form-group">
                                                                    <input type="text" class="form-control" name="title" value="{{ $item->title }}" placeholder="Title" required>
                                                                </div>
                                                            </div>

                                                        <div class="col-md-3 fw-bold h6 mt-2">Organizer ID</div>
                                                            <div class="col-md-9">
                                                                <div class="mb-2 form-group">
                                                                    <input type="text" class="form-control" name="organizer_id" value="{{ $item->organizer_id }}" placeholder="Organizer ID" required>
                                                                </div>
                                                            </div>

                                                        <div class="col-md-3 fw-bold h6 mt-2">Meeting Date</div>
                                                            <div class="col-md-9">
                                                                <div class="mb-2 form-group">
                                                                    <input type="datetime-local" class="form-control" value="{{ $item->meeting_date }}" name="meeting_date" placeholder="Project Name" required>
                                                                </div>
                                                            </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                    <label class="fw-bold h6 mt-2">Date Start</label>
                                                                    <input type="datetime-local" name="date_start" value="{{ $item->date_start }}" class="form-control" placeholder="Address">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 mb-2">
                                                            <div class="form-group">
                                                                    <label class="fw-bold h6 mt-2">Date End</label>
                                                                    <input type="datetime-local" name="date_end" value="{{ $item->date_end }}" class="form-control" placeholder="Address">
                                                            </div>
                                                        </div>

                                                        <label class="col-md-2 fw-bold h6 mt-2">Location</label>
                                                        <div class="col-md-10">
                                                            <div class="form-group">
                                                                <input type="text" name="location" value="{{ $item->location }}" class="form-control" placeholder="Location">
                                                            </div>
                                                        </div>

                                                        <label class="col-md-2 fw-bold h6 mt-2">Meeting Links</label>
                                                        <div class="col-md-10">
                                                            <div class="form-group">
                                                                <input type="url" name="meeting_links" value="{{ $item->meeting_link }}" class="form-control" placeholder="Meeting Links">
                                                            </div>
                                                        </div>

                                                        <label class="col-md-2 fw-bold h6 mt-2 mb-3">Description</label>
                                                        <div class="col-md-10">
                                                            <div class="form-group mb-3">
                                                            <textarea name="description" id="" cols="30" minlength="0" placeholder="Enter Description"
                                                                    maxlength="300" class="form-control" rows="4" style="resize: none;">{{ $item->description }}</textarea>
                                                            </div>
                                                        </div>

                                                        <label class="col-md-2 fw-bold h6 mt-2 mb-3">Attendies</label>
                                                        <div class="col-md-10">
                                                            <div class="form-group mb-3">
                                                            <textarea name="attendies" id="" cols="30" minlength="0" maxlength="300" placeholder="Enter Attendies"
                                                                    class="form-control" rows="4" style="resize: none;">{{ $item->attendies }}</textarea>
                                                            </div>
                                                        </div>

                                                        <label class="col-md-2 fw-bold h6 mt-2">Status</label>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <select class="form-select"
                                                                        name="status"
                                                                        aria-label="Floating label select example"
                                                                        required>
                                                                    <option value="Approved" {{ $item->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                                                    <option value="Pending" {{ $item->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                                    <option value="Declined" {{ $item->status == 'Declined' ? 'selected' : '' }}>Declined</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" name="create_meeting" class="btn btn-success">Update</button>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
{{--
                                <div class="modal fade" id="editProjectModal{{ $item->id }}" data-bs-backdrop="static" tabindex="-1" role="dialog"
                                    aria-labelledby="transferModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title fw-bold " id="transferModalLabel">EDIT MEETINGS</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{  route('remote.meetings.update')  }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                                                        <div class="row mb-3">
                                                        <div class="col-md-3 fw-bold h6 mt-2">Project Name</div>
                                                            <div class="col-md-9">
                                                                <div class="mb-2 form-group">
                                                                    <input type="text" class="form-control" name="title" value="{{ $item->title }}" placeholder="Project Name">
                                                                </div>
                                                            </div>
                                                        </div><hr>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                    <label class="fw-bold h6 mt-2">Date Start</label>
                                                                    <input type="datetime-local" name="date_start" value="{{ $item->date_start }}" class="form-control" placeholder="Address">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 mb-2">
                                                            <div class="form-group">
                                                                    <label class="fw-bold h6 mt-2">Date End</label>
                                                                    <input type="datetime-local" name="date_end" value="{{ $item->date_end }}" class="form-control" placeholder="Address">
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
                                                                    <option value="Approved" {{ $item->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                                                    <option value="Pending" {{ $item->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                                    <option value="Declined" {{ $item->status == 'Declined' ? 'selected' : '' }}>Declined</option>
                                                                </select>
                                                            </div>
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
                                                        <button type="submit" class="btn btn-success">Update</button>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}



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
                    <h5 class="modal-title fw-bold " id="transferModalLabel">CREATE MEETING</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{  route('remote.meetings.store')  }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="item_id">
                            <div class="col-md-3 fw-bold h6 mt-2">Title</div>
                                <div class="col-md-9">
                                    <div class="mb-2 form-group">
                                        <input type="text" class="form-control" name="title" placeholder="Title" required>
                                    </div>
                                </div>

                            <div class="col-md-3 fw-bold h6 mt-2">Organizer ID</div>
                                <div class="col-md-9">
                                    <div class="mb-2 form-group">
                                        <input type="text" class="form-control" name="organizer_id" placeholder="Organizer ID" required>
                                    </div>
                                </div>

                            <div class="col-md-3 fw-bold h6 mt-2">Meeting Date</div>
                                <div class="col-md-9">
                                    <div class="mb-2 form-group">
                                        <input type="datetime-local" class="form-control" name="meeting_date" placeholder="Project Name" required>
                                    </div>
                                </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                        <label class="fw-bold h6 mt-2">Date Start</label>
                                        <input type="datetime-local" name="date_start" class="form-control" placeholder="Address">
                                </div>
                            </div>

                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                        <label class="fw-bold h6 mt-2">Date End</label>
                                        <input type="datetime-local" name="date_end" class="form-control" placeholder="Address">
                                </div>
                            </div>

                            <label class="col-md-2 fw-bold h6 mt-2">Location</label>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <input type="text" name="location" class="form-control" placeholder="Location">
                                </div>
                            </div>

                            <label class="col-md-2 fw-bold h6 mt-2">Meeting Links</label>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <input type="url" name="meeting_links" class="form-control" placeholder="Meeting Links">
                                </div>
                            </div>

                            <label class="col-md-2 fw-bold h6 mt-2 mb-3">Description</label>
                            <div class="col-md-10">
                                <div class="form-group mb-3">
                                <textarea name="description" id="" cols="30" minlength="0" placeholder="Enter Description"
                                        maxlength="300" class="form-control" rows="4" style="resize: none;"></textarea>
                                </div>
                            </div>

                            <label class="col-md-2 fw-bold h6 mt-2 mb-3">Attendies</label>
                            <div class="col-md-10">
                                <div class="form-group mb-3">
                                <textarea name="attendies" id="" cols="30" minlength="0" maxlength="300" placeholder="Enter Attendies"
                                        class="form-control" rows="4" style="resize: none;"></textarea>
                                </div>
                            </div>

                            <label class="col-md-2 fw-bold h6 mt-2 mb-3">Status</label>
                            <div class="col-md-10">
                                <div class="form-group mb-3">
                                    <input type="text" class="form-control" value="Pending" disabled>
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
