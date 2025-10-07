<?php

namespace App\Policies;

use App\Models\BillCategory;
use App\Models\User;

class BillCategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('house_owner');
    }

    public function view(User $user, BillCategory $billCategory): bool
    {
        return $user->hasRole('house_owner') &&
            $user->houseOwner->id === $billCategory->house_owner_id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('house_owner');
    }

    public function update(User $user, BillCategory $billCategory): bool
    {
        return $user->hasRole('house_owner') &&
            $user->houseOwner->id === $billCategory->house_owner_id;
    }

    public function delete(User $user, BillCategory $billCategory): bool
    {
        return $user->hasRole('house_owner') &&
            $user->houseOwner->id === $billCategory->house_owner_id;
    }
}