<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\GuruLoginController;
use App\Http\Controllers\Auth\SiswaLoginController;

Route::get('/', fn() => redirect()->route('login'));
Route::get('/login', fn() => view('auth.login'))->name('login');

Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
Route::post('/guru/login', [GuruLoginController::class, 'login'])->name('guru.login');
Route::post('/guru/logout', [GuruLoginController::class, 'logout'])->name('guru.logout');
Route::post('/siswa/login', [SiswaLoginController::class, 'login'])->name('siswa.login');
Route::post('/siswa/logout', [SiswaLoginController::class, 'logout'])->name('siswa.logout');

Route::prefix('admin')->middleware('admin.auth')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/kelas', [\App\Http\Controllers\Admin\KelasController::class, 'index'])->name('kelas.index');
    Route::post('/kelas', [\App\Http\Controllers\Admin\KelasController::class, 'store'])->name('kelas.store');
    Route::put('/kelas/{kelas}', [\App\Http\Controllers\Admin\KelasController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas/{kelas}', [\App\Http\Controllers\Admin\KelasController::class, 'destroy'])->name('kelas.destroy');
    Route::post('/kelas/bulk-delete', [\App\Http\Controllers\Admin\KelasController::class, 'bulkDelete'])->name('kelas.bulk-delete');
    Route::get('/mapel', [\App\Http\Controllers\Admin\MapelController::class, 'index'])->name('mapel.index');
    Route::post('/mapel', [\App\Http\Controllers\Admin\MapelController::class, 'store'])->name('mapel.store');
    Route::put('/mapel/{mapel}', [\App\Http\Controllers\Admin\MapelController::class, 'update'])->name('mapel.update');
    Route::delete('/mapel/{mapel}', [\App\Http\Controllers\Admin\MapelController::class, 'destroy'])->name('mapel.destroy');
    Route::post('/mapel/bulk-delete', [\App\Http\Controllers\Admin\MapelController::class, 'bulkDelete'])->name('mapel.bulk-delete');
    Route::get('/guru', [\App\Http\Controllers\Admin\GuruController::class, 'index'])->name('guru.index');
    Route::post('/guru', [\App\Http\Controllers\Admin\GuruController::class, 'store'])->name('guru.store');
    Route::put('/guru/{guru}', [\App\Http\Controllers\Admin\GuruController::class, 'update'])->name('guru.update');
    Route::delete('/guru/{guru}', [\App\Http\Controllers\Admin\GuruController::class, 'destroy'])->name('guru.destroy');
    Route::post('/guru/{guru}/relasi', [\App\Http\Controllers\Admin\GuruController::class, 'updateRelasi'])->name('guru.relasi');
    Route::post('/guru/import', [\App\Http\Controllers\Admin\GuruController::class, 'import'])->name('guru.import');
    Route::get('/siswa', [\App\Http\Controllers\Admin\SiswaController::class, 'index'])->name('siswa.index');
    Route::post('/siswa', [\App\Http\Controllers\Admin\SiswaController::class, 'store'])->name('siswa.store');
    Route::put('/siswa/{siswa}', [\App\Http\Controllers\Admin\SiswaController::class, 'update'])->name('siswa.update');
    Route::delete('/siswa/{siswa}', [\App\Http\Controllers\Admin\SiswaController::class, 'destroy'])->name('siswa.destroy');
    Route::post('/siswa/import', [\App\Http\Controllers\Admin\SiswaController::class, 'import'])->name('siswa.import');
    Route::get('/bank-soal', [\App\Http\Controllers\Admin\BankSoalController::class, 'index'])->name('bank-soal.index');
    Route::post('/bank-soal', [\App\Http\Controllers\Admin\BankSoalController::class, 'store'])->name('bank-soal.store');
    Route::get('/bank-soal/{bankSoal}/edit', [\App\Http\Controllers\Admin\BankSoalController::class, 'edit'])->name('bank-soal.edit');
    Route::put('/bank-soal/{bankSoal}', [\App\Http\Controllers\Admin\BankSoalController::class, 'update'])->name('bank-soal.update');
    Route::delete('/bank-soal/{bankSoal}', [\App\Http\Controllers\Admin\BankSoalController::class, 'destroy'])->name('bank-soal.destroy');
    Route::post('/soal', [\App\Http\Controllers\Admin\SoalController::class, 'store'])->name('soal.store');
    Route::put('/soal/{soal}', [\App\Http\Controllers\Admin\SoalController::class, 'update'])->name('soal.update');
    Route::delete('/soal/{soal}', [\App\Http\Controllers\Admin\SoalController::class, 'destroy'])->name('soal.destroy');
    Route::post('/soal/import-word', [\App\Http\Controllers\Admin\SoalController::class, 'importWord'])->name('soal.import-word');
    Route::post('/soal/import-excel', [\App\Http\Controllers\Admin\SoalController::class, 'importExcel'])->name('soal.import-excel');
    Route::get('/ruang-ujian', [\App\Http\Controllers\Admin\RuangUjianController::class, 'index'])->name('ruang-ujian.index');
    Route::post('/ruang-ujian', [\App\Http\Controllers\Admin\RuangUjianController::class, 'store'])->name('ruang-ujian.store');
    Route::put('/ruang-ujian/{ruangUjian}', [\App\Http\Controllers\Admin\RuangUjianController::class, 'update'])->name('ruang-ujian.update');
    Route::delete('/ruang-ujian/{ruangUjian}', [\App\Http\Controllers\Admin\RuangUjianController::class, 'destroy'])->name('ruang-ujian.destroy');
    Route::get('/ruang-ujian/{ruangUjian}/monitoring', [\App\Http\Controllers\Admin\RuangUjianController::class, 'monitoring'])->name('ruang-ujian.monitoring');
    Route::post('/ruang-ujian/{ruangUjian}/reset-siswa', [\App\Http\Controllers\Admin\RuangUjianController::class, 'resetSiswa'])->name('ruang-ujian.reset-siswa');
    Route::get('/exambrowser', [\App\Http\Controllers\Admin\ExambrowserController::class, 'index'])->name('exambrowser.index');
    Route::post('/exambrowser/toggle', [\App\Http\Controllers\Admin\ExambrowserController::class, 'toggle'])->name('exambrowser.toggle');
    Route::get('/administrator', [\App\Http\Controllers\Admin\AdministratorController::class, 'index'])->name('administrator.index');
    Route::post('/administrator', [\App\Http\Controllers\Admin\AdministratorController::class, 'store'])->name('administrator.store');
    Route::put('/administrator/{administrator}', [\App\Http\Controllers\Admin\AdministratorController::class, 'update'])->name('administrator.update');
    Route::delete('/administrator/{administrator}', [\App\Http\Controllers\Admin\AdministratorController::class, 'destroy'])->name('administrator.destroy');
    Route::get('/pengumuman', [\App\Http\Controllers\Admin\PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::post('/pengumuman', [\App\Http\Controllers\Admin\PengumumanController::class, 'store'])->name('pengumuman.store');
    Route::put('/pengumuman/{pengumuman}', [\App\Http\Controllers\Admin\PengumumanController::class, 'update'])->name('pengumuman.update');
    Route::delete('/pengumuman/{pengumuman}', [\App\Http\Controllers\Admin\PengumumanController::class, 'destroy'])->name('pengumuman.destroy');
});

Route::prefix('guru')->middleware('guru.auth')->name('guru.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Guru\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/bank-soal', [\App\Http\Controllers\Guru\BankSoalController::class, 'index'])->name('bank-soal.index');
    Route::post('/bank-soal', [\App\Http\Controllers\Guru\BankSoalController::class, 'store'])->name('bank-soal.store');
    Route::get('/bank-soal/{bankSoal}/edit', [\App\Http\Controllers\Guru\BankSoalController::class, 'edit'])->name('bank-soal.edit');
    Route::put('/bank-soal/{bankSoal}', [\App\Http\Controllers\Guru\BankSoalController::class, 'update'])->name('bank-soal.update');
    Route::delete('/bank-soal/{bankSoal}', [\App\Http\Controllers\Guru\BankSoalController::class, 'destroy'])->name('bank-soal.destroy');
    Route::post('/soal', [\App\Http\Controllers\Guru\SoalController::class, 'store'])->name('soal.store');
    Route::put('/soal/{soal}', [\App\Http\Controllers\Guru\SoalController::class, 'update'])->name('soal.update');
    Route::delete('/soal/{soal}', [\App\Http\Controllers\Guru\SoalController::class, 'destroy'])->name('soal.destroy');
    Route::get('/ruang-ujian', [\App\Http\Controllers\Guru\RuangUjianController::class, 'index'])->name('ruang-ujian.index');
    Route::post('/ruang-ujian', [\App\Http\Controllers\Guru\RuangUjianController::class, 'store'])->name('ruang-ujian.store');
    Route::put('/ruang-ujian/{ruangUjian}', [\App\Http\Controllers\Guru\RuangUjianController::class, 'update'])->name('ruang-ujian.update');
    Route::delete('/ruang-ujian/{ruangUjian}', [\App\Http\Controllers\Guru\RuangUjianController::class, 'destroy'])->name('ruang-ujian.destroy');
    Route::get('/ruang-ujian/{ruangUjian}/monitoring', [\App\Http\Controllers\Guru\RuangUjianController::class, 'monitoring'])->name('ruang-ujian.monitoring');
});

Route::prefix('siswa')->middleware('siswa.auth')->name('siswa.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Siswa\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/ruang-ujian', [\App\Http\Controllers\Siswa\DashboardController::class, 'masukToken'])->name('ruang-ujian');
    Route::post('/ujian/masuk-token', [\App\Http\Controllers\Siswa\UjianController::class, 'masukToken'])->name('ujian.masuk-token');
    Route::get('/ujian/{ruangUjian}/mulai', [\App\Http\Controllers\Siswa\UjianController::class, 'mulai'])->name('ujian.mulai');
    Route::post('/ujian/jawab', [\App\Http\Controllers\Siswa\UjianController::class, 'jawab'])->name('ujian.jawab');
    Route::post('/ujian/selesai', [\App\Http\Controllers\Siswa\UjianController::class, 'selesai'])->name('ujian.selesai');
    Route::post('/ujian/keluar', [\App\Http\Controllers\Siswa\UjianController::class, 'keluar'])->name('ujian.keluar');
});
