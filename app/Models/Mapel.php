<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model {
    use HasFactory;
    protected $fillable = ['kode', 'nama_mapel'];

    public function gurus() { return $this->belongsToMany(Guru::class, 'guru_mapel'); }
    public function bankSoals() { return $this->hasMany(BankSoal::class); }
}
