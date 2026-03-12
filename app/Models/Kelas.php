<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model {
    use HasFactory;
    protected $table = 'kelas';
    protected $fillable = ['kode', 'nama_kelas'];

    public function gurus() { return $this->belongsToMany(Guru::class, 'guru_kelas'); }
    public function siswas() { return $this->belongsToMany(Siswa::class, 'siswa_kelas'); }
    public function ruangUjians() { return $this->belongsToMany(RuangUjian::class, 'ruang_ujian_kelas'); }
    public function pengumumans() { return $this->belongsToMany(Pengumuman::class, 'pengumuman_kelas'); }
}
