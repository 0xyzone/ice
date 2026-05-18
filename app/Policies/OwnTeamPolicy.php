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
        return $authUser->can('ViewAny:OwnTeamResource');
    }

    public function view(AuthUser $authUser, OwnTeam $ownTeam): bool
    {
        return $authUser->can('View:OwnTeamResource');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:OwnTeamResource');
    }

    public function update(AuthUser $authUser, OwnTeam $ownTeam): bool
    {
        return $authUser->can('Update:OwnTeamResource');
    }

    public function delete(AuthUser $authUser, OwnTeam $ownTeam): bool
    {
        return $authUser->can('Delete:OwnTeamResource');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:OwnTeamResource');
    }

    public function restore(AuthUser $authUser, OwnTeam $ownTeam): bool
    {
        return $authUser->can('Restore:OwnTeamResource');
    }

    public function forceDelete(AuthUser $authUser, OwnTeam $ownTeam): bool
    {
        return $authUser->can('ForceDelete:OwnTeamResource');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:OwnTeamResource');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:OwnTeamResource');
    }

    public function replicate(AuthUser $authUser, OwnTeam $ownTeam): bool
    {
        return $authUser->can('Replicate:OwnTeamResource');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:OwnTeamResource');
    }

}