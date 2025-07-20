<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\DiagnosticsController;
use App\Http\Controllers\Admin\OpdController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\HospitalController;
use App\Http\Controllers\Admin\LaboratoryController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" and "auth" middleware group.
|
*/

// Admin Dashboard - accessible to anyone with admin dashboard access
Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

// Patient Registration routes
Route::prefix('registration')->group(function () {
    // New Patient
    Route::get('/new-patient', [PatientController::class, 'newPatient'])->name('patients.new');
    
    // Patient List
    Route::get('/patients', [PatientController::class, 'patientList'])->name('patients.list');
});

// Hospital routes
Route::prefix('hospital')->group(function () {
    // Admission
    Route::get('/admission', [HospitalController::class, 'admission'])->name('hospital.admission');
    
    // Bed Management
    Route::get('/bed-management', [HospitalController::class, 'bedManagement'])->name('hospital.bed-management');
    
    // Bed Change
    Route::get('/bed-change', [HospitalController::class, 'bedChange'])->name('hospital.bed-change');
    
    // Discharge
    Route::get('/discharge', [HospitalController::class, 'discharge'])->name('hospital.discharge');
    
    // Advance Collection
    Route::get('/advance-collection', [HospitalController::class, 'advanceCollection'])->name('hospital.advance-collection');
    
    // Procedure Entry
    Route::get('/procedure-entry', [HospitalController::class, 'procedureEntry'])->name('hospital.procedure-entry');
    
    // Due Collection
    Route::get('/due-collection', [HospitalController::class, 'dueCollection'])->name('hospital.due-collection');
});

// Laboratory routes
Route::prefix('laboratory')->group(function () {
    // Test Results
    Route::get('/test-results', [LaboratoryController::class, 'testResults'])->name('laboratory.test-results');
    
    // Sample Collection
    Route::get('/sample-collection', [LaboratoryController::class, 'sampleCollection'])->name('laboratory.sample-collection');
    
    // Lab Equipment
    Route::get('/lab-equipment', [LaboratoryController::class, 'labEquipment'])->name('laboratory.lab-equipment');
});

// Diagnostics routes
Route::prefix('diagnostics')->group(function () {
    // Invoice
    Route::get('/invoice', [DiagnosticsController::class, 'invoice'])->name('diagnostics.invoice');
    
    // Invoice Return
    Route::get('/invoice-return', [DiagnosticsController::class, 'invoiceReturn'])->name('diagnostics.invoice-return');
    
    // Due Collection
    Route::get('/due-collection', [DiagnosticsController::class, 'dueCollection'])->name('diagnostics.due-collection');
    
    // Re-Print
    Route::get('/re-print', [DiagnosticsController::class, 'rePrint'])->name('diagnostics.re-print');
    
    // Report
    Route::get('/report', [DiagnosticsController::class, 'report'])->name('diagnostics.report');
});

// OPD routes
Route::prefix('opd')->group(function () {
    // Invoice
    Route::get('/invoice', [OpdController::class, 'invoice'])->name('opd.invoice');
    
    // Due Collection
    Route::get('/due-collection', [OpdController::class, 'dueCollection'])->name('opd.due-collection');
    
    // Re-Print
    Route::get('/re-print', [OpdController::class, 'rePrint'])->name('opd.re-print');
});

// Doctor/Consultant routes
Route::prefix('doctor')->group(function () {
    // Invoice
    Route::get('/invoice', [DoctorController::class, 'invoice'])->name('doctor.invoice');
    
    // Due Collection
    Route::get('/due-collection', [DoctorController::class, 'dueCollection'])->name('doctor.due-collection');
    
    // Report
    Route::get('/report', [DoctorController::class, 'report'])->name('doctor.report');
});

// Role routes - protected by permissions
Route::get('/roles', [RolePermissionController::class, 'roles'])
    ->middleware('permission:view roles')
    ->name('roles.index');
    
Route::get('/roles/create', [RolePermissionController::class, 'createRole'])
    ->middleware('permission:create roles')
    ->name('roles.create');
    
Route::post('/roles', [RolePermissionController::class, 'storeRole'])
    ->middleware('permission:create roles')
    ->name('roles.store');
    
Route::get('/roles/{role}/edit', [RolePermissionController::class, 'editRole'])
    ->middleware('permission:edit roles')
    ->name('roles.edit');
    
Route::put('/roles/{role}', [RolePermissionController::class, 'updateRole'])
    ->middleware('permission:edit roles')
    ->name('roles.update');
    
Route::delete('/roles/{role}', [RolePermissionController::class, 'destroyRole'])
    ->middleware('permission:delete roles')
    ->name('roles.destroy');

// Permission routes - protected by permissions
Route::get('/permissions', [PermissionController::class, 'index'])
    ->middleware('permission:view permissions')
    ->name('permissions.index');

Route::get('/permissions/create', [PermissionController::class, 'create'])
    ->middleware('permission:assign permissions')
    ->name('permissions.create');

Route::post('/permissions', [PermissionController::class, 'store'])
    ->middleware('permission:assign permissions')
    ->name('permissions.store');

Route::get('/permissions/{permission}', [PermissionController::class, 'show'])
    ->middleware('permission:view permissions')
    ->name('permissions.show');

Route::get('/permissions/{permission}/edit', [PermissionController::class, 'edit'])
    ->middleware('permission:assign permissions')
    ->name('permissions.edit');

Route::put('/permissions/{permission}', [PermissionController::class, 'update'])
    ->middleware('permission:assign permissions')
    ->name('permissions.update');

Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])
    ->middleware('permission:assign permissions')
    ->name('permissions.destroy');

// User management routes - protected by permissions
Route::group(['middleware' => 'permission:view users'], function() {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
});

Route::group(['middleware' => 'permission:create users'], function() {
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
});

Route::group(['middleware' => 'permission:edit users'], function() {
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
});

Route::delete('/users/{user}', [UserController::class, 'destroy'])
    ->middleware('permission:delete users')
    ->name('users.destroy');

// Reports route with permission middleware
Route::get('/reports', function() {
    return view('admin.reports');
})->middleware(['permission:view reports'])->name('reports');

// Settings routes - protected by permissions
Route::group(['middleware' => 'permission:manage settings', 'prefix' => 'settings'], function() {
    Route::get('/', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::post('/general', [App\Http\Controllers\Admin\SettingsController::class, 'updateGeneral'])->name('settings.update.general');
    Route::post('/security', [App\Http\Controllers\Admin\SettingsController::class, 'updateSecurity'])->name('settings.update.security');
    Route::post('/email', [App\Http\Controllers\Admin\SettingsController::class, 'updateEmail'])->name('settings.update.email');
    Route::post('/email/test', [App\Http\Controllers\Admin\SettingsController::class, 'sendTestEmail'])->name('settings.email.test');
});

// Admin Profile routes
Route::get('/profile/password', [AdminController::class, 'showChangePasswordForm'])->name('profile.password');
Route::put('/profile/password', [AdminController::class, 'updatePassword'])->name('profile.password.update'); 