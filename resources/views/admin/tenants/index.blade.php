@extends('layouts.admin')

@section('admin-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tenants</h1>
    <a href="{{ route('admin.tenants.create') }}" class="btn btn-primary">Add Tenant</a>
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
                        <th>Building</th>
                        <th>Flat</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tenants as $tenant)
                        <tr>
                            <td>{{ $tenant->id }}</td>
                            <td>{{ $tenant->name }}</td>
                            <td>{{ $tenant->email }}</td>
                            <td>{{ $tenant->phone }}</td>
                            <td>{{ $tenant->building->name }}</td>
                            <td>{{ $tenant->flat ? $tenant->flat->flat_number : 'Unassigned' }}</td>
                            <td>
                                <span class="badge bg-{{ $tenant->status == 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($tenant->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.tenants.show', $tenant) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('admin.tenants.edit', $tenant) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.tenants.destroy', $tenant) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No tenants found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $tenants->links() }}
        </div>
    </div>
</div>
@endsection