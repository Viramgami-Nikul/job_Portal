@extends('front.layouts.app')

@section('main')

    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Account Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3">
                    @include('front.accout.sidebar')
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    @include('front.message')

                    <div class="card border-0 shadow mb-4 p-3">
                        <div class="card-body card-form">
                            <div class="d-flex justify-content-between">
                                <h3 class="fs-4 mb-1">
                                    @if (Auth::user()->role === 'employer')
                                        Job Applications Received
                                    @else
                                        Jobs Applied
                                    @endif
                                </h3>
                            </div>

                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">Applied Date</th>
                                            <th scope="col">
                                                @if (Auth::user()->role === 'employer')
                                                    Applicants
                                                @else
                                                    Status
                                                @endif
                                            </th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-0">
                                        @if ($jobApplications->isNotEmpty())
                                            @foreach ($jobApplications as $jobApplication)
                                                <tr class="active">
                                                    <td>
                                                        <div class="job-name fw-500">{{ $jobApplication->job->title }}</div>
                                                        <div class="info1">{{ $jobApplication->job->jobType->name }} ·
                                                            {{ $jobApplication->job->location }}</div>

                                                        {{-- @if (Auth::user()->role !== 'employer') --}}
                                                            <div class="applicant-name text-muted-boled">Applied by:
                                                                {{ $jobApplication->user->name }}</div><br>
                                                                {{ $jobApplication->user->email }}</div><br>
                                                        {{-- @endif --}}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($jobApplication->applied_date)->format('d M, Y') }}
                                                    </td>
                                                    <td>
                                                        @if (Auth::user()->role === 'employer')
                                                            {{ $jobApplication->job->applications->count() }} Applicants
                                                        @else
                                                            @if ($jobApplication->job->status == 1)
                                                                <div class="job-status text-success text-capitalize">Active
                                                                </div>
                                                            @else
                                                                <div class="job-status text-danger text-capitalize">Blocked
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="action-dots float-end">
                                                            <button class="btn" data-bs-toggle="dropdown"
                                                                aria-expanded="false">
                                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('jobDetail', $jobApplication->job_id) }}">
                                                                        <i class="fa fa-eye" aria-hidden="true"></i> View
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a class="dropdown-item" href="#"
                                                                        onclick="removeJob({{ $jobApplication->id }})">
                                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                                        Remove
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" class="text-center">No job applications found.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div>
                                {{ $jobApplications->links() }}
                            </div>
                        </div>
                    </div>

                </div> <!-- End Main Content -->
            </div>
        </div>
    </section>

@endsection

@section('customJs')
    <script type="text/javascript">
        function removeJob(id) {
            if (confirm("Are you sure you want to remove this job application?")) {
                $.ajax({
                    url: '{{ route('accout.removeJobs') }}',
                    type: 'POST',
                    data: {
                        id: id,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            alert("Job application removed successfully!");
                            location.reload();
                        } else {
                            alert("Error: " + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Something went wrong. Check console for details.");
                        console.log(xhr.responseText);
                    }
                });
            }
        }
    </script>
@endsection
