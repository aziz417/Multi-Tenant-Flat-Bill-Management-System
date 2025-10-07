<?php

namespace App\Policies;

use App\Models\Building;
use App\Models\User;

class BuildingPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('house_owner');
    }

    public function view(User $user, Building $building): bool
    {
        return $user->hasRole('house_owner') &&
            $user->houseOwner->id === $building->house_owner_id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('house_owner');
    }

    public function update(User $user, Building $building): bool
    {
        return $user->hasRole('house_owner') &&
            $user->houseOwner->id === $building->house_owner_id;
    }

    public function delete(User $user, Building $building): bool
    {
        return $user->hasRole('house_owner') &&
            $user->houseOwner->id === $building->house_owner_id;
    }
}