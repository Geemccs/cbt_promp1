<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('soals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_soal_id')->constrained('bank_soals')->onDelete('cascade');
            $table->enum('jenis_soal', ['pg', 'essay', 'benar_salah', 'menjodohkan']);
            $table->text('pertanyaan');
            $table->text('opsi_a')->nullable();
            $table->text('opsi_b')->nullable();
            $table->text('opsi_c')->nullable();
            $table->text('opsi_d')->nullable();
            $table->text('opsi_e')->nullable();
            $table->text('jawaban_benar');
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('soals'); }
};
