<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('haura_bookings', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('jadwal_id');
        $table->date('tanggal_konsultasi');
        $table->text('keluhan')->nullable();
        $table->enum('status', ['Menunggu', 'Disetujui', 'Ditolak'])->default('Menunggu');
        $table->timestamps();

        $table->foreign('user_id')->references('id')->on('haura_users')->onDelete('cascade');
        $table->foreign('jadwal_id')->references('id')->on('haura_jadwals')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('haura_bookings');
    }
};
