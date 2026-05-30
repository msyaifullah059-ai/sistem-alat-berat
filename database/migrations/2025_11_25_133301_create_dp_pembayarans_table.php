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
        Schema::create('dp_pembayarans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('transaksi_sewa_id');
            $table->enum('status', ['Belum Lunas','Lunas'])->default('Belum Lunas');
            $table->timestamps();

            $table->foreign('transaksi_sewa_id')->references('id')->on('transaksi_sewas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dp_pembayarans');
    }
};
