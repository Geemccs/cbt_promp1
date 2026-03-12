<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\RuangUjian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaLoginController extends Controller {
    public function login(Request $request) {
        $credentials = $request->validate([
            'nisn' => 'required',
            'password' => 'required',
        ]);
        if (Auth::guard('siswa')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->route('siswa.dashboard');
        }
        return back()->with('error_siswa', 'NISN atau password salah.');
    }

    public function loginToken(Request $request) {
        $request->validate(['token' => 'required']);
        $ruangUjian = RuangUjian::where('token', strtoupper($request->token))->first();
        if (!$ruangUjian) {
            return back()->with('error_siswa', 'Token ujian tidak valid.');
        }
        $siswa = Auth::guard('siswa')->user();
        if (!$siswa) {
            return back()->with('error_siswa', 'Silakan login terlebih dahulu.');
        }
        return redirect()->route('siswa.ujian.mulai', $ruangUjian->id);
    }

    public function logout(Request $request) {
        Auth::guard('siswa')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
