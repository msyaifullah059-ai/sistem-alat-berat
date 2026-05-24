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
        Schema::create('pricing_alats', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('alat_berat_id');

            // JSON ARRAY
            $table->json('jenis_pekerjaan');

            // =========================
            // BAKET
            // =========================
            $table->bigInteger('harga_sewa_hari_baket')->nullable();
            $table->bigInteger('harga_sewa_jam_baket')->nullable();

            // =========================
            // BREKER
            // =========================
            $table->bigInteger('harga_sewa_hari_breker')->nullable();
            $table->bigInteger('harga_sewa_jam_breker')->nullable();

            // =========================
            // TANGGAL
            // =========================
            $table->date('berlaku_mulai');

            $table->date('berlaku_selesai')->nullable();

            $table->timestamps();

            // FOREIGN KEY
            $table->foreign('alat_berat_id')
                ->references('id')
                ->on('alat_berats')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_alats');
    }
};
