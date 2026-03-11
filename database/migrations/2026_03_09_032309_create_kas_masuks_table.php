<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kas_masuks', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->string('sumber'); // Sumber pemasukan: sumbangan, subsidi, dll.
            $table->string('kategori')->default('Umum'); // Kategori: Rutin, Donasi, Subsidi, dll.
            $table->decimal('jumlah', 12, 2);
            $table->text('keterangan')->nullable();
            $table->string('bukti_foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kas_masuks');
    }
};
