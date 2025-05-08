<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Dashboard
Route::get('/dashboard', [HomeController::class, 'dashboard'])
    ->middleware(['auth'])
    ->name('dashboard');

// Admin routes with auth middleware
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Role routes
    Route::get('/roles', [RolePermissionController::class, 'roles'])->name('roles.index');
    Route::get('/roles/create', [RolePermissionController::class, 'createRole'])->name('roles.create');
    Route::post('/roles', [RolePermissionController::class, 'storeRole'])->name('roles.store');
    Route::get('/roles/{role}/edit', [RolePermissionController::class, 'editRole'])->name('roles.edit');
    Route::put('/roles/{role}', [RolePermissionController::class, 'updateRole'])->name('roles.update');
    Route::delete('/roles/{role}', [RolePermissionController::class, 'destroyRole'])->name('roles.destroy');
    
    // Permission routes
    Route::resource('permissions', PermissionController::class);
    
    // User management routes
    Route::resource('users', UserController::class);
});

// Example of route with permission middleware
Route::get('/admin/reports', function() {
    return view('admin.reports');
})->middleware(['auth', 'permission:view reports'])->name('admin.reports');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
