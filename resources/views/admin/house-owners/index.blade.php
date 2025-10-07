@extends('layouts.admin')

@section('admin-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">House Owners</h1>
    <a href="{{ route('admin.house-owners.create') }}" class="btn btn-primary">Add House Owner</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Buildings</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($houseOwners as $owner)
                        <tr>
                            <td>{{ $owner->id }}</td>
                            <td>{{ $owner->name }}</td>
                            <td>{{ $owner->email }}</td>
                            <td>{{ $owner->phone ?? 'N/A' }}</td>
                            <td>{{ $owner->buildings->count() }}</td>
                            <td>{{ $owner->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('admin.house-owners.show', $owner) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('admin.house-owners.edit', $owner) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.house-owners.destroy', $owner) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No house owners found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $houseOwners->links() }}
        </div>
    </div>
</div>
@endsection