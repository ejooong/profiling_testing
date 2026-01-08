<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // DEBUG: Tambahkan log
        \Log::info('CheckRole middleware dipanggil', [
            'user' => $request->user() ? $request->user()->email : 'no user',
            'roles_required' => $roles,
            'user_roles' => $request->user() ? $request->user()->roles->pluck('name')->toArray() : []
        ]);

        if (!$request->user()) {
            return redirect()->route('login');
        }

        foreach ($roles as $role) {
            if ($request->user()->hasRole($role)) {
                \Log::info('Role cocok: ' . $role);
                return $next($request);
            }
        }

        \Log::warning('User tidak memiliki role yang diperlukan', [
            'user' => $request->user()->email,
            'required_roles' => $roles,
            'user_roles' => $request->user()->roles->pluck('name')->toArray()
        ]);

        abort(403, 'Unauthorized action.');
    }
}
