<?php
namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\BankSoal;
use App\Models\RuangUjian;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller {
    public function index() {
        $guru = Auth::guard('guru')->user();
        $totalBankSoal = BankSoal::where('guru_id', $guru->id)->count();
        $totalRuangUjian = RuangUjian::where('guru_id', $guru->id)->count();
        return view('pages.Guru.dashboard', compact('guru', 'totalBankSoal', 'totalRuangUjian'));
    }
}
