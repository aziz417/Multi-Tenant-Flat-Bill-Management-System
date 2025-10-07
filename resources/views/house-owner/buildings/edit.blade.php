@extends('layouts.house-owner')

@section('house-owner-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Building</h1>
    <a href="{{ route('house-owner.buildings.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('house-owner.buildings.update', $building) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Building Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name', $building->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                <textarea class="form-control @error('address') is-invalid @enderror" 
                          id="address" name="address" rows="3" required>{{ old('address', $building->address) }}</textarea>
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="3">{{ old('description', $building->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="total_floors" class="form-label">Total Floors <span class="text-danger">*</span></label>
                <input type="number" class="form-control @error('total_floors') is-invalid @enderror" 
                       id="total_floors" name="total_floors" value="{{ old('total_floors', $building->total_floors) }}" min="1" required>
                @error('total_floors')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Building</button>
        </form>
    </div>
</div>
@endsection