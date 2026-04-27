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
        Schema::create('researchers', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();
            $table->unsignedBigInteger('user_id')->primary();
        
            $table->unsignedBigInteger('project_id')->nullable();
            
            $table->foreign('user_id')
                    ->references('user_id')
                    ->on('user_infos')
                    ->onDelete('cascade');
                    
            $table->foreign('project_id')
                    ->references('project_id')
                    ->on('projects')
                    ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('researchers');
    }
};
