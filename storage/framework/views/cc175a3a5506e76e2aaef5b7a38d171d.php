

<?php $__env->startSection('title', isset($isArchived) && $isArchived ? 'Archived Patients' : 'Patient List'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary">
                    <i class="fas fa-users me-2"></i> <?php echo e(isset($isArchived) && $isArchived ? 'Archived Patients' : 'Patient List'); ?>

                </h5>
                <a href="<?php echo e(route('admin.patients.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-1"></i> New Patient
                </a>
            </div>
        </div>
        <div class="card-body">
            <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            
            <!-- Search and Filter Section -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <form action="<?php echo e(route('admin.patients.index')); ?>" method="GET">
                        <div class="d-flex gap-2">
                            <div class="input-group flex-grow-1">
                                <input type="text" class="form-control" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search patients by name, ID, phone or address...">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                            
                            <div class="input-group" style="width: auto;">
                                <select class="form-select" name="status" onchange="this.form.submit()">
                                    <option value="active" <?php echo e(request('status') != 'archived' ? 'selected' : ''); ?>>Active Patients</option>
                                    <option value="archived" <?php echo e(request('status') == 'archived' ? 'selected' : ''); ?>>Archived Patients</option>
                                </select>
                            </div>
                            
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-download"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="exportDropdown">
                                    <li><a class="dropdown-item" href="#"><i class="far fa-file-excel me-2"></i>Export Excel</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="far fa-file-pdf me-2"></i>Export PDF</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="fas fa-print me-2"></i>Print</a></li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Patients Table -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered compact-table">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Patient ID</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th>Gender</th>
                            <th>Age</th>
                            <th>Blood Group</th>
                            <th style="width: 150px;">Registered</th>
                            <th style="width: 120px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($index + $patients->firstItem()); ?></td>
                            <td><?php echo e($patient->patient_id); ?></td>
                            <td><?php echo e($patient->name); ?></td>
                            <td><?php echo e($patient->phone); ?></td>
                            <td><?php echo e($patient->address); ?></td>
                            <td><?php echo e($patient->gender); ?></td>
                            <td>
                                <?php
                                    $age = '';
                                    if ($patient->dob) {
                                        $dob = new DateTime($patient->dob);
                                        $now = new DateTime();
                                        $diff = $now->diff($dob);
                                        $age = $diff->y . 'y ' . $diff->m . 'm';
                                    }
                                ?>
                                <?php echo e($age); ?>

                            </td>
                            <td>
                                <i class="fas fa-tint text-danger"></i> <?php echo e($patient->blood_group); ?>

                            </td>
                            <td><?php echo e(date('d M Y', strtotime($patient->reg_date))); ?></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <?php if(isset($isArchived) && $isArchived): ?>
                                        <form action="<?php echo e(route('admin.patients.restore', $patient->id)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-success btn-sm" title="Restore Patient"><i class="fas fa-trash-restore"></i></button>
                                        </form>
                                    <?php else: ?>
                                        <a href="<?php echo e(route('admin.patients.show', $patient->id)); ?>" class="btn btn-info btn-sm" title="View"><i class="fas fa-eye"></i></a>
                                        <a href="<?php echo e(route('admin.patients.edit', $patient->id)); ?>" class="btn btn-primary btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                                        <form action="<?php echo e(route('admin.patients.destroy', $patient->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to archive this patient? The record will be soft deleted.')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger btn-sm" style="border-radius: 0 5px 5px 0;" title="Archive (Soft Delete)"><i class="fas fa-archive"></i></button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="10" class="text-center py-2">No patients found</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <span class="text-muted">Showing <?php echo e($patients->firstItem() ?? 0); ?> to <?php echo e($patients->lastItem() ?? 0); ?> of <?php echo e($patients->total() ?? 0); ?> entries</span>
                </div>
                <div>
                    <?php echo e($patients->appends(request()->query())->links('pagination::bootstrap-4')); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    $(document).ready(function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .compact-table {
        font-size: 0.875rem;
    }
    
    .compact-table th,
    .compact-table td {
        padding: 0.5rem 0.75rem;
        vertical-align: middle;
    }
    .compact-table td {
        padding:0rem 0.75rem;
    }
    
    .compact-table thead th {
        padding: 0.75rem 0.75rem;
        font-weight: 600;
        font-size: 0.875rem;
    }
    
    .compact-table tbody tr {
        height: auto;
        min-height: 40px;
    }
    
    .compact-table .btn-group .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.75rem;
    }
    
    .compact-table .btn-group .btn i {
        font-size: 0.75rem;
    }
    
    /* Reduce spacing for action buttons */
    .compact-table .btn-group {
        gap: 2px;
    }
    
    /* Make table more dense */
    .compact-table tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
</style>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\aioli\Herd\diagnostic\resources\views/admin/registration/index.blade.php ENDPATH**/ ?>