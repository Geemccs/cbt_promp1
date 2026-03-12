<?php
namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\RuangUjian;
use App\Models\UjianSiswa;
use App\Models\JawabanSiswa;
use App\Models\Soal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UjianController extends Controller {
    public function masukToken(Request $request) {
        $request->validate(['token' => 'required']);
        $ruangUjian = RuangUjian::where('token', strtoupper($request->token))->first();
        if (!$ruangUjian) return back()->with('error', 'Token tidak valid.');
        $now = now();
        if ($now < $ruangUjian->tanggal_mulai) return back()->with('error', 'Ujian belum dimulai.');
        if ($now > $ruangUjian->batas_akhir) return back()->with('error', 'Waktu ujian telah berakhir.');
        return redirect()->route('siswa.ujian.mulai', $ruangUjian->id);
    }

    public function mulai(RuangUjian $ruangUjian) {
        $siswa = Auth::guard('siswa')->user();
        $ujianSiswa = UjianSiswa::firstOrCreate(
            ['ruang_ujian_id' => $ruangUjian->id, 'siswa_id' => $siswa->id],
            ['status' => 'belum']
        );
        if ($ujianSiswa->status === 'selesai') return redirect()->route('siswa.dashboard')->with('info', 'Ujian sudah selesai.');
        if ($ujianSiswa->status === 'belum') {
            $ujianSiswa->update(['status' => 'sedang', 'waktu_mulai' => now()]);
            $soals = $ruangUjian->acak_soal ? $ruangUjian->bankSoal->soals()->inRandomOrder()->get() : $ruangUjian->bankSoal->soals()->orderBy('urutan')->get();
            foreach ($soals as $soal) JawabanSiswa::firstOrCreate(['ujian_siswa_id' => $ujianSiswa->id, 'soal_id' => $soal->id]);
        }
        $soals = $ruangUjian->bankSoal->soals()->orderBy('urutan')->get();
        $jawabanSiswas = JawabanSiswa::where('ujian_siswa_id', $ujianSiswa->id)->get()->keyBy('soal_id');
        $waktuMulai = $ujianSiswa->waktu_mulai;
        $waktuSelesai = $waktuMulai->copy()->addMinutes($ruangUjian->bankSoal->waktu_mengerjakan);
        return view('pages.Siswa.ujian', compact('ruangUjian', 'ujianSiswa', 'soals', 'jawabanSiswas', 'waktuSelesai'));
    }

    public function jawab(Request $request) {
        $request->validate(['ujian_siswa_id' => 'required|exists:ujian_siswas,id', 'soal_id' => 'required|exists:soals,id', 'jawaban' => 'nullable']);
        $ujianSiswa = UjianSiswa::findOrFail($request->ujian_siswa_id);
        if ($ujianSiswa->siswa_id !== Auth::guard('siswa')->id()) abort(403);
        $soal = Soal::findOrFail($request->soal_id);
        $isBenar = strtolower(trim($request->jawaban ?? '')) === strtolower(trim($soal->jawaban_benar));
        JawabanSiswa::updateOrCreate(['ujian_siswa_id' => $request->ujian_siswa_id, 'soal_id' => $request->soal_id], ['jawaban' => $request->jawaban, 'is_benar' => $isBenar]);
        return response()->json(['success' => true]);
    }

    public function selesai(Request $request) {
        $request->validate(['ujian_siswa_id' => 'required|exists:ujian_siswas,id']);
        $ujianSiswa = UjianSiswa::with(['jawabanSiswas', 'ruangUjian.bankSoal'])->findOrFail($request->ujian_siswa_id);
        if ($ujianSiswa->siswa_id !== Auth::guard('siswa')->id()) abort(403);
        $jumlahBenar = $ujianSiswa->jawabanSiswas->where('is_benar', true)->count();
        $jumlahSoal = $ujianSiswa->jawabanSiswas->count();
        $nilai = $jumlahSoal > 0 ? ($jumlahBenar / $jumlahSoal) * 100 : 0;
        $ujianSiswa->update(['status' => 'selesai', 'waktu_selesai' => now(), 'jumlah_benar' => $jumlahBenar, 'jumlah_salah' => $jumlahSoal - $jumlahBenar, 'nilai' => $nilai]);
        return redirect()->route('siswa.dashboard')->with('success', 'Ujian selesai. Nilai: ' . number_format($nilai, 2));
    }

    public function keluar(Request $request) {
        $request->validate(['ujian_siswa_id' => 'required|exists:ujian_siswas,id']);
        $ujianSiswa = UjianSiswa::findOrFail($request->ujian_siswa_id);
        if ($ujianSiswa->siswa_id !== Auth::guard('siswa')->id()) abort(403);
        $ujianSiswa->increment('jumlah_keluar');
        $ujianSiswa->refresh();
        if ($ujianSiswa->jumlah_keluar >= $ujianSiswa->ruangUjian->batas_keluar) {
            $this->selesai($request);
            return response()->json(['redirect' => route('siswa.dashboard'), 'message' => 'Batas keluar terlampaui.']);
        }
        return response()->json(['success' => true, 'jumlah_keluar' => $ujianSiswa->jumlah_keluar]);
    }
}
