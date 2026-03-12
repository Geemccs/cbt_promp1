<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller {
    public function index() {
        $kelas = Kelas::orderBy('kode')->paginate(10);
        return view('pages.Admin.kelas', compact('kelas'));
    }

    public function store(Request $request) {
        $request->validate(['nama_kelas' => 'required|array', 'nama_kelas.*' => 'required|string|max:100']);
        $lastKelas = Kelas::orderBy('id', 'desc')->first();
        $lastNum = $lastKelas ? (int) substr($lastKelas->kode, 1) : 0;
        foreach ($request->nama_kelas as $nama) {
            $lastNum++;
            Kelas::create(['kode' => 'K' . $lastNum, 'nama_kelas' => $nama]);
        }
        return back()->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function update(Request $request, Kelas $kelas) {
        $request->validate(['nama_kelas' => 'required|string|max:100']);
        $kelas->update(['nama_kelas' => $request->nama_kelas]);
        return back()->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kelas) {
        $kelas->delete();
        return back()->with('success', 'Data kelas berhasil dihapus.');
    }

    public function bulkDelete(Request $request) {
        $request->validate(['ids' => 'required|array']);
        Kelas::whereIn('id', $request->ids)->delete();
        return back()->with('success', 'Data kelas berhasil dihapus.');
    }
}
