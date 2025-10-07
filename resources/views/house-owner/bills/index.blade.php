@extends('layouts.house-owner')

@section('house-owner-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Bills</h1>
    <a href="{{ route('house-owner.bills.create') }}" class="btn btn-primary">Create Bill</a>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" action="{{ route('house-owner.bills.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    <option value="partially_paid" {{ request('status') == 'partially_paid' ? 'selected' : '' }}>Partially Paid</option>
                    <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="month" class="form-label">Month</label>
                <input type="month" name="month" id="month" class="form-control" value="{{ request('month') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label d-block">&nbsp;</label>
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="{{ route('house-owner.bills.index') }}" class="btn btn-secondary">Clear</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Building</th>
                        <th>Flat</th>
                        <th>Category</th>
                        <th>Month</th>
                        <th>Amount</th>
                        <th>Paid</th>
                        <th>Due</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bills as $bill)
                        <tr>
                            <td>{{ $bill->id }}</td>
                            <td>{{ $bill->flat->building->name }}</td>
                            <td>{{ $bill->flat->flat_number }}</td>
                            <td>{{ $bill->billCategory->name }}</td>
                            <td>{{ date('M Y', strtotime($bill->month)) }}</td>
                            <td>৳{{ number_format($bill->amount, 2) }}</td>
                            <td>৳{{ number_format($bill->paid_amount, 2) }}</td>
                            <td>৳{{ number_format($bill->due_amount, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ $bill->status == 'paid' ? 'success' : ($bill->status == 'partially_paid' ? 'warning' : 'danger') }}">
                                    {{ ucfirst(str_replace('_', ' ', $bill->status)) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('house-owner.bills.show', $bill) }}" class="btn btn-sm btn-info">View</a>
                                @if($bill->status != 'paid')
                                    <a href="{{ route('house-owner.bills.edit', $bill) }}" class="btn btn-sm btn-warning">Edit</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">No bills found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $bills->links() }}
        </div>
    </div>
</div>
@endsection