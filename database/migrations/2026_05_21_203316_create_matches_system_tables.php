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
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained('tournaments')->cascadeOnDelete();
            $table->foreignId('own_team_id')->constrained('own_teams')->cascadeOnDelete();
            $table->string('opponent_name');
            $table->string('opponent_logo')->nullable();
            $table->dateTime('match_date');
            $table->string('status')->default('completed'); // scheduled, ongoing, completed
            $table->string('stage')->nullable(); // Group Stage, Grand Finals, etc.
            $table->integer('best_of')->default(3); // BO1, BO3, BO5
            $table->integer('our_score')->default(0);
            $table->integer('opponent_score')->default(0);
            $table->timestamps();
        });

        Schema::create('match_series', function (Blueprint $table) {
            $table->id();
            $table->foreignId('match_id')->constrained('matches')->cascadeOnDelete();
            $table->integer('game_number')->default(1);
            $table->string('map_name')->nullable();
            $table->string('result')->default('won'); // won, lost, draw, pending
            $table->string('win_condition')->nullable(); // Wiped Out, Outlived, Objective, etc.
            $table->integer('our_score')->default(0);
            $table->integer('opponent_score')->default(0);
            $table->timestamps();
        });

        Schema::create('player_match_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('match_series_id')->constrained('match_series')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->integer('kills')->default(0);
            $table->integer('deaths')->default(0);
            $table->integer('assists')->default(0);
            $table->boolean('is_mvp')->default(false);
            $table->timestamps();

            $table->unique(['match_series_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_match_stats');
        Schema::dropIfExists('match_series');
        Schema::dropIfExists('matches');
    }
};
