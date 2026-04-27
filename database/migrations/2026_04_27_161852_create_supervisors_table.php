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
        Schema::create('supervisors', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();
            $table->unsignedBigInteger('user_id')->primary();
        
            // FOREIGN KEY constraint
            $table->foreign('user_id')
                ->references('user_id')
                ->on('user_infos')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supervisors');
    }
};
