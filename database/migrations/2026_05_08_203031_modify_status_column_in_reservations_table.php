<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {

            $table->dropColumn('status');

        });

        Schema::table('reservations', function (Blueprint $table) {

            $table->boolean('authorized')->default(0);

        });
    }

    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {

            $table->dropColumn('authorized');

        });

        Schema::table('reservations', function (Blueprint $table) {

            $table->string('status')->default('pending');

        });
    }
};