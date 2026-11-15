<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\FreeFireRole;
use App\Enums\GameType;
use App\Enums\MlbbRole;
use App\Enums\PubgRole;
use App\Models\GameInfo;
use App\Models\OwnTeam;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MultiRoleAndRosterSortingTest extends TestCase
{
    use RefreshDatabase;

    public function test_game_info_multi_select_roles_sync_primary_role_by_rank(): void
    {
        $user = User::factory()->create();

        $pubgInfo = GameInfo::create([
            'user_id' => $user->id,
            'game' => GameType::PubgMobile,
            'in_game_id' => '5123456789',
            'in_game_username' => 'CRASH',
            'roles' => [PubgRole::Support->value, PubgRole::Igl->value],
            'status' => true,
        ]);

        // Roles are sorted by rank (IGL = 1 before Support = 6) and primary `role` syncs to IGL
        $this->assertSame(['igl', 'support'], $pubgInfo->roles);
        $this->assertSame('igl', $pubgInfo->role);
        $this->assertSame(1, $pubgInfo->getPrimaryRoleRank());
        $this->assertSame(['IGL (In-Game Leader)', 'Supporter'], $pubgInfo->getRoleLabels());

        $ffInfo = GameInfo::create([
            'user_id' => $user->id,
            'game' => GameType::FreeFire,
            'in_game_id' => '99887766',
            'in_game_username' => 'NADER',
            'roles' => [FreeFireRole::Bomber->value, FreeFireRole::PrimaryRusher->value],
            'status' => true,
        ]);

        $this->assertSame(['primary_rusher', 'bomber'], $ffInfo->roles);
        $this->assertSame('primary_rusher', $ffInfo->role);
        $this->assertSame(2, $ffInfo->getPrimaryRoleRank());

        $this->assertArrayHasKey('flex', MlbbRole::options());
    }

    public function test_team_roster_sorts_by_manual_sort_order_then_game_role_rank(): void
    {
        $team = OwnTeam::create([
            'name' => 'IceCream PUBGM',
            'status' => true,
            'game' => GameType::PubgMobile,
        ]);

        $playersData = [
            ['name' => 'AAYAN ALI', 'ign' => 'AAYAN', 'role' => PubgRole::Support->value, 'sort_order' => null],
            ['name' => 'BIBEK YADAV', 'ign' => 'SHADOW', 'role' => PubgRole::Assaulter->value, 'sort_order' => null],
            ['name' => 'SABIR HUSSAIN', 'ign' => 'FILECLOSE', 'role' => PubgRole::Fragger->value, 'sort_order' => null],
            ['name' => 'SAMIR ALI', 'ign' => 'CRASH', 'role' => PubgRole::Igl->value, 'sort_order' => null],
        ];

        $members = [];
        foreach ($playersData as $data) {
            $u = User::factory()->create(['name' => $data['name']]);
            GameInfo::create([
                'user_id' => $u->id,
                'game' => GameType::PubgMobile,
                'in_game_id' => (string) random_int(100000, 999999),
                'in_game_username' => $data['ign'],
                'roles' => [$data['role']],
                'status' => true,
            ]);
            $members[$data['ign']] = TeamMember::create([
                'own_team_id' => $team->id,
                'user_id' => $u->id,
                'role' => 'player',
                'is_main_roster' => true,
                'sort_order' => $data['sort_order'],
                'status' => true,
                'joined_at' => now(),
            ]);
        }

        // Without manual sort_order, sorts automatically by role rank: CRASH (IGL) -> FILECLOSE (Fragger) -> SHADOW (Assaulter) -> AAYAN (Supporter)
        $team->load(['members.user.gameInfos']);
        $team->sortMembersRelation();
        $orderedNames = $team->members->map(fn (TeamMember $m) => $m->user->name)->all();

        $this->assertSame(['SAMIR ALI', 'SABIR HUSSAIN', 'BIBEK YADAV', 'AAYAN ALI'], $orderedNames);

        // With manual sort_order = 1 on AAYAN, manual sort_order overrides automatic role rank
        $members['AAYAN']->update(['sort_order' => 1]);
        $team->load(['members.user.gameInfos']);
        $team->sortMembersRelation();
        $manualOrderedNames = $team->members->map(fn (TeamMember $m) => $m->user->name)->all();

        $this->assertSame('AAYAN ALI', $manualOrderedNames[0]);
    }
}
