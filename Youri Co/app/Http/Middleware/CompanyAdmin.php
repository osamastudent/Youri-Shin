<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        
        if (Auth::check()) {
            if (Auth::user()->status == 0) {
                Auth::logout();
                return redirect()->route('login')->with('error', '<center>Your Account Is Deactivated!</center>');
            }
                
            if ((auth()->user()->user_type == '2')) {
                return $next($request);
            }else
            {
               abort(403, 'Unauthorized Action');
                
            }
        }
    }
}