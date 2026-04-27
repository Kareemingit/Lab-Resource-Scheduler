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
        Schema::create('reports', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();
            $table->id('id');
            $table->date('date');
            $table->string('description'); // VARCHAR(255) by default
            
            $table->unsignedBigInteger('eq_id');
            $table->unsignedBigInteger('lab_man_id')->nullable();
            $table->unsignedBigInteger('researcher_id')->nullable();
            
            $table->foreign('eq_id')
                ->references('eq_id')
                ->on('equipments')
                ->onDelete('cascade');
                
            $table->foreign('lab_man_id')
                ->references('user_id') // Fixed missing column reference
                ->on('lab_managers')
                ->onDelete('set null');
                
            $table->foreign('researcher_id')
                ->references('user_id') // Fixed missing column reference
                ->on('researchers')
                ->onDelete('set null');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
