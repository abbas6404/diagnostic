@extends('admin.setup.setup-layout')

@section('page-title', 'OPD Service Details')
@section('page-description', 'View OPD service information')

@section('setup-content')
<div class="card shadow">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-stethoscope me-2"></i>OPD Service Details
        </h6>
        <div class="btn-group" role="group">
            @if(!$opdService->deleted_at)
                <a href="{{ route('admin.setup.opd-service.edit', $opdService) }}" 
                   class="btn btn-warning btn-sm">
                    <i class="fas fa-edit me-1"></i>Edit
                </a>
            @endif
            <a href="{{ route('admin.setup.opd-service.index') }}" 
               class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Basic Information -->
        <div class="row mb-4">
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td class="fw-bold text-muted" style="width: 40%;">Service Code:</td>
                            <td><strong class="text-primary">{{ $opdService->code }}</strong></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Service Name:</td>
                            <td><strong>{{ $opdService->name }}</strong></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Department:</td>
                            <td>
                                <span class="badge bg-info">{{ $opdService->department->name ?? 'N/A' }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Charge:</td>
                            <td><strong class="text-success">{{ $opdService->formatted_charge }}</strong></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Status:</td>
                            <td>{!! $opdService->status_badge !!}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td class="fw-bold text-muted" style="width: 40%;">Created:</td>
                            <td>{{ $opdService->created_at ? $opdService->created_at->format('M d, Y \a\t g:i A') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Created By:</td>
                            <td>
                                @if($opdService->createdBy)
                                    <span class="badge bg-secondary">{{ $opdService->createdBy->name ?? 'Unknown' }}</span>
                                @else
                                    <span class="text-muted">Unknown</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Last Updated:</td>
                            <td>{{ $opdService->updated_at ? $opdService->updated_at->format('M d, Y \a\t g:i A') : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">Updated By:</td>
                            <td>
                                @if($opdService->updatedBy)
                                    <span class="badge bg-secondary">{{ $opdService->updatedBy->name ?? 'Unknown' }}</span>
                                @else
                                    <span class="text-muted">Unknown</span>
                                @endif
                            </td>
                        </tr>
                        @if($opdService->deleted_at)
                            <tr>
                                <td class="fw-bold text-muted">Deleted:</td>
                                <td class="text-danger">{{ $opdService->deleted_at->format('M d, Y \a\t g:i A') }}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Description Section -->
        @if($opdService->description)
            <div class="card border-left-primary mb-4">
                <div class="card-body">
                    <h6 class="card-title text-primary">
                        <i class="fas fa-info-circle me-2"></i>Description
                    </h6>
                    <p class="card-text">{{ $opdService->description }}</p>
                </div>
            </div>
        @endif

        <!-- Action Buttons -->
        @if($opdService->deleted_at)
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Note:</strong> This OPD service has been deleted. You can restore it or permanently delete it.
            </div>
            
            <div class="d-flex gap-2">
                <form action="{{ route('admin.setup.opd-service.restore', $opdService->id) }}" 
                      method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-undo me-1"></i>Restore OPD Service
                    </button>
                </form>
                
                <form action="{{ route('admin.setup.opd-service.force-delete', $opdService->id) }}" 
                      method="POST" class="d-inline" 
                      onsubmit="return confirm('Are you sure you want to permanently delete this OPD service? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt me-1"></i>Permanently Delete
                    </button>
                </form>
            </div>
        @else
            <div class="d-flex gap-2">
                <form action="{{ route('admin.setup.opd-service.destroy', $opdService) }}" 
                      method="POST" class="d-inline" 
                      onsubmit="return confirm('Are you sure you want to delete this OPD service?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Delete OPD Service
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection 