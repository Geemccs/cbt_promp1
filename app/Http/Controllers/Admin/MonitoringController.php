<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RuangUjian;

class MonitoringController extends Controller {
    public function index() {
        $ruangUjians = RuangUjian::with(['ujianSiswas'])->get();
        return view('pages.Admin.monitoring', compact('ruangUjians'));
    }
}
