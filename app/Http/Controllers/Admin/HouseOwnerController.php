<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HouseOwner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class HouseOwnerController extends Controller
{
    public function index()
    {
        $houseOwners = HouseOwner::with('user', 'buildings')
            ->latest()
            ->paginate(15);

        return view('admin.house-owners.index', compact('houseOwners'));
    }

    public function create()
    {
        return view('admin.house-owners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $user->assignRole('house_owner');

            HouseOwner::create([
                'user_id' => $user->id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.house-owners.index')
                ->with('success', 'House Owner created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to create House Owner: ' . $e->getMessage());
        }
    }

    public function show(HouseOwner $houseOwner)
    {
        $houseOwner->load(['buildings.flats', 'billCategories']);

        $stats = [
            'total_buildings' => $houseOwner->buildings()->count(),
            'total_flats' => $houseOwner->flats()->count(),
            'occupied_flats' => $houseOwner->flats()->where('status', 'occupied')->count(),
            'total_bill_categories' => $houseOwner->billCategories()->count(),
        ];

        return view('admin.house-owners.show', compact('houseOwner', 'stats'));
    }

    public function edit(HouseOwner $houseOwner)
    {
        return view('admin.house-owners.edit', compact('houseOwner'));
    }

    public function update(Request $request, HouseOwner $houseOwner)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:house_owners,email,' . $houseOwner->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
        ]);

        DB::beginTransaction();
        try {
            $houseOwner->update($validated);

            $houseOwner->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            DB::commit();

            return redirect()
                ->route('admin.house-owners.index')
                ->with('success', 'House Owner updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Failed to update House Owner: ' . $e->getMessage());
        }
    }

    public function destroy(HouseOwner $houseOwner)
    {
        DB::beginTransaction();
        try {
            $user = $houseOwner->user;
            $houseOwner->delete();
            $user->delete();

            DB::commit();

            return redirect()
                ->route('admin.house-owners.index')
                ->with('success', 'House Owner deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete House Owner: ' . $e->getMessage());
        }
    }
}