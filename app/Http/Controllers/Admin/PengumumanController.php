<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use App\Models\Kelas;
use Illuminate\Http\Request;

class PengumumanController extends Controller {
    public function index() {
        $pengumumans = Pengumuman::with('kelas')->paginate(10);
        $kelas = Kelas::all();
        return view('pages.Admin.pengumuman', compact('pengumumans', 'kelas'));
    }

    public function store(Request $request) {
        $request->validate(['isi' => 'required']);
        $pengumuman = Pengumuman::create(['isi' => $request->isi]);
        if ($request->kelas_ids) {
            $pengumuman->kelas()->sync($request->kelas_ids);
        }
        return back()->with('success', 'Pengumuman berhasil ditambahkan.');
    }

    public function update(Request $request, Pengumuman $pengumuman) {
        $request->validate(['isi' => 'required']);
        $pengumuman->update(['isi' => $request->isi]);
        if ($request->kelas_ids !== null) {
            $pengumuman->kelas()->sync($request->kelas_ids ?? []);
        }
        return back()->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Pengumuman $pengumuman) {
        $pengumuman->delete();
        return back()->with('success', 'Pengumuman berhasil dihapus.');
    }
}
