@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Dashboard</h5>
                </div>
                <div class="card-body">
                    <h2 class="mb-4">Welcome, {{ Auth::user()->name }}!</h2>
                    
                    <div class="alert alert-info">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas fa-info-circle fa-2x"></i>
                            </div>
                            <div>
                                <h5 class="alert-heading">Your Account</h5>
                                <p class="mb-0">You are logged in as <strong>{{ Auth::user()->email }}</strong></p>
                                <p class="mb-0">
                                    Your roles: 
                                    @forelse(Auth::user()->roles as $role)
                                        <span class="badge bg-primary">{{ $role->name }}</span>
                                    @empty
                                        <span class="badge bg-secondary">No roles assigned</span>
                                    @endforelse
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="display-4 text-primary mb-3">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5 class="card-title">Users</h5>
                    <p class="card-text display-6">{{ $stats['users'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="display-4 text-success mb-3">
                        <i class="fas fa-user-tag"></i>
                    </div>
                    <h5 class="card-title">Roles</h5>
                    <p class="card-text display-6">{{ $stats['roles'] }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="display-4 text-warning mb-3">
                        <i class="fas fa-key"></i>
                    </div>
                    <h5 class="card-title">Permissions</h5>
                    <p class="card-text display-6">{{ $stats['permissions'] }}</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Your Permissions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse(Auth::user()->getAllPermissions() as $permission)
                            <div class="col-md-3 mb-2">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    <span>{{ $permission->name }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-warning">
                                    You don't have any specific permissions assigned.
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @role('Admin|Super Admin')
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Admin Access</h5>
                    <p class="card-text">You have administrative privileges. Access the admin panel to manage users, roles, and permissions.</p>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-light">Go to Admin Dashboard</a>
                </div>
            </div>
        </div>
    </div>
    @endrole
</div>
@endsection 