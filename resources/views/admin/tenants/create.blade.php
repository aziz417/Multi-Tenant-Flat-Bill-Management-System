@extends('layouts.admin')

@section('admin-content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create Tenant</h1>
    <a href="{{ route('admin.tenants.index') }}" class="btn btn-secondary">Back</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.tenants.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="building_id" class="form-label">Building <span class="text-danger">*</span></label>
                <select class="form-select @error('building_id') is-invalid @enderror" 
                        id="building_id" name="building_id" required>
                    <option value="">Select Building</option>
                    @foreach($buildings as $building)
                        <option value="{{ $building->id }}" {{ old('building_id') == $building->id ? 'selected' : '' }}>
                            {{ $building->name }} ({{ $building->houseOwner->name }})
                        </option>
                    @endforeach
                </select>
                @error('building_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="flat_id" class="form-label">Flat (Optional)</label>
                <select class="form-select @error('flat_id') is-invalid @enderror" 
                        id="flat_id" name="flat_id">
                    <option value="">Select Flat</option>
                </select>
                @error('flat_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                       id="phone" name="phone" value="{{ old('phone') }}" required>
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nid_number" class="form-label">NID Number</label>
                <input type="text" class="form-control @error('nid_number') is-invalid @enderror" 
                       id="nid_number" name="nid_number" value="{{ old('nid_number') }}">
                @error('nid_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="move_in_date" class="form-label">Move In Date</label>
                <input type="date" class="form-control @error('move_in_date') is-invalid @enderror" 
                       id="move_in_date" name="move_in_date" value="{{ old('move_in_date') }}">
                @error('move_in_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                <select class="form-select @error('status') is-invalid @enderror" 
                        id="status" name="status" required>
                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Create Tenant</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('building_id').addEventListener('change', function() {
    const buildingId = this.value;
    const flatSelect = document.getElementById('flat_id');
    
    flatSelect.innerHTML = '<option value="">Select Flat</option>';
    
    if (buildingId) {
        fetch(`/admin/buildings/${buildingId}/flats`)
            .then(response => response.json())
            .then(data => {
                data.forEach(flat => {
                    const option = document.createElement('option');
                    option.value = flat.id;
                    option.textContent = `${flat.flat_number} (${flat.status})`;
                    flatSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
    }
});

// Trigger on page load if building is already selected
if (document.getElementById('building_id').value) {
    document.getElementById('building_id').dispatchEvent(new Event('change'));
}
</script>
@endpush