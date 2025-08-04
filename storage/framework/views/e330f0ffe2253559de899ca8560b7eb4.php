

<?php $__env->startSection('title', 'Invoice Templates'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary">
                    <i class="fas fa-file-invoice me-2"></i> Invoice Templates
                </h5>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-file-invoice fa-3x text-primary mb-3"></i>
                            <h6>Default Template</h6>
                            <p class="text-muted small">Standard invoice layout</p>
                            <a href="<?php echo e(route('admin.admin.invoice-templates.default')); ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye me-1"></i> View Template
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-receipt fa-3x text-success mb-3"></i>
                            <h6>Compact Template</h6>
                            <p class="text-muted small">Space-efficient layout</p>
                            <a href="<?php echo e(route('admin.admin.invoice-templates.compact')); ?>" class="btn btn-success btn-sm">
                                <i class="fas fa-eye me-1"></i> View Template
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-briefcase fa-3x text-info mb-3"></i>
                            <h6>Professional Template</h6>
                            <p class="text-muted small">Premium business layout</p>
                            <a href="<?php echo e(route('admin.admin.invoice-templates.professional')); ?>" class="btn btn-info btn-sm">
                                <i class="fas fa-eye me-1"></i> View Template
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-print fa-3x text-warning mb-3"></i>
                            <h6>Receipt Template</h6>
                            <p class="text-muted small">Simple receipt format</p>
                            <a href="<?php echo e(route('admin.admin.invoice-templates.receipt')); ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-eye me-1"></i> View Template
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-flask fa-3x text-danger mb-3"></i>
                            <h6>Laboratory Template</h6>
                            <p class="text-muted small">Lab test specific layout</p>
                            <a href="<?php echo e(route('admin.admin.invoice-templates.laboratory')); ?>" class="btn btn-danger btn-sm">
                                <i class="fas fa-eye me-1"></i> View Template
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-user-md fa-3x text-primary mb-3"></i>
                            <h6>Doctor/Consultant Template</h6>
                            <p class="text-muted small">Doctor consultation invoice</p>
                            <a href="<?php echo e(route('admin.admin.invoice-templates.doctor-consultant')); ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye me-1"></i> View Template
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-plus-circle fa-3x text-muted mb-3"></i>
                            <h6>Test Template</h6>
                            <p class="text-muted small">Simple test template</p>
                            <a href="<?php echo e(route('admin.admin.invoice-templates.test')); ?>" class="btn btn-secondary btn-sm">
                                <i class="fas fa-eye me-1"></i> View Template
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\aioli\Herd\diagnostic\resources\views/admin/invoice-templates/index.blade.php ENDPATH**/ ?>