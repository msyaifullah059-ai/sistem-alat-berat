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
        Schema::create('detail_dp_pembayarans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('dp_pembayaran_id');
            $table->date('tanggal_bayar');
            $table->bigInteger('jumlah');
            $table->text('keterangan')->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps();
            $table->foreign('dp_pembayaran_id')->references('id')->on('dp_pembayarans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_dp_pembayarans');
    }
};
