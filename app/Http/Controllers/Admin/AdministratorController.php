<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdministratorController extends Controller {
    public function index() {
        $admins = Admin::paginate(10);
        return view('pages.Admin.administrator', compact('admins'));
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required', 'email' => 'required|email|unique:admins', 'password' => 'required|min:6']);
        Admin::create(['name' => $request->name, 'email' => $request->email, 'password' => Hash::make($request->password)]);
        return back()->with('success', 'Administrator berhasil ditambahkan.');
    }

    public function update(Request $request, Admin $administrator) {
        $request->validate(['name' => 'required', 'email' => 'required|email|unique:admins,email,' . $administrator->id]);
        $data = ['name' => $request->name, 'email' => $request->email];
        if ($request->password) { $data['password'] = Hash::make($request->password); }
        $administrator->update($data);
        return back()->with('success', 'Administrator berhasil diperbarui.');
    }

    public function destroy(Admin $administrator) {
        if ($administrator->id === Auth::guard('admin')->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }
        $administrator->delete();
        return back()->with('success', 'Administrator berhasil dihapus.');
    }
}
