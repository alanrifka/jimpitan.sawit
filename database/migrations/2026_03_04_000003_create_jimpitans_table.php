<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jimpitans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rumah_id')->constrained('rumahs')->onDelete('cascade');
            $table->foreignId('warga_id')->nullable()->constrained('wargas')->onDelete('set null');
            $table->foreignId('petugas_id')->nullable()->constrained('users')->onDelete('set null');
            $table->date('tanggal');
            $table->decimal('jumlah', 15, 2);
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jimpitans');
    }
};
