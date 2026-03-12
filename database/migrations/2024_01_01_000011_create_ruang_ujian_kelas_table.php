<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ruang_ujian_kelas', function (Blueprint $table) {
            $table->foreignId('ruang_ujian_id')->constrained('ruang_ujians')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->primary(['ruang_ujian_id', 'kelas_id']);
        });
    }
    public function down(): void { Schema::dropIfExists('ruang_ujian_kelas'); }
};
