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
    Schema::create('haura_jadwals', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('dokter_id');
        $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']);
        $table->time('jam_mulai');
        $table->time('jam_selesai');
        $table->string('lokasi', 100);
        $table->timestamps();

        $table->foreign('dokter_id')->references('id')->on('haura_dokters')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('haura_jadwals');
    }
};
