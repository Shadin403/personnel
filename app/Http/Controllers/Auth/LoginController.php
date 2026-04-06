<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('admin.dashboard');
        }
        if (Auth::guard('soldiers')->check()) {
            $user = Auth::guard('soldiers')->user();
            return redirect()->route('admin.soldiers.show', $user->id);
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $loginId = $request->input('email'); // Form field still named 'email' for compatibility
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        // Logic to determine if it's an Email (Admin) or Personal ID (Soldier)
        if (filter_var($loginId, FILTER_VALIDATE_EMAIL)) {
            // Attempt Admin/Staff login (users table)
            if (Auth::guard('web')->attempt(['email' => $loginId, 'password' => $password], $remember)) {
                $request->session()->regenerate();
                
                $user = Auth::guard('web')->user();
                if ($user->soldier_id && strtoupper($user->soldier->user_type ?? '') === 'SNK') {
                    return redirect()->route('admin.soldiers.show', $user->soldier_id);
                }
                
                return redirect()->intended(route('admin.dashboard'));
            }
        } else {
            // Attempt Soldier login (soldiers table)
            if (Auth::guard('soldiers')->attempt(['personal_no' => $loginId, 'password' => $password], $remember)) {
                $request->session()->regenerate();
                $user = Auth::guard('soldiers')->user();
                return redirect()->route('admin.soldiers.show', $user->id);
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        Auth::guard('soldiers')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
