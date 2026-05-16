<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\OwnTeam;
use Illuminate\Auth\Access\HandlesAuthorization;

class OwnTeamPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:OwnTeam');
    }

    public function view(AuthUser $authUser, OwnTeam $ownTeam): bool
    {
        return $authUser->can('View:OwnTeam');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:OwnTeam');
    }

    public function update(AuthUser $authUser, OwnTeam $ownTeam): bool
    {
        return $authUser->can('Update:OwnTeam');
    }

    public function delete(AuthUser $authUser, OwnTeam $ownTeam): bool
    {
        return $authUser->can('Delete:OwnTeam');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:OwnTeam');
    }

    public function restore(AuthUser $authUser, OwnTeam $ownTeam): bool
    {
        return $authUser->can('Restore:OwnTeam');
    }

    public function forceDelete(AuthUser $authUser, OwnTeam $ownTeam): bool
    {
        return $authUser->can('ForceDelete:OwnTeam');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:OwnTeam');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:OwnTeam');
    }

    public function replicate(AuthUser $authUser, OwnTeam $ownTeam): bool
    {
        return $authUser->can('Replicate:OwnTeam');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:OwnTeam');
    }

}