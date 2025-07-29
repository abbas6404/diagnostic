@extends('admin.setup.setup-layout')

@section('page-title', 'Edit Collection Kit')
@section('page-description', 'Update collection kit information')

@section('setup-content')
<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-edit me-2"></i>Edit Collection Kit
        </h6>
    </div>
    <div class="card-body">
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('admin.setup.collection-kit.update', $collectionKit) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="pcode" class="form-label">Product Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('pcode') is-invalid @enderror" 
                               id="pcode" name="pcode" value="{{ old('pcode', $collectionKit->pcode) }}" 
                               placeholder="e.g., CK-001" required>
                        @error('pcode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Unique product code for the collection kit</small>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $collectionKit->name) }}" 
                               placeholder="e.g., Needle, Semen Container" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="color" class="form-label">Color</label>
                        <input type="text" class="form-control @error('color') is-invalid @enderror" 
                               id="color" name="color" value="{{ old('color', $collectionKit->color) }}" 
                               placeholder="e.g., Red, Blue, Yellow">
                        @error('color')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="charge" class="form-label">Charge <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">৳</span>
                            <input type="number" step="0.01" min="0" class="form-control @error('charge') is-invalid @enderror" 
                                   id="charge" name="charge" value="{{ old('charge', $collectionKit->charge) }}" 
                                   placeholder="0.00" required>
                            @error('charge')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="">Select Status</option>
                    <option value="active" {{ old('status', $collectionKit->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $collectionKit->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="group_test" {{ old('status', $collectionKit->status) == 'group_test' ? 'selected' : '' }}>Group Test</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.setup.collection-kit.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to List
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Update Collection Kit
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 