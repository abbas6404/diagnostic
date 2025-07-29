@extends('admin.setup.setup-layout')

@section('page-title', 'Create Lab Test')
@section('page-description', 'Add a new laboratory test')

@section('setup-content')
<div class="row">
    <!-- Main Form Area -->
    <div class="col-md-7">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-plus me-2"></i>Create New Lab Test
                    <span id="selected-kits-header" class="ms-2 text-muted small"></span>
                </h6>
            </div>
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                                <form action="{{ route('admin.setup.lab-test.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="code" class="form-label fw-bold">Test Code <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('code') is-invalid @enderror" 
                                       id="code" 
                                       name="code" 
                                       value="{{ old('code') }}" 
                                       placeholder="Enter test code"
                                       required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Unique code for the lab test</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="department_id" class="form-label fw-bold">Department <span class="text-danger">*</span></label>
                                <select class="form-select @error('department_id') is-invalid @enderror" 
                                        id="department_id" 
                                        name="department_id" 
                                        required>
                                    <option value="">Select Department</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" 
                                                {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Test Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               placeholder="Enter test name"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="3" 
                                  placeholder="Enter test description">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Optional description for the lab test</div>
                    </div>

                    <div class="mb-3">
                        <label for="charge" class="form-label fw-bold">Charge <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">৳</span>
                            <input type="number" 
                                   class="form-control @error('charge') is-invalid @enderror" 
                                   id="charge" 
                                   name="charge" 
                                   value="{{ old('charge') }}" 
                                   placeholder="0.00"
                                   step="0.01"
                                   min="0"
                                   required>
                        </div>
                        @error('charge')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Cost of the lab test in Taka</div>
                    </div>

                    <!-- Hidden collection kits inputs -->
                    <div id="collection-kits-inputs"></div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.setup.lab-test.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Back to List
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Create Lab Test
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Collection Kits Sidebar -->
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-box me-2"></i>Collection Kits
                </h6>
            </div>
            <div class="card-body">
                <div class="form-text mb-3">Select collection kits required for this test</div>
                <div class="border rounded p-3" style="max-height: 400px; overflow-y: auto;">
                    @forelse($collectionKits as $kit)
                        <div class="form-check mb-2">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   name="collection_kits[]" 
                                   value="{{ $kit->id }}" 
                                   id="kit_{{ $kit->id }}"
                                   {{ in_array($kit->id, old('collection_kits', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="kit_{{ $kit->id }}">
                                <strong>{{ $kit->pcode }}</strong> - {{ $kit->name }}
                                @if($kit->color)
                                    <span class="badge bg-secondary ms-2">{{ $kit->color }}</span>
                                @endif
                                <span class="text-muted ms-2">(৳{{ number_format($kit->charge, 2) }})</span>
                            </label>
                        </div>
                    @empty
                        <div class="text-muted">No collection kits available</div>
                    @endforelse
                </div>
                @error('collection_kits')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('input[name="collection_kits[]"]');
    const headerSpan = document.getElementById('selected-kits-header');
    const hiddenInputsContainer = document.getElementById('collection-kits-inputs');
    
    function updateSelectedKits() {
        const selectedKits = [];
        
        // Clear existing hidden inputs
        hiddenInputsContainer.innerHTML = '';
        
        checkboxes.forEach(checkbox => {
            const label = checkbox.nextElementSibling;
            
            if (checkbox.checked) {
                const kitCode = label.querySelector('strong').textContent;
                selectedKits.push(kitCode);
                label.classList.add('selected-kit');
                
                // Add hidden input to form
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'collection_kits[]';
                hiddenInput.value = checkbox.value;
                hiddenInputsContainer.appendChild(hiddenInput);
            } else {
                label.classList.remove('selected-kit');
            }
        });
        
        if (selectedKits.length > 0) {
            const highlightedKits = selectedKits.map(kit => `<span class="selected-kit-code">${kit}</span>`).join(' ');
            headerSpan.innerHTML = `| ${highlightedKits}`;
            headerSpan.style.display = 'inline';
        } else {
            headerSpan.style.display = 'none';
        }
    }
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedKits);
    });
    
    // Initialize display
    updateSelectedKits();
});
</script>
@endsection

@section('styles')
<style>
.selected-kit {
    background-color: #e3f2fd !important;
    border-radius: 6px;
    padding: 8px 12px;
    margin: 2px 0;
    border-left: 4px solid #2196f3;
    font-weight: 600;
    color: #1976d2;
    transition: all 0.3s ease;
}

.selected-kit strong {
    color: #1565c0 !important;
}

.selected-kit .badge {
    background-color: #1976d2 !important;
}

.form-check-label {
    padding: 6px 8px;
    border-radius: 4px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.form-check-label:hover {
    background-color: #f5f5f5;
}

.form-check {
    display: flex;
    align-items: center;
    margin-bottom: 8px;
}

.form-check-input {
    margin-top: 0;
    margin-right: 8px;
    flex-shrink: 0;
}

.form-check-label {
    padding: 6px 8px;
    border-radius: 4px;
    transition: all 0.3s ease;
    cursor: pointer;
    flex: 1;
    display: flex;
    align-items: center;
}

.selected-kit-code {
    background-color: #2196f3;
    color: white;
    padding: 2px 6px;
    border-radius: 4px;
    font-weight: 600;
    font-size: 0.85em;
    margin: 0 1px;
    display: inline-block;
}
</style>
@endsection 