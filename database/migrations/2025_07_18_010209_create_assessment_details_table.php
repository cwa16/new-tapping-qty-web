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
        Schema::create('assessment_details', function (Blueprint $table) {
            $table->id();
            $table->string('assessment_code')->unique();
            $table->string('nik_penyadap')->nullable();
            $table->string('blok')->nullable();
            $table->string('task')->nullable();
            $table->string('kemandoran')->nullable();
            $table->integer('no_hancak')->nullable();
            $table->integer('tahun_tanam')->nullable();
            $table->string('clone')->nullable();
            $table->string('sistem_sadap')->nullable();
            $table->string('panel_sadap')->nullable();
            $table->string('jenis_kulit_pohon')->nullable();
            $table->string('jenis_sadap')->nullable();
            $table->string('inspection_by')->nullable();
            $table->dateTime('tanggal_inspeksi')->nullable();
            $table->timestamps();
            $table->foreign('nik_penyadap')->references('nik')->on('tappers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_details');
    }
};
