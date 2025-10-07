<?php

namespace App\Http\Controllers\HouseOwner;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $houseOwner = auth()->user()->houseOwner;

        $stats = [
            'total_buildings' => $houseOwner->buildings()->count(),
            'total_flats' => $houseOwner->flats()->count(),
            'occupied_flats' => $houseOwner->flats()->where('status', 'occupied')->count(),
            'total_tenants' => DB::table('tenants')
                ->join('buildings', 'tenants.building_id', '=', 'buildings.id')
                ->where('buildings.house_owner_id', $houseOwner->id)
                ->where('tenants.status', 'active')
                ->count(),
        ];

        $unpaidBills = Bill::whereHas('flat.building', function ($query) use ($houseOwner) {
            $query->where('house_owner_id', $houseOwner->id);
        })
            ->whereIn('status', ['unpaid', 'partially_paid'])
            ->with(['flat', 'billCategory'])
            ->latest()
            ->take(10)
            ->get();

        $recentBills = Bill::whereHas('flat.building', function ($query) use ($houseOwner) {
            $query->where('house_owner_id', $houseOwner->id);
        })
            ->with(['flat', 'billCategory'])
            ->latest()
            ->take(5)
            ->get();

        return view('house-owner.dashboard', compact('stats', 'unpaidBills', 'recentBills'));
    }
}