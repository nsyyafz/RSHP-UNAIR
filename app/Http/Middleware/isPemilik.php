<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsPemilik
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user tidak terautentikasi, redirect ke login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Ambil role dari session
        $userRole = session('user_role');

        // Cek apakah role adalah 5 (Pemilik)
        if ($userRole === 5) {
            return $next($request);
        } else {
            return back()->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }
}