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
        $data = [
            'total_siswa' => Siswa::count(),
            'total_guru' => Guru::count(),
            'total_kelas' => Kelas::count(),
            'total_mapel' => Mapel::count(),
            'total_bank_soal' => BankSoal::count(),
            'total_ruang_ujian' => RuangUjian::count(),
        ];
        return view('pages.Admin.dashboard', $data);
    }
}
