<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\EsportsMatch;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class EsportsMatchPolicy
{
    use HandlesAuthorization;

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MatchResource');
    }

    public function view(AuthUser $authUser, EsportsMatch $esportsMatch): bool
    {
        return $authUser->can('View:MatchResource');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MatchResource');
    }

    public function update(AuthUser $authUser, EsportsMatch $esportsMatch): bool
    {
        return $authUser->can('Update:MatchResource');
    }

    public function delete(AuthUser $authUser, EsportsMatch $esportsMatch): bool
    {
        return $authUser->can('Delete:MatchResource');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:MatchResource');
    }

    public function restore(AuthUser $authUser, EsportsMatch $esportsMatch): bool
    {
        return $authUser->can('Restore:MatchResource');
    }

    public function forceDelete(AuthUser $authUser, EsportsMatch $esportsMatch): bool
    {
        return $authUser->can('ForceDelete:MatchResource');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:MatchResource');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:MatchResource');
    }

    public function replicate(AuthUser $authUser, EsportsMatch $esportsMatch): bool
    {
        return $authUser->can('Replicate:MatchResource');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:MatchResource');
    }
}
