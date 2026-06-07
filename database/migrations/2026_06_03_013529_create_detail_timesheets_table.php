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
        Schema::create('detail_timesheets', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('timesheet_id');

            $table->date('tanggal_pekerjaan');
            
            $table->integer('jam_baket')->default(0);

            $table->integer('hm_awal')->default(0);

            $table->date('tanggal_awal_hm');
            $table->date('tanggal_akhir_hm');

            $table->integer('hm_akhir')->default(0);

            $table->integer('jam_breker')->default(0);

            $table->string('gambar')->nullable();

            $table->timestamps();

            $table->foreign('timesheet_id')
                ->references('id')
                ->on('timesheets')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_timesheets');
    }
};