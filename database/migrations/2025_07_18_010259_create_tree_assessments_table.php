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
        Schema::create('tree_assessments', function (Blueprint $table) {
            $table->id();
            $table->string('assessment_code')->nullable();
            $table->foreignId('tree_id')->constrained('trees')->onDelete('cascade');
            $table->foreignId('criteria_id')->constrained('criteria')->onDelete('cascade');
            $table->timestamps();
            $table->foreign('assessment_code')->references('assessment_code')->on('assessment_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tree_assessments');
    }
};
