<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ruang_ujians', function (Blueprint $table) {
            $table->id();
            $table->string('nama_ruang');
            $table->foreignId('guru_id')->nullable()->constrained('gurus')->onDelete('set null');
            $table->foreignId('bank_soal_id')->constrained('bank_soals')->onDelete('cascade');
            $table->string('token', 10)->unique();
            $table->integer('waktu_hentikan')->default(0);
            $table->integer('batas_keluar')->default(3);
            $table->dateTime('tanggal_mulai');
            $table->dateTime('batas_akhir');
            $table->boolean('acak_soal')->default(false);
            $table->boolean('acak_jawaban')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('ruang_ujians'); }
};
