<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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
        $user = auth()->user();
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
            return redirect()->route('admin.dashboard')->with('error', 'Unauthorized access. Only administrative accounts are permitted to perform this action.');
        }

        return $next($request);
    }
}
