<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class is_admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.panel'); // Redirect to login
        }
        
         $admin = Auth::guard('admin')->user();

        if (!in_array($admin->role, [1, 4,3,5,6])) {
            return redirect()->route('admin.panel')->with('error', 'You do not have administrative permission to access this page.');
        }

        return $next($request);
        // return redirect()->route('admin.panel')->with('error', 'You do not have administrative permission to access this page.');
    }
}
