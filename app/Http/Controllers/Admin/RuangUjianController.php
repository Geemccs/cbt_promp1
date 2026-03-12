<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RuangUjian;
use App\Models\BankSoal;
use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RuangUjianController extends Controller {
    public function index() {
        $ruangUjians = RuangUjian::with(['guru', 'bankSoal', 'kelas'])->paginate(10);
        $bankSoals = BankSoal::all();
        $gurus = Guru::all();
        $kelas = Kelas::all();
        return view('pages.Admin.ruang_ujian.index', compact('ruangUjians', 'bankSoals', 'gurus', 'kelas'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama_ruang' => 'required',
            'bank_soal_id' => 'required|exists:bank_soals,id',
            'tanggal_mulai' => 'required|date',
            'batas_akhir' => 'required|date|after:tanggal_mulai',
            'batas_keluar' => 'required|integer|min:0',
        ]);
        $token = strtoupper(Str::random(6));
        while (RuangUjian::where('token', $token)->exists()) {
            $token = strtoupper(Str::random(6));
        }
        $ruang = RuangUjian::create(array_merge($request->except('kelas_ids'), ['token' => $token]));
        if ($request->kelas_ids) {
            $ruang->kelas()->sync($request->kelas_ids);
        }
        return back()->with('success', 'Ruang ujian berhasil dibuat. Token: ' . $token);
    }

    public function update(Request $request, RuangUjian $ruangUjian) {
        $ruangUjian->update($request->except('kelas_ids'));
        if ($request->kelas_ids) {
            $ruangUjian->kelas()->sync($request->kelas_ids);
        }
        return back()->with('success', 'Ruang ujian berhasil diperbarui.');
    }

    public function destroy(RuangUjian $ruangUjian) {
        $ruangUjian->delete();
        return back()->with('success', 'Ruang ujian berhasil dihapus.');
    }

    public function monitoring(RuangUjian $ruangUjian) {
        $ruangUjian->load(['ujianSiswas.siswa', 'bankSoal']);
        return view('pages.Admin.ruang_ujian.monitoring', compact('ruangUjian'));
    }

    public function resetSiswa(Request $request, RuangUjian $ruangUjian) {
        $request->validate(['siswa_id' => 'required|exists:siswas,id']);
        $ujianSiswa = $ruangUjian->ujianSiswas()->where('siswa_id', $request->siswa_id)->first();
        if ($ujianSiswa) {
            $ujianSiswa->jawabanSiswas()->delete();
            $ujianSiswa->update(['status' => 'belum', 'waktu_mulai' => null, 'waktu_selesai' => null, 'nilai' => null, 'jumlah_keluar' => 0]);
        }
        return back()->with('success', 'Ujian siswa berhasil direset.');
    }
}
