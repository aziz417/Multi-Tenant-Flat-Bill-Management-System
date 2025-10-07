<?php

namespace App\Http\Controllers\HouseOwner;

use App\Http\Controllers\Controller;
use App\Models\Flat;
use App\Models\Building;
use Illuminate\Http\Request;

class FlatController extends Controller
{
    public function index()
    {
        $houseOwner = auth()->user()->houseOwner;

        $flats = Flat::whereHas('building', function ($query) use ($houseOwner) {
            $query->where('house_owner_id', $houseOwner->id);
        })
            ->with(['building', 'tenant'])
            ->latest()
            ->paginate(15);

        return view('house-owner.flats.index', compact('flats'));
    }

    public function create()
    {
        $houseOwner = auth()->user()->houseOwner;
        $buildings = Building::where('house_owner_id', $houseOwner->id)->get();

        return view('house-owner.flats.create', compact('buildings'));
    }

    public function store(Request $request)
    {
        $houseOwner = auth()->user()->houseOwner;

        $validated = $request->validate([
            'building_id' => ['required', 'exists:buildings,id'],
            'flat_number' => ['required', 'string', 'max:255'],
            'floor_number' => ['required', 'integer', 'min:0'],
            'flat_owner_name' => ['required', 'string', 'max:255'],
            'flat_owner_phone' => ['nullable', 'string', 'max:20'],
            'flat_owner_email' => ['nullable', 'email', 'max:255'],
            'bedrooms' => ['required', 'integer', 'min:1'],
            'monthly_rent' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:occupied,vacant'],
        ]);

        // Verify building belongs to house owner
        $building = Building::where('id', $validated['building_id'])
            ->where('house_owner_id', $houseOwner->id)
            ->firstOrFail();

        // Check unique flat number in building
        $exists = Flat::where('building_id', $validated['building_id'])
            ->where('flat_number', $validated['flat_number'])
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors(['flat_number' => 'Flat number already exists in this building.']);
        }

        Flat::create($validated);

        return redirect()
            ->route('house-owner.flats.index')
            ->with('success', 'Flat created successfully.');
    }

    public function show(Flat $flat)
    {
        $this->authorize('view', $flat);

        $flat->load(['building', 'tenant', 'bills.billCategory']);

        return view('house-owner.flats.show', compact('flat'));
    }

    public function edit(Flat $flat)
    {
        $this->authorize('update', $flat);

        $houseOwner = auth()->user()->houseOwner;
        $buildings = Building::where('house_owner_id', $houseOwner->id)->get();

        return view('house-owner.flats.edit', compact('flat', 'buildings'));
    }

    public function update(Request $request, Flat $flat)
    {
        $this->authorize('update', $flat);

        $houseOwner = auth()->user()->houseOwner;

        $validated = $request->validate([
            'building_id' => ['required', 'exists:buildings,id'],
            'flat_number' => ['required', 'string', 'max:255'],
            'floor_number' => ['required', 'integer', 'min:0'],
            'flat_owner_name' => ['required', 'string', 'max:255'],
            'flat_owner_phone' => ['nullable', 'string', 'max:20'],
            'flat_owner_email' => ['nullable', 'email', 'max:255'],
            'bedrooms' => ['required', 'integer', 'min:1'],
            'monthly_rent' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'in:occupied,vacant'],
        ]);

        // Verify building belongs to house owner
        $building = Building::where('id', $validated['building_id'])
            ->where('house_owner_id', $houseOwner->id)
            ->firstOrFail();

        // Check unique flat number in building (excluding current flat)
        $exists = Flat::where('building_id', $validated['building_id'])
            ->where('flat_number', $validated['flat_number'])
            ->where('id', '!=', $flat->id)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors(['flat_number' => 'Flat number already exists in this building.']);
        }

        $flat->update($validated);

        return redirect()
            ->route('house-owner.flats.index')
            ->with('success', 'Flat updated successfully.');
    }

    public function destroy(Flat $flat)
    {
        $this->authorize('delete', $flat);

        if ($flat->bills()->count() > 0) {
            return back()->with('error', 'Cannot delete flat with existing bills.');
        }

        if ($flat->tenant) {
            return back()->with('error', 'Cannot delete flat with active tenant.');
        }

        $flat->delete();

        return redirect()
            ->route('house-owner.flats.index')
            ->with('success', 'Flat deleted successfully.');
    }
}