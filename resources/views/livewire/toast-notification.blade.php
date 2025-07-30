<div>
    @if($show)
    <div id="toast-container" class="toast-container position-fixed top-50 start-50 translate-middle" style="z-index: 9999;">
        <div class="toast show custom-toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header custom-toast-header {{ $type === 'success' ? 'bg-success' : ($type === 'error' ? 'bg-danger' : ($type === 'warning' ? 'bg-warning' : 'bg-info')) }}">
                <div class="toast-icon">
                    <i class="fas {{ $type === 'success' ? 'fa-check-circle' : ($type === 'error' ? 'fa-exclamation-triangle' : ($type === 'warning' ? 'fa-exclamation-circle' : 'fa-info-circle')) }}"></i>
                </div>
                <div class="toast-content">
                    <strong class="toast-title">{{ ucfirst($type) }}</strong>
                    <div class="toast-message">{{ $message }}</div>
                    @if(isset($invoiceNo) && $invoiceNo)
                    <div class="toast-details">
                        <span class="detail-item">
                            <i class="fas fa-file-invoice me-2"></i>
                            Invoice: <strong>{{ $invoiceNo }}</strong>
                        </span>
                    </div>
                    @endif
                    @if(isset($ticketNo) && $ticketNo)
                    <div class="toast-details">
                        <span class="detail-item">
                            <i class="fas fa-ticket-alt me-2"></i>
                            Ticket: <strong>{{ $ticketNo }}</strong>
                        </span>
                    </div>
                    @endif
                    @if($type === 'success' && isset($invoiceNo) && $invoiceNo)
                    <div class="toast-actions">
                        <button type="button" class="btn btn-sm btn-light me-2" onclick="printInvoice('{{ $invoiceNo }}')">
                            <i class="fas fa-print me-1"></i> Print
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-light" onclick="viewInvoice('{{ $invoiceNo }}')">
                            <i class="fas fa-eye me-1"></i> View
                        </button>
                    </div>
                    @endif
                </div>
                <button type="button" class="btn-close btn-close-white" wire:click="hideToast"></button>
            </div>
        </div>
    </div>

    <style>
    .toast-container {
        animation: slideInDown 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    .custom-toast {
        width: 450px;
        height: 450px;
        border: none;
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        backdrop-filter: blur(15px);
        background: rgba(255, 255, 255, 0.95);
        border: 2px solid rgba(255, 255, 255, 0.2);
        /* Ensure toast stays visible */
        opacity: 1 !important;
        visibility: visible !important;
        display: block !important;
        animation: none !important;
    }

    .custom-toast-header {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 50px 40px;
        width: 100%;
        height: 100%;
        border: none;
        position: relative;
        overflow: hidden;
        border-radius: 20px;
        flex-direction: column;
    }

    .custom-toast-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0.05) 100%);
        z-index: 1;
    }

    .toast-icon {
        width: 90px;
        height: 90px;
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 35px;
        background: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        z-index: 2;
        position: relative;
        border: 2px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .toast-icon i {
        font-size: 40px;
        color: white;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .toast-content {
        flex: 1;
        z-index: 2;
        position: relative;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .toast-title {
        font-size: 28px;
        font-weight: 700;
        color: white;
        margin-bottom: 20px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        letter-spacing: 0.5px;
    }

    .toast-message {
        font-size: 20px;
        color: rgba(255, 255, 255, 0.95);
        line-height: 1.6;
        margin: 0 0 25px 0;
        text-align: center;
        max-width: 350px;
        font-weight: 400;
    }

    .toast-details {
        margin-top: 15px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: center;
    }

    .detail-item {
        background: rgba(255, 255, 255, 0.2);
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 16px;
        color: white;
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 200px;
    }

    .detail-item strong {
        font-weight: 600;
        margin-left: 5px;
    }

    .toast-actions {
        margin-top: 20px;
        display: flex;
        justify-content: center;
        gap: 10px;
        z-index: 2;
        position: relative;
    }

    .toast-actions .btn {
        font-size: 12px;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.2s ease;
        min-width: 80px;
    }

    .toast-actions .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .toast-actions .btn-light {
        background: rgba(255, 255, 255, 0.9);
        color: #333;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .toast-actions .btn-outline-light {
        background: transparent;
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.5);
    }

    .toast-actions .btn-outline-light:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.8);
    }

    .btn-close {
        z-index: 2;
        position: absolute;
        top: 20px;
        right: 20px;
        opacity: 0.9;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.25);
        border-radius: 6px;
        padding: 6px;
        backdrop-filter: blur(5px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .btn-close::before {
        content: '×';
        font-size: 16px;
        font-weight: bold;
        color: white;
        line-height: 1;
    }

    .btn-close:hover {
        opacity: 1;
        transform: scale(1.1);
        background: rgba(255, 255, 255, 0.4);
        border-color: rgba(255, 255, 255, 0.6);
    }

    /* Type-specific styling */
    .bg-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 50%, #17a2b8 100%);
    }

    .bg-danger {
        background: linear-gradient(135deg, #dc3545 0%, #e74c3c 50%, #fd7e14 100%);
    }

    .bg-warning {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 50%, #e74c3c 100%);
    }

    .bg-info {
        background: linear-gradient(135deg, #17a2b8 0%, #20c997 50%, #28a745 100%);
    }

    /* Enhanced animations */
    @keyframes slideInDown {
        from {
            transform: translate(-50%, -100%) scale(0.8);
            opacity: 0;
        }
        to {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.8) translateY(-20px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .toast.show {
        animation: fadeIn 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }

    /* Removed fade-out animation to prevent auto-close behavior */
    /* .toast.fade-out {
        animation: fadeOut 0.3s cubic-bezier(0.55, 0.055, 0.675, 0.19) forwards;
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
        to {
            opacity: 0;
            transform: scale(0.8) translateY(-20px);
        }
    } */

    /* Progress bar for auto-dismiss - REMOVED since toast doesn't auto-close */
    /* .toast::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        height: 5px;
        background: rgba(255, 255, 255, 0.4);
        animation: progressBar 5s linear;
        border-radius: 0 0 20px 20px;
    }

    @keyframes progressBar {
        from {
            width: 100%;
        }
        to {
            width: 0%;
        }
    } */

    /* Responsive design */
    @media (max-width: 576px) {
        .custom-toast {
            width: 350px;
            height: 350px;
        }
        
        .custom-toast-header {
            padding: 40px 30px;
        }
        
        .toast-icon {
            width: 70px;
            height: 70px;
            margin-bottom: 25px;
        }
        
        .toast-icon i {
            font-size: 32px;
        }
        
        .toast-title {
            font-size: 24px;
            margin-bottom: 15px;
        }
        
        .toast-message {
            font-size: 18px;
            max-width: 280px;
            margin-bottom: 20px;
        }

        .detail-item {
            font-size: 14px;
            padding: 6px 12px;
            min-width: 180px;
        }

        .toast-actions {
            margin-top: 15px;
            gap: 8px;
        }

        .toast-actions .btn {
            font-size: 11px;
            padding: 5px 10px;
            min-width: 70px;
        }

        .btn-close {
            top: 15px;
            right: 15px;
            width: 24px;
            height: 24px;
            padding: 4px;
        }

        .btn-close::before {
            font-size: 14px;
        }
    }

    /* Hover effects */
    .custom-toast:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35);
        transition: all 0.3s ease;
    }

    /* Pulse animation for important messages */
    .custom-toast.important {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }
        50% {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
        }
        100% {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
        }
    }
    </style>

    <script>
    // Global flag to prevent auto-close
    window.toastAutoCloseDisabled = true;
    
    // Debug function to check if toast is being hidden
    function debugToast() {
        const toast = document.querySelector('.custom-toast');
        if (toast) {
            console.log('Toast visibility:', {
                opacity: toast.style.opacity,
                visibility: toast.style.visibility,
                display: toast.style.display,
                classes: toast.className
            });
        }
    }
    
    document.addEventListener('livewire:load', function () {
        console.log('Livewire loaded - disabling auto-close');
        
        // Clear any existing timers
        if (typeof window.toastTimer !== 'undefined') {
            clearTimeout(window.toastTimer);
            window.toastTimer = null;
        }
        
        // Add entrance animation class
        const toast = document.querySelector('.custom-toast');
        if (toast) {
            toast.classList.add('show');
            
            // Ensure toast stays visible
            toast.style.animation = 'none';
            toast.style.opacity = '1';
            toast.style.transform = 'translate(-50%, -50%) scale(1)';
            toast.style.visibility = 'visible';
            toast.style.display = 'block';
            
            // Remove any fade-out classes
            toast.classList.remove('fade-out');
            
            // Debug toast state
            debugToast();
        }
        
        // Explicitly disable auto-close - toast will stay open until manually closed
        console.log('Toast loaded - auto-close disabled');
        
        // Monitor for any changes that might hide the toast
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                    const toast = document.querySelector('.custom-toast');
                    if (toast && (toast.style.opacity === '0' || toast.style.visibility === 'hidden')) {
                        console.log('Toast being hidden - preventing...');
                        toast.style.opacity = '1';
                        toast.style.visibility = 'visible';
                        toast.style.display = 'block';
                    }
                }
            });
        });
        
        if (toast) {
            observer.observe(toast, { attributes: true, attributeFilter: ['style'] });
        }
    });

    // Override any potential auto-close functions
    window.hideToast = function() {
        // Only allow manual close via Livewire
        console.log('Auto-close prevented - only manual close allowed');
        return false;
    };

    // Prevent any setTimeout that might hide the toast
    const originalSetTimeout = window.setTimeout;
    window.setTimeout = function(func, delay, ...args) {
        if (typeof func === 'string' && func.includes('hideToast')) {
            console.log('Prevented setTimeout that would hide toast');
            return null;
        }
        return originalSetTimeout(func, delay, ...args);
    };

    // Print invoice function
    function printInvoice(invoiceNo) {
        console.log('Print invoice:', invoiceNo);
        
        // Hide the toast first
        @this.hideToast();
        
        // Show loading toast
        Livewire.dispatch('showInfo', { message: 'Preparing print job...' });
        
        // Redirect to print page
        setTimeout(() => {
            window.open(`/admin/doctor/reprint?invoice_no=${invoiceNo}&print=true`, '_blank');
        }, 1000);
    }

    // View invoice function
    function viewInvoice(invoiceNo) {
        console.log('View invoice:', invoiceNo);
        
        // Hide the toast first
        @this.hideToast();
        
        // Show loading toast
        Livewire.dispatch('showInfo', { message: 'Loading invoice details...' });
        
        // Redirect to view page
        setTimeout(() => {
            window.location.href = `/admin/doctor/reprint?invoice_no=${invoiceNo}`;
        }, 1000);
    }
    </script>
    @endif
</div> 