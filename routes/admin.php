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
use App\Http\Controllers\Admin\InvestigationReportController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\Setup\SetupController;
use App\Http\Controllers\Admin\Setup\OverviewController;
use App\Http\Controllers\Admin\Setup\PrefixSetupController;
use App\Http\Controllers\Admin\Setup\DepartmentController;
use App\Http\Controllers\Admin\Setup\LabTestController;
use App\Http\Controllers\Admin\Setup\CollectionKitController;
use App\Http\Controllers\Admin\Setup\OpdServiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    Route::get('/', [PatientController::class, 'index'])->name('patients.index');  
    Route::get('/create', [PatientController::class, 'create'])->name('patients.create');
    Route::get('/show/{id}', [PatientController::class, 'show'])->name('patients.show');
    Route::get('/edit/{id}', [PatientController::class, 'edit'])->name('patients.edit');
    Route::put('/update/{id}', [PatientController::class, 'update'])->name('patients.update');
    Route::delete('/delete/{id}', [PatientController::class, 'destroy'])->name('patients.destroy');
    Route::post('/restore/{id}', [PatientController::class, 'restore'])->name('patients.restore');
    
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
    Route::get('/invoice-return/search', [DiagnosticsController::class, 'searchInvoicesForReturn'])->name('diagnostics.invoice-return.search');
    Route::get('/invoice-return/invoice/{invoiceId}/details', [DiagnosticsController::class, 'getInvoiceDetailsForReturn'])->name('diagnostics.invoice-return.invoice.details');
    Route::get('/invoice-return/default-invoices', [DiagnosticsController::class, 'getDefaultInvoices'])->name('diagnostics.invoice-return.default');
    
    // Due Collection
    Route::get('/duecollection', [DiagnosticsController::class, 'dueCollection'])->name('diagnostics.duecollection');
    Route::post('/duecollection/store', [DiagnosticsController::class, 'storePayment'])->name('diagnostics.duecollection.store');
    Route::get('/duecollection/patient/{patientId}/invoices', [DiagnosticsController::class, 'getPatientDueInvoices'])->name('diagnostics.duecollection.patient.invoices');
    Route::get('/duecollection/invoice/{invoiceId}/details', [DiagnosticsController::class, 'getInvoiceDetails'])->name('diagnostics.duecollection.invoice.details');
    Route::get('/duecollection/invoice/{invoiceId}/full-data', [DiagnosticsController::class, 'getInvoiceFullData'])->name('diagnostics.duecollection.invoice.full-data');
    
    // Report
    Route::get('/report', [DiagnosticsController::class, 'report'])->name('diagnostics.report');
    // Re-Print
    Route::get('/reprint', [DiagnosticsController::class, 'rePrint'])->name('diagnostics.reprint');
    

    // Diagnostics Re-Print Routes
    Route::get('/reprint/default-invoices', [DiagnosticsController::class, 'getDefaultInvoicesForReprint'])->name('diagnostics.reprint.default');
    Route::get('/reprint/search', [DiagnosticsController::class, 'searchInvoicesForReprint'])->name('diagnostics.reprint.search');
    Route::get('/reprint/invoice/{id}/details', [DiagnosticsController::class, 'getInvoiceDetailsForReprint'])->name('diagnostics.reprint.details');
    Route::post('/reprint/print', [DiagnosticsController::class, 'printInvoice'])->name('diagnostics.reprint.print');
    Route::post('/reprint/print-item', [DiagnosticsController::class, 'printSingleItem'])->name('diagnostics.reprint.print-item');
});

// OPD routes
Route::prefix('opd')->group(function () {
    // Invoice
    Route::get('/invoice', [OpdController::class, 'invoice'])->name('opd.invoice');
    Route::post('/invoice/store', [OpdController::class, 'storeInvoice'])->name('opd.invoice.store');
    
    // Due Collection
    Route::get('/duecollection', [OpdController::class, 'dueCollection'])->name('opd.duecollection');
    Route::post('/duecollection/store', [OpdController::class, 'storePayment'])->name('opd.duecollection.store');
    Route::get('/duecollection/patient/{patientId}/invoices', [OpdController::class, 'getPatientDueInvoices'])->name('opd.duecollection.patient.invoices');
    Route::get('/duecollection/invoice/{invoiceId}/details', [OpdController::class, 'getInvoiceDetails'])->name('opd.duecollection.invoice.details');
    Route::get('/duecollection/invoice/{invoiceId}/full-data', [OpdController::class, 'getInvoiceFullData'])->name('opd.duecollection.invoice.full-data');
    Route::get('/duecollection/invoice/{invoiceId}/payment-history', [OpdController::class, 'getPaymentHistory'])->name('opd.duecollection.invoice.payment-history');
    
    // Re-Print
    Route::get('/reprint', [OpdController::class, 'rePrint'])->name('opd.reprint');
    Route::get('/reprint/default-invoices', [OpdController::class, 'getDefaultInvoicesForReprint'])->name('opd.reprint.default');
    Route::get('/reprint/search', [OpdController::class, 'searchInvoicesForReprint'])->name('opd.reprint.search');
    Route::get('/reprint/invoice/{id}/details', [OpdController::class, 'getInvoiceDetailsForReprint'])->name('opd.reprint.details');
    Route::post('/reprint/print', [OpdController::class, 'printInvoice'])->name('opd.reprint.print');
});

