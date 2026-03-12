<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Guru extends Authenticatable {
    use HasFactory, Notifiable;
    protected $guard = 'guru';
    protected $fillable = ['name', 'nik', 'password'];
    protected $hidden = ['password', 'remember_token'];

    public function kelas() { return $this->belongsToMany(Kelas::class, 'guru_kelas'); }
    public function mapels() { return $this->belongsToMany(Mapel::class, 'guru_mapel'); }
    public function bankSoals() { return $this->hasMany(BankSoal::class); }
    public function ruangUjians() { return $this->hasMany(RuangUjian::class); }
}
