<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
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

        // Cek apakah pengguna memiliki level 'Super Admin' dan status 'Aktif'
        if ($user->level_pengguna !== 'Super Admin' || $user->status !== 'Aktif') {
            return redirect('/dashboard')->with('loginError', 'Anda tidak memiliki akses.');
        }

        return $next($request);
    }
}
