<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ujian_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ruang_ujian_id')->constrained('ruang_ujians')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->enum('status', ['belum', 'sedang', 'selesai'])->default('belum');
            $table->dateTime('waktu_mulai')->nullable();
            $table->dateTime('waktu_selesai')->nullable();
            $table->integer('jumlah_benar')->default(0);
            $table->integer('jumlah_salah')->default(0);
            $table->decimal('nilai', 5, 2)->nullable();
            $table->integer('jumlah_keluar')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('ujian_siswas'); }
};
