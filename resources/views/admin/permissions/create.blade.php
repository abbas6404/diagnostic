@extends('admin.layouts.app')

@section('title', 'Create Permission')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create New Permission</h1>
        <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Back to Permissions
        </a>
    </div>

    <!-- Permission Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Permission Details</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.permissions.store') }}">
                @csrf

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Permission Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Enter permission name">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="form-text text-muted">
                                Permission name should follow the pattern: "action resource" (e.g., "view users", "manage settings")
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info">
                    <div class="d-flex align-items-start">
                        <i class="fas fa-info-circle mt-1 me-2"></i>
                        <div>
                            <strong>Common Permission Naming Patterns:</strong>
                            <ul class="mb-0 mt-1">
                                <li><strong>view</strong> - For read-only access (e.g., view users, view reports)</li>
                                <li><strong>create</strong> - For creating new resources (e.g., create users, create roles)</li>
                                <li><strong>edit</strong> - For updating existing resources (e.g., edit users, edit settings)</li>
                                <li><strong>delete</strong> - For removing resources (e.g., delete users, delete roles)</li>
                                <li><strong>manage</strong> - For complete control over resources (e.g., manage settings)</li>
                                <li><strong>access</strong> - For accessing specific areas (e.g., access admin dashboard)</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-1"></i> Create Permission
                </button>
            </form>
        </div>
    </div>
</div>
@endsection 