// Doctor/Consultant routes
Route::prefix('doctor')->group(function () {
    // Invoice
    Route::get('/invoice', [DoctorController::class, 'invoice'])->name('doctor.invoice');
    Route::post('/invoice/store', [DoctorController::class, 'storeInvoice'])->name('doctor.invoice.store');
    Route::get('/invoice/doctor-ticket-count', [DoctorController::class, 'getDoctorTicketCount'])->name('doctor.invoice.ticket-count');
 
    // Due Collection
    Route::get('/duecollection', [DoctorController::class, 'dueCollection'])->name('doctor.duecollection');
    
    // Report
    Route::get('/report', [DoctorController::class, 'report'])->name('doctor.report');
    
    // Re-Print
    Route::get('/reprint', [DoctorController::class, 'rePrint'])->name('doctor.reprint');
  
});

// AJAX Search endpoints are no longer needed as we're using Livewire components
// Route::prefix('search')->group(function () {
//     Route::get('/doctor', [SearchController::class, 'doctors'])->name('search.doctor');
//     Route::get('/pcp', [SearchController::class, 'pcps'])->name('search.pcp');
//     Route::get('/patient', [SearchController::class, 'patients'])->name('search.patient');
// });

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
});

// Invoice Templates routes
Route::group(['prefix' => 'invoice-templates'], function() {
    Route::get('/', [App\Http\Controllers\Admin\InvoiceTemplateController::class, 'index'])->name('admin.invoice-templates.index');
    
    Route::get('/default', [App\Http\Controllers\Admin\InvoiceTemplateController::class, 'showDefault'])->name('admin.invoice-templates.default');
    
    Route::get('/compact', [App\Http\Controllers\Admin\InvoiceTemplateController::class, 'showCompact'])->name('admin.invoice-templates.compact');
    
    Route::get('/professional', [App\Http\Controllers\Admin\InvoiceTemplateController::class, 'showProfessional'])->name('admin.invoice-templates.professional');
    
    Route::get('/receipt', [App\Http\Controllers\Admin\InvoiceTemplateController::class, 'showReceipt'])->name('admin.invoice-templates.receipt');
    
    Route::get('/laboratory', [App\Http\Controllers\Admin\InvoiceTemplateController::class, 'showLaboratory'])->name('admin.invoice-templates.laboratory');
    
    Route::get('/test', [App\Http\Controllers\Admin\InvoiceTemplateController::class, 'showTest'])->name('admin.invoice-templates.test');
    
    Route::get('/doctor-consultant', [App\Http\Controllers\Admin\InvoiceTemplateController::class, 'showDoctorConsultant'])->name('admin.invoice-templates.doctor-consultant');
    
    Route::get('/due-collection', [App\Http\Controllers\Admin\InvoiceTemplateController::class, 'showDueCollection'])->name('admin.invoice-templates.due-collection');

    // API routes for invoice data
    Route::get('/invoice-data/{invoiceId}', [App\Http\Controllers\Admin\InvoiceTemplateController::class, 'getInvoiceData'])->name('admin.invoice-templates.invoice-data');
    
    Route::post('/print', [App\Http\Controllers\Admin\InvoiceTemplateController::class, 'printInvoice'])->name('admin.invoice-templates.print');
});

// Settings routes - protected by permissions
Route::group(['middleware' => 'permission:manage settings', 'prefix' => 'settings'], function() {
    Route::post('/email', [App\Http\Controllers\Admin\SettingsController::class, 'updateEmail'])->name('settings.update.email');
    Route::post('/email/test', [App\Http\Controllers\Admin\SettingsController::class, 'sendTestEmail'])->name('settings.email.test');
});

// Admin Profile routes
Route::get('/profile', [AdminController::class, 'showProfile'])->name('profile.index');
Route::put('/profile', [AdminController::class, 'updateProfile'])->name('profile.update');
Route::get('/profile/password', [AdminController::class, 'showChangePasswordForm'])->name('profile.password');
Route::put('/profile/password', [AdminController::class, 'updatePassword'])->name('profile.password.update'); 



// Setup routes - protected by permissions
Route::group(['middleware' => 'permission:manage settings', 'prefix' => 'setup'], function() {
    Route::get('/', [SetupController::class, 'index'])->name('setup.index');
});

