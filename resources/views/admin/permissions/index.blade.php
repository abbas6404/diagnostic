@extends('admin.layouts.app')

@section('title', 'Permission Management')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Permission Management</h1>
        @permission('create roles')
        <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> Create New Permission
        </a>
        @endpermission
    </div>

    <!-- Permissions Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">System Permissions</h6>
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

            <div class="accordion" id="permissionAccordion">
                @php
                    $permissionColors = [
                        'view' => '#17a2b8',
                        'create' => '#28a745',
                        'edit' => '#fd7e14',
                        'delete' => '#dc3545',
                        'access' => '#6f42c1',
                        'manage' => '#20c997',
                    ];
                    
                    $index = 0;
                @endphp
                
                @foreach($permissionCategories as $category => $categoryPermissions)
                    <div class="accordion-item mb-3 border shadow-sm">
                        <h2 class="accordion-header" id="heading{{ $index }}">
                            <button class="accordion-button {{ $index === 0 ? '' : 'collapsed' }}" type="button" 
                                    data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" 
                                    aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                                <strong class="text-capitalize">{{ $category }} Permissions</strong>
                                <span class="badge bg-secondary rounded-pill ms-2">{{ count($categoryPermissions) }}</span>
                            </button>
                        </h2>
                        <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" 
                             aria-labelledby="heading{{ $index }}" data-bs-parent="#permissionAccordion">
                            <div class="accordion-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="60%">Permission Name</th>
                                                <th width="20%">Used In Roles</th>
                                                <th width="20%">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($categoryPermissions as $permission)
                                                @php
                                                    $color = '#6c757d'; // default gray
                                                    
                                                    foreach ($permissionColors as $key => $value) {
                                                        if (strpos($permission->name, $key) !== false) {
                                                            $color = $value;
                                                            break;
                                                        }
                                                    }
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <span class="badge rounded-pill py-2 px-3" 
                                                              style="background-color: {{ $color }};">
                                                            {{ $permission->name }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $permission->roles->count() }}</td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            @permission('edit roles')
                                                            <a href="{{ route('admin.permissions.edit', $permission) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Edit Permission">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            @endpermission
                                                            
                                                            @permission('delete roles')
                                                            @if ($permission->roles->count() === 0)
                                                                <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Delete Permission" onclick="return confirm('Are you sure you want to delete this permission? This action cannot be undone.')">
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
                            </div>
                        </div>
                    </div>
                    @php $index++; @endphp
                @endforeach
            </div>
            
            <div class="mt-4">
                <div class="alert alert-info d-flex align-items-center">
                    <i class="fas fa-info-circle me-2"></i> 
                    <div>
                        <strong>Note:</strong> Permissions that are currently assigned to roles cannot be deleted.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .badge {
        font-size: 0.75rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    
    .badge.rounded-pill {
        padding: 0.3rem 0.6rem;
    }
    
    .badge:hover {
        opacity: 0.9;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .btn-group .btn {
        border-radius: 4px;
        margin-right: 5px;
    }
    
    .table th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .alert-info {
        border-left: 4px solid #17a2b8;
        background-color: rgba(23, 162, 184, 0.1);
        color: #17a2b8;
    }
    
    .alert-info .fas {
        color: #17a2b8;
    }
    
    .card-header h6 {
        color: #4e73df;
    }
    
    .accordion-button:not(.collapsed) {
        background-color: rgba(78, 115, 223, 0.1);
        color: #4e73df;
    }
    
    .accordion-button:focus {
        box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
    }
    
    .accordion-item {
        border-radius: 0.35rem;
        overflow: hidden;
    }
</style>
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