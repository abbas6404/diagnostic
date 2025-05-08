@extends('admin.layouts.app')

@section('title', 'Create Role')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create New Role</h1>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Back to Roles
        </a>
    </div>

    <!-- Role Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Role Details</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.roles.store') }}">
                @csrf

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Role Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Enter role name">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="form-text text-muted">
                                Role name should be unique and descriptive (e.g., "Content Editor", "Moderator")
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Role Permissions</label>
                    <p class="text-muted mb-3">Select the permissions to assign to this role. Users with this role will be able to perform these actions.</p>
                    
                    <div class="permission-groups">
                        <!-- User Management Permissions -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <div class="form-check">
                                    <input class="form-check-input permission-group-toggle" type="checkbox" id="user_management_toggle">
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
                                                    <input class="form-check-input permission-checkbox" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}" data-group="user_management">
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
                                    <input class="form-check-input permission-group-toggle" type="checkbox" id="role_management_toggle">
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
                                                    <input class="form-check-input permission-checkbox" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}" data-group="role_management">
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
                                    <input class="form-check-input permission-group-toggle" type="checkbox" id="access_toggle">
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
                                                    <input class="form-check-input permission-checkbox" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}" data-group="access">
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
                                    <input class="form-check-input permission-group-toggle" type="checkbox" id="other_toggle">
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
                                                    <input class="form-check-input permission-checkbox" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}" data-group="other">
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

                <div class="d-flex justify-content-between">
                    <div>
                        <button type="button" id="selectAllPermissions" class="btn btn-outline-primary me-2">
                            <i class="fas fa-check-square mr-1"></i> Select All
                        </button>
                        <button type="button" id="clearAllPermissions" class="btn btn-outline-secondary">
                            <i class="fas fa-square mr-1"></i> Clear All
                        </button>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-1"></i> Create Role
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
        // Handle group toggles
        const groupToggles = document.querySelectorAll('.permission-group-toggle');
        
        groupToggles.forEach(toggle => {
            toggle.addEventListener('change', function() {
                const group = this.id.replace('_toggle', '');
                const checkboxes = document.querySelectorAll(`.permission-checkbox[data-group="${group}"]`);
                
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });
        });
        
        // Update group toggle state based on checkboxes
        const checkboxes = document.querySelectorAll('.permission-checkbox');
        
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const group = this.dataset.group;
                const groupToggle = document.getElementById(`${group}_toggle`);
                const groupCheckboxes = document.querySelectorAll(`.permission-checkbox[data-group="${group}"]`);
                const allChecked = Array.from(groupCheckboxes).every(cb => cb.checked);
                
                groupToggle.checked = allChecked;
            });
        });
        
        // Select all permissions
        document.getElementById('selectAllPermissions').addEventListener('click', function() {
            const allCheckboxes = document.querySelectorAll('.permission-checkbox');
            const allGroupToggles = document.querySelectorAll('.permission-group-toggle');
            
            allCheckboxes.forEach(checkbox => {
                checkbox.checked = true;
            });
            
            allGroupToggles.forEach(toggle => {
                toggle.checked = true;
            });
        });
        
        // Clear all permissions
        document.getElementById('clearAllPermissions').addEventListener('click', function() {
            const allCheckboxes = document.querySelectorAll('.permission-checkbox');
            const allGroupToggles = document.querySelectorAll('.permission-group-toggle');
            
            allCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            
            allGroupToggles.forEach(toggle => {
                toggle.checked = false;
            });
        });
    });
</script>
@endpush 