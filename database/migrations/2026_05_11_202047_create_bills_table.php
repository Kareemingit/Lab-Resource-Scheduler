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
        Schema::create('bills', function (Blueprint $table) {
            $table->id("bill_id");
            $table->unsignedBigInteger('grant_id')->nullable();
            $table->unsignedBigInteger('project_id')->nullable();
            $table->foreign('grant_id')
              ->references('grant_id')
              ->on('grants')
              ->onDelete('set null');

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
        Schema::dropIfExists('bills');
    }
};
