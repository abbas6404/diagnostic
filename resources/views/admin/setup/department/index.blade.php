@extends('admin.setup.setup-layout')

@section('page-title', 'Department Management')
@section('page-description', 'Manage hospital departments')

@section('setup-content')
<div class="card shadow">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-building me-2"></i>Departments
        </h6>
        
        <div class="d-flex align-items-center gap-2">
            <!-- Filter Tab Button -->
            @if(request('filter') == 'archive')
                <a href="{{ route('admin.setup.department.index') }}" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-list me-1"></i>Active ({{ $activeCount }})
                </a>
            @else
                <a href="{{ route('admin.setup.department.index', ['filter' => 'archive']) }}" class="btn btn-outline-warning btn-sm">
                    <i class="fas fa-archive me-1"></i>Archive ({{ $archiveCount }})
                </a>
            @endif
            
            <a href="{{ route('admin.setup.department.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i>Add Department
            </a>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($departments as $department)
                        <tr class="{{ request('filter') == 'archive' ? 'table-warning' : '' }}">
                            <td>
                                <strong>{{ $department->name }}</strong>
                            </td>
                            <td>
                                {{ $department->description ?: 'No description' }}
                            </td>
                            <td>
                                {{ $department->created_at ? $department->created_at->format('M d, Y') : 'N/A' }}
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.setup.department.show', $department) }}" 
                                       class="btn btn-sm btn-outline-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if(request('filter') != 'archive')
                                        <a href="{{ route('admin.setup.department.edit', $department) }}" 
                                           class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.setup.department.destroy', $department) }}" 
                                              method="POST" class="d-inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this department?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.setup.department.restore', $department->id) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success" title="Restore">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.setup.department.force-delete', $department->id) }}" 
                                              method="POST" class="d-inline" 
                                              onsubmit="return confirm('Are you sure you want to permanently delete this department? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Permanently Delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No departments found</h5>
                                <p class="text-muted">Create your first department to get started.</p>
                                <a href="{{ route('admin.setup.department.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i>Add Department
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

 