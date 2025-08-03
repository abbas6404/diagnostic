<div>
    <div class="container-fluid">
        <div class="card shadow">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 text-primary">
                        <i class="fas fa-user-plus me-2"></i> Patient's Registration
                    </h5>
                    <a href="{{ route('admin.patients.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-th-list me-1"></i> Patient List
                    </a>
                </div>
            </div>
            <div class="card-body">
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
                                            <input type="hidden" wire:model="patient_id_hidden">
                                        </div>
                                    </div>
                                </div>

                                   <!-- Row 1 -->
                                <div class="col-md-5">
                                    <div class="row align-items-center">
                                        <label for="reg_date" class="col-4 col-form-label">Reg. Date:</label>
                                        <div class="col-8">
                                                                                         <input type="date" class="form-control" id="reg_date" wire:model="reg_date">
                                            @error('reg_date') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Row 2 -->
                                <div class="col-md-12">
                                    <div class="row align-items-center">
                                        <label for="name_en" class="col-2 col-form-label">Name(Eng): <span class="text-danger">*</span></label>
                                        <div class="col-10">
                                                                                         <input type="text" class="form-control" id="name_en" wire:model="name_en" 
                                                    placeholder="Name (English)" required>
                                            @error('name_en') <span class="text-danger">{{ $message }}</span> @enderror
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
                                            @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Row 7 -->
                                <div class="col-md-6">
                                    <div class="row align-items-center">
                                        <label for="phone" class="col-4 col-form-label">Contact: <span class="text-danger">*</span></label>
                                        <div class="col-8">
                                                                                         <input type="text" class="form-control" id="phone" wire:model="phone" 
                                                    placeholder="Contact No" value="+880" required>
                                            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Row 8 -->
                                <div class="col-md-6">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <div class="form-check">
                                                                                                 <input class="form-check-input" type="checkbox" id="original_dob" 
                                                        wire:model="original_dob">
                                                <label class="form-check-label text-success" for="original_dob">
                                                    Original DOB
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-8">
                                                                                         <input type="date" class="form-control" id="dob" wire:model="dob">
                                            @error('dob') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="row align-items-center">
                                        <label for="age_year" class="col-4 col-form-label">Age:</label>
                                        <div class="col-8">
                                            <div class="row g-1">
                                                <div class="col-4">
                                                                                                         <input type="number" class="form-control text-center" id="age_year" 
                                                            wire:model="age_year" placeholder="Y" min="0" max="150">
                                                    @error('age_year') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                                <div class="col-4">
                                                                                                         <input type="number" class="form-control text-center" id="age_month" 
                                                            wire:model="age_month" placeholder="M" min="0" max="12">
                                                    @error('age_month') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                                <div class="col-4">
                                                                                                         <input type="number" class="form-control text-center" id="age_day" 
                                                            wire:model="age_day" placeholder="D" min="0" max="31">
                                                    @error('age_day') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                                                 <!-- Row 9 -->
                                 <div class="col-md-6">
                                     <div class="row align-items-center">
                                         <label for="gender" class="col-4 col-form-label">Sex: </label>
                                                                                   <div class="col-8">
                                              <button type="button" wire:click="toggleSexOptions" class="form-control text-start" style="height: 38px; border: 1px solid #ced4da; background-color: #f8f9fa; color: #495057;">
                                                  {{ $gender ?: 'Click to select sex' }}
                                              </button>
                                              <input type="hidden" id="gender" wire:model="gender">
                                              @error('gender') <span class="text-danger">{{ $message }}</span> @enderror
                                          </div>
                                     </div>
                                 </div>
                                
                                                                 <div class="col-md-6">
                                     <div class="row align-items-center">
                                         <label for="blood_group" class="col-4 col-form-label">Blood: </label>
                                                                                                                                                                       <div class="col-8">
                                              <button type="button" wire:click="toggleBloodGroups" class="form-control text-start" style="height: 38px; border: 1px solid #ced4da; background-color: #f8f9fa; color: #495057;">
                                                  {{ $blood_group ?: 'Click to select blood group' }}
                                              </button>
                                              <input type="hidden" id="blood_group" wire:model="blood_group">
                                              @error('blood_group') <span class="text-danger">{{ $message }}</span> @enderror
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
                                            @error('reg_fee') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                                                 <!-- Right Column - Search Results & Blood Groups -->
                         <div class="col-lg-5">
                             <!-- Search Results Area -->
                             @if($showSearchResults)
                                 <div class="card border mb-3" id="search-results-container">
                                     <div class="card-header bg-primary text-white py-2">
                                         <h6 class="mb-0"><i class="fas fa-search me-1"></i> Search Results</h6>
                                     </div>
                                     <div class="card-body p-0" style="height: 400px; overflow-y: auto;" id="search-results-body">
                                         @if(count($searchResults) > 0)
                                             <div class="list-group list-group-flush">
                                                 @foreach($searchResults as $patient)
                                                     <div class="list-group-item list-group-item-action search-item" 
                                                          wire:click="selectPatient({{ $patient->id }})" 
                                                          style="cursor: pointer;">
                                                         <div class="d-flex justify-content-between align-items-start">
                                                             <div>
                                                                 <h6 class="mb-1">{{ $patient->name_en ?? $patient->name_bn ?? 'Unknown' }}</h6>
                                                                 <small class="text-muted">{{ $patient->phone }}</small>
                                                             </div>
                                                             <div class="text-end">
                                                                 <small class="text-primary">{{ $patient->patient_id }}</small>
                                                                 @if($patient->address)
                                                                     <small class="text-muted d-block">{{ $patient->address }}</small>
                                                                 @endif
                                                             </div>
                                                         </div>
                                                     </div>
                                                 @endforeach
                                             </div>
                                         @else
                                             <div class="text-center py-4">
                                                 <i class="fas fa-search text-muted fa-2x mb-2"></i>
                                                 <p class="text-muted">No patients found</p>
                                             </div>
                                         @endif
                                     </div>
                                 </div>
                             @endif
                             
                                                           <!-- Blood Groups Area -->
                              @if($showBloodGroups)
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
                              @endif
                              
                              <!-- Sex Options Area -->
                              @if($showSexOptions)
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
                              @endif
                             
                                                           <!-- Default State -->
                              @if(!$showSearchResults && !$showBloodGroups && !$showSexOptions)
                                 <div class="card border mb-3">
                                     <div class="card-header bg-info text-white py-2">
                                         <h6 class="mb-0"><i class="fas fa-info-circle me-1"></i> Information</h6>
                                     </div>
                                     <div class="card-body text-center py-4">
                                         <i class="fas fa-user-plus text-muted fa-2x mb-2"></i>
                                                                                   <p class="text-muted">Showing 20 most recent patients. Search for specific patients or focus on blood group/sex fields</p>
                                     </div>
                                 </div>
                             @endif
                         </div>
                    </div>

                                         <div class="row mt-4">
                         <div class="col-12 text-center">
                                                           
                                                           <button type="submit" class="btn btn-success px-4 me-2">
                                 <i class="fas fa-save me-1"></i> Save
                             </button>
                                                           <a href="{{ route('admin.patients.index') }}" class="btn btn-secondary px-4">
                                 <i class="fas fa-times me-1"></i> Exit
                             </a>
                         </div>
                     </div>
                </form>
            </div>
        </div>
    </div>

    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

         @if(session()->has('error'))
         <div class="alert alert-danger alert-dismissible fade show" role="alert">
             {{ session('error') }}
             <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
         </div>
     @endif
     
                       


</div> 