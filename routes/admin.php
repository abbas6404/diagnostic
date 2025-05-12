<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\UserController;

// Admin Dashboard - accessible to anyone with admin dashboard access
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

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