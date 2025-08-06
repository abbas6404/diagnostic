<div>
    <!-- This component handles SweetAlert2 notifications -->
    <!-- It's invisible but listens for events -->
    
    <script>
        document.addEventListener('livewire:init', () => {
            console.log('AlertNotifications component initialized');
            
            // Listen for SweetAlert2 events from Livewire
            Livewire.on('showSweetAlert', (data) => {
                console.log('showSweetAlert event received:', data);
                const { type, title, message } = data;
                
                // Configure SweetAlert2 options based on type
                const options = {
                    icon: type,
                    title: title,
                    text: message,
                    position: 'center',
                    allowOutsideClick: true,
                    allowEscapeKey: true,
                    customClass: {
                        popup: 'swal2-popup-custom',
                        icon: 'swal2-icon-custom'
                    }
                };

                // Add specific options based on alert type
                if (type === 'success') {
                    options.showConfirmButton = false;
                    options.timer = 5000;
                    options.timerProgressBar = true;
                    options.didOpen = (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    };
                } else {
                    options.showConfirmButton = true;
                    options.confirmButtonText = 'OK';
                    options.confirmButtonColor = '#4361ee';
                }

                // Show the SweetAlert2 popup
                Swal.fire(options);
            });
        });
    </script>

    <style>
        /* Custom SweetAlert2 styling */
        .swal2-popup-custom {
            border-radius: 15px !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2) !important;
            padding: 30px 25px !important;
            min-width: 350px !important;
        }

        .swal2-icon-custom {
            font-size: 2.5rem !important;
            margin: 20px auto 15px !important;
            width: 80px !important;
            height: 80px !important;
            border-width: 4px !important;
        }

        /* Error icon fix */
        .swal2-icon.swal2-error {
            border-color: #dc3545 !important;
            color: #dc3545 !important;
            background-color: #f8d7da !important;
        }

        .swal2-icon.swal2-error .swal2-error-line {
            background-color: #dc3545 !important;
            height: 5px !important;
            border-radius: 2px !important;
        }

        /* Success icon */
        .swal2-icon.swal2-success {
            border-color: #28a745 !important;
            color: #28a745 !important;
            background-color: #d4edda !important;
        }

        /* Warning icon */
        .swal2-icon.swal2-warning {
            border-color: #ffc107 !important;
            color: #ffc107 !important;
            background-color: #fff3cd !important;
        }

        /* Info icon */
        .swal2-icon.swal2-info {
            border-color: #17a2b8 !important;
            color: #17a2b8 !important;
            background-color: #d1ecf1 !important;
        }

        /* Question icon */
        .swal2-icon.swal2-question {
            border-color: #6c757d !important;
            color: #6c757d !important;
            background-color: #e2e3e5 !important;
        }

        /* Title styling */
        .swal2-title {
            font-size: 18px !important;
            font-weight: 600 !important;
            color: #2c3e50 !important;
            line-height: 1.4 !important;
            margin-top: 15px !important;
        }

        /* Text styling */
        .swal2-html-container {
            font-size: 14px !important;
            color: #495057 !important;
            line-height: 1.6 !important;
            white-space: pre-line !important;
        }

        /* Button styling */
        .swal2-confirm {
            border-radius: 8px !important;
            font-weight: 600 !important;
            padding: 12px 24px !important;
            font-size: 14px !important;
            transition: all 0.3s ease !important;
        }

        .swal2-confirm:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3) !important;
        }

        /* Backdrop styling */
        .swal2-backdrop-show {
            backdrop-filter: blur(8px) !important;
            -webkit-backdrop-filter: blur(8px) !important;
            background-color: rgba(0, 0, 0, 0.3) !important;
        }
    </style>
</div> <?php /**PATH C:\Users\aioli\Herd\diagnostic\resources\views/livewire/alert-notifications.blade.php ENDPATH**/ ?>