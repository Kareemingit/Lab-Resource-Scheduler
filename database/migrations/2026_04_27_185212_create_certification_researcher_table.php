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
        Schema::create('certification_researcher', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();
            $table->date('expiry_date');
        
            $table->unsignedBigInteger('cert_id');
            $table->unsignedBigInteger('researcher_id');
        
            // Fixed composite primary key (was cert_id, user_id)
            $table->primary(['cert_id', 'researcher_id']);
            
            $table->foreign('cert_id')
                ->references('cert_id')
                ->on('certifications')
                ->onDelete('cascade');
                
            // Fixed missing column reference (was researchers())
            $table->foreign('researcher_id')
                ->references('user_id')
                ->on('researchers')
                ->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certification_researcher');
    }
};
