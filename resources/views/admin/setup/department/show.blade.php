@extends('admin.setup.setup-layout')

@section('page-title', 'Department Details')
@section('page-description', 'View department information')

@section('setup-content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-building me-2"></i>Department Details
                </h6>
                <div class="btn-group" role="group">
                    <a href="{{ route('admin.setup.department.edit', $department) }}" 
                       class="btn btn-warning btn-sm">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    <a href="{{ route('admin.setup.department.index') }}" 
                       class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td class="fw-bold text-muted">Department Name:</td>
                                    <td>{{ $department->name }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Status:</td>
                                    <td>{!! $department->status_badge !!}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Created:</td>
                                    <td>{{ $department->created_at ? $department->created_at->format('M d, Y \a\t g:i A') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-muted">Last Updated:</td>
                                    <td>{{ $department->updated_at ? $department->updated_at->format('M d, Y \a\t g:i A') : 'N/A' }}</td>
                                </tr>
                                @if($department->deleted_at)
                                    <tr>
                                        <td class="fw-bold text-muted">Deleted:</td>
                                        <td>{{ $department->deleted_at ? $department->deleted_at->format('M d, Y \a\t g:i A') : 'N/A' }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-left-primary">
                            <div class="card-body">
                                <h6 class="card-title text-primary">
                                    <i class="fas fa-info-circle me-2"></i>Description
                                </h6>
                                <p class="card-text">
                                    {{ $department->description ?: 'No description provided.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($department->deleted_at)
                    <div class="alert alert-warning mt-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Note:</strong> This department has been deleted. You can restore it or permanently delete it.
                    </div>
                    
                    <div class="d-flex gap-2 mt-3">
                        <form action="{{ route('admin.setup.department.restore', $department->id) }}" 
                              method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-undo me-1"></i>Restore Department
                            </button>
                        </form>
                        
                        <form action="{{ route('admin.setup.department.force-delete', $department->id) }}" 
                              method="POST" class="d-inline" 
                              onsubmit="return confirm('Are you sure you want to permanently delete this department? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt me-1"></i>Permanently Delete
                            </button>
                        </form>
                    </div>
                @else
                    <div class="mt-3">
                        <form action="{{ route('admin.setup.department.destroy', $department) }}" 
                              method="POST" class="d-inline" 
                              onsubmit="return confirm('Are you sure you want to delete this department?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-1"></i>Delete Department
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 