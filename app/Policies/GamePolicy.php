<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Game;
use Illuminate\Auth\Access\HandlesAuthorization;

class GamePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:GameResource');
    }

    public function view(AuthUser $authUser, Game $game): bool
    {
        return $authUser->can('View:GameResource');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:GameResource');
    }

    public function update(AuthUser $authUser, Game $game): bool
    {
        return $authUser->can('Update:GameResource');
    }

    public function delete(AuthUser $authUser, Game $game): bool
    {
        return $authUser->can('Delete:GameResource');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:GameResource');
    }

    public function restore(AuthUser $authUser, Game $game): bool
    {
        return $authUser->can('Restore:GameResource');
    }

    public function forceDelete(AuthUser $authUser, Game $game): bool
    {
        return $authUser->can('ForceDelete:GameResource');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:GameResource');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:GameResource');
    }

    public function replicate(AuthUser $authUser, Game $game): bool
    {
        return $authUser->can('Replicate:GameResource');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:GameResource');
    }

}