<?php
namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\UjianSiswa;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {
    public function index() {
        $siswa = Auth::guard('siswa')->user();
        $ujianSiswas = UjianSiswa::where('siswa_id', $siswa->id)->with('ruangUjian')->get();
        $pengumumans = Pengumuman::latest()->take(5)->get();
        return view('pages.Siswa.dashboard', compact('siswa', 'ujianSiswas', 'pengumumans'));
    }
    public function masukToken() {
        return view('pages.Siswa.ruang_ujian');
    }
}
