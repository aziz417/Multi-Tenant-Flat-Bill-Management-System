@extends('layouts.admin')

@section('admin-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tenant Details</h1>
    <div>
        <a href="{{ route('admin.tenants.edit', $tenant) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('admin.tenants.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Personal Information</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Name:</strong> {{ $tenant->name }}</p>
                <p><strong>Email:</strong> {{ $tenant->email }}</p>
                <p><strong>Phone:</strong> {{ $tenant->phone }}</p>
                <p><strong>NID Number:</strong> {{ $tenant->nid_number ?? 'N/A' }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Building:</strong> {{ $tenant->building->name }}</p>
                <p><strong>Flat:</strong> {{ $tenant->flat ? $tenant->flat->flat_number : 'Unassigned' }}</p>
                <p><strong>Move In Date:</strong> {{ $tenant->move_in_date?->format('Y-m-d') ?? 'N/A' }}</p>
                <p><strong>Move Out Date:</strong> {{ $tenant->move_out_date?->format('Y-m-d') ?? 'N/A' }}</p>
                <p><strong>Status:</strong> 
                    <span class="badge bg-{{ $tenant->status == 'active' ? 'success' : 'secondary' }}">
                        {{ ucfirst($tenant->status) }}
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection