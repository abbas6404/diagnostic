@extends('admin.layouts.app')

@section('title', 'Edit Role')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Role: {{ $role->name }}</h1>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Back to Roles
        </a>
    </div>

    <!-- Role Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold">Role Details</h6>
            <span class="badge {{ $role->name === 'Super Admin' ? 'bg-danger' : ($role->name === 'Admin' ? 'bg-primary' : 'bg-success') }} px-3 py-2">
                {{ $role->users->count() }} {{ Str::plural('User', $role->users->count()) }}
            </span>
        </div>
        <div class="card-body">
            @if($role->name === 'Super Admin')
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    <strong>Warning:</strong> The Super Admin role has all permissions by default and cannot be modified.
                </div>
            @endif

            <form method="POST" action="{{ route('admin.roles.update', $role) }}" id="roleForm">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Role Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $role->name) }}" required {{ $role->name === 'Super Admin' || $role->name === 'Admin' ? 'readonly' : '' }}> 
                            @if($role->name === 'Super Admin' || $role->name === 'Admin')
                                <input type="hidden" name="name" value="{{ $role->name }}">
                            @endif
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="form-text text-muted">
                                @if($role->name === 'Super Admin' || $role->name === 'Admin')
                                    System roles cannot be renamed.
                                @else
                                    Role name should be unique and descriptive.
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card bg-light h-100">
                            <div class="card-body">
                                <h6 class="card-title">Role Information</h6>
                                <div class="mb-2">
                                    <strong>Created:</strong> {{ $role->created_at ? $role->created_at->format('M d, Y h:i A') : 'N/A' }}
                                </div>
                                <div>
                                    <strong>Permissions:</strong> {{ $role->permissions->count() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Role Permissions</label>
                    <p class="text-muted mb-3">
                        @if($role->name === 'Super Admin')
                            Super Admin role has all permissions by default.
                        @else
                            Select the permissions to assign to this role. Users with this role will be able to perform these actions.
                        @endif
                    </p>
                    
                    <div class="permission-groups">
                        <!-- User Management Permissions -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <div class="form-check">
                                    <input class="form-check-input permission-group-toggle" type="checkbox" id="user_management_toggle" {{ $role->name === 'Super Admin' ? 'checked disabled' : '' }}>
                                    <label class="form-check-label fw-bold" for="user_management_toggle">
                                        User Management
                                    </label>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($permissions as $permission)
                                        @if (strpos($permission->name, 'user') !== false)
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input permission-checkbox" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}" data-group="user_management" 
                                                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }} 
                                                    {{ $role->name === 'Super Admin' ? 'disabled' : '' }}>
                                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
                        <!-- Role Management Permissions -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <div class="form-check">
                                    <input class="form-check-input permission-group-toggle" type="checkbox" id="role_management_toggle" {{ $role->name === 'Super Admin' ? 'checked disabled' : '' }}>
                                    <label class="form-check-label fw-bold" for="role_management_toggle">
                                        Role Management
                                    </label>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($permissions as $permission)
                                        @if (strpos($permission->name, 'role') !== false)
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input permission-checkbox" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}" data-group="role_management" 
                                                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }} 
                                                    {{ $role->name === 'Super Admin' ? 'disabled' : '' }}>
                                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
                        <!-- Access Permissions -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <div class="form-check">
                                    <input class="form-check-input permission-group-toggle" type="checkbox" id="access_toggle" {{ $role->name === 'Super Admin' ? 'checked disabled' : '' }}>
                                    <label class="form-check-label fw-bold" for="access_toggle">
                                        Access Control
                                    </label>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($permissions as $permission)
                                        @if (strpos($permission->name, 'access') !== false || strpos($permission->name, 'dashboard') !== false)
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input permission-checkbox" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}" data-group="access" 
                                                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }} 
                                                    {{ $role->name === 'Super Admin' ? 'disabled' : '' }}>
                                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        
                        <!-- Other Permissions -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <div class="form-check">
                                    <input class="form-check-input permission-group-toggle" type="checkbox" id="other_toggle" {{ $role->name === 'Super Admin' ? 'checked disabled' : '' }}>
                                    <label class="form-check-label fw-bold" for="other_toggle">
                                        Other Permissions
                                    </label>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach ($permissions as $permission)
                                        @if (
                                            strpos($permission->name, 'user') === false && 
                                            strpos($permission->name, 'role') === false && 
                                            strpos($permission->name, 'access') === false && 
                                            strpos($permission->name, 'dashboard') === false
                                        )
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input permission-checkbox" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}" data-group="other" 
                                                    {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }} 
                                                    {{ $role->name === 'Super Admin' ? 'disabled' : '' }}>
                                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- If Super Admin, add hidden fields for all permissions -->
                @if ($role->name === 'Super Admin')
                    @foreach ($permissions as $permission)
                        <input type="hidden" name="permissions[]" value="{{ $permission->id }}">
                    @endforeach
                @endif

                <div class="d-flex justify-content-between">
                    <div>
                        @if($role->name !== 'Super Admin')
                            <button type="button" id="selectAllPermissions" class="btn btn-outline-primary me-2">
                                <i class="fas fa-check-square mr-1"></i> Select All
                            </button>
                            <button type="button" id="clearAllPermissions" class="btn btn-outline-secondary">
                                <i class="fas fa-square mr-1"></i> Clear All
                            </button>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Update Role
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // For Admin role, ensure disabled checkboxes values are still submitted
        if ('{{ $role->name }}' === 'Admin') {
            const form = document.getElementById('roleForm');
            
            // Process all checked and unchecked permissions
            form.addEventListener('submit', function(e) {
                const allCheckboxes = document.querySelectorAll('.permission-checkbox');
                let permissionIds = [];
                
                allCheckboxes.forEach(function(checkbox) {
                    // If checkbox is checked (regardless of disabled state), add its value
                    if (checkbox.checked) {
                        permissionIds.push(checkbox.value);
                    }
                });
                
                // Clear any existing hidden inputs
                const existingHiddenInputs = form.querySelectorAll('input[name="permissions[]"][type="hidden"]');
                existingHiddenInputs.forEach(input => input.remove());
                
                // Create new hidden inputs for all permission IDs
                permissionIds.forEach(function(id) {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'permissions[]';
                    hiddenInput.value = id;
                    form.appendChild(hiddenInput);
                });
                
                console.log('Submitting permissions:', permissionIds);
            });
        }
        
        // Handle group toggles
        const groupToggles = document.querySelectorAll('.permission-group-toggle');
        
        groupToggles.forEach(toggle => {
            // Initial state
            if (!toggle.disabled) {
                const group = toggle.id.replace('_toggle', '');
                const checkboxes = document.querySelectorAll(`.permission-checkbox[data-group="${group}"]:not(:disabled)`);
                const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                toggle.checked = allChecked && checkboxes.length > 0;
            }
            
            // Change event
            toggle.addEventListener('change', function() {
                if (this.disabled) return;
                
                const group = this.id.replace('_toggle', '');
                const checkboxes = document.querySelectorAll(`.permission-checkbox[data-group="${group}"]:not(:disabled)`);
                
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });
        });
        
        // Update group toggle state based on checkboxes
        const checkboxes = document.querySelectorAll('.permission-checkbox:not(:disabled)');
        
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.disabled) return;
                
                const group = this.dataset.group;
                const groupToggle = document.getElementById(`${group}_toggle`);
                const groupCheckboxes = document.querySelectorAll(`.permission-checkbox[data-group="${group}"]:not(:disabled)`);
                const allChecked = Array.from(groupCheckboxes).every(cb => cb.checked);
                
                groupToggle.checked = allChecked;
            });
        });
        
        // Select all permissions
        const selectAllBtn = document.getElementById('selectAllPermissions');
        if (selectAllBtn) {
            selectAllBtn.addEventListener('click', function() {
                const allCheckboxes = document.querySelectorAll('.permission-checkbox:not(:disabled)');
                const allGroupToggles = document.querySelectorAll('.permission-group-toggle:not(:disabled)');
                
                allCheckboxes.forEach(checkbox => {
                    checkbox.checked = true;
                });
                
                allGroupToggles.forEach(toggle => {
                    toggle.checked = true;
                });
            });
        }
        
        // Clear all permissions
        const clearAllBtn = document.getElementById('clearAllPermissions');
        if (clearAllBtn) {
            clearAllBtn.addEventListener('click', function() {
                const allCheckboxes = document.querySelectorAll('.permission-checkbox:not(:disabled)');
                const allGroupToggles = document.querySelectorAll('.permission-group-toggle:not(:disabled)');
                
                allCheckboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });
                
                allGroupToggles.forEach(toggle => {
                    toggle.checked = false;
                });
            });
        }
    });
</script>
@endpush 