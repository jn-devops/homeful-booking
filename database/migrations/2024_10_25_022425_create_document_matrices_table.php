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
        Schema::create('document_matrices', function (Blueprint $table) {
            $table->id();
            $table->json('documents');
            $table->string('civil_status_code');
            $table->string('employment_status_code');
            $table->string('market_segment_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_matrices');
    }
};