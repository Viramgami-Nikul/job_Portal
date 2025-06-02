<!DOCTYPE html>
<html class="no-js" lang="en_AU" />
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>ONUS | Find Best Jobs</title>
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />
	<meta name="HandheldFriendly" content="True" />
	<meta name="pinterest" content="nopin" />
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/ui/trumbowyg.min.css" />
	
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css')  }}" />
	<!-- Fav Icon -->
	<link rel="shortcut icon" type="image/x-icon" href="#" />
</head>
<body data-instant-intensity="mousedown">
<header>
	<nav class="navbar navbar-expand-lg navbar-light bg-white shadow py-3">
		<div class="container">
			<a class="navbar-brand" href="{{ route('home') }}">O N U S</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ms-0 ms-sm-0 me-auto mb-2 mb-lg-0 ms-lg-4">
					<li class="nav-item">
						<a class="nav-link" aria-current="page" href="{{ route('home') }}">Home</a>
					</li>	
					<li class="nav-item">
						<a class="nav-link" aria-current="page" href="{{ route('jobs') }}">Find Jobs</a>
					</li>										
				</ul>				

                {{-- <a class="btn btn-outline-primary me-2" href="{{ route('admin.dashboard' )}}" type="submit">Admin</a> --}}
                <a class="btn btn-outline-primary me-2" href="{{ route('admin.login' )}}" type="submit">Admin</a>
                {{-- @guest
                <a class="btn btn-outline-primary me-2" href="{{ route('admin.login') }}" type="submit">Admin</a>
            @endguest --}}
            
            <!-- user login ot not login check the condition -->
			 @if (!Auth::check())
			 <a class="btn btn-outline-primary me-2" href="{{ route('accout.login' )}}" type="submit">Login</a>
              @else

                  {{-- @if (Auth::user()->role == 'admin')
			 <a class="btn btn-outline-primary me-2" href="{{ route('admin.dashboard' )}}" type="submit">Admin</a>
                    @endif --}}

       
                     

                    
                    @endif
                    <a class="btn btn-outline-primary me-2" href="{{ route('accout.profile' )}}" type="submit">Account</a>
                    @if(Auth::check() && Auth::user()->role == 'employer')
                    
				<a class="btn btn-primary" href="{{ route('accout.createJob') }}" type="submit">Post a Job</a>
			  @endif

              

			</div>
		</div>
	</nav>
</header>
 
<!-- replace main part of body  -->
 @yield('main')

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title pb-0" id="exampleModalLabel">Change Profile Picture</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="profilePicForm"  name="profilePicForm" action="" method="post">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Profile Image</label>
                <input type="file" class="form-control" id="image"  name="image">
				<p class="text-danger" id="image-error"></p>
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mx-3">Update</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            
        </form>
      </div>
    </div>
  </div>
</div>

<footer class="bg-dark py-5 bg-2">
    <div class="container">
        <div class="row">
            <!-- About Section -->
            <div class="col-md-4 mb-4">
                <h5 class="text-white mb-3">About Us</h5>
                <p class="text-white">
                    We are a leading job portal connecting job seekers with employers. Find your dream job or the perfect candidate with ease.
                </p>
            </div>

            <!-- Quick Links Section -->
            <div class="col-md-4 mb-4">
                <h5 class="text-white mb-3">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}" class="text-decoration-none text-white">Home</a></li>
                    <li><a href="{{ route('jobs') }}" class="text-decoration-none text-white">Find Jobs</a></li>
                    <li><a href="{{ route('accout.profile') }}" class="text-decoration-none text-white">Account Profile</a></li>
                </ul>
                
            </div>

            <!-- Contact Information Section -->
            <div class="col-md-4 mb-4">
                <h5 class="text-white mb-3">Contact Us</h5>
                <ul class="list-unstyled">
                    <li class="text-white">
                        <a href="https://www.google.com/maps/place/Onus+Job+Placement/@23.0311164,72.4706761,17z/data=!3m1!4b1!4m6!3m5!1s0x395e9b757fbfea09:0x33767b9359eb79ee!8m2!3d23.0311164!4d72.473251!16s%2Fg%2F1ptzvn4d1?entry=ttu&g_ep=EgoyMDI1MDIxOS4xIKXMDSoASAFQAw%3D%3D" target="_blank" class="text-white text-decoration-none">
                            <i class="fas fa-map-marker-alt me-2"></i>123 Job Street, City, Country
                        </a>
                    </li>
                    <li class="text-white">
                        <a href="tel:08460760376" class="text-white text-decoration-none">
                            <i class="fas fa-phone me-2"></i>08460760376
                        </a>
                    </li>
                    <li class="text-white">
                        <a href="mailto:onusjobplacement@gmail.com" class="text-white text-decoration-none">
                            <i class="fas fa-envelope me-2"></i> onusjobplacement@gmail.com
                        </a>
                    </li>
                    
                </ul>
                
                <!-- Social Media Icons -->
                <div class="mt-3">
                    <a href="https://www.facebook.com/onus.jobplacement" target="_blank" class="text-decoration-none text-white me-3">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/yourprofile" target="_blank" class="text-decoration-none text-white me-3">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://in.linkedin.com/in/dhara-chanchu-53348b3b" target="_blank" class="text-decoration-none text-white me-3">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a href="https://www.instagram.com/" target="_blank" class="text-decoration-none text-white">
                        <i class="fab fa-instagram"></i>
                    </a>
                </div>
                
            </div>
        </div>

        <!-- Copyright Section -->
        <div class="row mt-4">
            <div class="col-12">
                <p class="text-center text-white pt-3 fw-bold fs-6 mb-0">
                    © {{ date('Y') }} {{ config('app.name') }}, All Rights Reserved.
                </p>
            </div>
        </div>
    </div>
</footer>
<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.5.1.3.min.js') }}"></script>
<script src="{{ asset('assets/js/instantpages.5.1.0.min.js') }}"></script>
<script src="{{ asset('assets/js/lazyload.17.6.0.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/trumbowyg.min.js" ></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script>
           
		   $('.textarea').trumbowyg();

	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
});

$("#profilePicForm").submit(function(e){

	e.preventDefault();

	var formData= new FormData(this);
	$.ajax({
       url:'{{ route("accout.updateProfilePic") }}',
	   type:'post',
	   data:formData,
	   dataType: 'json',
	   contentType:false,
	   processData:false,
	   success:function(response){
// error for the update pic
		if(response.status == false){

			var errors=response.errors;
			if(errors.image){
				$("#image-error").html(errors.image)
			}
		}
		else
		
		{
			window.location.href= '{{url()->current()}}';
		}


	
	   }
	});
});
 
</script>

@yield('customJs')

</body>
</html>




