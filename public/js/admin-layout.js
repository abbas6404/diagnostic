// Admin Layout JavaScript - Version 3.0
console.log('Admin Layout JS Version 3.0 loaded');

// Enhanced sidebar toggle functionality
console.log('Admin layout JS loaded successfully!');

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

// Livewire event handlers for print functionality
document.addEventListener('livewire:init', () => {
    console.log('Livewire initialized, setting up print handlers...');
    
    // Print window handler for diagnostics invoice
    Livewire.on('openPrintWindow', (data) => {
        console.log('Print window event received:', data);
        
        if (data && data.invoiceId) {
            const templateUrl = `{{ route('admin.admin.invoice-templates.diagnosis-invoice') }}?invoice_id=${data.invoiceId}`;
            console.log('Print URL:', templateUrl);
            
            // Create hidden iframe for printing
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            iframe.src = templateUrl;
            
            document.body.appendChild(iframe);
            
            iframe.onload = function() {
                try {
                    const frameWindow = iframe.contentWindow;
                    frameWindow.print();
                    
                    // Remove iframe after printing
                    setTimeout(() => {
                        document.body.removeChild(iframe);
                    }, 1000);
                } catch (error) {
                    console.error('Print error:', error);
                    // Fallback to window.open
                    window.open(templateUrl, '_blank');
                }
            };
            
            iframe.onerror = function() {
                console.error('Failed to load print template');
                // Fallback to window.open
                window.open(templateUrl, '_blank');
                document.body.removeChild(iframe);
            };
        }
    });
    
    // Print window handler for doctor invoice
    Livewire.on('openDoctorPrintWindow', (data) => {
        console.log('Doctor print window event received:', data);
        
        if (data && data.invoiceId) {
            const templateUrl = `{{ route('admin.admin.invoice-templates.doctor-consultant') }}?invoice_id=${data.invoiceId}`;
            console.log('Doctor print URL:', templateUrl);
            
            // Create hidden iframe for printing
            const iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            iframe.src = templateUrl;
            
            document.body.appendChild(iframe);
            
            iframe.onload = function() {
                try {
                    const frameWindow = iframe.contentWindow;
                    frameWindow.print();
                    
                    // Remove iframe after printing
                    setTimeout(() => {
                        document.body.removeChild(iframe);
                    }, 1000);
                } catch (error) {
                    console.error('Print error:', error);
                    // Fallback to window.open
                    window.open(templateUrl, '_blank');
                }
            };
            
            iframe.onerror = function() {
                console.error('Failed to load print template');
                // Fallback to window.open
                window.open(templateUrl, '_blank');
                document.body.removeChild(iframe);
            };
        }
    });
}); 