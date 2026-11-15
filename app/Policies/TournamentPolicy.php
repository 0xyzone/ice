<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Tournament;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class TournamentPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:TournamentResource');
    }

    public function view(AuthUser $authUser, Tournament $tournament): bool
    {
        return $authUser->can('View:TournamentResource');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:TournamentResource');
    }

    public function update(AuthUser $authUser, Tournament $tournament): bool
    {
        return $authUser->can('Update:TournamentResource');
    }

    public function delete(AuthUser $authUser, Tournament $tournament): bool
    {
        return $authUser->can('Delete:TournamentResource');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:TournamentResource');
    }

    public function restore(AuthUser $authUser, Tournament $tournament): bool
    {
        return $authUser->can('Restore:TournamentResource');
    }

    public function forceDelete(AuthUser $authUser, Tournament $tournament): bool
    {
        return $authUser->can('ForceDelete:TournamentResource');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:TournamentResource');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:TournamentResource');
    }

    public function replicate(AuthUser $authUser, Tournament $tournament): bool
    {
        return $authUser->can('Replicate:TournamentResource');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:TournamentResource');
    }
}
