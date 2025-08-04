// Enhanced sidebar toggle functionality
console.log('Admin layout JS loaded successfully!');

// Global SweetAlert2 configuration to prevent auto-closing
if (typeof Swal !== 'undefined') {
    // Configure global defaults to prevent auto-closing
    Swal.mixin({
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        timer: undefined,
        timerProgressBar: false,
        backdrop: true
    });
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing admin layout...');
    
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebarToggleBtn = document.getElementById('sidebar-toggle-btn');
    const sidebar = document.querySelector('.sidebar');
    const sidebarOverlay = document.querySelector('.sidebar-overlay');
    const adminLayout = document.querySelector('.admin-layout');
    const contentContainer = document.querySelector('.content-container');

    // Check for saved sidebar state
    if (localStorage.getItem('sidebarCollapsed') === 'true') {
        adminLayout.classList.add('sidebar-collapsed');
    }

    // Sidebar toggle button inside sidebar
    if (sidebarToggleBtn) {
        sidebarToggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            adminLayout.classList.toggle('sidebar-collapsed');
            localStorage.setItem('sidebarCollapsed', adminLayout.classList.contains(
                'sidebar-collapsed'));
        });
    }

    // Mobile sidebar toggle
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
        });
    }

    // Overlay click event
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
        });
    }

    // Initialize Bootstrap collapse for all submenu items
    const collapseElements = document.querySelectorAll('.sidebar .collapse');
    collapseElements.forEach(function(collapseEl) {
        // Create Bootstrap collapse instance
        const bsCollapse = new bootstrap.Collapse(collapseEl, {
            toggle: false
        });

        // Get the trigger element
        const trigger = document.querySelector(`[data-bs-target="#${collapseEl.id}"]`);
        if (trigger) {
            // Listen for Bootstrap collapse events
            collapseEl.addEventListener('show.bs.collapse', function() {
                trigger.setAttribute('aria-expanded', 'true');
            });

            collapseEl.addEventListener('hide.bs.collapse', function() {
                trigger.setAttribute('aria-expanded', 'false');
            });

            // Handle click on menu items with submenu
            trigger.addEventListener('click', function(e) {
                // Don't process if clicking on submenu items
                if (e.target.closest('.submenu')) {
                    return;
                }

                e.preventDefault();

                // Toggle the collapse
                bsCollapse.toggle();
            });
        }
    });

    // Close sidebar when clicking on a nav link on mobile
    const navLinks = document.querySelectorAll('.sidebar .nav-link:not(.has-submenu)');
    navLinks.forEach(function(link) {
        link.addEventListener('click', function() {
            if (window.innerWidth < 992) {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
            }
        });
    });

    // Adjust on window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 992) {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
        }
    });

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.admin-navbar');
        if (window.scrollY > 10) {
            navbar.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.1)';
        } else {
            navbar.style.boxShadow = '0 3px 10px rgba(0, 0, 0, 0.1)';
        }
    });
});

