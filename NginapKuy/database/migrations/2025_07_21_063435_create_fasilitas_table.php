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
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id('id_fasilitas'); // Primary key
            $table->string('nama_fasilitas', 255)->unique();
            $table->text('deskripsi')->nullable();
            $table->decimal('biaya_tambahan', 10, 2)->default(0.00); // Biaya tambahan untuk fasilitas
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fasilitas');
    }
};