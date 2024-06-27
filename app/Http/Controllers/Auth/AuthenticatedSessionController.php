<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login'); // Pastikan Anda memiliki view auth.login
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Memeriksa role pengguna setelah berhasil login
        if (Auth::user()->role->name === 'admin') {
            return redirect()->intended(RouteServiceProvider::HOME); // Redirect admin ke /dashboard
        } elseif (Auth::user()->role->name === 'karyawan') {
            return redirect()->intended('/absensi/form-absen'); // Redirect karyawan ke /absensi/form-absen
        } else {
            return redirect()->back(); // Jika role bukan admin, karyawan, atau jika tidak ada role
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
