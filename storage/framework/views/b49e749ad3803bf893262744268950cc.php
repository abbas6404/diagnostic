<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-bolt me-2"></i>Livewire Notification Testing
            </h1>
            <p class="mb-0 text-muted">Test Livewire-based notifications in the global alert system</p>
        </div>
    </div>

    <!-- Info Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Livewire Alert System
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                SweetAlert2 + Livewire Integration
                            </div>
                            <p class="text-muted mb-0">
                                This page demonstrates Livewire-based notifications using the dispatch system. 
                                Click any button below to test different notification types without page reloads.
                            </p>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bolt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Livewire Notification Tests -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt me-2"></i>Livewire Notification Tests
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-3">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Livewire Notifications:</strong> These tests use Livewire's dispatch system to show notifications without page reloads. 
                        Perfect for forms and dynamic interactions.
                    </div>
                    
                    <!-- Debug Info -->
                    <div class="alert alert-warning mb-3">
                        <i class="fas fa-bug me-2"></i>
                        <strong>Debug Info:</strong> Check browser console for debugging information. 
                        If notifications don't work, check if Livewire is properly initialized.
                    </div>
                    
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <button type="button" class="btn btn-success btn-block" wire:click="testSuccess">
                                <i class="fas fa-check-circle me-2"></i>Success Notification
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button type="button" class="btn btn-danger btn-block" wire:click="testError">
                                <i class="fas fa-exclamation-circle me-2"></i>Error Notification
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button type="button" class="btn btn-warning btn-block" wire:click="testWarning">
                                <i class="fas fa-exclamation-triangle me-2"></i>Warning Notification
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button type="button" class="btn btn-info btn-block" wire:click="testInfo">
                                <i class="fas fa-info-circle me-2"></i>Info Notification
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <button type="button" class="btn btn-outline-primary btn-block" wire:click="testMultiple">
                                <i class="fas fa-layer-group me-2"></i>Multiple Notifications
                            </button>
                            <small class="text-muted d-block mt-1">Shows multiple notifications in sequence</small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <button type="button" class="btn btn-outline-secondary btn-block" wire:click="testForm">
                                <i class="fas fa-edit me-2"></i>Form Simulation
                            </button>
                            <small class="text-muted d-block mt-1">Simulates form validation errors</small>
                        </div>
                        <div class="col-md-4 mb-3">
                            <button type="button" class="btn btn-outline-danger btn-block" onclick="testDirectNotification()">
                                <i class="fas fa-bolt me-2"></i>Direct Test
                            </button>
                            <small class="text-muted d-block mt-1">Test direct JavaScript notification</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Code Examples -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-code me-2"></i>Livewire Code Examples
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary">Basic Livewire Dispatch:</h6>
                            <pre class="bg-light p-3 rounded"><code>// In Livewire components
$this->dispatch('show-alert', [
    'type' => 'success',
    'message' => 'Patient registered successfully!'
]);

$this->dispatch('show-alert', [
    'type' => 'error',
    'message' => 'Validation failed!'
]);</code></pre>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary">Livewire Helper Functions:</h6>
                            <pre class="bg-light p-3 rounded"><code>// Livewire helper functions
livewire_success('Operation completed!');
livewire_error('Something went wrong!');
livewire_warning('Please check input!');
livewire_info('Information message.');</code></pre>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h6 class="text-primary">With Dynamic Data:</h6>
                            <pre class="bg-light p-3 rounded"><code>// With variables
$patientName = 'John Doe';
$invoiceNumber = 'INV-2025-001';

$this->dispatch('show-alert', [
    'type' => 'success',
    'message' => "Patient {$patientName} registered successfully! 
Invoice: {$invoiceNumber}"
]);</code></pre>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary">Form Validation Errors:</h6>
                            <pre class="bg-light p-3 rounded"><code>// Multiple validation errors
