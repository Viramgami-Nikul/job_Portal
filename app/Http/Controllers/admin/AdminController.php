<?php

namespace App\Http\Controllers\admin;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function createAdmin()
    {
        $admin = Admin::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => 'admin', // ❌ Password is stored as plain text (NOT recommended)
        ]);

        return response()->json(['message' => 'Admin created successfully!', 'admin' => $admin]);
    }

 
}
