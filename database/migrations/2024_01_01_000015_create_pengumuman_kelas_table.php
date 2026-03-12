<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pengumuman_kelas', function (Blueprint $table) {
            $table->foreignId('pengumuman_id')->constrained('pengumumans')->onDelete('cascade');
            $table->foreignId('kelas_id')->constrained('kelas')->onDelete('cascade');
            $table->primary(['pengumuman_id', 'kelas_id']);
        });
    }
    public function down(): void { Schema::dropIfExists('pengumuman_kelas'); }
};
