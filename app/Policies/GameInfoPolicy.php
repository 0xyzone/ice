<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\GameInfo;
use Illuminate\Auth\Access\HandlesAuthorization;

class GameInfoPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:GameInfoResource');
    }

    public function view(AuthUser $authUser, GameInfo $gameInfo): bool
    {
        return $authUser->can('View:GameInfoResource');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:GameInfoResource');
    }

    public function update(AuthUser $authUser, GameInfo $gameInfo): bool
    {
        return $authUser->can('Update:GameInfoResource');
    }

    public function delete(AuthUser $authUser, GameInfo $gameInfo): bool
    {
        return $authUser->can('Delete:GameInfoResource');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:GameInfoResource');
    }

    public function restore(AuthUser $authUser, GameInfo $gameInfo): bool
    {
        return $authUser->can('Restore:GameInfoResource');
    }

    public function forceDelete(AuthUser $authUser, GameInfo $gameInfo): bool
    {
        return $authUser->can('ForceDelete:GameInfoResource');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:GameInfoResource');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:GameInfoResource');
    }

    public function replicate(AuthUser $authUser, GameInfo $gameInfo): bool
    {
        return $authUser->can('Replicate:GameInfoResource');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:GameInfoResource');
    }

}