@extends('layouts.admin')

@section('admin-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">House Owner Details</h1>
    <div>
        <a href="{{ route('admin.house-owners.edit', $houseOwner) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('admin.house-owners.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Personal Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $houseOwner->name }}</p>
                <p><strong>Email:</strong> {{ $houseOwner->email }}</p>
                <p><strong>Phone:</strong> {{ $houseOwner->phone ?? 'N/A' }}</p>
                <p><strong>Address:</strong> {{ $houseOwner->address ?? 'N/A' }}</p>
                <p><strong>Created:</strong> {{ $houseOwner->created_at->format('Y-m-d H:i') }}</p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5>Statistics</h5>
            </div>
            <div class="card-body">
                <p><strong>Total Buildings:</strong> {{ $stats['total_buildings'] }}</p>
                <p><strong>Total Flats:</strong> {{ $stats['total_flats'] }}</p>
                <p><strong>Occupied Flats:</strong> {{ $stats['occupied_flats'] }}</p>
                <p><strong>Bill Categories:</strong> {{ $stats['total_bill_categories'] }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Buildings</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Floors</th>
                                <th>Flats</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($houseOwner->buildings as $building)
                                <tr>
                                    <td>{{ $building->name }}</td>
                                    <td>{{ $building->address }}</td>
                                    <td>{{ $building->total_floors }}</td>
                                    <td>{{ $building->flats->count() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No buildings found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5>Bill Categories</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($houseOwner->billCategories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->description ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="text-center">No bill categories found</td>
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