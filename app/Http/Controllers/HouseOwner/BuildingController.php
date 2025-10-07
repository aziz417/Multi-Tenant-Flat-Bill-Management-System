<?php

namespace App\Http\Controllers\HouseOwner;

use App\Http\Controllers\Controller;
use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function index()
    {
        $houseOwner = auth()->user()->houseOwner;

        $buildings = Building::where('house_owner_id', $houseOwner->id)
            ->withCount('flats')
            ->latest()
            ->paginate(15);

        return view('house-owner.buildings.index', compact('buildings'));
    }

    public function create()
    {
        return view('house-owner.buildings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'total_floors' => ['required', 'integer', 'min:1'],
        ]);

        $houseOwner = auth()->user()->houseOwner;

        Building::create([
            'house_owner_id' => $houseOwner->id,
            ...$validated
        ]);

        return redirect()
            ->route('house-owner.buildings.index')
            ->with('success', 'Building created successfully.');
    }

    public function show(Building $building)
    {
        $this->authorize('view', $building);

        $building->load(['flats', 'tenants']);

        return view('house-owner.buildings.show', compact('building'));
    }

    public function edit(Building $building)
    {
        $this->authorize('update', $building);

        return view('house-owner.buildings.edit', compact('building'));
    }

    public function update(Request $request, Building $building)
    {
        $this->authorize('update', $building);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'total_floors' => ['required', 'integer', 'min:1'],
        ]);

        $building->update($validated);

        return redirect()
            ->route('house-owner.buildings.index')
            ->with('success', 'Building updated successfully.');
    }

    public function destroy(Building $building)
    {
        $this->authorize('delete', $building);

        if ($building->flats()->count() > 0) {
            return back()->with('error', 'Cannot delete building with existing flats.');
        }

        $building->delete();

        return redirect()
            ->route('house-owner.buildings.index')
            ->with('success', 'Building deleted successfully.');
    }
}