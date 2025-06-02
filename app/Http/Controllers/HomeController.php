<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    //show the Home Page

    public function index(){

        //active category ko hi show karenge fetch from databse
      $categories =  Category::where('status',1)->orderBy('name','ASC')->take(8)->get();


  $newCategories =    Category::where('status',1)->orderBy('name','ASC')->get();

      //featured job fetch from database //only show the 1 featured job //take(6) only show 6 job featured

      //created_at me latest job upper dikhayegi //featured admin kar sakta hai
      $featuredJobs= Job::where('status',1)->orderBy('created_at','DESC')->with('jobType')->where('isFeatured',1)->take(6)->get();

      //latest job //here use the job model in relation jobtype
      $latestJobs= Job::where('status',1)->with('jobType')->orderBy('created_at','DESC')->take(6)->get();

        return view('front.home',[
            'categories' => $categories,
            'featuredJobs' => $featuredJobs,
            'latestJobs' => $latestJobs,
            'newCategories' => $newCategories,
        ]);
    }
}
