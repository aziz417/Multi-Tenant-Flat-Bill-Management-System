<?php

namespace App\Http\Controllers\HouseOwner;

use App\Http\Controllers\Controller;
use App\Models\BillCategory;
use Illuminate\Http\Request;

class BillCategoryController extends Controller
{
    public function index()
    {
        $houseOwner = auth()->user()->houseOwner;

        $categories = BillCategory::where('house_owner_id', $houseOwner->id)
            ->withCount('bills')
            ->latest()
            ->paginate(15);

        return view('house-owner.bill-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('house-owner.bill-categories.create');
    }

    public function store(Request $request)
    {
        $houseOwner = auth()->user()->houseOwner;

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        // Check unique name for house owner
        $exists = BillCategory::where('house_owner_id', $houseOwner->id)
            ->where('name', $validated['name'])
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors(['name' => 'Bill category name already exists.']);
        }

        BillCategory::create([
            'house_owner_id' => $houseOwner->id,
            ...$validated
        ]);

        return redirect()
            ->route('house-owner.bill-categories.index')
            ->with('success', 'Bill Category created successfully.');
    }

    public function edit(BillCategory $billCategory)
    {
        $this->authorize('update', $billCategory);

        return view('house-owner.bill-categories.edit', compact('billCategory'));
    }

    public function update(Request $request, BillCategory $billCategory)
    {
        $this->authorize('update', $billCategory);

        $houseOwner = auth()->user()->houseOwner;

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        // Check unique name for house owner (excluding current)
        $exists = BillCategory::where('house_owner_id', $houseOwner->id)
            ->where('name', $validated['name'])
            ->where('id', '!=', $billCategory->id)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors(['name' => 'Bill category name already exists.']);
        }

        $billCategory->update($validated);

        return redirect()
            ->route('house-owner.bill-categories.index')
            ->with('success', 'Bill Category updated successfully.');
    }

    public function destroy(BillCategory $billCategory)
    {
        $this->authorize('delete', $billCategory);

        if ($billCategory->bills()->count() > 0) {
            return back()->with('error', 'Cannot delete category with existing bills.');
        }

        $billCategory->delete();

        return redirect()
            ->route('house-owner.bill-categories.index')
            ->with('success', 'Bill Category deleted successfully.');
    }
}