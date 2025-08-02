@extends('admin.layouts.app')

@section('title', 'Lab Reporting')

@section('styles')
<style>
    .patient-info-card {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    
    .test-results-card {
        background: white;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        min-height: 500px;
    }
    
    .search-input {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 10px 15px;
        font-size: 14px;
        background: #f8f9fa;
    }
    
    .search-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        background: white;
    }
    
    .department-select {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 10px 15px;
        font-size: 14px;
        background: #f8f9fa;
    }
    
    .department-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        background: white;
    }
    
    .patient-input {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 5px 10px;
        font-size: 14px;
        background: #f8f9fa;
    }
    
    .patient-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        background: white;
    }
    
    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 15px;
    }
    
    .btn-action {
        border-radius: 25px;
        padding: 10px 20px;
        font-weight: 500;
        border: none;
        transition: all 0.3s ease;
    }
    
    .btn-save { background: #28a745; color: white; }
    .btn-save:hover { background: #218838; transform: translateY(-2px); }
    
    .btn-save-print { background: #007bff; color: white; }
    .btn-save-print:hover { background: #0056b3; transform: translateY(-2px); }
    
    .btn-view { background: #17a2b8; color: white; }
    .btn-view:hover { background: #138496; transform: translateY(-2px); }
    
    .btn-exit { background: #dc3545; color: white; }
    .btn-exit:hover { background: #c82333; transform: translateY(-2px); }
    
    .test-table {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .test-table th {
        background: #f8f9fa;
        border: none;
        padding: 15px;
        font-weight: 600;
        color: #495057;
    }
    
    .test-table td {
        padding: 15px;
        border-bottom: 1px solid #dee2e6;
        vertical-align: middle;
    }
    
    .test-table tr:hover {
        background-color: #f8f9fa;
    }
    
    .result-value {
        font-weight: bold;
        color: #28a745;
    }
    
    .unit-badge {
        background: #e9ecef;
        color: #495057;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.8em;
    }
    
    .normal-value {
        color: #6c757d;
        font-size: 0.9em;
    }

            .lab-reporting-table{
           border-radius: 0px !important;
        }
        .lab-reporting-table th, .lab-reporting-table td {
        border: 1px solid #333 !important;
        padding: 0px !important;
        vertical-align: middle;
    }
    .lab-reporting-table td .form-control{
        border: none !important;
        border-radius: 0px !important;
    }
    .lab-reporting-table td .form-control:focus{
        border: none !important;
        box-shadow: none !important;
        border-radius: 0px !important;
    }
    .lab-reporting-table th{
        background-color:rgb(151, 151, 151) !important;
        padding: 5px 10px !important;
    }
    .lab-reporting-table td .form-control{
       padding-left: 5px !important;
    }
    .lab-reporting-table td .form-control:focus{
        font-weight: normal !important;
    }
    .lab-reporting-table td input:hover{
        background: linear-gradient(90deg, #ffe0e0, #d3b2b2) !important;
        transition: all 0.3s ease !important;
    }
    
    /* Custom backdrop blur for notifications */
    .swal2-backdrop-show {
        backdrop-filter: blur(8px) !important;
        -webkit-backdrop-filter: blur(8px) !important;
        background-color: rgba(0, 0, 0, 0.3) !important;
        width: 100% !important;
        height: 100% !important;
    }
    
    /* Ensure notification displays fully */
    .swal2-popup {
        margin: 20px !important;
        max-width: 400px !important;
        width: auto !important;
    }
    
    .swal2-title {
        font-size: 18px !important;
        margin: 10px 0 !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    @livewire('investigation-reporting-all-reporting', ['userDepartmentId' => $userDepartmentId, 'departments' => $departments])
</div>
@endsection

@section('scripts')
<script>
// Success notification handler
if (!window.successNotificationInitialized) {
    window.successNotificationInitialized = true;
    
    $(document).ready(function() {
        if (typeof Livewire !== 'undefined') {
            setupLivewireEvents();
        } else {
            document.addEventListener('livewire:init', setupLivewireEvents);
        }
    });
}

function setupLivewireEvents() {
    Livewire.on('show-success', (message) => {
        if (typeof Swal !== 'undefined') {
            const Toast = Swal.mixin({
                toast: false,
                position: 'center',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                backdrop: true,
                allowOutsideClick: false,
                width: '400px',
                padding: '20px',
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
            
            Toast.fire({
                icon: 'success',
                title: message || 'Report saved successfully!'
            });
        } else {
            alert(message || 'Report saved successfully!');
        }
    });
}
</script>
@endsection