<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // ✅ Add this line

class AdminAuthController extends Controller
{
    
    public function showLoginForm()
    {
        return view('admin.login.login');
    }

    public function authenticate(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        // Find the admin by email
        $admin = Admin::where('email', $request->email)->first();
    
        // Check if admin exists and manually compare the plain-text password
        if ($admin && $admin->password === $request->password) {
            
            // Log in the admin manually
            Auth::guard('admin')->login($admin);
    
            // Regenerate session to prevent session fixation
            $request->session()->regenerate();
    
            // Redirect to admin dashboard
            return redirect()->route('admin.dashboard')->with('success', 'Login successful!');
        }
    
        // If authentication fails, redirect back with error
        return back()->with('error', 'Invalid email or password.')->withInput();
    }
    
    public function logout(){
        Auth::logout();
        return redirect()->route('admin.login');
     }


}