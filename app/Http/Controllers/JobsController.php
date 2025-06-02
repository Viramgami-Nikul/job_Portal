<?php

namespace App\Http\Controllers;

use App\Mail\JobNotificationEmail;
use App\Models\Job;
use App\Models\Category;
use App\Models\JobType;
use App\Models\User;
use App\Models\JobApplication;
use App\Models\SavedJob;
use App\Mail\JobApplicationMail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class JobsController extends Controller
{
  //  This method show jobs page

  public function index(Request $request)
  {

    $categories = Category::where('status', 1)->get();
    $jobTypes = JobType::where('status', 1)->get();

    $jobs = Job::where('status', 1);


    //search using keyword

    if (!empty($request->keyword)) {


      $jobs = $jobs->where(function ($query) use ($request) {

        $query->orWhere('title', 'like', '%' . $request->keyword . '%');     //url through find out the search title
        $query->orWhere('keywords', 'like', '%' . $request->keyword . '%');  //keyword through  the find out the title

      });
    }

    //Search using location

    if (!empty($request->location)) {
      $jobs = $jobs->where('location', $request->location);
    }
    //Search using category

    if (!empty($request->category)) {
      $jobs = $jobs->where('category_id', $request->category);
    }



    $jobTypeArray = [];
    //Search using jobType

    if (!empty($request->jobType)) {

      //search for url jobType like 1,2,3
      $jobTypeArray = explode(',', $request->jobType);
      $jobs = $jobs->whereIn('job_type_id', $jobTypeArray);
    }

    if (!empty($request->experience)) {

      //Searching using experience

      $jobs = $jobs->where('experience', $request->experience);
    }


    $jobs = $jobs->with(['jobType', 'category']);

    if ($request->sort == '0') {
      $jobs = $jobs->orderBy('created_at', 'ASC');
    } else {

      $jobs = $jobs->orderBy('created_at', 'DESC');
    }


    $jobs = $jobs->paginate(9);

    return view('front.jobs', [

      'categories' => $categories,
      'jobTypes' => $jobTypes,
      'jobs'  => $jobs,
      'jobTypeArray'  => $jobTypeArray,


    ]);
  }

  //this method will show the job detail page

  public function detail($id)
  {

    // fetch the job in database to jobDetail page
    //with denoted the relation table
    $job = Job::where(['id' => $id, 'status' => 1])->with(['jobType', 'category'])->first();
    //  dd($job);

    if ($job == null) {
      abort(404);
    }

    $count = 0;
    if (Auth::user()) {

      $count = SavedJob::where([
        'user_id' => Auth::user()->id,
        'job_id' => $id
      ])->count();
    }

    // fetch applicants or jish user ne job applied kiya ohs user ki detail show

    $applications = JobApplication::where('job_id', $id)->with('user')->get();
    // dd($application); 

    return view('front.jobDetail', ['job' => $job, 'count' => $count, 'applications' => $applications]);
  }

  //applyjob with ajax method

  //     public function applyJob(Request $request){

  //       $id =$request->id;

  //       $job = Job::where('id',$id)->first();

  //       if($job == null){

  //         // if job null then not found in db

  //       $message ='Job does not exist';


  //         session()->flash('error',$message);
  //         return response()->json([

  //           'status' =>false,
  //           'message' => $message
  //         ]);
  //       }


  //       //agar userne khud job create kiya hai to vo apply nahi kar sakta

  //       // 16 video
  //       //employe and user ek hi dono ka kam ek hi hoga

  //       $employer_id = $job->user_id;

  //       if($employer_id == Auth::user()->id){
  //         //user or emplyoe not apply for own job

  //       $message ='You can not apply on your own job';


  //         session()->flash('error',$message);
  //         return response()->json([

  //           'status' =>false,
  //           'message' => $message
  //         ]);

  //       }



  //       //You can not apply on a job twise(ek job par dushri bar apply nahi karsakte )

  //       $jobApplicationCount =JobApplication::where([

  //         'user_id' => Auth::user()->id,
  //         'job_id' => $id


  //       ])->count();


  //       //user or employee already applied the job
  //       if($jobApplicationCount > 0){

  //         $message ='You already applied on this job.';


  //         session()->flash('error',$message);
  //         return response()->json([

  //           'status' =>false,
  //           'message' => $message
  //         ]);


  //       }



  //       $application = new JobApplication();
  //       $application->job_id=$id;
  //       $application->user_id = Auth::user()->id;
  //       $application->employer_id =$employer_id;
  //       $application->applied_date=now();
  //       $application->save();


  // //Send Notification Email to Employer

  // $employer= User::where('id',$employer_id)->first();


  // $mailData= [
  //          'employer'  => $employer,
  //          'user' => Auth::user(),
  //          'job' =>$job,

  // ];

  // // Mail::to($employer->email)->send(new JobNotificationEmail($mailData));

  // Mail::to(Auth::user()->email)->send(new JobNotificationEmail($mailData));



  //       $message ='You have successfully applied.';

  //       session()->flash('success',$message);


  //         return response()->json([

  //           'status' =>true,
  //           'message' => $message,
  //         ]);



  //       //save button on operation


  //     }


  public function applyJob(Request $request)
  {
    $request->validate([
      'job_id' => 'required|exists:jobs,id',
      'resume' => 'required|mimes:pdf,doc,docx|max:2048'
    ]);

    $job = Job::findOrFail($request->job_id);
    $user = Auth::user();

    // Get the employer ID from the job
    $employer_id = $job->user_id;

    // Prevent the user from applying to their own job
    if ($employer_id == $user->id) {
      return back()->with('error', 'You cannot apply to your own job.');
    }

    // Check if the user already applied
    if (JobApplication::where('user_id', $user->id)->where('job_id', $job->id)->exists()) {
      return back()->with('error', 'You have already applied for this job.');
    }

    // Handle Resume Upload
    $resumePath = $request->file('resume')->store('resumes', 'public');

    // Save the application
    $application = new JobApplication();
    $application->job_id = $job->id;
    $application->user_id = $user->id;
    $application->employer_id = $employer_id;
    $application->resume = $resumePath;
    $application->applied_date = now();
    $application->save();

    // Send email to employer
    Mail::to($job->user->email)->send(new JobApplicationMail($user, $job, $resumePath));
    // Mail::to($employer->email)->send(new JobNotificationEmail($mailData));


    return back()->with('success', 'Application submitted successfully!');
  }



  public function saveJob(Request $request)
  {
    //when click on the save button then save the job
    //job id
    $id = $request->id;

    $job = Job::find($id);

    if ($job == null) {

      session()->flash('error', 'job not found');
      return response()->json([
        'status' => false,

      ]);
    }

    //check if user already saved the job

    $count = SavedJob::where([
      'user_id' => Auth::user()->id,
      'job_id' => $id
    ])->count();

    if ($count > 0) {
      session()->flash('error', 'You already saved on this job.');

      return response()->json([
        'status' => false,


      ]);
    }

    $savedJob = new SavedJob;
    $savedJob->job_id = $id;
    $savedJob->user_id = Auth::user()->id;
    $savedJob->save();


    session()->flash('success', 'You have successfully saved the job.');

    return response()->json([
      'status' => true,


    ]);
  }
}
