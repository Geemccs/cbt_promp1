<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller {
    public function index() {
        $siswas = Siswa::paginate(10);
        $kelas = Kelas::all();
        return view('pages.Admin.siswa', compact('siswas', 'kelas'));
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required', 'nisn' => 'required|size:10|unique:siswas', 'password' => 'required|min:6']);
        Siswa::create(['name' => $request->name, 'nisn' => $request->nisn, 'password' => Hash::make($request->password)]);
        return back()->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function update(Request $request, Siswa $siswa) {
        $request->validate(['name' => 'required', 'nisn' => 'required|size:10|unique:siswas,nisn,' . $siswa->id]);
        $data = ['name' => $request->name, 'nisn' => $request->nisn];
        if ($request->password) { $data['password'] = Hash::make($request->password); }
        $siswa->update($data);
        return back()->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa) {
        $siswa->delete();
        return back()->with('success', 'Data siswa berhasil dihapus.');
    }

    public function import(Request $request) {
        $request->validate(['file' => 'required|mimes:xlsx,xls']);
        return back()->with('success', 'Data siswa berhasil diimpor.');
    }
}
