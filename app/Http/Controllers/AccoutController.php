<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordEmail;
use App\Models\User;
use Illuminate\Http\Request;

//login authentication
use Illuminate\Support\Facades\Auth;
//password hash 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Validator;

//for image size url
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

//delete old pic
use Illuminate\Support\Facades\File;
//show the category from database
use App\Models\Category;
//show the jobtypes table from databse like fulltime
use App\Models\JobType;

//show the job field not requied that store in databse
use App\Models\Job;
//applied job show
use App\Models\JobApplication;
//show the saved job
use App\Models\SavedJob;

use Illuminate\Support\Str;




class AccoutController extends Controller
{
    //
    //registration page show
    public function registration(){
        return view('front.accout.registration');

    }

    //This method show the user move in database
    public function processRegistration(Request $request){
  
        $validator= Validator::make($request->all(),[
       
            'name' => 'required',
            'email'=> 'required|email|unique:users,email',
            'password'=> 'required|min:8|same:confirm_password',
            'confirm_password'=>'required',
            

        ]);

        if($validator->passes()){
            $user= new User();
            
            $user->name= $request->name;
            $user->email= $request->email;
            $user->password=  Hash::make($request->password);
            $user->save();


            //session set

            session()->flash('success','You have registerd successfully.');


            return response()->json([
                'status'=>true,
                'errors'=>[]
            ]);

        }

        else{
            //return the error json formate
            return response()->json([

                'status'=>false,
                'errors'=>$validator->errors()

            ]);
        }
    }

    //login page show

    public function login(){

  return view('front.accout.login');
    }

    //Authentication method show

    public function authenticate(Request $request){

         $validator = Validator::make($request->all(),[
            'email'  => 'required|email',
            'password' =>'required'
         ]);


         if($validator->passes()){


            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                return redirect()->route('accout.profile');


            }

            else{
                // not fullfield currect field then redirect the login
                    
                return redirect()->route('accout.login')->with('error','Either Email/Password is incorrect');
            }

         }

