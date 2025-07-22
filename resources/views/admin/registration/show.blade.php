@extends('admin.layouts.app')

@section('title', 'Patient Details')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary">
                    <i class="fas fa-user me-2"></i> Patient Details
                </h5>
                <div>
                    <a href="{{ route('admin.patients.edit', $patient->id) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <a href="{{ route('admin.patients.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="d-flex align-items-center mb-3">
                                <div class="patient-avatar bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 80px; height: 80px; border-radius: 50%; font-size: 32px; font-weight: bold;">
                                    {{ strtoupper(substr($patient->name_en, 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="mb-0">{{ $patient->name_en }}</h4>
                                    <p class="text-muted mb-0">{{ $patient->name_bn }}</p>
                                    <div class="d-flex align-items-center mt-1">
                                        <span class="badge bg-primary me-2">{{ $patient->patient_id }}</span>
                                        <span class="badge bg-secondary">{{ $patient->patient_type ?? 'General' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i> Basic Information</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th style="width: 40%">Registration Date</th>
                                            <td>{{ date('d M Y', strtotime($patient->reg_date)) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Gender</th>
                                            <td>{{ $patient->gender }}</td>
                                        </tr>
                                        <tr>
                                            <th>Date of Birth</th>
                                            <td>{{ $patient->dob ? date('d M Y', strtotime($patient->dob)) : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Age</th>
                                            <td>
                                                @php
                                                    $age = '';
                                                    if ($patient->dob) {
                                                        $dob = new DateTime($patient->dob);
                                                        $now = new DateTime();
                                                        $diff = $now->diff($dob);
                                                        $age = $diff->y . ' years, ' . $diff->m . ' months, ' . $diff->d . ' days';
                                                    }
                                                @endphp
                                                {{ $age ?: 'N/A' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Blood Group</th>
                                            <td>{{ $patient->blood_group ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Religion</th>
                                            <td>{{ $patient->religion ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Nationality</th>
                                            <td>{{ $patient->nationality ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Occupation</th>
                                            <td>{{ $patient->occupation ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-address-book me-2"></i> Contact Information</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th style="width: 40%">Father/Husband</th>
                                            <td>{{ $patient->father_husband_name_en ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone</th>
                                            <td>{{ $patient->phone ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $patient->email ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Address</th>
                                            <td>{{ $patient->address ?? 'N/A' }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0"><i class="fas fa-file-medical me-2"></i> Registration Details</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th style="width: 40%">Registration Fee</th>
                                            <td>{{ $patient->reg_fee ? number_format($patient->reg_fee, 2) : '0.00' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Created At</th>
                                            <td>{{ date('d M Y H:i', strtotime($patient->created_at)) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Updated At</th>
                                            <td>{{ date('d M Y H:i', strtotime($patient->updated_at)) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fas fa-history me-2"></i> Recent Medical History</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                {{-- <div class="list-group-item py-3">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1">Lab Test</h6>
                                        <small>3 days ago</small>
                                    </div>
                                    <p class="mb-1 text-muted">Blood Test - Complete Blood Count (CBC)</p>
                                </div> --}}
                           
                                
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fas fa-notes-medical me-2"></i> Quick Actions</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="#" class="btn btn-outline-info">
                                    <i class="fas fa-print me-1"></i> Print Patient Card
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 