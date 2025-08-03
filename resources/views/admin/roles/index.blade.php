@extends('admin.layouts.app')

@section('title', 'Role Management')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Role Management</h1>
        @permission('create roles')
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> Create New Role
        </a>
        @endpermission
    </div>

    <!-- Role List Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">System Roles</h6>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="20%">Role Name</th>
                            <th width="10%">Users</th>
                            <th>Permissions</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td>
                                    <strong>{{ $role->name }}</strong>
                                    @if($role->name === 'Super Admin')
                                        <span class="badge bg-danger ms-2">System</span>
                                    @elseif($role->name === 'Admin')
                                        <span class="badge bg-primary ms-2">System</span>
                                    @endif
                                </td>
                                <td class="text-center">{{ $role->users->count() }}</td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        @php
                                            $permissionColors = [
                                                'view' => '#17a2b8',
                                                'create' => '#28a745',
                                                'edit' => '#fd7e14',
                                                'delete' => '#dc3545',
                                                'access' => '#6f42c1',
                                                'manage' => '#20c997',
                                            ];
                                            
                                            $permissionDescriptions = [
                                                'view users' => 'Can view user listings and profiles',
                                                'create users' => 'Can create new user accounts',
                                                'edit users' => 'Can modify existing user accounts',
                                                'delete users' => 'Can remove user accounts from the system',
                                                'view roles' => 'Can view role listings',
                                                'edit roles' => 'Can modify role permissions',
                                                'create roles' => 'Can create new roles',
                                                'delete roles' => 'Can remove roles from the system',
                                                'access admin dashboard' => 'Can access the admin control panel',
                                                'view reports' => 'Can view system reports and analytics',
                                                'manage settings' => 'Can modify system settings',
                                            ];
                                            
                                            $displayed = 0;
                                            $maxDisplay = 8;
                                        @endphp
                                        
                                        @foreach ($role->permissions as $permission)
                                            @php
                                                $displayed++;
                                                if ($displayed > $maxDisplay) continue;
                                                
                                                $color = '#6c757d'; // default gray
                                                foreach ($permissionColors as $key => $value) {
                                                    if (strpos($permission->name, $key) !== false) {
                                                        $color = $value;
                                                        break;
                                                    }
                                                }
                                                
                                                $description = $permissionDescriptions[$permission->name] ?? 'Allows ' . $permission->name;
                                            @endphp
                                            <span class="badge rounded-pill py-1 px-2" 
                                                  style="background-color: {{ $color }};"
                                                  data-bs-toggle="tooltip" 
                                                  title="{{ $description }}">
                                                {{ $permission->name }}
                                            </span>
                                        @endforeach
                                        
                                        @if($role->permissions->count() > $maxDisplay)
                                            <span class="badge bg-secondary rounded-pill">+{{ $role->permissions->count() - $maxDisplay }} more</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        @permission('edit roles')
                                        <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Edit Role">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endpermission
                                        
                                        @permission('delete roles')
                                        @if ($role->name !== 'Super Admin' && $role->name !== 'Admin')
                                            <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Delete Role" onclick="return confirm('Are you sure you want to delete this role? This action cannot be undone.')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                        @endpermission
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                <div class="alert alert-info d-flex align-items-center">
                    <i class="fas fa-info-circle me-2"></i> 
                    <div>
                        <strong>Note:</strong> The Super Admin and Admin roles are system roles and cannot be deleted.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/admin-layout.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endpush 