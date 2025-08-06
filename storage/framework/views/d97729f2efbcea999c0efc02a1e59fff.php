

<?php $__env->startSection('title', 'Livewire Notification Test'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Livewire Notification Test</h5>
                </div>
                <div class="card-body">
                    <p>Click the buttons below to test the Livewire-based notification system:</p>
                    
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <button type="button" class="btn btn-success" onclick="testSuccess()">
                                <i class="fas fa-check-circle me-2"></i>Test Success
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button type="button" class="btn btn-danger" onclick="testError()">
                                <i class="fas fa-exclamation-circle me-2"></i>Test Error
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button type="button" class="btn btn-warning" onclick="testWarning()">
                                <i class="fas fa-exclamation-triangle me-2"></i>Test Warning
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button type="button" class="btn btn-info" onclick="testInfo()">
                                <i class="fas fa-info-circle me-2"></i>Test Info
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function testSuccess() {
        if (typeof Livewire !== 'undefined') {
            Livewire.dispatch('show-alert', {
                type: 'success',
                message: 'This is a test success notification!'
            });
        }
    }

    function testError() {
        if (typeof Livewire !== 'undefined') {
            Livewire.dispatch('show-alert', {
                type: 'error',
                message: 'This is a test error notification!'
            });
        }
    }

    function testWarning() {
        if (typeof Livewire !== 'undefined') {
            Livewire.dispatch('show-alert', {
                type: 'warning',
                message: 'This is a test warning notification!'
            });
        }
    }

    function testInfo() {
        if (typeof Livewire !== 'undefined') {
            Livewire.dispatch('show-alert', {
                type: 'info',
                message: 'This is a test info notification!'
            });
        }
    }
</script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\aioli\Herd\diagnostic\resources\views/admin/test/livewire-notifications.blade.php ENDPATH**/ ?>