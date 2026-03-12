<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuangUjian extends Model {
    use HasFactory;
    protected $fillable = ['nama_ruang', 'guru_id', 'bank_soal_id', 'token', 'waktu_hentikan', 'batas_keluar', 'tanggal_mulai', 'batas_akhir', 'acak_soal', 'acak_jawaban'];
    protected $casts = ['tanggal_mulai' => 'datetime', 'batas_akhir' => 'datetime', 'acak_soal' => 'boolean', 'acak_jawaban' => 'boolean'];

    public function guru() { return $this->belongsTo(Guru::class); }
    public function bankSoal() { return $this->belongsTo(BankSoal::class); }
    public function kelas() { return $this->belongsToMany(Kelas::class, 'ruang_ujian_kelas'); }
    public function ujianSiswas() { return $this->hasMany(UjianSiswa::class); }
}
