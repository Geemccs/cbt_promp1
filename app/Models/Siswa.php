<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Siswa extends Authenticatable {
    use HasFactory, Notifiable;
    protected $guard = 'siswa';
    protected $fillable = ['name', 'nisn', 'password'];
    protected $hidden = ['password', 'remember_token'];

    public function kelas() { return $this->belongsToMany(Kelas::class, 'siswa_kelas'); }
    public function ujianSiswas() { return $this->hasMany(UjianSiswa::class); }
}
