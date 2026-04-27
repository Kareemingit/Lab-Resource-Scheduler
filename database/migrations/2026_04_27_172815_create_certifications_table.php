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
        Schema::create('certifications', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();
            $table->id('cert_id');
            $table->string('name');
        
        // Unsigned to match typical MySQL ID data types for foreign keys
        $table->unsignedBigInteger('eq_id');
        
        $table->foreign('eq_id')
              ->references('eq_id')
              ->on('equipments')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certifications');
    }
};
