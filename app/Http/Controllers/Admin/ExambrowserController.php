<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class ExambrowserController extends Controller {
    public function index() {
        $sebEnabled = Setting::get('seb_enabled', '0');
        return view('pages.Admin.exambrowser', compact('sebEnabled'));
    }

    public function toggle(Request $request) {
        $current = Setting::get('seb_enabled', '0');
        Setting::set('seb_enabled', $current === '1' ? '0' : '1');
        return back()->with('success', 'Pengaturan Exambrowser berhasil diperbarui.');
    }
}
