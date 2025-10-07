@extends('layouts.house-owner')

@section('house-owner-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create Bill</h1>
    <a href="{{ route('house-owner.bills.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('house-owner.bills.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="flat_id" class="form-label">Flat <span class="text-danger">*</span></label>
                <select class="form-select @error('flat_id') is-invalid @enderror" 
                        id="flat_id" name="flat_id" required>
                    <option value="">Select Flat</option>
                    @foreach($flats as $flat)
                        <option value="{{ $flat->id }}" {{ old('flat_id') == $flat->id ? 'selected' : '' }}>
                            {{ $flat->building->name }} - Flat {{ $flat->flat_number }}
                        </option>
                    @endforeach
                </select>
                @error('flat_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="bill_category_id" class="form-label">Bill Category <span class="text-danger">*</span></label>
                <select class="form-select @error('bill_category_id') is-invalid @enderror" 
                        id="bill_category_id" name="bill_category_id" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('bill_category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('bill_category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="month" class="form-label">Month <span class="text-danger">*</span></label>
                        <input type="month" class="form-control @error('month') is-invalid @enderror" 
                               id="month" name="month" value="{{ old('month', date('Y-m')) }}" required>
                        @error('month')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" 
                               id="amount" name="amount" value="{{ old('amount') }}" min="0" required>
                        @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea class="form-control @error('notes') is-invalid @enderror" 
                          id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Create Bill</button>
        </form>
    </div>
</div>
@endsection