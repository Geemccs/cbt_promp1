<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\BankSoal;
use App\Models\RuangUjian;

class DashboardController extends Controller {
    public function index() {
        $siswaCount = Siswa::count();
        $guruCount = Guru::count();
        $kelasCount = Kelas::count();
        $mapelCount = Mapel::count();
        $bankSoalCount = BankSoal::count();
        $ruangUjianCount = RuangUjian::count();
        return view('pages.Admin.dashboard', compact('siswaCount', 'guruCount', 'kelasCount', 'mapelCount', 'bankSoalCount', 'ruangUjianCount'));
    }
}
