@extends('layouts.house-owner')

@section('house-owner-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Bill</h1>
    <a href="{{ route('house-owner.bills.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('house-owner.bills.update', $bill) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="alert alert-info">
                <strong>Flat:</strong> {{ $bill->flat->building->name }} - Flat {{ $bill->flat->flat_number }}<br>
                <strong>Category:</strong> {{ $bill->billCategory->name }}<br>
                <strong>Month:</strong> {{ date('F Y', strtotime($bill->month)) }}
            </div>

            <div class="mb-3">
                <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" 
                       id="amount" name="amount" value="{{ old('amount', $bill->amount) }}" min="0" required>
                @error('amount')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="notes" class="form-label">Notes</label>
                <textarea class="form-control @error('notes') is-invalid @enderror" 
                          id="notes" name="notes" rows="3">{{ old('notes', $bill->notes) }}</textarea>
                @error('notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Bill</button>
        </form>
    </div>
</div>
@endsection