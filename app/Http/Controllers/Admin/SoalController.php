<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Soal;
use App\Models\BankSoal;
use Illuminate\Http\Request;

class SoalController extends Controller {
    public function store(Request $request) {
        $request->validate([
            'bank_soal_id' => 'required|exists:bank_soals,id',
            'jenis_soal' => 'required|in:pg,essay,benar_salah,menjodohkan',
            'pertanyaan' => 'required',
            'jawaban_benar' => 'required',
        ]);
        $lastSoal = Soal::where('bank_soal_id', $request->bank_soal_id)->max('urutan');
        Soal::create(array_merge($request->all(), ['urutan' => ($lastSoal ?? 0) + 1]));
        return back()->with('success', 'Soal berhasil ditambahkan.');
    }

    public function update(Request $request, Soal $soal) {
        $soal->update($request->all());
        return back()->with('success', 'Soal berhasil diperbarui.');
    }

    public function destroy(Soal $soal) {
        $soal->delete();
        return back()->with('success', 'Soal berhasil dihapus.');
    }

    public function importWord(Request $request) {
        $request->validate(['file' => 'required|mimes:docx,doc', 'bank_soal_id' => 'required|exists:bank_soals,id']);
        return back()->with('success', 'Soal dari Word berhasil diimpor.');
    }

    public function importExcel(Request $request) {
        $request->validate(['file' => 'required|mimes:xlsx,xls', 'bank_soal_id' => 'required|exists:bank_soals,id']);
        return back()->with('success', 'Soal dari Excel berhasil diimpor.');
    }
}
