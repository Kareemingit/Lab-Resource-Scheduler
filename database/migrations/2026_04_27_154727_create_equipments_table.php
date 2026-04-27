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
        Schema::create('equipments', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();

            $table->id('eq_id'); 
            
            $table->string('name', 50);
            $table->string('category');
            
            // is_special as bool
            $table->boolean('is_special');
            
            // Nullable with default 0
            $table->float('used_hours')->nullable()->default(0);
            
            $table->float('max_hours');
            $table->string('required_role');
            
            // Default constraint with value 0
            $table->integer('maintenance_times')->default(0);
            
            // Self-referencing foreign key
            $table->unsignedBigInteger('sec_eq_id')->nullable();
            $table->foreign('sec_eq_id')
                  ->references('eq_id')
                  ->on('equipments')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};
