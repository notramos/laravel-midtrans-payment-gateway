<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         if (!Auth::check()) {
             return back();
        }
        
        // Check if the authenticated user is an admin
        if (Auth::user()->role !== 'admin') {
            // Redirect non-admin users or return a forbidden response
             return back();
            // Alternatively, you can return abort(403, 'Unauthorized access');
        }
        
        return $next($request);
    }
}
