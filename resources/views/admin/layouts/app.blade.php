<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin @yield('title', 'Dashboard')</title>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom styles -->
    <link href="{{ asset('css/admin-layout.css') }}" rel="stylesheet">
    

        
        @livewireStyles
        
        @yield('styles')
</head>

<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        @include('admin.layouts.sidebar')

        <!-- Sidebar Toggle Button -->
        <button class="sidebar-toggle-btn" id="sidebar-toggle-btn">
            <i class="fas fa-angle-left"></i>
        </button>

        <!-- Content Container -->
        <div class="content-container">
            <!-- Sidebar Overlay for mobile -->
            <div class="sidebar-overlay"></div>

            <!-- Top Navbar -->
            @include('admin.layouts.header')

            <!-- Main Content -->
            <div class="main-content">
                @yield('content')
            </div>

            <!-- Footer -->
            @include('admin.layouts.footer')
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Custom Scripts -->
    @livewireScripts
    
    <!-- Custom JavaScript -->
    <script src="{{ asset('js/admin-layout.js') }}?v=3.0"></script>
    
    <!-- Global Notification System -->
    <script>
        // Global alert function
        function showAlert(type, message) {
            if (type === 'success') {
                Swal.fire({
                    icon: type,
                    html: message,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true,
                    allowOutsideClick: true,
                    allowEscapeKey: true,
                    customClass: {
                        icon: 'swal2-icon-large',
                        popup: 'swal2-popup-with-icon'
                    },
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });
            } else {
                Swal.fire({
                    icon: type,
                    html: message,
                    position: 'center',
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#4361ee',
                    allowOutsideClick: true,
                    allowEscapeKey: true,
                    customClass: {
                        icon: 'swal2-icon-large',
                        popup: 'swal2-popup-with-icon'
                    }
                });
            }
        }

        // Global Livewire Alert Handler
        document.addEventListener('livewire:init', () => {
            console.log('Livewire initialized, setting up alert handler...');
            
            Livewire.on('show-alert', (data) => {
                console.log('Livewire alert received:', data);
                
                // Fix: Extract data properly from array
                let alertData;
                if (Array.isArray(data)) {
                    alertData = data[0]; // Get first element if it's an array
                } else {
                    alertData = data; // Use as is if it's an object
                }
                
                const { type, message } = alertData;
                console.log('Extracted data:', { type, message });
                
                if (type === 'success') {
                    console.log('Showing success alert with message:', message);
                    Swal.fire({
                        icon: type,
                        html: message,
                        position: 'center',
                        showConfirmButton: false,
                        timer: 5000,
                        timerProgressBar: true,
                        allowOutsideClick: true,
                        allowEscapeKey: true,
                        customClass: {
                            icon: 'swal2-icon-large',
                            popup: 'swal2-popup-with-icon'
                        },
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                } else {
                    console.log('Showing alert with message:', message);
                    Swal.fire({
                        icon: type,
                        html: message,
                        position: 'center',
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#4361ee',
                        allowOutsideClick: true,
                        allowEscapeKey: true,
                        customClass: {
                            icon: 'swal2-icon-large',
                            popup: 'swal2-popup-with-icon'
                        }
                    });
                }
            });
        });

        // Session-based notifications
        document.addEventListener('DOMContentLoaded', function() {
            // Check for session messages
            @if(session('success'))
                showAlert('success', '{{ session('success') }}');
            @endif

            @if(session('error'))
                showAlert('error', '{{ session('error') }}');
            @endif

            @if(session('warning'))
                showAlert('warning', '{{ session('warning') }}');
            @endif

            @if(session('info'))
                showAlert('info', '{{ session('info') }}');
            @endif
        });

        // Global helper functions
        window.globalSuccess = function(message) {
            showAlert('success', message);
        };

        window.globalError = function(message) {
            showAlert('error', message);
        };

        window.globalWarning = function(message) {
            showAlert('warning', message);
        };

        window.globalInfo = function(message) {
            showAlert('info', message);
        };
    </script>
    
    @yield('scripts')
</body>

</html>
