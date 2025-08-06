

<?php $__env->startSection('title', 'Edit Patient'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-primary">
                    <i class="fas fa-user-edit me-2"></i> Edit Patient
                </h5>
                <div>
                    <a href="<?php echo e(route('admin.patients.show', $patient->id)); ?>" class="btn btn-info btn-sm me-2">
                        <i class="fas fa-eye me-1"></i> View
                    </a>
                    <a href="<?php echo e(route('admin.patients.index')); ?>" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.patients.update', $patient->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="row">
                    <!-- Left Column - Patient Registration Form -->
                    <div class="col-lg-7">
                        <div class="row gx-3 gy-2">
                            <!-- Row 1 -->
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="reg_date" class="col-4 col-form-label">Reg. Date:</label>
                                    <div class="col-8">
                                        <input type="date" class="form-control" id="reg_date" name="reg_date" value="<?php echo e(old('reg_date', $patient->reg_date)); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="patient_id" class="col-4 col-form-label">Reg. No(#):</label>
                                    <div class="col-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="patient_id" value="<?php echo e($patient->patient_id); ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Row 2 -->
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <label for="name" class="col-2 col-form-label">Name: <span class="text-danger">*</span></label>
                                    <div class="col-10">
                                        <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name" name="name" value="<?php echo e(old('name', $patient->name)); ?>" placeholder="Name" required>
                                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Row 5 -->
                            <div class="col-md-12">
                                <div class="row align-items-center">
                                    <label for="address" class="col-2 col-form-label">Address:</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="address" name="address" value="<?php echo e(old('address', $patient->address)); ?>" placeholder="Present Address">
                                        <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Row 7 -->
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="phone" class="col-4 col-form-label">Contact: <span class="text-danger">*</span></label>
                                    <div class="col-8">
                                        <input type="text" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="phone" name="phone" value="<?php echo e(old('phone', $patient->phone)); ?>" placeholder="Contact No" required>
                                        <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="email" class="col-4 col-form-label">E-mail:</label>
                                    <div class="col-8">
                                        <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="email" name="email" value="<?php echo e(old('email', $patient->email)); ?>" placeholder="E-mail">
                                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Row 9 -->
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="dob" class="col-4 col-form-label">Date of Birth:</label>
                                    <div class="col-8">
                                        <input type="date" class="form-control <?php $__errorArgs = ['dob'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="dob" name="dob" value="<?php echo e(old('dob', $patient->dob)); ?>">
                                        <?php $__errorArgs = ['dob'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="gender" class="col-4 col-form-label">Sex:</label>
                                    <div class="col-8">
                                        <select class="form-control <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="gender" name="gender">
                                            <option value="">Select Sex</option>
                                            <option value="Male" <?php echo e(old('gender', $patient->gender) == 'Male' ? 'selected' : ''); ?>>Male</option>
                                            <option value="Female" <?php echo e(old('gender', $patient->gender) == 'Female' ? 'selected' : ''); ?>>Female</option>
                                            <option value="Other" <?php echo e(old('gender', $patient->gender) == 'Other' ? 'selected' : ''); ?>>Other</option>
                                        </select>
                                        <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Row 10 -->
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="blood_group" class="col-4 col-form-label">Blood Group:</label>
                                    <div class="col-8">
                                        <select class="form-control <?php $__errorArgs = ['blood_group'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="blood_group" name="blood_group">
                                            <option value="">Select Blood Group</option>
                                            <option value="A+" <?php echo e(old('blood_group', $patient->blood_group) == 'A+' ? 'selected' : ''); ?>>A+</option>
                                            <option value="A-" <?php echo e(old('blood_group', $patient->blood_group) == 'A-' ? 'selected' : ''); ?>>A-</option>
                                            <option value="B+" <?php echo e(old('blood_group', $patient->blood_group) == 'B+' ? 'selected' : ''); ?>>B+</option>
                                            <option value="B-" <?php echo e(old('blood_group', $patient->blood_group) == 'B-' ? 'selected' : ''); ?>>B-</option>
                                            <option value="AB+" <?php echo e(old('blood_group', $patient->blood_group) == 'AB+' ? 'selected' : ''); ?>>AB+</option>
                                            <option value="AB-" <?php echo e(old('blood_group', $patient->blood_group) == 'AB-' ? 'selected' : ''); ?>>AB-</option>
                                            <option value="O+" <?php echo e(old('blood_group', $patient->blood_group) == 'O+' ? 'selected' : ''); ?>>O+</option>
                                            <option value="O-" <?php echo e(old('blood_group', $patient->blood_group) == 'O-' ? 'selected' : ''); ?>>O-</option>
                                        </select>
                                        <?php $__errorArgs = ['blood_group'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="religion" class="col-4 col-form-label">Religion:</label>
                                    <div class="col-8">
                                        <input type="text" class="form-control <?php $__errorArgs = ['religion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="religion" name="religion" value="<?php echo e(old('religion', $patient->religion)); ?>" placeholder="Religion">
                                        <?php $__errorArgs = ['religion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Row 11 -->
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="occupation" class="col-4 col-form-label">Occupation:</label>
                                    <div class="col-8">
                                        <input type="text" class="form-control <?php $__errorArgs = ['occupation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="occupation" name="occupation" value="<?php echo e(old('occupation', $patient->occupation)); ?>" placeholder="Occupation">
                                        <?php $__errorArgs = ['occupation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="reg_fee" class="col-4 col-form-label">Reg. Fee:</label>
                                    <div class="col-8">
                                        <input type="number" step="0.01" class="form-control <?php $__errorArgs = ['reg_fee'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="reg_fee" name="reg_fee" value="<?php echo e(old('reg_fee', $patient->reg_fee)); ?>" placeholder="0.00">
                                        <?php $__errorArgs = ['reg_fee'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Row 12 -->
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="nationality" class="col-4 col-form-label">Nationality:</label>
                                    <div class="col-8">
                                        <input type="text" class="form-control <?php $__errorArgs = ['nationality'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="nationality" name="nationality" value="<?php echo e(old('nationality', $patient->nationality)); ?>" placeholder="Nationality">
                                        <?php $__errorArgs = ['nationality'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <label for="patient_type" class="col-4 col-form-label">Patient Type:</label>
                                    <div class="col-8">
                                        <select class="form-control <?php $__errorArgs = ['patient_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="patient_type" name="patient_type">
                                            <option value="">Select Type</option>
                                            <option value="General" <?php echo e(old('patient_type', $patient->patient_type) == 'General' ? 'selected' : ''); ?>>General</option>
                                            <option value="Emergency" <?php echo e(old('patient_type', $patient->patient_type) == 'Emergency' ? 'selected' : ''); ?>>Emergency</option>
                                            <option value="VIP" <?php echo e(old('patient_type', $patient->patient_type) == 'VIP' ? 'selected' : ''); ?>>VIP</option>
                                        </select>
                                        <?php $__errorArgs = ['patient_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Column - Age Calculation -->
                    <div class="col-lg-5">
                        <div class="card border">
                            <div class="card-header bg-info text-white py-2">
                                <h6 class="mb-0"><i class="fas fa-calculator me-1"></i> Age Calculation</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-md-4">
                                        <label for="age_year" class="form-label">Years:</label>
                                        <input type="number" class="form-control" id="age_year" name="age_year" value="<?php echo e(old('age_year', $ageData['age_year'] ?? 0)); ?>" min="0" max="150">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="age_month" class="form-label">Months:</label>
                                        <input type="number" class="form-control" id="age_month" name="age_month" value="<?php echo e(old('age_month', $ageData['age_month'] ?? 0)); ?>" min="0" max="12">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="age_day" class="form-label">Days:</label>
                                        <input type="number" class="form-control" id="age_day" name="age_day" value="<?php echo e(old('age_day', $ageData['age_day'] ?? 0)); ?>" min="0" max="31">
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Fill age fields to automatically calculate date of birth, or fill date of birth to calculate age.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-success px-4 me-2">
                            <i class="fas fa-save me-1"></i> Update Patient
                        </button>
                        <a href="<?php echo e(route('admin.patients.index')); ?>" class="btn btn-secondary px-4">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Handle session messages using global notification system
document.addEventListener('DOMContentLoaded', function() {
    <?php if(session('success')): ?>
        if (typeof showAlert !== 'undefined') {
            showAlert('success', '<?php echo e(session('success')); ?>');
        } else if (typeof Livewire !== 'undefined') {
            Livewire.dispatch('show-alert', {
                type: 'success',
                message: '<?php echo e(session('success')); ?>'
            });
        }
    <?php endif; ?>
    
    <?php if(session('error')): ?>
        if (typeof showAlert !== 'undefined') {
            showAlert('error', '<?php echo e(session('error')); ?>');
        } else if (typeof Livewire !== 'undefined') {
            Livewire.dispatch('show-alert', {
                type: 'error',
                message: '<?php echo e(session('error')); ?>'
            });
        }
    <?php endif; ?>
});
</script>
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\aioli\Herd\diagnostic\resources\views/admin/registration/edit.blade.php ENDPATH**/ ?>