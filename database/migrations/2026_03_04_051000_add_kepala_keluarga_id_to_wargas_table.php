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
        Schema::table('wargas', function (Blueprint $table) {
            $table->foreignId('kepala_keluarga_id')->nullable()->after('id')->constrained('wargas')->onDelete('set null');
            $table->string('hubungan_keluarga')->nullable()->after('status_warga'); // e.g., Istri, Anak, Orang Tua
        });
    }

    public function down(): void
    {
        Schema::table('wargas', function (Blueprint $table) {
            $table->dropForeign(['kepala_keluarga_id']);
            $table->dropColumn(['kepala_keluarga_id', 'hubungan_keluarga']);
        });
    }
};
