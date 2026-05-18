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
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('prize_pool')->nullable();
            $table->string('status')->default('upcoming'); // upcoming, ongoing, completed
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });

        Schema::create('tournament_team', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained('tournaments')->cascadeOnDelete();
            $table->foreignId('own_team_id')->constrained('own_teams')->cascadeOnDelete();
            $table->integer('matches_played')->default(0);
            $table->integer('matches_won')->default(0);
            $table->integer('matches_lost')->default(0);
            $table->integer('points')->default(0);
            $table->string('rank')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournament_team');
        Schema::dropIfExists('tournaments');
    }
};
