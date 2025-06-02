<!-- comman sidebar part of profile using include file -->
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<div class="card border-0 shadow mb-4 p-3">
    <div class="s-body text-center mt-3">

        <!-- display the profile picture -->
        @if (Auth::user()->image != '')
            <!-- if upload pic then show the image -->
            <img src="{{ asset('profile_pic/thumb/' . Auth::user()->image) }}" alt="avatar"
                class="rounded-circle img-fluid" style="width: 150px;">
        @else
            <img src="{{ asset('assets/images/avatar7.png') }}" alt="avatar" class="rounded-circle img-fluid"
                style="width: 150px;">
        @endif
        <h5 class="mt-3 pb-0">{{ Auth::user()->name }}</h5>
        <p class="text-muted mb-1 fs-6">{{ Auth::user()->designation }}</p>
        <div class="d-flex justify-content-center mb-2">
            <button data-bs-toggle="modal" data-bs-target="#exampleModal" type="button" class="btn btn-primary">Change
                Profile Picture</button>
        </div>
    </div>
</div>
<div class="card account-nav border-0 shadow mb-4 mb-lg-0">
    <div class="card-body p-0">
        <ul class="list-group list-group-flush ">
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">

                <a href="{{ route('accout.profile') }}" class="d-flex align-items-center">
                    <i class='bx bxs-user-account fs-5'></i>
                    {{-- <i class='bx bxs-account fs-5'></i> --}}
                    <span class="ms-3 fs-6">Account Settings</span>
                </a>

            </li>
            <!-- Show only for Employers -->
            @if (Auth::user()->role === 'employer')
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <a href="{{ route('accout.createJob') }}" class="d-flex align-items-center">
                        <i class='bx bx-import fs-5'></i>
                        <span class="ms-3 fs-6">Post a Job</span>
                    </a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <a href="{{ route('accout.myJobs') }}" class="d-flex align-items-center">
                        <i class='bx bxs-user-badge fs-5'></i>
                        <span class="ms-3 fs-6">My Jobs</span>
                    </a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <a href="{{ route('accout.myJobApplications') }}" class="d-flex align-items-center">
                        <i class='bx bxs-receipt fs-5'></i>
                        <span class="ms-3 fs-6">Jobs Applied</span>
                    </a>
                </li>
            @endif

            @if (Auth::user()->role === 'user')
               
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <a href="{{ route('accout.savedJobs') }}" class="d-flex align-items-center">
                        <i class='bx bxs-save fs-5'></i>
                        <span class="ms-3 fs-6">Saved Jobs</span>
                    </a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                    <a href="{{ route('accout.myJobApplications') }}" class="d-flex align-items-center">
                        <i class='bx bxs-receipt fs-5'></i>
                        <span class="ms-3 fs-6">Jobs Applied</span>
                    </a>
                </li>
            @endif
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('accout.logout') }}" class="d-flex align-items-center">
                    <i class='bx bx-arrow-to-left fs-5'></i>
                    <span class="ms-3 fs-6">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>




