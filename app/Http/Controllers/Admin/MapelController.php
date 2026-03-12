<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller {
    public function index() {
        $mapels = Mapel::orderBy('kode')->paginate(10);
        return view('pages.Admin.mapel', compact('mapels'));
    }

    public function store(Request $request) {
        $request->validate(['nama_mapel' => 'required|array', 'nama_mapel.*' => 'required|string|max:100']);
        $lastMapel = Mapel::orderBy('id', 'desc')->first();
        $lastNum = $lastMapel ? (int) substr($lastMapel->kode, 1) : 0;
        foreach ($request->nama_mapel as $nama) {
            $lastNum++;
            Mapel::create(['kode' => 'M' . $lastNum, 'nama_mapel' => $nama]);
        }
        return back()->with('success', 'Data mapel berhasil ditambahkan.');
    }

    public function update(Request $request, Mapel $mapel) {
        $request->validate(['nama_mapel' => 'required|string|max:100']);
        $mapel->update(['nama_mapel' => $request->nama_mapel]);
        return back()->with('success', 'Data mapel berhasil diperbarui.');
    }

    public function destroy(Mapel $mapel) {
        $mapel->delete();
        return back()->with('success', 'Data mapel berhasil dihapus.');
    }

    public function bulkDelete(Request $request) {
        $request->validate(['ids' => 'required|array']);
        Mapel::whereIn('id', $request->ids)->delete();
        return back()->with('success', 'Data mapel berhasil dihapus.');
    }
}
