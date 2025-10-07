@extends('layouts.house-owner')

@section('house-owner-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Buildings</h1>
    <a href="{{ route('house-owner.buildings.create') }}" class="btn btn-primary">Add Building</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Floors</th>
                        <th>Flats</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($buildings as $building)
                        <tr>
                            <td>{{ $building->id }}</td>
                            <td>{{ $building->name }}</td>
                            <td>{{ $building->address }}</td>
                            <td>{{ $building->total_floors }}</td>
                            <td>{{ $building->flats_count }}</td>
                            <td>{{ $building->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('house-owner.buildings.show', $building) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('house-owner.buildings.edit', $building) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('house-owner.buildings.destroy', $building) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No buildings found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $buildings->links() }}
        </div>
    </div>
</div>
@endsection