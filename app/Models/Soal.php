<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model {
    use HasFactory;
    protected $fillable = ['bank_soal_id', 'jenis_soal', 'pertanyaan', 'opsi_a', 'opsi_b', 'opsi_c', 'opsi_d', 'opsi_e', 'jawaban_benar', 'urutan'];

    public function bankSoal() { return $this->belongsTo(BankSoal::class); }
    public function jawabanSiswas() { return $this->hasMany(JawabanSiswa::class); }
}
