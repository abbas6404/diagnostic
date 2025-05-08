@extends('admin.layouts.app')

@section('title', 'Create User')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create New User</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Back to Users
        </a>
    </div>

    <!-- User Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">User Details</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Enter user name">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="Enter user email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Enter password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="form-text text-muted">
                                Password must be at least 8 characters long and contain at least one letter and one number.
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">User Roles</label>
                            <div class="card">
                                <div class="card-body">
                                    <div class="roles-section">
                                        @foreach ($roles as $role)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}" {{ old('roles') && in_array((string)$role->id, old('roles')) ? 'checked' : '' }}>
                                                <label class="form-check-label d-flex align-items-center" for="role_{{ $role->id }}">
                                                    <span class="badge me-2 {{ $role->name === 'Super Admin' ? 'bg-danger' : ($role->name === 'Admin' ? 'bg-primary' : ($role->name === 'Moderator' ? 'bg-warning' : 'bg-secondary')) }} px-3 py-2">
                                                        {{ $role->name }}
                                                    </span>
                                                    <small class="text-muted">
                                                        ({{ $role->permissions->count() }} permissions)
                                                    </small>
                                                </label>
                                            </div>
                                        @endforeach
                                        
                                        @error('roles')
                                            <div class="text-danger mt-2">
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-text text-muted mt-2">
                                Select at least one role for the user. Each role grants different permissions in the system.
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Create User
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .badge {
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .card-body {
        padding: 1.25rem;
    }
    
    .roles-section {
        max-height: 250px;
        overflow-y: auto;
    }
</style>
@endpush 