<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankSoal extends Model {
    use HasFactory;
    protected $fillable = ['guru_id', 'nama_soal', 'mapel_id', 'waktu_mengerjakan', 'bobot_pg', 'bobot_essay', 'bobot_menjodohkan', 'bobot_benar_salah'];

    public function guru() { return $this->belongsTo(Guru::class); }
    public function mapel() { return $this->belongsTo(Mapel::class); }
    public function soals() { return $this->hasMany(Soal::class); }
    public function ruangUjians() { return $this->hasMany(RuangUjian::class); }
}
