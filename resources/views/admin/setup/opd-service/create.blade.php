@extends('admin.setup.setup-layout')

@section('page-title', 'Create OPD Service')
@section('page-description', 'Add a new OPD service')

@section('setup-content')
<div class="card shadow">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-plus me-2"></i>Create New OPD Service
        </h6>
    </div>
    <div class="card-body">
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('admin.setup.opd-service.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="code" class="form-label fw-bold">Service Code <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('code') is-invalid @enderror" 
                               id="code" 
                               name="code" 
                               value="{{ old('code') }}" 
                               placeholder="Enter service code"
                               required>
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Unique code for the OPD service</div>
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
                <label for="name" class="form-label fw-bold">Service Name <span class="text-danger">*</span></label>
                <input type="text" 
                       class="form-control @error('name') is-invalid @enderror" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}" 
                       placeholder="Enter service name"
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
                          placeholder="Enter service description">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="form-text">Optional description for the OPD service</div>
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
                <div class="form-text">Cost of the OPD service in Taka</div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.setup.opd-service.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to List
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Create OPD Service
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 