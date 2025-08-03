@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit User</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Back to Users
        </a>
    </div>

    <!-- User Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold">User Details</h6>
            <div>
                @foreach($user->roles as $role)
                    <span class="badge {{ $role->name === 'Super Admin' ? 'bg-danger' : ($role->name === 'Admin' ? 'bg-primary' : ($role->name === 'Moderator' ? 'bg-warning' : 'bg-secondary')) }} px-3 py-2">
                        {{ $role->name }}
                    </span>
                @endforeach
            </div>
        </div>
        <div class="card-body">
            @if ($user->id === auth()->id())
                <div class="alert alert-info mb-4">
                    <i class="fas fa-info-circle mr-1"></i> You are editing your own profile. Note that changing your own roles might affect your access to certain features.
                </div>
            @endif

            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Leave blank to keep current password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="form-text text-muted">
                                Leave blank to keep the current password. If changing, password must be at least 8 characters long.
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">User Roles</label>
                            <div class="card">
                                <div class="card-body">
                                    @if(isset($canAssignRoles) && $canAssignRoles)
                                    <div class="roles-section">
                                        @foreach ($roles as $role)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}" 
                                                {{ (old('roles') && in_array((string)$role->id, old('roles'))) || 
                                                   (empty(old('roles')) && in_array((string)$role->id, $userRoles)) ? 'checked' : '' }}
                                                {{ ($user->email === 'superadmin@example.com' && $role->name === 'Super Admin') ? 'checked disabled' : '' }}>
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
                                    <div class="form-text text-muted mt-2">
                                        Select at least one role for the user. Each role grants different permissions in the system.
                                    </div>
                                    @else
                                    <div class="alert alert-info mb-0">
                                        <i class="fas fa-info-circle me-2"></i> You don't have permission to change user roles.
                                        <div class="mt-2">
                                            <strong>Current roles:</strong>
                                            @forelse($user->roles as $role)
                                                <span class="badge me-1 {{ $role->name === 'Super Admin' ? 'bg-danger' : ($role->name === 'Admin' ? 'bg-primary' : ($role->name === 'Moderator' ? 'bg-warning' : 'bg-secondary')) }} px-3 py-2">
                                                    {{ $role->name }}
                                                </span>
                                            @empty
                                                <span class="text-muted">No roles assigned</span>
                                            @endforelse
                                        </div>
                                    </div>
                                    @endif
                                    
                                    @if ($user->email === 'superadmin@example.com')
                                        <div class="alert alert-warning mt-3">
                                            <i class="fas fa-exclamation-triangle mr-1"></i> The system Super Admin role cannot be removed from this user.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Update User
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/admin-layout.css') }}" rel="stylesheet">
@endpush 