<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Category;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function index(){

       $jobs = Job::orderBy('created_at','DESC')->with('user','applications')->paginate(10);
    //    dd($jobs);
        return view('admin.jobs.list',[

          'jobs' => $jobs,

        ]);

    }

    //edit the job by admin

    public function edit($id){
      // dd($id);

      $job = Job::findOrFail($id);

      $categories= Category::orderBy('name','ASC')->get();
      $jobTypes= JobType::orderBy('name','ASC')->get();

      
      return view('admin.jobs.edit',[

        'job' => $job,
        'categories' => $categories,
        'jobTypes' => $jobTypes,

      ]);

    }


    public function update(Request $request, $id){
      $rules= [

          //mandatory yani required field in form job
          'title' => 'required|min:5|max:200',
          'category' => 'required',
          'jobType' => 'required',
          'vacancy' => 'required|integer',
          'location' => 'required|max:50',
          'description' => 'required',
          'company_name' => 'required|min:3|max:50',
          


      ];
      $validator= Validator::make($request->all(), $rules);

      if($validator->passes()){

          //store the job in database
          $job= Job::find($id);
          $job->title= $request->title;
          $job->category_id= $request->category;
          $job->job_type_id= $request->jobType;
          $job->vacancy= $request->vacancy;
          $job->salary= $request->salary;
          $job->location= $request->location;
          $job->description= $request->description;
          $job->benefits= $request->benefits;
          $job->responsibility= $request->responsibility;
          $job->qualifications= $request->qualifications;
          $job->keywords= $request->keywords;
          $job->experience= $request->experience;
          $job->company_name= $request->company_name;
          $job->company_location= $request->company_location;
          $job->company_website= $request->website;
          $job->status= $request->status;
          $job->isFeatured= (!empty($request->isfeatured)) ? $request->isfeatured : 0;

          $job->save();

        session()->flash('success', 'Job updated successfully.');

          return response()->json([
              'status' => true,
              'errors' => []
          ]);



      }
      else{
          //error show the for job

          return response()->json([
              'status' => false,
              'errors' => $validator->errors()

          ]);
      }


   }

   //job deleted by the admin

   public function destroy(Request $request){

    $id= $request->id;

   $job= Job::find($id);

   if($job == null){

    session()->flash('error','Either job deleted or not found');
    return response()->json([

      
      'status' => false,
      
  ]);


   }

   $job->delete();
     
   session()->flash('success','Job deleted successfully.');
   return response()->json([

     
     'status' => true,
     
 ]);

   }
   
}
