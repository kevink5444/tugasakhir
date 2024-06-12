<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    // Bagian lain dari controller

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout(); // Keluar dari guard 'web'

        $request->session()->invalidate(); // Menghapus sesi

        $request->session()->regenerateToken(); // Regenerasi token sesi

        return redirect('/'); // Redirect ke halaman utama
    }
}
