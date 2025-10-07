<?php

namespace App\Http\Controllers\HouseOwner;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index()
    {
        $houseOwner = auth()->user()->houseOwner;

        $tenants = Tenant::whereHas('building', function ($query) use ($houseOwner) {
            $query->where('house_owner_id', $houseOwner->id);
        })
            ->with(['building', 'flat'])
            ->latest()
            ->paginate(15);

        return view('house-owner.tenants.index', compact('tenants'));
    }

    public function show(Tenant $tenant)
    {
        $houseOwner = auth()->user()->houseOwner;

        // Verify tenant belongs to house owner's building
        if ($tenant->building->house_owner_id !== $houseOwner->id) {
            abort(403, 'Unauthorized action.');
        }

        $tenant->load(['building', 'flat']);

        return view('house-owner.tenants.show', compact('tenant'));
    }
}