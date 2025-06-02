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
            <div class="col-lg-3">
                @include('front.accout.sidebar')
            </div>
            <div class="col-lg-9">
                @include('front.message')

                <div class="card border-0 shadow mb-4">
                    <form id="userForm" method="post">
                        <div class="card-body p-4">
                            <h3 class="fs-4 mb-1">My Profile</h3>
                            <div class="mb-4">
                                <label class="mb-2">Name*</label>
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                            </div>
                            <div class="mb-4">
                                <label class="mb-2">Email*</label>
                                <input type="text" name="email" class="form-control" value="{{ $user->email }}">
                            </div>
                            <div class="mb-4">
                                <label class="mb-2">Designation</label>
                                <input type="text" name="designation" class="form-control" value="{{ $user->designation }}">
                            </div>
                            <div class="mb-4">
                                <label class="mb-2">Mobile</label>
                                <input type="text" name="mobile" class="form-control" value="{{ $user->mobile }}">
                            </div>                        
                        </div>
                        <div class="card-footer p-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>

                
                <div class="card border-0 shadow mb-4">
                    <form id="changePasswordForm" method="post">
                        <div class="card-body p-4">
                            <h3 class="fs-4 mb-1">Change Password</h3>
                            <div class="mb-4">
                                <label class="mb-2">Old Password*</label>
                                <input type="password" name="old_password" class="form-control">
                            </div>
                            <div class="mb-4">
                                <label class="mb-2">New Password*</label>
                                <input type="password" name="new_password" class="form-control">
                            </div>
                            <div class="mb-4">
                                <label class="mb-2">Confirm Password*</label>
                                <input type="password" name="confirm_password" class="form-control">
                            </div>                        
                        </div>
                        <div class="card-footer p-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>          
            </div>
        </div>
    </div>
</section>
@endsection
{{-- @if(Auth::user()->role === 'employer')
    <div class="d-flex justify-content-end mb-4">
        <a class="btn btn-primary me-2" href="{{ route('accout.createJob') }}">Post a Job</a>
        {{-- <a class="btn btn-secondary" href="{{ route('accout.myJobs') }}">My Jobs</a> --}}
    </div>
{{-- @endif --}}


@section('customJs')
<script type="text/javascript">

$("#userForm").submit(function(e){
 //not reload the page using this method  
 e.preventDefault();
   
 $.ajax({
    url:'{{ route("accout.updateProfile") }}',
    type:'put',
    dataType: 'json',
    //full form submit
    data: $("#userForm").serializeArray(),
     
    success:function(response){
        if(response.status == true){

            //properly update then remove the error and reset the button update profile
            $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
            $("#email").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
  
            window.location.href="{{ route('accout.profile' )}}";
        
        }

        else{
            //updateprofile error show
            var errors= response.errors;

            if(errors.name){
                $("#name").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.name)
              }

             else{
                $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
             }
              if(errors.email){
                $("#email").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.email)
              }

             else{
                $("#email").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')

             }
        }
    }

 });

});


//change password using ajax
$("#changePasswordForm").submit(function(e){
 //not reload the page using this method  
 e.preventDefault();
   
 $.ajax({
    url:'{{ route("accout.updatePassword") }}',
    type:'post',
    dataType: 'json',
    //full form submit
    data: $("#changePasswordForm").serializeArray(),
     
    success:function(response){
        if(response.status == true){

            //properly update then remove the error and reset the button update profile
            $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
            $("#email").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
  
            window.location.href="{{ route('accout.profile' )}}";
        
        }

        else{
            //updateprofile error show
            var errors= response.errors;

            if(errors.old_password){
                $("#old_password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.old_password)
              }

             else{
                $("#old_password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
             }
              if(errors.new_password){
                $("#new_password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.new_password)
              }

             else{
                $("#new_password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')

             }
              if(errors.confirm_password){
                $("#confirm_password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.confirm_password)
              }

             else{
                $("#confirm_password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')

             }
        }
    }

 });

});

</script>

@endsection