         else{
                  //authenticate error show in login  page then redirect the login with error
                  return redirect()->route('accout.login')->withErrors($validator)->withInput($request->only('email'));
         }
    }

     //Profile page show

     public function profile(){
        //fetch the information from database using id
        $id=Auth::user()->id;
        $user= User::where('id',$id)->first();

    
        return view('front.accout.profile',[
            'user'=> $user
        ]);

     }

     //User Informaton Update method

     public function updateProfile(Request $request){
        $id=Auth::user()->id;

          $validator= Validator::make($request->all(),[
            
            'name' => 'required|min:5|max:20',
            //login time email alread exist then this email ignore the email
            'email' =>'required|email|unique:users,email,'.$id.',id'
          ]);

          if($validator->passes()){

         $user = User::find($id);
         $user->name=$request->name;
         $user->email=$request->email;
         $user->mobile=$request->mobile;
         $user->designation=$request->designation;
         $user->save();

         session()->flash('success','Profile updated successfully.');

         return response()->json([

            'status' => true,
            'errors' =>[]
        ]);

          }
          else{
            return response()->json([

                'status' => false,
                'errors' => $validator->errors()
            ]);
          }
     }

     //logout

     public function logout(){
        Auth::logout();
        return redirect()->route('accout.login');
     }


     //update Profile Picture

     public function updateProfilePic(Request $request){
        // dd($request->all());

        $id=Auth::user()->id;

        $validator = Validator::make($request->all(),[

            'image' => 'required|image'

        ]);

        if($validator->passes()){
            //file upload image file logic
            $image = $request->image;
            //extension nikal ne ke liye
            $ext =$image->getClientOriginalExtension();
            //unique name generate
            $imageName= $id.'-'.time().'.'.$ext; // ex:=3.152555.png
            $image->move(public_path('/profile_pic/'),$imageName);


            //Create a Small thumbnail
            $sourcePath=public_path('/profile_pic/'.$imageName);
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($sourcePath);

// crop the best fitting 5:3 (600x360) ratio and resize to 600x360 pixel
            $image->cover(150,150);
            $image->toPng()->save(public_path('/profile_pic/thumb/').$imageName);
           
            //Delete Old  Profile Pic

            File::delete(public_path('/profile_pic/thumb/'.Auth::user()->image));
            //profile se delete
            File::delete(public_path('/profile_pic/'.Auth::user()->image));


            //update the image in database store
            User::where('id',$id)->update(['image' => $imageName]);

            session()->flash('success','Profile Picture updated successfully.');

            return response()->json([

                'status' => true,
                'errors' => []
            ]);


        }

        else{
            //return the error

            return response()->json([

                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

     }



     public function createJob(){
        //this metod show the createjob page
        //showing the category of job from database

       $categories = Category::orderBy('name','ASC')->where('status',1)->get();

      $jobTypes= JobType::orderBy('name','ASC')->where('status',1)->get();

        return view('front.accout.job.create',[
            'categories' => $categories,
            'jobTypes' => $jobTypes
        ]);

     }



     //jobs create this method //store the job in database
     public function saveJob(Request $request){
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
            $job= new Job();
            $job->title= $request->title;
            $job->category_id= $request->category;
            $job->job_type_id= $request->jobType;
            //logdin user ka id here pass
            $job->user_id=Auth::user()->id;
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

            $job->save();

          session()->flash('success', 'Job added successfully.');

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

     public function myJobs(){

        //fetch the job //yaha user_id loggdin user ka hona chahiye
        $jobs = Job::where('user_id',Auth::user()->id)->with('jobType')->orderBy('created_at','DESC')->paginate(10);
        
        return view('front.accout.job.my-jobs',[
            'jobs' =>$jobs
        ]);

     }

     //edit the job

     public function editJob(Request $request,$id){
// dd($id);
        $categories = Category::orderBy('name','ASC')->where('status',1)->get();

        $jobTypes= JobType::orderBy('name','ASC')->where('status',1)->get();

        $job=Job::where([

            'user_id' => Auth::user()->id,
            'id' => $id,
            

        ])->first();

        if($job == null){
            abort(404);
        }
  
        return view('front.accout.job.edit',[
            'categories' => $categories,
            'jobTypes' => $jobTypes,
            'job'     => $job,

        ]);
     }

     //update the job
     public function updateJob(Request $request, $id){
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
            //logdin user ka id here pass
            $job->user_id=Auth::user()->id;
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


     //this method show the delete job
     public function deleteJob(Request $request){

      $job = Job::where([

            'user_id' => Auth::user()->id,
            'id' => $request->jobId

        ])->first();

        if($job == null){
            session()->flash('error','Either Job deleted or not found.');
            return response()->json([

                'status' => true,
            ]);
        }
      
         Job::where('id', $request->jobId)->delete();
         session()->flash('success','Job deleted successfully.');
            return response()->json([

                'status' => true,
            ]);
     }


//      public function myJobApplications(){

//    $jobApplications =  JobApplication::where('user_id',Auth::user()->id)->with(['job','job.jobType','job.applications'])->orderBy('created_at','DESC')->paginate(10);
// //    dd($jobs);
//         return view('front.accout.job.my-job-applications',[
//             'jobApplications' => $jobApplications
//         ]);
//      }

     public function myJobApplications()
{
    $user = Auth::user();

    if ($user->role === 'employer') {
        // Employers see applications for their jobs
        $jobApplications = JobApplication::whereHas('job', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->latest()->paginate(10);
    } else {
        // Users see jobs they have applied to
        $jobApplications = JobApplication::where('user_id', $user->id)
            ->latest()
            ->paginate(10);
    }

    return view('front.accout.job.my-job-applications', compact('jobApplications'));
}


    //  //applied karel job remove for my-job-application route
    //  public function removeJobs(Request $request){

    // $jobApplication= JobApplication::where(['id' => $request->id, 'user_id' => Auth::user()->id])->first();

    //                 if($jobApplication == null){

    //                  session()->flash('error','Job Application not found');

    //                     return response()->json([
    //                         'status' => false,

    //                     ]);
    //                 }

    //                 JobApplication::find($request->id)->delete();  

    //                 session()->flash('success','Job Application removed successfully.');

    //                 return response()->json([
    //                     'status' => true,
    //                 ]);


    //  }
    public function removeJobs(Request $request)
{
    $jobApplication = JobApplication::find($request->id);

    if (!$jobApplication) {
        session()->flash('error', 'Job Application not found');
        return response()->json([
            'status' => false,
        ]);
    }

    // Check if the user is either the applicant OR the employer who posted the job
    if (
        Auth::user()->id === $jobApplication->user_id ||  // User who applied
        Auth::user()->id === $jobApplication->job->user_id // Employer who posted the job
    ) {
        $jobApplication->delete();
        session()->flash('success', 'Job Application removed successfully.');
        return response()->json([
            'status' => true,
        ]);
    }

    // If the logged-in user is neither the applicant nor the employer
    session()->flash('error', 'You are not authorized to remove this job application.');
    return response()->json([
        'status' => false,
    ]);
}


     public function savedJobs(){

        // $jobApplications =  JobApplication::where('user_id',Auth::user()->id)->with(['job','job.jobType','job.applications'])->paginate(10);
        //    dd($jobs);

        $savedJobs = SavedJob::where([
            'user_id' => Auth::user()->id,
        ])->with(['job','job.jobType','job.applications'])->orderBy('created_at','DESC')->paginate(10);


                return view('front.accout.job.saved-jobs',[
                    'savedJobs' => $savedJobs
                ]);

     }



     public function removeSavedJob(Request $request){

        $savedJob= SavedJob::where(['id' => $request->id, 'user_id' => Auth::user()->id])->first();
    
                        if($savedJob == null){
    
                         session()->flash('error','Job  not found');
    
                            return response()->json([
                                'status' => false,
    
                            ]);
                        }
    
                        SavedJob::find($request->id)->delete();  
    
                        session()->flash('success','Job removed successfully.');
    
                        return response()->json([
                            'status' => true,
                        ]);
    
    
         }

         public function updatePassword(Request $request){

            $validator = Validator::make($request->all(),[

                'old_password' => 'required',
                'new_password' => 'required|min:5',
                'confirm_password' => 'required|same:new_password',
                
            ]);

            if($validator->fails()){

                return response()->json([
                    'status' => false,
                    'errors' =>$validator->errors(),

                ]);

            }

            //agar old password incorrect hai to show the error
            if(Hash::check($request->old_password,Auth::user()->password) == false){

                session()->flash('error','Your old password is incorrect.');
                return response()->json([
                  'status' => true,
                ]);

            }

            $user=User::find(Auth::user()->id);

            $user->password=Hash::make($request->new_password);
            $user->save();

            session()->flash('success','Password updated succssfully.');
           
            return response()->json([
                'status' => true,
              ]);

         }

         public function forgotPassword(){
            return view('front.accout.forgot-password');
         }

         public function processForgotPassword(Request $request){

            $validator= Validator::make($request->all(),[

                'email' => 'required|email|exists:users,email'
            ]);

            if($validator->fails()){
                return redirect()->route('accout.forgotPassword')->withInput()->withErrors($validator);
            }

         $token= Str::random(60);

         \DB::table('password_reset_tokens')->where('email',$request->email)->delete();
            //insert the record not use the model
            \DB::table('password_reset_tokens')->insert([

                'email' => $request->email,
                'token' => $token,
                'created_at'=> now()

            ]);

            //send Email here

            $user= User::where('email',$request->email)->first();
            $mailData = [

                'token' => $token,
                'user' => $user,
                'subject' => 'You have requested to change your password.'
            ];

            Mail::to($request->email)->send(new ResetPasswordEmail($mailData));

            return redirect()->route('accout.forgotPassword')->with('success','Reset password email has been sent to your Email');
         }

         public function resetPassword($tokenString){

       $token =  \DB::table('password_reset_tokens')->where('token',$tokenString)->first();

       if($token == null){
        
        return redirect()->route('accout.forgotPassword')->with('error','Invalid token');

       } 
       
       return view('front.accout.reset-password',[
  
        'tokenString' => $tokenString,

       ]);

         }

         //reset password with update

         public function processResetPassword(Request $request){


            $token =  \DB::table('password_reset_tokens')->where('token',$request->token)->first();

            if($token == null){
             
             return redirect()->route('accout.forgotPassword')->with('error','Invalid token.');
     
            } 


            $validator= Validator::make($request->all(),[

                'new_password' => 'required|min:5',
                'confirm_password' => 'required|same:new_password',
            ]);

            if($validator->fails()){
                return redirect()->route('accout.resetPassword',$request->token)->withErrors($validator);
            }

            User::where('email',$token->email)->update([

                'password' => Hash::make($request->new_password),

            ]);

            return redirect()->route('accout.login')->with('success','You have successfully changed your password.');

         }
}
