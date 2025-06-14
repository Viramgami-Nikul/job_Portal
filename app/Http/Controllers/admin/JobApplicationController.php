<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
   public function index(){

   $applications = JobApplication::orderBy('created_at','DESC')->with('job','user','employer')->paginate(10);
//    dd($application);
  
     return view('admin.job-applications.list',[

        'applications' => $applications,
     ]);


     
     
   }
   //delete jobApplication
   public function destroy(Request $request){

      $id = $request->id;

     $jobApplication= JobApplication::find($id);


     if($jobApplication == null){

      session()->flash('error','Either job Application deleted or not found');
      return response()->json([
  
        
        'status' => false,
        
    ]);
   }

      $jobApplication->delete();

      session()->flash('success','Job Application deleted successfully.');
      return response()->json([
   
        
        'status' => true,
        
    ]);

   }
}
