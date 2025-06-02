<?php

use Illuminate\Support\Facades\Route;
//Home page
use App\Http\Controllers\HomeController;
//registration page
use App\Http\Controllers\AccoutController;

//Jobs controller
use App\Http\Controllers\JobsController;


use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\JobController;
use App\Http\Controllers\admin\JobApplicationController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\AdminAuthController;
use App\Http\Middleware\CheckUserOrEmployer;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/create-admin', [AdminController::class, 'createAdmin']);
// Show login form


Route::get('/',[HomeController::class,'index'])->name('home');

//show the job page
Route::get('/jobs',[JobsController::class,'index'])->name('jobs');

//job details
Route::get('/jobs/detail/{id}',[JobsController::class,'detail'])->name('jobDetail');

//Apply the job
Route::post('/apply-job',[JobsController::class,'applyJob'])->name('applyJob');

//saved the job
Route::post('/save-job',[JobsController::class,'saveJob'])->name('saveJob');

//forgor-password
Route::get('/forgot-password',[AccoutController::class,'forgotPassword'])->name('accout.forgotPassword');

Route::post('/process-forgot-password',[AccoutController::class,'processForgotPassword'])->name('accout.processForgotPassword');
Route::get('/reset-password/{token}',[AccoutController::class,'resetPassword'])->name('accout.resetPassword');

Route::post('/process-reset-password',[AccoutController::class,'processResetPassword'])->name('accout.processResetPassword');






//middleware

Route::middleware('guest')->group( function(){
    Route::get('/accout/register',[AccoutController::class,'registration'])->name('accout.registration');
    Route::post('/accout/process-register',[AccoutController::class,'processRegistration'])->name('accout.processRegistration');
    //login
    Route::get('/accout/login',[AccoutController::class,'login'])->name('accout.login');
    Route::post('/accout/authenticate',[AccoutController::class,'authenticate'])->name('accout.authenticate');

  


});

// Route::middleware('auth')->group( function(){
   
    
//     Route::get('/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');


// //profile
// Route::get('/accout/profile',[AccoutController::class,'profile'])->name('accout.profile');
// Route::put('/update-profile',[AccoutController::class,'updateProfile'])->name('accout.updateProfile');
// //logout
// Route::get('/accout/logout',[AccoutController::class,'logout'])->name('accout.logout');
// //update the Profile Picture
// Route::post('/update-profile-pic',[AccoutController::class,'updateProfilePic'])->name('accout.updateProfilePic');
// Route::get('accout/create-job',[AccoutController::class,'createJob'])->name('accout.createJob');
// Route::post('accout/save-job',[AccoutController::class,'saveJob'])->name('accout.saveJob');

// // my crate a job 
// Route::get('accout/my-jobs',[AccoutController::class,'myJobs'])->name('accout.myJobs');

// //edit the job
// Route::get('accout/my-jobs/edit/{jobId}',[AccoutController::class,'editJob'])->name('accout.editJob');

// //update the job
// Route::post('accout/update-job/{jobId}',[AccoutController::class,'updateJob'])->name('accout.updateJob');

// //delete the job
// Route::post('accout/delete-job',[AccoutController::class,'deleteJob'])->name('accout.deleteJob');

// //job applied

// Route::get('accout/my-job-applications',[AccoutController::class,'myJobApplications'])->name('accout.myJobApplications');

// //applied job remove


// Route::post('accout/remove-job-application',[AccoutController::class,'removeJobs'])->name('accout.removeJobs');

// //show the saved job page
// Route::get('accout/saved-jobs',[AccoutController::class,'savedJobs'])->name('accout.savedJobs');

// Route::post('accout/remove-saved-job',[AccoutController::class,'removeSavedJob'])->name('accout.removeSavedJob');

// //change password 
// Route::post('accout/update-password',[AccoutController::class,'updatePassword'])->name('accout.updatePassword');





// });





