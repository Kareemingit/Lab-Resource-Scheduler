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
        Schema::create('projects', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();
            $table->id('project_id');
            $table->string('name'); // VARCHAR(255) by default
            $table->float('balance');
            $table->string('state'); 
            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->foreign('supervisor_id')
              ->references('user_id')
              ->on('supervisors')
              ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
