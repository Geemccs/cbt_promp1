<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller {
    public function index() {
        $gurus = Guru::with(['kelas', 'mapels'])->paginate(10);
        $kelas = Kelas::all();
        $mapels = Mapel::all();
        return view('pages.Admin.guru', compact('gurus', 'kelas', 'mapels'));
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required', 'nik' => 'required|size:16|unique:gurus', 'password' => 'required|min:6']);
        Guru::create(['name' => $request->name, 'nik' => $request->nik, 'password' => Hash::make($request->password)]);
        return back()->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function update(Request $request, Guru $guru) {
        $request->validate(['name' => 'required', 'nik' => 'required|size:16|unique:gurus,nik,' . $guru->id]);
        $data = ['name' => $request->name, 'nik' => $request->nik];
        if ($request->password) { $data['password'] = Hash::make($request->password); }
        $guru->update($data);
        return back()->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru) {
        $guru->delete();
        return back()->with('success', 'Data guru berhasil dihapus.');
    }

    public function updateRelasi(Request $request, Guru $guru) {
        $guru->kelas()->sync($request->kelas_ids ?? []);
        $guru->mapels()->sync($request->mapel_ids ?? []);
        return back()->with('success', 'Relasi guru berhasil diperbarui.');
    }

    public function import(Request $request) {
        $request->validate(['file' => 'required|mimes:xlsx,xls']);
        return back()->with('success', 'Data guru berhasil diimpor.');
    }

    public function downloadTemplate() {
        return response()->json(['message' => 'Template download']);
    }
}
