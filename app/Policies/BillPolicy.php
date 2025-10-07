<?php

namespace App\Policies;

use App\Models\Bill;
use App\Models\User;

class BillPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('house_owner');
    }

    public function view(User $user, Bill $bill): bool
    {
        return $user->hasRole('house_owner') &&
            $user->houseOwner->id === $bill->flat->building->house_owner_id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('house_owner');
    }

    public function update(User $user, Bill $bill): bool
    {
        return $user->hasRole('house_owner') &&
            $user->houseOwner->id === $bill->flat->building->house_owner_id;
    }

    public function delete(User $user, Bill $bill): bool
    {
        return $user->hasRole('house_owner') &&
            $user->houseOwner->id === $bill->flat->building->house_owner_id;
    }
}