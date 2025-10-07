<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\Building;
use App\Models\Flat;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::with(['building', 'flat'])
            ->latest()
            ->paginate(15);

        return view('admin.tenants.index', compact('tenants'));
    }

    public function create()
    {
        $buildings = Building::with('houseOwner')->get();
        return view('admin.tenants.create', compact('buildings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'building_id' => ['required', 'exists:buildings,id'],
            'flat_id' => ['nullable', 'exists:flats,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'nid_number' => ['nullable', 'string', 'max:50'],
            'move_in_date' => ['nullable', 'date'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        // If flat is assigned, update flat status
        if ($validated['flat_id']) {
            $flat = Flat::find($validated['flat_id']);
            if ($flat && $flat->building_id == $validated['building_id']) {
                $flat->update(['status' => 'occupied']);
            }
        }

        Tenant::create($validated);

        return redirect()
            ->route('admin.tenants.index')
            ->with('success', 'Tenant created successfully.');
    }

    public function show(Tenant $tenant)
    {
        $tenant->load(['building', 'flat']);
        return view('admin.tenants.show', compact('tenant'));
    }

    public function edit(Tenant $tenant)
    {
        $buildings = Building::with('houseOwner')->get();
        $flats = Flat::where('building_id', $tenant->building_id)->get();

        return view('admin.tenants.edit', compact('tenant', 'buildings', 'flats'));
    }

    public function update(Request $request, Tenant $tenant)
    {
        $validated = $request->validate([
            'building_id' => ['required', 'exists:buildings,id'],
            'flat_id' => ['nullable', 'exists:flats,id'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'nid_number' => ['nullable', 'string', 'max:50'],
            'move_in_date' => ['nullable', 'date'],
            'move_out_date' => ['nullable', 'date'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        // Update old flat status if changed
        if ($tenant->flat_id && $tenant->flat_id != $validated['flat_id']) {
            $tenant->flat->update(['status' => 'vacant']);
        }

        // Update new flat status
        if ($validated['flat_id']) {
            $flat = Flat::find($validated['flat_id']);
            if ($flat && $flat->building_id == $validated['building_id']) {
                $flat->update(['status' => 'occupied']);
            }
        }

        $tenant->update($validated);

        return redirect()
            ->route('admin.tenants.index')
            ->with('success', 'Tenant updated successfully.');
    }

    public function destroy(Tenant $tenant)
    {
        // Update flat status when tenant is removed
        if ($tenant->flat_id) {
            $tenant->flat->update(['status' => 'vacant']);
        }

        $tenant->delete();

        return redirect()
            ->route('admin.tenants.index')
            ->with('success', 'Tenant removed successfully.');
    }

    public function getFlats($buildingId)
    {
        $flats = Flat::where('building_id', $buildingId)
            ->select('id', 'flat_number', 'status')
            ->get();

        return response()->json($flats);
    }
}