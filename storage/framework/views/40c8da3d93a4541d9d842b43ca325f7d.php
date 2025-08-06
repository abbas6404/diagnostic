

<?php $__env->startSection('page-title', 'Setup Dashboard'); ?>
<?php $__env->startSection('page-description', 'System configuration and management'); ?>

<?php $__env->startSection('setup-content'); ?>
<div class="card shadow">
    <div class="card-body text-center py-5">
        <i class="fas fa-cogs fa-4x text-muted mb-4"></i>
        <h4 class="text-muted">Setup Dashboard</h4>
        <p class="text-muted">Select an option from the sidebar to get started.</p>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('admin.setup.setup-layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\aioli\Herd\diagnostic\resources\views/admin/setup/index.blade.php ENDPATH**/ ?>