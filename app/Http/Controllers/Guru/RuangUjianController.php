<?php
namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\RuangUjian;
use App\Models\BankSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RuangUjianController extends Controller {
    public function index() {
        $guru = Auth::guard('guru')->user();
        $ruangUjians = RuangUjian::where('guru_id', $guru->id)->with(['bankSoal', 'kelas'])->paginate(10);
        $bankSoals = BankSoal::where('guru_id', $guru->id)->get();
        $kelas = $guru->kelas;
        return view('pages.Guru.ruang_ujian.index', compact('ruangUjians', 'bankSoals', 'kelas'));
    }

    public function store(Request $request) {
        $request->validate(['nama_ruang' => 'required', 'bank_soal_id' => 'required|exists:bank_soals,id', 'tanggal_mulai' => 'required|date', 'batas_akhir' => 'required|date|after:tanggal_mulai']);
        $token = strtoupper(Str::random(6));
        while (RuangUjian::where('token', $token)->exists()) { $token = strtoupper(Str::random(6)); }
        $ruang = RuangUjian::create(array_merge($request->except('kelas_ids'), ['guru_id' => Auth::guard('guru')->id(), 'token' => $token]));
        if ($request->kelas_ids) { $ruang->kelas()->sync($request->kelas_ids); }
        return back()->with('success', 'Ruang ujian berhasil dibuat. Token: ' . $token);
    }

    public function update(Request $request, RuangUjian $ruangUjian) {
        if ($ruangUjian->guru_id !== Auth::guard('guru')->id()) { abort(403); }
        $ruangUjian->update($request->except('kelas_ids'));
        if ($request->kelas_ids) { $ruangUjian->kelas()->sync($request->kelas_ids); }
        return back()->with('success', 'Ruang ujian berhasil diperbarui.');
    }

    public function destroy(RuangUjian $ruangUjian) {
        if ($ruangUjian->guru_id !== Auth::guard('guru')->id()) { abort(403); }
        $ruangUjian->delete();
        return back()->with('success', 'Ruang ujian berhasil dihapus.');
    }

    public function monitoring(RuangUjian $ruangUjian) {
        if ($ruangUjian->guru_id !== Auth::guard('guru')->id()) { abort(403); }
        $ruangUjian->load(['ujianSiswas.siswa', 'bankSoal']);
        return view('pages.Guru.ruang_ujian.monitoring', compact('ruangUjian'));
    }
}
