@extends('layouts.house-owner')

@section('house-owner-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Flats</h1>
    <a href="{{ route('house-owner.flats.create') }}" class="btn btn-primary">Add Flat</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Building</th>
                        <th>Flat Number</th>
                        <th>Floor</th>
                        <th>Owner</th>
                        <th>Bedrooms</th>
                        <th>Rent</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($flats as $flat)
                        <tr>
                            <td>{{ $flat->id }}</td>
                            <td>{{ $flat->building->name }}</td>
                            <td>{{ $flat->flat_number }}</td>
                            <td>{{ $flat->floor_number }}</td>
                            <td>{{ $flat->flat_owner_name }}</td>
                            <td>{{ $flat->bedrooms }}</td>
                            <td>{{ $flat->monthly_rent ? '৳' . number_format($flat->monthly_rent, 2) : 'N/A' }}</td>
                            <td>
                                <span class="badge bg-{{ $flat->status == 'occupied' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($flat->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('house-owner.flats.show', $flat) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('house-owner.flats.edit', $flat) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('house-owner.flats.destroy', $flat) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No flats found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $flats->links() }}
        </div>
    </div>
</div>
@endsection