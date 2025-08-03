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
                        <div class="col-md-4">
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
                        <div class="col-md-4">
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
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="category_id" class="form-label fw-bold">Category</label>
                                <select class="form-select @error('category_id') is-invalid @enderror" 
                                        id="category_id" 
                                        name="category_id">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Optional category for organizing tests</div>
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

                    <!-- Test Parameters Section -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-list me-1"></i>Test Parameters
                        </label>
                        <div class="card border">
                            <div class="card-body">
                                <div id="parameters-container">
                                    <!-- Parameters will be added here dynamically -->
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm" onclick="addParameter()">
                                    <i class="fas fa-plus me-1"></i>Add Parameter
                                </button>
                            </div>
                        </div>
                        @error('parameters')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Add parameters that will be tested in this lab test</div>
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
// Parameter management
let parameterCounter = 0;

function addParameter() {
    parameterCounter++;
    const container = document.getElementById('parameters-container');
    
    const parameterDiv = document.createElement('div');
    parameterDiv.className = 'parameter-item border rounded p-3 mb-3';
    parameterDiv.id = `parameter-${parameterCounter}`;
    
    parameterDiv.innerHTML = `
        <div class="row">
            <div class="col-md-4">
                <div class="mb-2">
                    <label class="form-label small fw-bold">Parameter Name</label>
                    <input type="text" 
                           class="form-control form-control-sm" 
                           name="parameters[${parameterCounter}][name_description]" 
                           placeholder="e.g., Hemoglobin"
                           required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-2">
                    <label class="form-label small fw-bold">Unit</label>
                    <input type="text" 
                           class="form-control form-control-sm" 
                           name="parameters[${parameterCounter}][unit]" 
                           placeholder="e.g., g/dL">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-2">
                    <label class="form-label small fw-bold">Normal Value</label>
                    <input type="text" 
                           class="form-control form-control-sm" 
                           name="parameters[${parameterCounter}][normal_value]" 
                           placeholder="e.g., 12-16">
                </div>
            </div>
            <div class="col-md-2">
                <div class="mb-2">
                    <label class="form-label small fw-bold">Sort Order</label>
                    <input type="number" 
                           class="form-control form-control-sm" 
                           name="parameters[${parameterCounter}][sort_order]" 
                           value="${parameterCounter}"
                           min="1">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="mb-2">
                    <label class="form-label small fw-bold">Default Result</label>
                    <input type="text" 
                           class="form-control form-control-sm" 
                           name="parameters[${parameterCounter}][default_result]" 
                           placeholder="Default result value">
                </div>
            </div>
            <div class="col-md-4">
                <div class="mb-2 d-flex align-items-end">
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeParameter(${parameterCounter})">
                        <i class="fas fa-trash me-1"></i>Remove
                    </button>
                </div>
            </div>
        </div>
    `;
    
    container.appendChild(parameterDiv);
}

function removeParameter(counter) {
    const parameterDiv = document.getElementById(`parameter-${counter}`);
    if (parameterDiv) {
        parameterDiv.remove();
    }
}

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
<link href="{{ asset('css/admin-layout.css') }}" rel="stylesheet">
@endsection 