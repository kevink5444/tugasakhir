<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MustAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Memeriksa jika pengguna adalah admin
        if (Auth::check() && Auth::user()->role->name === 'admin') {
            return $next($request); // Lanjutkan ke rute yang diminta
        }

        return redirect()->back(); // Redirect kembali jika bukan admin
    }
}
