<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('jawaban_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ujian_siswa_id')->constrained('ujian_siswas')->onDelete('cascade');
            $table->foreignId('soal_id')->constrained('soals')->onDelete('cascade');
            $table->text('jawaban')->nullable();
            $table->boolean('is_benar')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('jawaban_siswas'); }
};
