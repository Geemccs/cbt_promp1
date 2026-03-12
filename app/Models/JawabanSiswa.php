<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanSiswa extends Model {
    use HasFactory;
    protected $fillable = ['ujian_siswa_id', 'soal_id', 'jawaban', 'is_benar'];

    public function ujianSiswa() { return $this->belongsTo(UjianSiswa::class); }
    public function soal() { return $this->belongsTo(Soal::class); }
}
