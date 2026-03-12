<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UjianSiswa extends Model {
    use HasFactory;
    protected $fillable = ['ruang_ujian_id', 'siswa_id', 'status', 'waktu_mulai', 'waktu_selesai', 'jumlah_benar', 'jumlah_salah', 'nilai', 'jumlah_keluar'];
    protected $casts = ['waktu_mulai' => 'datetime', 'waktu_selesai' => 'datetime'];

    public function ruangUjian() { return $this->belongsTo(RuangUjian::class); }
    public function siswa() { return $this->belongsTo(Siswa::class); }
    public function jawabanSiswas() { return $this->hasMany(JawabanSiswa::class); }
}
