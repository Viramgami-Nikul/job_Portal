@extends('front.layouts.app')

@section('main')

<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
              @include('admin.sidebar')
            </div>
            <div class="col-lg-9">
              @include('front.message')

                <div class="card border-0 shadow mb-4">
                      
                <div class="card-body card-form">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fs-4 mb-1">Users</h3>
                            </div>
                            <div style="margin-top: -10px;">
                            </div>
                            
                        </div>
                        <div class="table-responsive">
                            <table class="table ">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Role</th>
                                    
                                        <th scope="col">Mobile</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @if($users->isNotEmpty())

                                    @foreach($users as $user)
                                    
                                    <tr class="active">
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            <div class="job-name fw-500">{{ $user->name }}</div>
                                
                                        </td>


                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <select class="role-selector form-select" data-user-id="{{ $user->id }}">
                                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                                <option value="employer" {{ $user->role == 'employer' ? 'selected' : '' }}>Employer</option>
                                            </select>
                                        </td>
                                        
                                        
                                        <td>{{ $user->mobile }}</td>
                                        
                                        <td>
                                            <div class="action-dots">
                                                <button href="#" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                          </button>
                                                <ul class="dropdown-menu dropdown-menu-end">

                                                    <li><a class="dropdown-item" href="{{ route('admin.users.edit',$user->id) }}"><i class="fa fa-edit" aria-hidden="true"></i> Edit</a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="deleteUser({{ $user->id }})"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                     @endforeach
                                    @endif
                                  
                              
                                </tbody>
                                
                            </table>
                        </div>
                        <div>
                            <!-- when use the paginate function in controller then that time use the links method -->
                            {{ $users->links() }}
                        </div>
                    </div>
                
                </div>

                       
            </div>
        </div>
    </div>
</section>

@endsection

@section('customJs')

{{-- <script type="text/javascript">

    function deleteUser(id){
    
        if(confirm("Are you sure you want to delete?")){


            $.ajax({

                 url: '{{ route("admin.users.destroy") }}',
                 type: 'delete',
                 data: {id:id},
                 dataType: 'json',
                 success: function(response){

                    if(response.status){

                        location.reload();
                    }
                    else{
                        location.reload();
                    }
     


            }

           });
        }
      
    }



</script> --}}
<script type="text/javascript">
    $(document).ready(function() {
        // Function to change user role dynamically
        $('.role-selector').change(function() {
            var userId = $(this).data('user-id');
            var newRole = $(this).val();

            $.ajax({
                url: '{{ route("admin.users.updateRole") }}', // Ensure this route is defined
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: userId,
                    role: newRole
                },
                success: function(response) {
                    if (response.status) {
                        alert('User role updated successfully!');
                    } else {
                        alert('Failed to update role. Please try again.');
                    }
                },
                error: function() {
                    alert('An error occurred. Please try again.');
                }
            });
        });

        // Function to delete a user
        window.deleteUser = function(id) {
            if (confirm("Are you sure you want to delete this user?")) {
                $.ajax({
                    url: '{{ route("admin.users.destroy") }}',
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            alert("User deleted successfully!");
                            location.reload();
                        } else {
                            alert("Failed to delete user.");
                        }
                    },
                    error: function() {
                        alert("An error occurred while deleting the user.");
                    }
                });
            }
        };
    });
</script>



@endsection