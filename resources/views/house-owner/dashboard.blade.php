@extends('layouts.house-owner')

@section('house-owner-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Buildings</h5>
                <p class="card-text display-4">{{ $stats['total_buildings'] }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Flats</h5>
                <p class="card-text display-4">{{ $stats['total_flats'] }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">Occupied Flats</h5>
                <p class="card-text display-4">{{ $stats['occupied_flats'] }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Tenants</h5>
                <p class="card-text display-4">{{ $stats['total_tenants'] }}</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Unpaid Bills</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Flat</th>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($unpaidBills as $bill)
                                <tr>
                                    <td>{{ $bill->flat->flat_number }}</td>
                                    <td>{{ $bill->billCategory->name }}</td>
                                    <td>৳{{ number_format($bill->due_amount, 2) }}</td>
                                    <td>
                                        <span class="badge bg-warning">{{ ucfirst($bill->status) }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No unpaid bills</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Recent Bills</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Flat</th>
                                <th>Category</th>
                                <th>Month</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBills as $bill)
                                <tr>
                                    <td>{{ $bill->flat->flat_number }}</td>
                                    <td>{{ $bill->billCategory->name }}</td>
                                    <td>{{ date('M Y', strtotime($bill->month)) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $bill->status == 'paid' ? 'success' : 'warning' }}">
                                            {{ ucfirst($bill->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No bills found</td>
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