// Beautiful SweetAlert2 notification system
document.addEventListener('livewire:init', () => {
    console.log('Livewire initialized, setting up notifications...');
    
    Livewire.on('show-success', (data) => {
        console.log('Success event received:', data);
        // Extract message from object or use data directly if it's a string
        const message = typeof data === 'object' && data.message ? data.message : (typeof data === 'string' ? data : 'Operation completed successfully!');
        
        if (typeof Swal !== 'undefined') {
            console.log('SweetAlert2 is available, showing notification...');
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
                title: message,
                customClass: {
                    title: 'swal2-title-custom',
                    popup: 'swal2-popup-custom'
                }
            });
        } else {
            console.log('SweetAlert2 not available, using alert...');
            alert(message);
        }
    });
    
    Livewire.on('show-error', (data) => {
        console.log('Error event received:', data);
        // Extract message from object or use data directly if it's a string
        const message = typeof data === 'object' && data.message ? data.message : (typeof data === 'string' ? data : 'An error occurred!');
        
        if (typeof Swal !== 'undefined') {
            console.log('SweetAlert2 is available, showing error notification...');
            
            // Force close any existing dialogs first
            Swal.close();
            
            // Create a completely isolated error dialog
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message,
                toast: false,
                position: 'center',
                showConfirmButton: true,
                confirmButtonText: 'OK',
                showCancelButton: false,
                backdrop: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                timer: undefined,
                timerProgressBar: false,
                width: '450px',
                padding: '20px',
                customClass: {
                    title: 'swal2-title-custom',
                    popup: 'swal2-popup-custom'
                },
                didOpen: () => {
                    console.log('Error dialog opened');
                },
                willClose: () => {
                    console.log('Error dialog will close');
                }
            }).then((result) => {
                // Only close when user clicks OK button
                if (result.isConfirmed) {
                    console.log('Error dialog closed by user');
                }
            });
        } else {
            console.log('SweetAlert2 not available, using alert...');
            alert('Error: ' + message);
        }
    });

    // Warning notification handler
    Livewire.on('show-warning', (data) => {
        console.log('Warning event received:', data);
        // Extract message from object or use data directly if it's a string
        const message = typeof data === 'object' && data.message ? data.message : (typeof data === 'string' ? data : 'Please confirm your action!');
        
        if (typeof Swal !== 'undefined') {
            console.log('SweetAlert2 is available, showing warning notification...');
            
            // Force close any existing dialogs first
            Swal.close();
            
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: message,
                toast: false,
                position: 'center',
                showConfirmButton: true,
                confirmButtonText: 'OK',
                showCancelButton: false,
                backdrop: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                timer: undefined,
                timerProgressBar: false,
                width: '400px',
                padding: '20px',
                customClass: {
                    title: 'swal2-title-custom',
                    popup: 'swal2-popup-custom'
                }
            });
        } else {
            console.log('SweetAlert2 not available, using alert...');
            alert('Warning: ' + message);
        }
    });

    // Invoice success notification handler
    Livewire.on('show-invoice-success', (data) => {
        console.log('Invoice success event received:', data);
        if (typeof Swal !== 'undefined') {
            console.log('SweetAlert2 is available, showing invoice success notification...');
            const Toast = Swal.mixin({
                toast: false,
                position: 'center',
                showConfirmButton: true,
                confirmButtonText: 'Print Invoice',
                showCancelButton: true,
                cancelButtonText: 'Close',
                backdrop: true,
                allowOutsideClick: false,
                width: '500px',
                padding: '20px'
            });
            
            Toast.fire({
                icon: 'success',
                title: 'Invoice Created Successfully!',
                html: `
                    <div class="text-start">
                        <p><strong>Message:</strong> ${data.message || 'Invoice created successfully!'}</p>
                        <p><strong>Invoice No:</strong> ${data.invoiceNo || 'N/A'}</p>
                        <p><strong>Ticket No:</strong> ${data.ticketNo || 'N/A'}</p>
                    </div>
                `,
                customClass: {
                    title: 'swal2-title-custom',
                    popup: 'swal2-popup-custom'
                }
            }).then((result) => {
                if (result.isConfirmed && data.redirectUrl) {
                    window.location.href = data.redirectUrl;
                }
            });
        } else {
            console.log('SweetAlert2 not available, using alert...');
            alert('Invoice Success: ' + (data.message || 'Invoice created successfully!'));
        }
    });

    // Payment success notification handler
    Livewire.on('show-payment-success', (data) => {
        console.log('Payment success event received:', data);
        
        // Handle data as array (Livewire sends it as array)
        const notificationData = Array.isArray(data) ? data[0] : data;
        
        console.log('Processed data:', notificationData);
        console.log('Data keys:', Object.keys(notificationData));
        console.log('Collection No:', notificationData.collectionNo);
        console.log('Amount:', notificationData.amount);
        
        if (typeof Swal !== 'undefined') {
            console.log('SweetAlert2 is available, showing payment success notification...');
            const Toast = Swal.mixin({
                toast: false,
                position: 'center',
                showConfirmButton: true,
                confirmButtonText: 'OK',
                backdrop: true,
                allowOutsideClick: false,
                width: '500px',
                padding: '20px'
            });
            
            Toast.fire({
                icon: 'success',
                title: 'Payment Collected Successfully!',
                html: `
                    <div class="text-start">
                        <p><strong>Message:</strong> ${notificationData.message || 'Payment collected successfully!'}</p>
                        <p><strong>Collection No:</strong> ${notificationData.collectionNo || 'N/A'}</p>
                        <p><strong>Amount:</strong> ${notificationData.amount || 'N/A'}</p>
                    </div>
                `,
                customClass: {
                    title: 'swal2-title-custom',
                    popup: 'swal2-popup-custom'
                }
            });
        } else {
            console.log('SweetAlert2 not available, using alert...');
            alert('Payment Success: ' + (notificationData.message || 'Payment collected successfully!'));
        }
    });
}); 