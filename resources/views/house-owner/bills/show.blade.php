@extends('layouts.house-owner')

@section('house-owner-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Bill Details</h1>
    <div>
        @if($bill->status != 'paid')
            <a href="{{ route('house-owner.bills.edit', $bill) }}" class="btn btn-warning">Edit</a>
        @endif
        <a href="{{ route('house-owner.bills.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Bill Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Building:</strong> {{ $bill->flat->building->name }}</p>
                <p><strong>Flat Number:</strong> {{ $bill->flat->flat_number }}</p>
                <p><strong>Category:</strong> {{ $bill->billCategory->name }}</p>
                <p><strong>Month:</strong> {{ date('F Y', strtotime($bill->month)) }}</p>
                <p><strong>Amount:</strong> ৳{{ number_format($bill->amount, 2) }}</p>
                <p><strong>Paid Amount:</strong> ৳{{ number_format($bill->paid_amount, 2) }}</p>
                <p><strong>Due Amount:</strong> ৳{{ number_format($bill->due_amount, 2) }}</p>
                <p><strong>Status:</strong> 
                    <span class="badge bg-{{ $bill->status == 'paid' ? 'success' : ($bill->status == 'partially_paid' ? 'warning' : 'danger') }}">
                        {{ ucfirst(str_replace('_', ' ', $bill->status)) }}
                    </span>
                </p>
                @if($bill->notes)
                    <p><strong>Notes:</strong> {{ $bill->notes }}</p>
                @endif
                @if($bill->paid_at)
                    <p><strong>Paid At:</strong> {{ $bill->paid_at->format('Y-m-d H:i') }}</p>
                @endif
                <p><strong>Created:</strong> {{ $bill->created_at->format('Y-m-d H:i') }}</p>
            </div>
        </div>
    </div>

    @if($bill->status != 'paid')
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Record Payment</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('house-owner.bills.mark-as-paid', $bill) }}" method="POST">
                    @csrf

                    <div class="alert alert-info">
                        <strong>Total Amount:</strong> ৳{{ number_format($bill->amount + $bill->due_amount, 2) }}<br>
                        <strong>Already Paid:</strong> ৳{{ number_format($bill->paid_amount, 2) }}<br>
                        <strong>Remaining:</strong> ৳{{ number_format(($bill->amount + $bill->due_amount) - $bill->paid_amount, 2) }}
                    </div>

                    <div class="mb-3">
                        <label for="paid_amount" class="form-label">Payment Amount <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('paid_amount') is-invalid @enderror" 
                               id="paid_amount" name="paid_amount" value="{{ old('paid_amount') }}" 
                               min="0" max="{{ ($bill->amount + $bill->due_amount) - $bill->paid_amount }}" required>
                        @error('paid_amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Maximum: ৳{{ number_format(($bill->amount + $bill->due_amount) - $bill->paid_amount, 2) }}</small>
                    </div>

                    <button type="submit" class="btn btn-success">Record Payment</button>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection