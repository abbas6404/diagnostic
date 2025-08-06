<?php $__env->startSection('title', 'Hospital Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid px-0">
    <!-- Content Row -->
    <div class="row">
        <!-- Department Chart -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4" style="height: 80vh; background-image: url('<?php echo e(asset('images/sarker_health_complex.jpg')); ?>'); background-size: cover; background-position: center;">
                   
           
           
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>

<?php $__env->stopPush(); ?> 
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\aioli\Herd\diagnostic\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>