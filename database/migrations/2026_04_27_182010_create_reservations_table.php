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
        Schema::create('reservations', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->float('res_hours');
            $table->string('status'); // VARCHAR(255) by default
            
            $table->unsignedBigInteger('researcher_id');
            $table->unsignedBigInteger('eq_id');
            
            // Composite Primary Key
            $table->primary(['start_date', 'researcher_id', 'eq_id']);
            
            // Foreign Keys
            $table->foreign('researcher_id')
                ->references('user_id') // Fixed missing column reference
                ->on('researchers')
                ->onDelete('cascade');
                
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
        Schema::dropIfExists('reservations');
    }
};
