<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class isResepsionis
{
    
    public function handle(Request $request, Closure $next): Response
    {

         // Jika user tidak terautentikasi, redirect ke login
        if (!Auth::check()) {
            
            return redirect()->route('login');
        }
        // Ambil role dari session atau dari relasi user
        $userRole = session('user_role');

        // Jika user terautentikasi tapi role  1, return 403
        if ($userRole == 4) {

            return $next($request);
        } else {
            return back()->with('error', 'Akses ditolak. Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

    }
}
