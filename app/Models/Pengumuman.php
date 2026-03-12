<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model {
    use HasFactory;
    protected $fillable = ['isi'];

    public function kelas() { return $this->belongsToMany(Kelas::class, 'pengumuman_kelas'); }
}
