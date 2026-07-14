<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check() || !in_array(auth()->user()->role, $roles)) {
            // Redirect based on role or abort if they don't have access
            if (auth()->check()) {
                $role = auth()->user()->role;
                if ($role === 'owner') {
                    return redirect('/admin/dashboard');
                } elseif ($role === 'karyawan') {
                    return redirect('/admin/orders');
                }
                return redirect('/profile');
            }
            return redirect('/login');
        }

        return $next($request);
    }
}
