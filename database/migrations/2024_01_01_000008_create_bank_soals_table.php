<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('bank_soals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->nullable()->constrained('gurus')->onDelete('set null');
            $table->string('nama_soal');
            $table->foreignId('mapel_id')->constrained('mapels')->onDelete('cascade');
            $table->integer('waktu_mengerjakan');
            $table->decimal('bobot_pg', 5, 2)->default(0);
            $table->decimal('bobot_essay', 5, 2)->default(0);
            $table->decimal('bobot_menjodohkan', 5, 2)->default(0);
            $table->decimal('bobot_benar_salah', 5, 2)->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('bank_soals'); }
};
