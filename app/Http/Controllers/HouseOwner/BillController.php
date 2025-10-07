<?php

namespace App\Http\Controllers\HouseOwner;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Flat;
use App\Models\BillCategory;
use App\Notifications\BillCreatedNotification;
use App\Notifications\BillPaidNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class BillController extends Controller
{
    public function index(Request $request)
    {
        $houseOwner = auth()->user()->houseOwner;
        
        $query = Bill::whereHas('flat.building', function ($q) use ($houseOwner) {
                $q->where('house_owner_id', $houseOwner->id);
            })
            ->with(['flat.building', 'billCategory']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by month
        if ($request->filled('month')) {
            $query->where('month', $request->month);
        }

        $bills = $query->latest()->paginate(15);

        return view('house-owner.bills.index', compact('bills'));
    }

    public function create()
    {
        $houseOwner = auth()->user()->houseOwner;
        
        $flats = Flat::whereHas('building', function ($query) use ($houseOwner) {
                $query->where('house_owner_id', $houseOwner->id);
            })
            ->with('building')
            ->get();

        $categories = BillCategory::where('house_owner_id', $houseOwner->id)->get();

        return view('house-owner.bills.create', compact('flats', 'categories'));
    }

    public function store(Request $request)
    {
        $houseOwner = auth()->user()->houseOwner;
        
        $validated = $request->validate([
            'flat_id' => ['required', 'exists:flats,id'],
            'bill_category_id' => ['required', 'exists:bill_categories,id'],
            'month' => ['required', 'date_format:Y-m'],
            'amount' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        // Verify flat belongs to house owner
        $flat = Flat::whereHas('building', function ($query) use ($houseOwner) {
                $query->where('house_owner_id', $houseOwner->id);
            })
            ->findOrFail($validated['flat_id']);

        // Verify category belongs to house owner
        $category = BillCategory::where('house_owner_id', $houseOwner->id)
            ->findOrFail($validated['bill_category_id']);

        // Check if bill already exists for this flat, category, and month
        $exists = Bill::where('flat_id', $validated['flat_id'])
            ->where('bill_category_id', $validated['bill_category_id'])
            ->where('month', $validated['month'])
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors(['month' => 'Bill already exists for this flat, category, and month.']);
        }

        // Check for unpaid bills in previous months
        $previousUnpaidBills = Bill::where('flat_id', $validated['flat_id'])
            ->where('bill_category_id', $validated['bill_category_id'])
            ->where('month', '<', $validated['month'])
            ->whereIn('status', ['unpaid', 'partially_paid'])
            ->sum('due_amount');

        $bill = Bill::create([
            'flat_id' => $validated['flat_id'],
            'bill_category_id' => $validated['bill_category_id'],
            'month' => $validated['month'],
            'amount' => $validated['amount'],
            'due_amount' => $validated['amount'] + $previousUnpaidBills,
            'notes' => $validated['notes'] ?? null,
            'status' => 'unpaid',
        ]);

        // Send notification
        try {
            $notifiables = collect([$houseOwner->user]);
            
            if ($flat->tenant && $flat->tenant->email) {
                $notifiables->push($flat->tenant);
            }
            
            Notification::send($notifiables, new BillCreatedNotification($bill));
        } catch (\Exception $e) {
            // Log error but don't fail the request
            \Log::error('Failed to send bill notification: ' . $e->getMessage());
        }

        return redirect()
            ->route('house-owner.bills.index')
            ->with('success', 'Bill created successfully.');
    }

    public function show(Bill $bill)
    {
        $this->authorize('view', $bill);
        
        $bill->load(['flat.building', 'billCategory']);
        
        return view('house-owner.bills.show', compact('bill'));
    }

    public function edit(Bill $bill)
    {
        $this->authorize('update', $bill);
        
        if ($bill->status === 'paid') {
            return back()->with('error', 'Cannot edit paid bills.');
        }
        
        $houseOwner = auth()->user()->houseOwner;
        
        $flats = Flat::whereHas('building', function ($query) use ($houseOwner) {
                $query->where('house_owner_id', $houseOwner->id);
            })
            ->with('building')
            ->get();

        $categories = BillCategory::where('house_owner_id', $houseOwner->id)->get();

        return view('house-owner.bills.edit', compact('bill', 'flats', 'categories'));
    }

    public function update(Request $request, Bill $bill)
    {
        $this->authorize('update', $bill);
        
        if ($bill->status === 'paid') {
            return back()->with('error', 'Cannot update paid bills.');
        }
        
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        $bill->update([
            'amount' => $validated['amount'],
            'notes' => $validated['notes'] ?? null,
        ]);

        // Recalculate due amount
        $bill->due_amount = $validated['amount'] - $bill->paid_amount;
        $bill->save();
        $bill->updateStatus();

        return redirect()
            ->route('house-owner.bills.index')
            ->with('success', 'Bill updated successfully.');
    }

    public function destroy(Bill $bill)
    {
        $this->authorize('delete', $bill);

        if ($bill->paid_amount > 0) {
            return back()->with('error', 'Cannot delete bills with payments.');
        }

        $bill->delete();

        return redirect()
            ->route('house-owner.bills.index')
            ->with('success', 'Bill deleted successfully.');
    }

    public function markAsPaid(Request $request, Bill $bill)
    {
        $this->authorize('update', $bill);

        $validated = $request->validate([
            'paid_amount' => ['required', 'numeric', 'min:0'],
        ]);

        DB::beginTransaction();
        try {
            $totalAmount = $bill->amount + $bill->due_amount;
            $newPaidAmount = $bill->paid_amount + $validated['paid_amount'];

            if ($newPaidAmount > $totalAmount) {
                return back()->withErrors(['paid_amount' => 'Paid amount exceeds total bill amount.']);
            }

            $bill->paid_amount = $newPaidAmount;
            $bill->updateStatus();

            DB::commit();

            // Send payment notification
            try {
                $houseOwner = auth()->user()->houseOwner;
                Notification::send($houseOwner->user, new BillPaidNotification($bill));
            } catch (\Exception $e) {
                \Log::error('Failed to send payment notification: ' . $e->getMessage());
            }

            return redirect()
                ->route('house-owner.bills.show', $bill)
                ->with('success', 'Payment recorded successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to record payment: ' . $e->getMessage());
        }
    }
}