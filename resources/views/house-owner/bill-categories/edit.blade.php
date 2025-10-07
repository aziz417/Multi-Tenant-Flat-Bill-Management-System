@extends('layouts.house-owner')

@section('house-owner-content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Bill Category</h1>
        <a href="{{ route('house-owner.bill-categories.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('house-owner.bill-categories.update', $billCategory) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" value="{{ old('name', $billCategory->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                        rows="3">{{ old('description', $billCategory->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Category</button>
            </form>
        </div>
    </div>
@endsection
