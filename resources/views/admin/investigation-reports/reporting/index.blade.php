@extends('admin.layouts.app')

@section('title', 'Lab Reporting')

@section('styles')
<link href="{{ asset('css/admin-layout.css') }}" rel="stylesheet">
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