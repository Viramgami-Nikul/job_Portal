<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ Correct Import
use Symfony\Component\HttpFoundation\Response;

class CheckUserOrEmployer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function handle(Request $request, Closure $next): Response
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('accout.login')->with('error', 'Please log in first.');
        }

        // Get the authenticated user
        $user = Auth::user();

        // Ensure the user object exists and has a valid role
        if (in_array($user->role, ['user', 'employer'])) {
            return $next($request);
        }

        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }
}
