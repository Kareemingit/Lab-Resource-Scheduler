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
        Schema::create('grants', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();
            $table->id('grant_id'); 
        
            $table->date('end_date');
            $table->float('fund');
            
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('financial_id');
            
            $table->foreign('project_id')
                ->references('project_id')
                ->on('projects')
                ->onDelete('cascade');
                
            $table->foreign('financial_id')
                ->references('user_id') // Added missing column reference
                ->on('financial_departments')
                ->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grants');
    }
};
