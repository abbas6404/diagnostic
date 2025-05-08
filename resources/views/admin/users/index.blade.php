@extends('admin.layouts.app')

@section('title', 'User Management')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">User Management</h1>
        @permission('create users')
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus me-1"></i> Create New User
        </a>
        @endpermission
    </div>

    <!-- Users Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold">System Users</h6>
            <span class="badge bg-primary">{{ $users->count() }} users</span>
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
                            <th width="5%">#</th>
                            <th width="20%">Name</th>
                            <th width="25%">Email</th>
                            <th>Roles</th>
                            <th width="15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar bg-primary text-white rounded-circle me-2 d-flex align-items-center justify-content-center">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span>{{ $user->name }}</span>
                                        @if($user->id === auth()->id())
                                            <span class="badge bg-info ms-2">You</span>
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach ($user->roles as $role)
                                            <span class="badge rounded-pill 
                                                {{ $role->name === 'Super Admin' ? 'bg-danger' : 
                                                   ($role->name === 'Admin' ? 'bg-primary' : 
                                                   ($role->name === 'Moderator' ? 'bg-warning' : 'bg-secondary')) }}">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @permission('edit users')
                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Edit User">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @endpermission
                                        
                                        @permission('delete users')
                                        @unless($user->id === auth()->id() || ($user->hasRole('Super Admin') && $user->email === 'superadmin@example.com'))
                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" data-bs-toggle="tooltip" title="Delete User" onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endunless
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
@endsection

@push('styles')
<style>
    .avatar {
        width: 30px;
        height: 30px;
        font-size: 14px;
        font-weight: 600;
    }
    
    .gap-1 {
        gap: 0.25rem !important;
    }
    
    .badge {
        font-size: 0.75rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    
    .badge:hover {
        opacity: 0.9;
        transform: translateY(-1px);
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