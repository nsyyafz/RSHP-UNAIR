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

        // User tanpa role khusus (bukan 1,2,3,4) dianggap sebagai pemilik
        // Jika tidak ada role atau role selain 1,2,3,4, maka dianggap pemilik
        if (empty($userRole) || !in_array($userRole, [1, 2, 3, 4])) {
            return $next($request);
        } else {
            return back()->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }
    }
}