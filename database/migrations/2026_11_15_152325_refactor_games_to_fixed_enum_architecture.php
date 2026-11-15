<?php

declare(strict_types=1);

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
        // 1. Update own_teams
        Schema::table('own_teams', function (Blueprint $table) {
            if (Schema::hasColumn('own_teams', 'game_id')) {
                $table->dropForeign(['game_id']);
                $table->dropColumn('game_id');
            }
            if (! Schema::hasColumn('own_teams', 'game')) {
                $table->string('game')->default('mlbb')->after('id');
            }
        });

        // 2. Update game_infos
        Schema::table('game_infos', function (Blueprint $table) {
            if (Schema::hasColumn('game_infos', 'game_id')) {
                $table->dropForeign(['game_id']);
                $table->dropColumn('game_id');
            }
            if (! Schema::hasColumn('game_infos', 'game')) {
                $table->string('game')->default('mlbb')->after('user_id');
            }
            if (! Schema::hasColumn('game_infos', 'role')) {
                $table->string('role')->nullable()->after('server_id');
            }
            if (! Schema::hasColumn('game_infos', 'device_type')) {
                $table->string('device_type')->nullable()->after('role');
            }
            if (! Schema::hasColumn('game_infos', 'main_heroes')) {
                $table->json('main_heroes')->nullable()->after('device_type');
            }
            $table->unique(['user_id', 'game']);
        });

        // 3. Update tournaments
        Schema::table('tournaments', function (Blueprint $table) {
            if (! Schema::hasColumn('tournaments', 'game')) {
                $table->string('game')->default('mlbb')->after('id');
            }
        });

        // 4. Update matches
        Schema::table('matches', function (Blueprint $table) {
            if (! Schema::hasColumn('matches', 'match_type')) {
                $table->string('match_type')->default('moba_series')->after('tournament_id');
            }
            if (! Schema::hasColumn('matches', 'placement')) {
                $table->integer('placement')->nullable()->after('stage');
            }
            if (! Schema::hasColumn('matches', 'placement_points')) {
                $table->integer('placement_points')->nullable()->after('placement');
            }
            if (! Schema::hasColumn('matches', 'kill_points')) {
                $table->integer('kill_points')->nullable()->after('placement_points');
            }
            if (! Schema::hasColumn('matches', 'total_points')) {
                $table->integer('total_points')->nullable()->after('kill_points');
            }
            if (! Schema::hasColumn('matches', 'is_winner')) {
                $table->boolean('is_winner')->default(false)->after('total_points');
            }
            $table->string('opponent_name')->nullable()->change();
        });

        // 5. Update match_series
        Schema::table('match_series', function (Blueprint $table) {
            if (! Schema::hasColumn('match_series', 'placement')) {
                $table->integer('placement')->nullable()->after('win_condition');
            }
            if (! Schema::hasColumn('match_series', 'placement_points')) {
                $table->integer('placement_points')->nullable()->after('placement');
            }
            if (! Schema::hasColumn('match_series', 'kill_points')) {
                $table->integer('kill_points')->nullable()->after('placement_points');
            }
            if (! Schema::hasColumn('match_series', 'total_points')) {
                $table->integer('total_points')->nullable()->after('kill_points');
            }
        });

        // 6. Update player_match_stats
        Schema::table('player_match_stats', function (Blueprint $table) {
            if (! Schema::hasColumn('player_match_stats', 'total_gold')) {
                $table->integer('total_gold')->nullable()->after('is_mvp');
            }
            if (! Schema::hasColumn('player_match_stats', 'damage_dealt')) {
                $table->integer('damage_dealt')->nullable()->after('total_gold');
            }
            if (! Schema::hasColumn('player_match_stats', 'turret_damage')) {
                $table->integer('turret_damage')->nullable()->after('damage_dealt');
            }
            if (! Schema::hasColumn('player_match_stats', 'damage_taken')) {
                $table->integer('damage_taken')->nullable()->after('turret_damage');
            }
            if (! Schema::hasColumn('player_match_stats', 'survival_time')) {
                $table->integer('survival_time')->nullable()->after('damage_taken'); // in seconds
            }
            if (! Schema::hasColumn('player_match_stats', 'knockdowns')) {
                $table->integer('knockdowns')->nullable()->after('survival_time');
            }
            if (! Schema::hasColumn('player_match_stats', 'revives')) {
                $table->integer('revives')->nullable()->after('knockdowns');
            }
            if (! Schema::hasColumn('player_match_stats', 'headshots')) {
                $table->integer('headshots')->nullable()->after('revives');
            }
        });

        // 7. Update player_tournament_stats
        Schema::table('player_tournament_stats', function (Blueprint $table) {
            if (! Schema::hasColumn('player_tournament_stats', 'total_damage')) {
                $table->bigInteger('total_damage')->nullable()->after('mvps');
            }
            if (! Schema::hasColumn('player_tournament_stats', 'total_points')) {
                $table->integer('total_points')->nullable()->after('total_damage');
            }
            if (! Schema::hasColumn('player_tournament_stats', 'avg_survival_time')) {
                $table->integer('avg_survival_time')->nullable()->after('total_points');
            }
        });

        // 8. Safely drop games table
        Schema::dropIfExists('games');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('game_logo')->nullable();
            $table->string('game_banner')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });

        Schema::table('player_tournament_stats', function (Blueprint $table) {
            $table->dropColumn(['total_damage', 'total_points', 'avg_survival_time']);
        });

        Schema::table('player_match_stats', function (Blueprint $table) {
            $table->dropColumn([
                'total_gold',
                'damage_dealt',
                'turret_damage',
                'damage_taken',
                'survival_time',
                'knockdowns',
                'revives',
                'headshots',
            ]);
        });

        Schema::table('match_series', function (Blueprint $table) {
            $table->dropColumn([
                'placement',
                'placement_points',
                'kill_points',
                'total_points',
            ]);
        });

        Schema::table('matches', function (Blueprint $table) {
            $table->dropColumn([
                'match_type',
                'placement',
                'placement_points',
                'kill_points',
                'total_points',
                'is_winner',
            ]);
        });

        Schema::table('tournaments', function (Blueprint $table) {
            $table->dropColumn('game');
        });

        Schema::table('game_infos', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'game']);
            $table->dropColumn(['game', 'role', 'device_type', 'main_heroes']);
            $table->foreignId('game_id')->nullable()->constrained('games')->cascadeOnDelete();
        });

        Schema::table('own_teams', function (Blueprint $table) {
            $table->dropColumn('game');
            $table->foreignId('game_id')->nullable()->constrained('games')->cascadeOnDelete();
        });
    }
};
