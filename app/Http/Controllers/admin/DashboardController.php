<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
     //admin controller work 

    public function index(){
        return view('admin.dashboard');
    }
}





