@extends('layouts.house-owner')

@section('house-owner-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Building Details</h1>
    <div>
        <a href="{{ route('house-owner.buildings.edit', $building) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('house-owner.buildings.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Building Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $building->name }}</p>
                <p><strong>Address:</strong> {{ $building->address }}</p>
                <p><strong>Description:</strong> {{ $building->description ?? 'N/A' }}</p>
                <p><strong>Total Floors:</strong> {{ $building->total_floors }}</p>
                <p><strong>Total Flats:</strong> {{ $building->flats->count() }}</p>
                <p><strong>Created:</strong> {{ $building->created_at->format('Y-m-d H:i') }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Flats</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Flat Number</th>
                                <th>Floor</th>
                                <th>Owner</th>
                                <th>Bedrooms</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($building->flats as $flat)
                                <tr>
                                    <td>{{ $flat->flat_number }}</td>
                                    <td>{{ $flat->floor_number }}</td>
                                    <td>{{ $flat->flat_owner_name }}</td>
                                    <td>{{ $flat->bedrooms }}</td>
                                    <td>
                                        <span class="badge bg-{{ $flat->status == 'occupied' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($flat->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No flats found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5>Tenants</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Flat</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($building->tenants as $tenant)
                                <tr>
                                    <td>{{ $tenant->name }}</td>
                                    <td>{{ $tenant->email }}</td>
                                    <td>{{ $tenant->phone }}</td>
                                    <td>{{ $tenant->flat ? $tenant->flat->flat_number : 'Unassigned' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $tenant->status == 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($tenant->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No tenants found</td>
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