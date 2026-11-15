<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('game_infos', 'roles')) {
            Schema::table('game_infos', function (Blueprint $table) {
                $table->json('roles')->nullable()->after('role');
            });

            DB::table('game_infos')
                ->whereNotNull('role')
                ->whereNull('roles')
                ->orderBy('id')
                ->each(function (object $row): void {
                    DB::table('game_infos')
                        ->where('id', $row->id)
                        ->update(['roles' => json_encode([$row->role])]);
                });
        }

        if (! Schema::hasColumn('team_members', 'sort_order')) {
            Schema::table('team_members', function (Blueprint $table) {
                $table->unsignedInteger('sort_order')->nullable()->after('is_main_roster');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('game_infos', 'roles')) {
            Schema::table('game_infos', function (Blueprint $table) {
                $table->dropColumn('roles');
            });
        }

        if (Schema::hasColumn('team_members', 'sort_order')) {
            Schema::table('team_members', function (Blueprint $table) {
                $table->dropColumn('sort_order');
            });
        }
    }
};