Route::get('/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');
// User & Employer Routes
Route::middleware(['auth',CheckUserOrEmployer::class])->group(function () {
    
    // User & Employer Profile
    Route::get('/accout/profile',[AccoutController::class,'profile'])->name('accout.profile');
Route::put('/update-profile',[AccoutController::class,'updateProfile'])->name('accout.updateProfile');

Route::get('/accout/logout',[AccoutController::class,'logout'])->name('accout.logout');
// //update the Profile Picture
Route::post('/update-profile-pic',[AccoutController::class,'updateProfilePic'])->name('accout.updateProfilePic');
Route::post('accout/update-password',[AccoutController::class,'updatePassword'])->name('accout.updatePassword');


    // Job Listings for Employers & Users
    // Route::get('/jobs', [JobController::class, 'index'])->name('jobs.list');
    // Route::get('/jobs/{id}', [JobController::class, 'show'])->name('jobs.view');

    // Employers: Create & Manage Jobs
    Route::middleware(['auth',CheckUserOrEmployer::class ])->group(function () {
        Route::get('accout/create-job',[AccoutController::class,'createJob'])->name('accout.createJob');
        Route::post('accout/save-job',[AccoutController::class,'saveJob'])->name('accout.saveJob');
        
Route::post('accout/remove-job-application',[AccoutController::class,'removeJobs'])->name('accout.removeJobs');
        // // my crate a job 
        Route::get('accout/my-jobs',[AccoutController::class,'myJobs'])->name('accout.myJobs');
        
        // //edit the job
        Route::get('accout/my-jobs/edit/{jobId}',[AccoutController::class,'editJob'])->name('accout.editJob');
        
        // //update the job
        Route::post('accout/update-job/{jobId}',[AccoutController::class,'updateJob'])->name('accout.updateJob');
        
        // //delete the job
        Route::post('accout/delete-job',[AccoutController::class,'deleteJob'])->name('accout.deleteJob');
        
    });

    // Job Applications (Users Applying to Jobs)
    Route::middleware(['auth',CheckUserOrEmployer::class ])->group(function () {

Route::get('accout/my-job-applications',[AccoutController::class,'myJobApplications'])->name('accout.myJobApplications');
Route::post('accout/remove-job-application',[AccoutController::class,'removeJobs'])->name('accout.removeJobs');
Route::get('accout/saved-jobs',[AccoutController::class,'savedJobs'])->name('accout.savedJobs');
Route::post('accout/remove-saved-job',[AccoutController::class,'removeSavedJob'])->name('accout.removeSavedJob');

    });

   
});




//admin prefix
// Route::middleware('checkRole')->group( function(){

// Route::prefix('admin')->group(function(){

//     //display the admin
//     Route::get('/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');

//     //display the users detail in admin panel
//     Route::get('/users',[UserController::class,'index'])->name('admin.users');

//     Route::get('/users/{id}',[UserController::class,'edit'])->name('admin.users.edit');
//     //update the user 
//     Route::put('/users/{id}',[UserController::class,'update'])->name('admin.users.update');

//     // deleted the user by admin

//     Route::delete('/users',[UserController::class,'destroy'])->name('admin.users.destroy');

//     //show the job page in admin
//     Route::get('/jobs',[JobController::class,'index'])->name('admin.jobs');

//     //edit the job

//     Route::get('/jobs/edit/{id}',[JobController::class,'edit'])->name('admin.jobs.edit');

//     Route::put('/jobs/{id}',[JobController::class,'update'])->name('admin.jobs.update');


//     Route::delete('/jobs',[JobController::class,'destroy'])->name('admin.jobs.destroy');


//     Route::get('/job-application',[JobApplicationController::class,'index'])->name('admin.jobApplication');

//     //delete the jobApplication
//     Route::delete('/job-application',[JobApplicationController::class,'destroy'])->name('admin.jobApplications.destroy');

   
  


// });

// });



Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/auth', [AdminAuthController::class, 'authenticate'])->name('admin.authenticate');
Route::get('/logout',[AdminAuthController::class,'logout'])->name('admin.logout');


    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');


        Route::get('/users',[UserController::class,'index'])->name('admin.users');

            Route::get('/users/{id}',[UserController::class,'edit'])->name('admin.users.edit');
            //update the user 
            Route::put('/users/{id}',[UserController::class,'update'])->name('admin.users.update');
        
            // deleted the user by admin
        
            Route::delete('/users',[UserController::class,'destroy'])->name('admin.users.destroy');
            Route::post('/admin/users/update-role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');
        
            //show the job page in admin
            Route::get('/jobs',[JobController::class,'index'])->name('admin.jobs');
        
            //edit the job
        
            Route::get('/jobs/edit/{id}',[JobController::class,'edit'])->name('admin.jobs.edit');
        
            Route::put('/jobs/{id}',[JobController::class,'update'])->name('admin.jobs.update');
        
        
            Route::delete('/jobs',[JobController::class,'destroy'])->name('admin.jobs.destroy');
        
        
            Route::get('/job-application',[JobApplicationController::class,'index'])->name('admin.jobApplication');
        
            //delete the jobApplication
            Route::delete('/job-application',[JobApplicationController::class,'destroy'])->name('admin.jobApplications.destroy');
        
           
          
        
        
    });
});

