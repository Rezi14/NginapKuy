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
    Schema::create('pemesanan_fasilitas', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('pemesanan_id');
        $table->unsignedBigInteger('fasilitas_id');
        $table->timestamps();

        $table->foreign('pemesanan_id')->references('id_pemesanan')->on('pemesanans')->onDelete('cascade');
        $table->foreign('fasilitas_id')->references('id_fasilitas')->on('fasilitas')->onDelete('cascade');

        $table->unique(['pemesanan_id', 'fasilitas_id']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan_fasilitas');
    }
};
