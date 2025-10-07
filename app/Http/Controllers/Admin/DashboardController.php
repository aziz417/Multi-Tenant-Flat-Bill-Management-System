<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HouseOwner;
use App\Models\Tenant;
use App\Models\Building;
use App\Models\Bill;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_house_owners' => HouseOwner::count(),
            'total_tenants' => Tenant::count(),
            'total_buildings' => Building::count(),
            'total_unpaid_bills' => Bill::whereIn('status', ['unpaid', 'partially_paid'])->count(),
        ];

        $recentHouseOwners = HouseOwner::with('user')
            ->latest()
            ->take(5)
            ->get();

        $recentTenants = Tenant::with(['flat', 'building'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentHouseOwners', 'recentTenants'));
    }
}