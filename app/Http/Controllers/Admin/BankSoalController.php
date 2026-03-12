<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankSoal;
use App\Models\Guru;
use App\Models\Mapel;
use Illuminate\Http\Request;

class BankSoalController extends Controller {
    public function index() {
        $bankSoals = BankSoal::with(['guru', 'mapel'])->paginate(10);
        $gurus = Guru::all();
        $mapels = Mapel::all();
        return view('pages.Admin.bank_soal.index', compact('bankSoals', 'gurus', 'mapels'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama_soal' => 'required',
            'mapel_id' => 'required|exists:mapels,id',
            'waktu_mengerjakan' => 'required|integer|min:1',
            'bobot_pg' => 'required|numeric|min:0|max:100',
            'bobot_essay' => 'required|numeric|min:0|max:100',
            'bobot_menjodohkan' => 'required|numeric|min:0|max:100',
            'bobot_benar_salah' => 'required|numeric|min:0|max:100',
        ]);
        $totalBobot = $request->bobot_pg + $request->bobot_essay + $request->bobot_menjodohkan + $request->bobot_benar_salah;
        if ($totalBobot != 100) {
            return back()->with('error', 'Total bobot harus 100%.');
        }
        BankSoal::create($request->all());
        return back()->with('success', 'Bank soal berhasil dibuat.');
    }

    public function edit(BankSoal $bankSoal) {
        $soals = $bankSoal->soals()->orderBy('urutan')->get();
        return view('pages.Admin.bank_soal.edit', compact('bankSoal', 'soals'));
    }

    public function update(Request $request, BankSoal $bankSoal) {
        $bankSoal->update($request->all());
        return back()->with('success', 'Bank soal berhasil diperbarui.');
    }

    public function destroy(BankSoal $bankSoal) {
        $bankSoal->delete();
        return back()->with('success', 'Bank soal berhasil dihapus.');
    }
}
