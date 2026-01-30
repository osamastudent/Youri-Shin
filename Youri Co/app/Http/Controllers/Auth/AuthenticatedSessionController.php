<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        
        if (Auth::user()->status === 0) {
                Auth::logout();
                return redirect()->back()->with('error', '<center>Your Account Is Deactivated!</center>');
            } else {
                
            $request->session()->regenerate();
        
            if (Auth::user()->user_type == 1) {
                return redirect('dashboard');
            } elseif (Auth::user()->user_type == 2 && Auth::user()->status == 1) {
                return redirect('company/dashboard');
            } elseif (Auth::user()->status == 3) {
        // Redirect to a new page when status is 3
        return redirect()->route('admin.deactivate'); // Use a named route for better readability
    } 
            else {
                // If user_type is neither 1 nor (2 and status is 1), redirect with error
                return redirect()->back()->with('error', 'Invalid user type or status');
            }
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
