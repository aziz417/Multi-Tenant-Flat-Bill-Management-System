@extends('layouts.house-owner')

@section('house-owner-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create Flat</h1>
    <a href="{{ route('house-owner.flats.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('house-owner.flats.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="building_id" class="form-label">Building <span class="text-danger">*</span></label>
                <select class="form-select @error('building_id') is-invalid @enderror" 
                        id="building_id" name="building_id" required>
                    <option value="">Select Building</option>
                    @foreach($buildings as $building)
                        <option value="{{ $building->id }}" {{ old('building_id') == $building->id ? 'selected' : '' }}>
                            {{ $building->name }}
                        </option>
                    @endforeach
                </select>
                @error('building_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="flat_number" class="form-label">Flat Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('flat_number') is-invalid @enderror" 
                               id="flat_number" name="flat_number" value="{{ old('flat_number') }}" required>
                        @error('flat_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="floor_number" class="form-label">Floor Number <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('floor_number') is-invalid @enderror" 
                               id="floor_number" name="floor_number" value="{{ old('floor_number', 0) }}" min="0" required>
                        @error('floor_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="flat_owner_name" class="form-label">Flat Owner Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('flat_owner_name') is-invalid @enderror" 
                       id="flat_owner_name" name="flat_owner_name" value="{{ old('flat_owner_name') }}" required>
                @error('flat_owner_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="flat_owner_phone" class="form-label">Flat Owner Phone</label>
                        <input type="text" class="form-control @error('flat_owner_phone') is-invalid @enderror" 
                               id="flat_owner_phone" name="flat_owner_phone" value="{{ old('flat_owner_phone') }}">
                        @error('flat_owner_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="flat_owner_email" class="form-label">Flat Owner Email</label>
                        <input type="email" class="form-control @error('flat_owner_email') is-invalid @enderror" 
                               id="flat_owner_email" name="flat_owner_email" value="{{ old('flat_owner_email') }}">
                        @error('flat_owner_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="bedrooms" class="form-label">Bedrooms <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('bedrooms') is-invalid @enderror" 
                               id="bedrooms" name="bedrooms" value="{{ old('bedrooms', 1) }}" min="1" required>
                        @error('bedrooms')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="monthly_rent" class="form-label">Monthly Rent</label>
                        <input type="number" step="0.01" class="form-control @error('monthly_rent') is-invalid @enderror" 
                               id="monthly_rent" name="monthly_rent" value="{{ old('monthly_rent') }}" min="0">
                        @error('monthly_rent')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                            <option value="vacant" {{ old('status') == 'vacant' ? 'selected' : '' }}>Vacant</option>
                            <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>Occupied</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Create Flat</button>
        </form>
    </div>
</div>
@endsection