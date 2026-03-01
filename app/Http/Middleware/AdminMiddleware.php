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
        // Pastikan pengguna sudah login
        if (!Auth::check()) {
            return redirect('/dashboard/login')->with('loginError', 'Silakan login terlebih dahulu.');
        }

        // Ambil data pengguna yang sedang login
        $user = Auth::user();

        // Pastikan level pengguna adalah 'Admin' atau 'Super Admin' dan statusnya 'Aktif'
        if (!in_array($user->level_pengguna, ['Admin', 'Super Admin'])) {
            return redirect('/dashboard/login')->with('loginError', 'Anda tidak memiliki akses.');
        }

        if ($user->status !== 'Aktif') {
            return redirect('/dashboard/login')->with('loginError', 'Akun Anda tidak aktif.');
        }

        return $next($request);
    }
}
