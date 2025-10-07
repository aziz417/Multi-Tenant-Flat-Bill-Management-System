<?php

namespace App\Policies;

use App\Models\Flat;
use App\Models\User;

class FlatPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('house_owner');
    }

    public function view(User $user, Flat $flat): bool
    {
        return $user->hasRole('house_owner') &&
            $user->houseOwner->id === $flat->building->house_owner_id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('house_owner');
    }

    public function update(User $user, Flat $flat): bool
    {
        return $user->hasRole('house_owner') &&
            $user->houseOwner->id === $flat->building->house_owner_id;
    }

    public function delete(User $user, Flat $flat): bool
    {
        return $user->hasRole('house_owner') &&
            $user->houseOwner->id === $flat->building->house_owner_id;
    }
}