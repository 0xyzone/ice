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
        return $authUser->can('ViewAny:GameInfo');
    }

    public function view(AuthUser $authUser, GameInfo $gameInfo): bool
    {
        return $authUser->can('View:GameInfo');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:GameInfo');
    }

    public function update(AuthUser $authUser, GameInfo $gameInfo): bool
    {
        return $authUser->can('Update:GameInfo');
    }

    public function delete(AuthUser $authUser, GameInfo $gameInfo): bool
    {
        return $authUser->can('Delete:GameInfo');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:GameInfo');
    }

    public function restore(AuthUser $authUser, GameInfo $gameInfo): bool
    {
        return $authUser->can('Restore:GameInfo');
    }

    public function forceDelete(AuthUser $authUser, GameInfo $gameInfo): bool
    {
        return $authUser->can('ForceDelete:GameInfo');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:GameInfo');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:GameInfo');
    }

    public function replicate(AuthUser $authUser, GameInfo $gameInfo): bool
    {
        return $authUser->can('Replicate:GameInfo');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:GameInfo');
    }

}