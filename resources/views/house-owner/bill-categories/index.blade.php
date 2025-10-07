@extends('layouts.house-owner')

@section('house-owner-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Bill Categories</h1>
    <a href="{{ route('house-owner.bill-categories.create') }}" class="btn btn-primary">Add Category</a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Total Bills</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description ?? 'N/A' }}</td>
                            <td>{{ $category->bills_count }}</td>
                            <td>{{ $category->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('house-owner.bill-categories.edit', $category) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('house-owner.bill-categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No bill categories found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $categories->links() }}
        </div>
    </div>
</div>
@endsection