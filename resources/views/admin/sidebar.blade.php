<!-- sidebar for the admin  -->
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<div class="card account-nav border-0 shadow mb-4 mb-lg-0">
    <div class="card-body p-0">
        <ul class="list-group list-group-flush ">
            <li class="list-group-item d-flex justify-content-between p-3">
                <a href="{{ route('admin.users') }}" class="d-flex align-items-center">
                    <i class='bx bxs-user fs-5'></i>
                    <span class="ms-3 fs-6">Users</span>
                </a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('admin.jobs') }}" class="d-flex align-items-center">
                    <i class='bx bxs-briefcase-alt-2 fs-5'></i>
                    <span class="ms-3 fs-6">Jobs</span>
                </a>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('admin.jobApplication') }}" class="d-flex align-items-center">
                    <i class='bx bxs-receipt fs-5'></i>
                    <span class="ms-3 fs-6"> Job Applications</span>
                </a>
            </li>

            <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                <a href="{{ route('admin.logout') }}" class="d-flex align-items-center">
                    <i class='bx bx-arrow-to-left fs-5'></i>
                    <span class="ms-3 fs-6">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>