// Overview routes - protected by permissions
Route::group(['middleware' => 'permission:manage settings', 'prefix' => 'setup/overview'], function() {
    Route::get('/', [OverviewController::class, 'index'])->name('setup.overview.index');
    Route::post('/check-updates', [OverviewController::class, 'checkUpdates'])->name('setup.overview.check-updates');
    Route::post('/perform-update', [OverviewController::class, 'performUpdate'])->name('setup.overview.perform-update');
    Route::post('/clear-cache', [OverviewController::class, 'clearCache'])->name('setup.overview.clear-cache');
    Route::post('/optimize-system', [OverviewController::class, 'optimizeSystem'])->name('setup.overview.optimize-system');
});

    // Prefix Setup Routes
    Route::prefix('setup/prefix')->name('setup.prefix.')->group(function () {
        Route::get('/', [PrefixSetupController::class, 'index'])->name('index');
        Route::post('/save-settings', [PrefixSetupController::class, 'saveSettings'])->name('save-settings');
        Route::post('/reset', [PrefixSetupController::class, 'resetPrefixes'])->name('reset');
        Route::get('/export', [PrefixSetupController::class, 'exportSettings'])->name('export');
        Route::post('/import', [PrefixSetupController::class, 'importSettings'])->name('import');
    });

    // Department Routes
    Route::prefix('setup/department')->name('setup.department.')->group(function () {
        Route::get('/', [DepartmentController::class, 'index'])->name('index');
        Route::get('/create', [DepartmentController::class, 'create'])->name('create');
        Route::post('/', [DepartmentController::class, 'store'])->name('store');
        Route::get('/{department}', [DepartmentController::class, 'show'])->name('show');
        Route::get('/{department}/edit', [DepartmentController::class, 'edit'])->name('edit');
        Route::put('/{department}', [DepartmentController::class, 'update'])->name('update');
        Route::delete('/{department}', [DepartmentController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [DepartmentController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [DepartmentController::class, 'forceDelete'])->name('force-delete');
    });

    // Lab Test Routes
    Route::prefix('setup/lab-test')->name('setup.lab-test.')->group(function () {
        Route::get('/', [LabTestController::class, 'index'])->name('index');
        Route::get('/create', [LabTestController::class, 'create'])->name('create');
        Route::post('/', [LabTestController::class, 'store'])->name('store');
        Route::get('/{labTest}', [LabTestController::class, 'show'])->name('show');
        Route::get('/{labTest}/edit', [LabTestController::class, 'edit'])->name('edit');
        Route::put('/{labTest}', [LabTestController::class, 'update'])->name('update');
        Route::delete('/{labTest}', [LabTestController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [LabTestController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [LabTestController::class, 'forceDelete'])->name('force-delete');
    });

    // Collection Kit Routes
    Route::prefix('setup/collection-kit')->name('setup.collection-kit.')->group(function () {
        Route::get('/', [CollectionKitController::class, 'index'])->name('index');
        Route::get('/create', [CollectionKitController::class, 'create'])->name('create');
        Route::post('/', [CollectionKitController::class, 'store'])->name('store');
        Route::get('/{collectionKit}', [CollectionKitController::class, 'show'])->name('show');
        Route::get('/{collectionKit}/edit', [CollectionKitController::class, 'edit'])->name('edit');
        Route::put('/{collectionKit}', [CollectionKitController::class, 'update'])->name('update');
        Route::delete('/{collectionKit}', [CollectionKitController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [CollectionKitController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [CollectionKitController::class, 'forceDelete'])->name('force-delete');
    });

    // OPD Service Routes
    Route::prefix('setup/opd-service')->name('setup.opd-service.')->group(function () {
        Route::get('/', [OpdServiceController::class, 'index'])->name('index');
        Route::get('/create', [OpdServiceController::class, 'create'])->name('create');
        Route::post('/', [OpdServiceController::class, 'store'])->name('store');
        Route::get('/{opdService}', [OpdServiceController::class, 'show'])->name('show');
        Route::get('/{opdService}/edit', [OpdServiceController::class, 'edit'])->name('edit');
        Route::put('/{opdService}', [OpdServiceController::class, 'update'])->name('update');
        Route::delete('/{opdService}', [OpdServiceController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/restore', [OpdServiceController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [OpdServiceController::class, 'forceDelete'])->name('force-delete');
    }); 

    // Investigation Reporting Routes
    Route::prefix('investigation-reporting')->name('investigation-reporting.')->group(function () {
        // Main Reporting Page (Livewire Component)
        Route::get('/all-reporting', [InvestigationReportController::class, 'testReporting'])->name('all-reporting');
        // Print Report Route
        Route::get('/print/{invoiceId}', [InvestigationReportController::class, 'printReport'])->name('print-report');
    }); 