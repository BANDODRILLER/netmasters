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
        Schema::create('fixtures', function (Blueprint $table) {
            $table->id();
            $table->string('match_datetime'); // Store date and time in a single column
            $table->string('league');
            $table->string('home_team');
            $table->string('away_team');
            $table->string('odds_1')->nullable(); // Replace with the appropriate data type for odds
            $table->string('odds_X')->nullable();
            $table->string('odds_2')->nullable();
            $table->string('score')->nullable();
            $table->string('tip')->nullable();
            $table->string('cs1')->nullable();
            $table->string('cs2')->nullable();
            $table->string('cs3')->nullable();
            $table->string('attack_home')->nullable();
            $table->string('attack_away')->nullable();
            $table->string('def_home')->nullable();
            $table->string('def_away')->nullable();
            $table->string('ppg_home')->nullable();
            $table->string('ppg_away')->nullable();
            $table->string('avg_home')->nullable();
            $table->string('avg_away')->nullable();
            $table->string('exact_goal_home')->nullable();
            $table->string('exact_goal_away')->nullable();
            $table->float('plus_1_5')->nullable();
            $table->float('minus_1_5')->nullable();
            $table->float('plus_2_5')->nullable();
            $table->float('minus_2_5')->nullable();
            $table->float('p_zero_home')->nullable();
            $table->float('p_one_home')->nullable();
            $table->float('p_two_home')->nullable();
            $table->float('p_three_home')->nullable();
            $table->float('p_four_home')->nullable();
            $table->float('p_five_home')->nullable();
            $table->float('p_zero_away')->nullable();
            $table->float('p_one_away')->nullable();
            $table->float('p_two_away')->nullable();
            $table->float('p_three_away')->nullable();
            $table->float('p_four_away')->nullable();
            $table->float('p_five_away')->nullable();
            $table->float('team_avg_home')->nullable();
            $table->float('team_avg_away')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixtures');
    }
};