$errors = ['Name required', 'Email invalid'];
$this->dispatch('show-alert', [
    'type' => 'error',
    'message' => 'Validation failed: ' . implode(', ', $errors)
]);</code></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features List -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-star me-2"></i>Livewire System Features
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-success">✅ What's Working:</h6>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-check text-success me-2"></i>Livewire-based notifications (no page reload)</li>
                                <li><i class="fas fa-check text-success me-2"></i>Multiple alert types (success, error, warning, info)</li>
                                <li><i class="fas fa-check text-success me-2"></i>Real-time updates</li>
                                <li><i class="fas fa-check text-success me-2"></i>Beautiful SweetAlert2 toasts</li>
                                <li><i class="fas fa-check text-success me-2"></i>Auto-dismiss with progress bar</li>
                                <li><i class="fas fa-check text-success me-2"></i>Responsive design</li>
                                <li><i class="fas fa-check text-success me-2"></i>Convenience functions</li>
                                <li><i class="fas fa-check text-success me-2"></i>Form validation integration</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-info">ℹ️ Technical Details:</h6>
                            <ul class="list-unstyled">
                                <li><i class="fas fa-info text-info me-2"></i>Position: Top-right corner</li>
                                <li><i class="fas fa-info text-info me-2"></i>Duration: 5 seconds</li>
                                <li><i class="fas fa-info text-info me-2"></i>Pause on hover</li>
                                <li><i class="fas fa-info text-info me-2"></i>Progress bar included</li>
                                <li><i class="fas fa-info text-info me-2"></i>No page reload required</li>
                                <li><i class="fas fa-info text-info me-2"></i>Works with Livewire components</li>
                                <li><i class="fas fa-info text-info me-2"></i>Real-time form validation</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Usage Instructions -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-book me-2"></i>How to Use Livewire Notifications
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6 class="alert-heading"><i class="fas fa-lightbulb me-2"></i>Quick Start:</h6>
                        <ol class="mb-0">
                            <li>In any Livewire component, call <code>$this->dispatch('show-alert', ['type' => 'success', 'message' => 'Your message'])</code></li>
                            <li>Use convenience functions like <code>livewire_success('message')</code></li>
                            <li>The notification will appear immediately without page reload</li>
                            <li>Perfect for form submissions and dynamic interactions</li>
                        </ol>
                    </div>
                    
                    <div class="alert alert-warning">
                        <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Important Notes:</h6>
                        <ul class="mb-0">
                            <li>Notifications appear instantly without page reload</li>
                            <li>Multiple notifications will stack and show in sequence</li>
                            <li>Works only with Livewire components</li>
                            <li>Requires Livewire to be properly initialized</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Handle multiple notifications with delays
    document.addEventListener('livewire:init', () => {
        Livewire.on('test-multiple-notifications', (data) => {
            const patients = data.patients;
            let currentIndex = 0;
            
            function showNextNotification() {
                if (currentIndex < patients.length) {
                    const patient = patients[currentIndex];
                    
                    if (patient.type === 'success') {
                        Swal.fire({
                            icon: patient.type,
                            html: `${patient.message}

Patient ID: ${patient.patientId}
Patient Name: ${patient.patientName}
Invoice No: ${patient.invoiceNo}
Ticket No: ${patient.ticketNo}`,
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
                            icon: patient.type,
                            html: `${patient.message}

Patient ID: ${patient.patientId}
Patient Name: ${patient.patientName}
Invoice No: ${patient.invoiceNo}
Ticket No: ${patient.ticketNo}`,
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
                    
                    currentIndex++;
                    
                    // Show next notification after 3 seconds
                    setTimeout(showNextNotification, 3000);
                }
            }

            // Start showing notifications after 3 seconds
            setTimeout(showNextNotification, 3000);
        });
    });

    // Add some interactive features to the test page
    document.addEventListener('DOMContentLoaded', function() {
        // Add hover effects to buttons
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.2)';
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '';
            });
        });
        
        // Add click feedback
        buttons.forEach(button => {
            button.addEventListener('click', function() {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });
    });

    // Direct test function
    window.testDirectNotification = function() {
        console.log('Testing direct notification...');
        Swal.fire({
            icon: 'success',
            html: '✅ Direct Test Successful!<br><br>This is a direct JavaScript test.<br>If you see this, SweetAlert2 is working.',
            position: 'center',
            showConfirmButton: true,
            confirmButtonText: 'OK',
            confirmButtonColor: '#4361ee'
        });
    };
</script> <?php /**PATH C:\Users\aioli\Herd\diagnostic\resources\views/livewire/test-notifications.blade.php ENDPATH**/ ?>