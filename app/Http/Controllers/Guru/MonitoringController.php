<?php
namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\RuangUjian;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller {
    public function index() {
        $guru = Auth::guard('guru')->user();
        $ruangUjians = RuangUjian::where('guru_id', $guru->id)->with('ujianSiswas')->get();
        return view('pages.Guru.monitoring', compact('ruangUjians'));
    }
}
