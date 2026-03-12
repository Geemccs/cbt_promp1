<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruLoginController extends Controller {
    public function login(Request $request) {
        $credentials = $request->validate([
            'nik' => 'required',
            'password' => 'required',
        ]);
        if (Auth::guard('guru')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->route('guru.dashboard');
        }
        return back()->with('error_guru', 'NIK atau password salah.');
    }

    public function logout(Request $request) {
        Auth::guard('guru')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
