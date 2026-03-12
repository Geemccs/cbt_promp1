<?php
namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Soal;
use App\Models\BankSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SoalController extends Controller {
    public function store(Request $request) {
        $bankSoal = BankSoal::findOrFail($request->bank_soal_id);
        if ($bankSoal->guru_id !== Auth::guard('guru')->id()) { abort(403); }
        $request->validate(['bank_soal_id' => 'required|exists:bank_soals,id', 'jenis_soal' => 'required|in:pg,essay,benar_salah,menjodohkan', 'pertanyaan' => 'required', 'jawaban_benar' => 'required']);
        $lastUrutan = Soal::where('bank_soal_id', $request->bank_soal_id)->max('urutan');
        Soal::create(array_merge($request->all(), ['urutan' => ($lastUrutan ?? 0) + 1]));
        return back()->with('success', 'Soal berhasil ditambahkan.');
    }

    public function update(Request $request, Soal $soal) {
        if ($soal->bankSoal->guru_id !== Auth::guard('guru')->id()) { abort(403); }
        $soal->update($request->all());
        return back()->with('success', 'Soal berhasil diperbarui.');
    }

    public function destroy(Soal $soal) {
        if ($soal->bankSoal->guru_id !== Auth::guard('guru')->id()) { abort(403); }
        $soal->delete();
        return back()->with('success', 'Soal berhasil dihapus.');
    }
}
