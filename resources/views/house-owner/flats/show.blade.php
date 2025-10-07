@extends('layouts.house-owner')

@section('house-owner-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Flat Details</h1>
    <div>
        <a href="{{ route('house-owner.flats.edit', $flat) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('house-owner.flats.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Flat Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Building:</strong> {{ $flat->building->name }}</p>
                <p><strong>Flat Number:</strong> {{ $flat->flat_number }}</p>
                <p><strong>Floor Number:</strong> {{ $flat->floor_number }}</p>
                <p><strong>Bedrooms:</strong> {{ $flat->bedrooms }}</p>
                <p><strong>Monthly Rent:</strong> {{ $flat->monthly_rent ? '৳' . number_format($flat->monthly_rent, 2) : 'N/A' }}</p>
                <p><strong>Status:</strong> 
                    <span class="badge bg-{{ $flat->status == 'occupied' ? 'success' : 'secondary' }}">
                        {{ ucfirst($flat->status) }}
                    </span>
                </p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5>Flat Owner Details</h5>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $flat->flat_owner_name }}</p>
                <p><strong>Phone:</strong> {{ $flat->flat_owner_phone ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $flat->flat_owner_email ?? 'N/A' }}</p>
            </div>
        </div>

        @if($flat->tenant)
        <div class="card mt-3">
            <div class="card-header">
                <h5>Current Tenant</h5>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $flat->tenant->name }}</p>
                <p><strong>Email:</strong> {{ $flat->tenant->email }}</p>
                <p><strong>Phone:</strong> {{ $flat->tenant->phone }}</p>
                <p><strong>Move In Date:</strong> {{ $flat->tenant->move_in_date?->format('Y-m-d') ?? 'N/A' }}</p>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Bills History</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Paid</th>
                                <th>Due</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($flat->bills as $bill)
                                <tr>
                                    <td>{{ date('M Y', strtotime($bill->month)) }}</td>
                                    <td>{{ $bill->billCategory->name }}</td>
                                    <td>৳{{ number_format($bill->amount, 2) }}</td>
                                    <td>৳{{ number_format($bill->paid_amount, 2) }}</td>
                                    <td>৳{{ number_format($bill->due_amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $bill->status == 'paid' ? 'success' : 'warning' }}">
                                            {{ ucfirst($bill->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No bills found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection