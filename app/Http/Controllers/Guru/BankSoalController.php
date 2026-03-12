<?php
namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\BankSoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankSoalController extends Controller {
    public function index() {
        $guru = Auth::guard('guru')->user();
        $bankSoals = BankSoal::where('guru_id', $guru->id)->with('mapel')->paginate(10);
        $mapels = $guru->mapels;
        return view('pages.Guru.bank_soal.index', compact('bankSoals', 'mapels'));
    }

    public function store(Request $request) {
        $request->validate(['nama_soal' => 'required', 'mapel_id' => 'required|exists:mapels,id', 'waktu_mengerjakan' => 'required|integer|min:1', 'bobot_pg' => 'required|numeric|min:0|max:100', 'bobot_essay' => 'required|numeric|min:0|max:100', 'bobot_menjodohkan' => 'required|numeric|min:0|max:100', 'bobot_benar_salah' => 'required|numeric|min:0|max:100']);
        $totalBobot = $request->bobot_pg + $request->bobot_essay + $request->bobot_menjodohkan + $request->bobot_benar_salah;
        if ($totalBobot != 100) { return back()->with('error', 'Total bobot harus 100%.'); }
        BankSoal::create(array_merge($request->all(), ['guru_id' => Auth::guard('guru')->id()]));
        return back()->with('success', 'Bank soal berhasil dibuat.');
    }

    public function edit(BankSoal $bankSoal) {
        $guru = Auth::guard('guru')->user();
        if ($bankSoal->guru_id !== $guru->id) { abort(403); }
        $soals = $bankSoal->soals()->orderBy('urutan')->get();
        return view('pages.Guru.bank_soal.edit', compact('bankSoal', 'soals'));
    }

    public function update(Request $request, BankSoal $bankSoal) {
        if ($bankSoal->guru_id !== Auth::guard('guru')->id()) { abort(403); }
        $bankSoal->update($request->all());
        return back()->with('success', 'Bank soal berhasil diperbarui.');
    }

    public function destroy(BankSoal $bankSoal) {
        if ($bankSoal->guru_id !== Auth::guard('guru')->id()) { abort(403); }
        $bankSoal->delete();
        return back()->with('success', 'Bank soal berhasil dihapus.');
    }
}
