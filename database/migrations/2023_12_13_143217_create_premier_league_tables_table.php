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
        Schema::create('premier_league_tables', function (Blueprint $table) {
            $table->id();
            $table->string('table_name');
            $table->integer('position');
            $table->string('team');
            $table->integer('played');
            $table->integer('win');
            $table->integer('draw');
            $table->integer('loss');
            $table->integer('f');
            $table->integer('a');
            $table->integer('goal_difference');
            $table->integer('points');
            $table->float('btts');
            $table->string('last_6_results');
            $table->string('g');
            $table->string('km');
            $table->string('Next_match');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('premier_league_tables');
    }
};
