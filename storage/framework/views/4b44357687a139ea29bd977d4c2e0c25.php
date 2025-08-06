<div>
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 text-primary">
                        <i class="fas fa-user-plus me-2"></i> Patient's Registration
                    </h5>
                    <div class="d-flex gap-2">
                        <a href="<?php echo e(route('admin.patients.index')); ?>" class="btn btn-outline-primary">
                            <i class="fas fa-th-list me-1"></i> Patient List
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!--[if BLOCK]><![endif]--><?php if($isPatientSelected): ?>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Patient Selected:</strong> A patient has been selected from search results. 
                        The Save button is disabled to prevent creating a duplicate patient. 
                        Click "Reset Form" to register a new patient.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                
                <form wire:submit.prevent="save">
                    <div class="row">
                        <!-- Left Column - Patient Registration Form -->
                        <div class="col-lg-7">
                            <div class="row gx-3 gy-2">
                             
                                
                                
                                <!-- Search -->
                                <div class="col-md-7">
                                    <div class="row align-items-center">
                                        <label for="search" class="col-4 col-form-label">Search: </label>
                                        <div class="col-8">
                                            <input type="text" class="form-control" id="search" wire:model.live="searchQuery" 
                                                   wire:keyup="searchPatients" autocomplete="off" placeholder="Search by name, phone, or ID">
                                        </div>
                                    </div>
                                </div>

                                   <!-- Row 1 -->
                                <div class="col-md-5">
                                    <div class="row align-items-center">
                                        <label for="reg_date" class="col-4 col-form-label">Reg. Date:</label>
                                        <div class="col-8">
                                                                                         <input type="date" class="form-control" id="reg_date" wire:model="reg_date">

                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Row 2 -->
                                <div class="col-md-12">
                                    <div class="row align-items-center">
                                        <label for="name" class="col-2 col-form-label">Name: <span class="text-danger">*</span></label>
                                        <div class="col-10">
                                                                                                                                     <input type="text" class="form-control" id="name" wire:model="name" 
                                                   placeholder="Name (English)">
                                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->

                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Row 5 -->
                                <div class="col-md-12">
                                    <div class="row align-items-center">
                                        <label for="address" class="col-2 col-form-label">Address:</label>
                                        <div class="col-10">
                                                                                         <input type="text" class="form-control" id="address" wire:model="address" 
                                                    placeholder="Present Address">

                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Row 7 -->
                                <div class="col-md-6">
                                    <div class="row align-items-center">
                                        <label for="phone" class="col-4 col-form-label">Contact: <span class="text-danger">*</span></label>
                                        <div class="col-8">
                                                                                                                                     <input type="text" class="form-control" id="phone" wire:model="phone" 
                                                   placeholder="Contact No" >
                                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->

                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Row 8 -->
                                <div class="col-md-6">
                                    <div class="row align-items-center">
                                        <label for="dob" class="col-4 col-form-label">Date of Birth:</label>
                                        <div class="col-8">
                                            <input type="date" class="form-control" id="dob" wire:model.live="dob" wire:change="updatedDob" 
                                                   value="<?php echo e($this->formattedDob); ?>" style="display: block !important; visibility: visible !important;">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="row align-items-center">
                                        <label for="age_year" class="col-4 col-form-label">Age:</label>
                                        <div class="col-8">
                                            <div class="row g-1">
                                                <div class="col-4">
                                                    <label for="age_year" class="form-label small text-muted">Years</label>
                                                    <input type="number" class="form-control text-center" id="age_year" 
                                                           wire:model.live="age_year" wire:change="calculateDobFromAge" 
                                                           placeholder="Y" min="0" max="150">

                                                </div>
                                                <div class="col-4">
                                                    <label for="age_month" class="form-label small text-muted">Months</label>
                                                    <input type="number" class="form-control text-center" id="age_month" 
                                                           wire:model.live="age_month" wire:change="calculateDobFromAge" 
                                                           placeholder="M" min="0" max="12">

                                                </div>
                                                <div class="col-4">
                                                    <label for="age_day" class="form-label small text-muted">Days</label>
                                                    <input type="number" class="form-control text-center" id="age_day" 
                                                           wire:model.live="age_day" wire:change="calculateDobFromAge" 
                                                           placeholder="D" min="0" max="31">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                                                 <!-- Row 9 -->
                                 <div class="col-md-6">
                                     <div class="row align-items-center">
                                         <label for="gender" class="col-4 col-form-label">Sex: <span class="text-danger">*</span></label>
                                                                                   <div class="col-8">
                                              <button type="button" wire:click="toggleSexOptions" class="form-control text-start" style="height: 38px; border: 1px solid #ced4da; background-color: #f8f9fa; color: #495057;">
                                                  <?php echo e($gender ?: 'Click to select sex'); ?>

                                              </button>
                                              <input type="hidden" id="gender" wire:model="gender">
                                              <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->

                                          </div>
                                     </div>
                                 </div>
                                
                                                                 <div class="col-md-6">
                                     <div class="row align-items-center">
                                         <label for="blood_group" class="col-4 col-form-label">Blood: </label>
                                                                                                                                                                       <div class="col-8">
                                              <button type="button" wire:click="toggleBloodGroups" class="form-control text-start" style="height: 38px; border: 1px solid #ced4da; background-color: #f8f9fa; color: #495057;">
                                                  <?php echo e($blood_group ?: 'Click to select blood group'); ?>

                                              </button>
                                              <input type="hidden" id="blood_group" wire:model="blood_group">

                                          </div>
                                     </div>
                                 </div>
                                
                                <!-- Row 11 -->
                                <div class="col-md-6">
                                    <div class="row align-items-center">
                                        <label for="reg_fee" class="col-4 col-form-label text-danger">Reg. Fees:</label>
                                        <div class="col-8">
                                                                                         <input type="number" class="form-control" id="reg_fee" wire:model="reg_fee" 
                                                    value="0">
                                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['reg_fee'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-danger"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                                                 <!-- Right Column - Search Results & Blood Groups -->
                         <div class="col-lg-5">
                             <!-- Search Results Area -->
                             <!--[if BLOCK]><![endif]--><?php if($showSearchResults): ?>
                                 <div class="card border mb-3" id="search-results-container">
                                     <div class="card-header bg-primary text-white py-2">
                                         <h6 class="mb-0 text-light"><i class="fas fa-search me-1"></i> Search Results</h6>
                                     </div>
                                     <div class="card-body p-0" style="height: 400px; overflow-y: auto;" id="search-results-body">
                                         <!--[if BLOCK]><![endif]--><?php if(count($searchResults) > 0): ?>
                                             <div class="list-group list-group-flush">
                                                 <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $searchResults; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                     <div class="list-group-item list-group-item-action search-item" 
                                                          wire:click="selectPatient(<?php echo e($patient->id); ?>)" 
                                                          style="cursor: pointer;">
                                                         <div class="d-flex justify-content-between align-items-start">
                                                             <div>
                                                                 <h6 class="mb-1"><?php echo e($patient->name ?? 'Unknown'); ?></h6>
                                                                 <small class="text-muted"><?php echo e($patient->phone); ?></small>
                                                             </div>
                                                             <div class="text-end">
                                                                 <small class="text-primary"><?php echo e($patient->patient_id); ?></small>
                                                                 <!--[if BLOCK]><![endif]--><?php if($patient->address): ?>
                                                                     <small class="text-muted d-block"><?php echo e($patient->address); ?></small>
                                                                 <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                                             </div>
                                                         </div>
                                                     </div>
                                                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                             </div>
                                         <?php else: ?>
                                             <div class="text-center py-4">
                                                 <i class="fas fa-search text-muted fa-2x mb-2"></i>
                                                 <p class="text-muted">No patients found</p>
                                             </div>
                                         <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                     </div>
                                 </div>
                             <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                             
                                                           <!-- Blood Groups Area -->
                              <!--[if BLOCK]><![endif]--><?php if($showBloodGroups): ?>
                                  <div class="card border mb-3" id="blood-groups-container">
                                      <div class="card-header bg-success text-white py-2">
                                          <h6 class="mb-0"><i class="fas fa-tint me-1"></i> Blood Groups</h6>
                                      </div>
                                      <div class="card-body p-0" style="height: 400px; overflow-y: auto;">
                                          <div class="list-group list-group-flush">
                                              <div class="list-group-item list-group-item-action" 
                                                   wire:click="selectBloodGroup('A+')" 
                                                   style="cursor: pointer;">
                                                  <div class="d-flex justify-content-between align-items-center">
                                                      <span>A+ (Positive)</span>
                                                      <small class="text-success">A+</small>
                                                  </div>
                                              </div>
                                              <div class="list-group-item list-group-item-action" 
                                                   wire:click="selectBloodGroup('A-')" 
                                                   style="cursor: pointer;">
                                                  <div class="d-flex justify-content-between align-items-center">
                                                      <span>A- (Negative)</span>
                                                      <small class="text-success">A-</small>
                                                  </div>
                                              </div>
                                              <div class="list-group-item list-group-item-action" 
                                                   wire:click="selectBloodGroup('B+')" 
                                                   style="cursor: pointer;">
                                                  <div class="d-flex justify-content-between align-items-center">
                                                      <span>B+ (Positive)</span>
                                                      <small class="text-success">B+</small>
                                                  </div>
                                              </div>
                                              <div class="list-group-item list-group-item-action" 
                                                   wire:click="selectBloodGroup('B-')" 
                                                   style="cursor: pointer;">
                                                  <div class="d-flex justify-content-between align-items-center">
                                                      <span>B- (Negative)</span>
                                                      <small class="text-success">B-</small>
                                                  </div>
                                              </div>
                                              <div class="list-group-item list-group-item-action" 
                                                   wire:click="selectBloodGroup('AB+')" 
                                                   style="cursor: pointer;">
                                                  <div class="d-flex justify-content-between align-items-center">
                                                      <span>AB+ (Positive)</span>
                                                      <small class="text-success">AB+</small>
                                                  </div>
                                              </div>
                                              <div class="list-group-item list-group-item-action" 
                                                   wire:click="selectBloodGroup('AB-')" 
                                                   style="cursor: pointer;">
                                                  <div class="d-flex justify-content-between align-items-center">
                                                      <span>AB- (Negative)</span>
                                                      <small class="text-success">AB-</small>
                                                  </div>
                                              </div>
                                              <div class="list-group-item list-group-item-action" 
                                                   wire:click="selectBloodGroup('O+')" 
                                                   style="cursor: pointer;">
                                                  <div class="d-flex justify-content-between align-items-center">
                                                      <span>O+ (Positive)</span>
                                                      <small class="text-success">O+</small>
                                                  </div>
                                              </div>
                                              <div class="list-group-item list-group-item-action" 
                                                   wire:click="selectBloodGroup('O-')" 
                                                   style="cursor: pointer;">
                                                  <div class="d-flex justify-content-between align-items-center">
                                                      <span>O- (Negative)</span>
                                                      <small class="text-success">O-</small>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                              
                              <!-- Sex Options Area -->
                              <!--[if BLOCK]><![endif]--><?php if($showSexOptions): ?>
                                  <div class="card border mb-3" id="sex-options-container">
                                      <div class="card-header bg-info text-white py-2">
                                          <h6 class="mb-0"><i class="fas fa-venus-mars me-1"></i> Sex Options</h6>
                                      </div>
                                      <div class="card-body p-0" style="height: 400px; overflow-y: auto;">
                                          <div class="list-group list-group-flush">
                                              <div class="list-group-item list-group-item-action" 
                                                   wire:click="selectSex('Male')" 
                                                   style="cursor: pointer;">
                                                  <div class="d-flex justify-content-between align-items-center">
                                                      <span><i class="fas fa-mars text-primary me-2"></i>Male</span>
                                                      <small class="text-primary">Male</small>
                                                  </div>
                                              </div>
                                              <div class="list-group-item list-group-item-action" 
                                                   wire:click="selectSex('Female')" 
                                                   style="cursor: pointer;">
                                                  <div class="d-flex justify-content-between align-items-center">
                                                      <span><i class="fas fa-venus text-danger me-2"></i>Female</span>
                                                      <small class="text-danger">Female</small>
                                                  </div>
                                              </div>
                                              <div class="list-group-item list-group-item-action" 
                                                   wire:click="selectSex('Other')" 
                                                   style="cursor: pointer;">
                                                  <div class="d-flex justify-content-between align-items-center">
                                                      <span><i class="fas fa-genderless text-secondary me-2"></i>Other</span>
                                                      <small class="text-secondary">Other</small>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                             
                                                           <!-- Default State -->
                              <!--[if BLOCK]><![endif]--><?php if(!$showSearchResults && !$showBloodGroups && !$showSexOptions): ?>
                                 <div class="card border mb-3">
                                     <div class="card-header bg-info text-white py-2">
                                         <h6 class="mb-0"><i class="fas fa-info-circle me-1"></i> Information</h6>
                                     </div>
                                     <div class="card-body text-center py-4">
                                         <i class="fas fa-user-plus text-muted fa-2x mb-2"></i>
                                                                                   <p class="text-muted">Showing 20 most recent patients. Search for specific patients or focus on blood group/sex fields</p>
                                     </div>
                                 </div>
                             <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                         </div>
                    </div>

                                         <div class="row mt-4">
                         <div class="col-12 text-center">
                                                           
                                                           <button type="button" wire:click="save" 
                                                                   class="btn btn-success px-4 me-2"
                                                                   <?php echo e($isPatientSelected ? 'disabled' : ''); ?>>
                                 <i class="fas fa-save me-1"></i> 
                                 <?php echo e($isPatientSelected ? 'Save (Disabled - Patient Selected)' : 'Save'); ?>

                             </button>
                                                           
                                                           <button type="button" wire:click="resetForm" 
                                                                   class="btn btn-warning px-4 me-2">
                                 <i class="fas fa-redo me-1"></i> Reset Form
                             </button>
                                                           
                                                           <a href="<?php echo e(route('admin.patients.index')); ?>" class="btn btn-secondary px-4">
                                 <i class="fas fa-times me-1"></i> Exit
                             </a>
                         </div>
                     </div>
                </form>
            </div>
        </div>
    </div>


     
                       


</div>

 <?php /**PATH C:\Users\aioli\Herd\diagnostic\resources\views/livewire/patient-registration.blade.php ENDPATH**/ ?>