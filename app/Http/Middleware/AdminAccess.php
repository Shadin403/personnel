<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Try to get user from web guard first, then soldiers guard
        $user = Auth::guard('web')->user() ?? Auth::guard('soldiers')->user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $userType = '';

        if ($user instanceof \App\Models\Soldier) {
            $userType = strtoupper($user->user_type ?? '');
        } elseif ($user instanceof \App\Models\User && $user->soldier_id) {
            $userType = strtoupper($user->soldier->user_type ?? '');
        } elseif ($user instanceof \App\Models\User) {
            $userType = strtoupper($user->user_type ?? '');
        }

        if ($userType === 'SNK') {
            return redirect()->route('admin.soldiers.show', [
                'soldier' => $user instanceof \App\Models\Soldier ? $user->id : $user->soldier_id
            ])->with('error', 'Unauthorized access to administrative sectors.');
        }

        if (Gate::denies('manage-soldiers')) {
            // Prevent circular redirect: only redirect to dashboard if we're not ALREADY there
            if ($request->routeIs('admin.dashboard')) {
                // If on dashboard and denied, it means this user has no admin rights at all
                return abort(403, 'Unauthorized access to administrative area.');
            }
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}
