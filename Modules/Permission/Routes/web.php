<?php

use Modules\Permission\Controllers\PermissionController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
    
    // Only superadmin can access permission management
    Route::middleware(['ensure.superadmin'])->group(function () {
        Route::get('/permissions', [PermissionController::class, 'index'])
            ->name('admin.permissions.index');
        
        Route::post('/permissions/assign', [PermissionController::class, 'assign'])
            ->name('admin.permissions.assign');
            
        Route::post('/permissions/bulk-assign', [PermissionController::class, 'bulkAssign'])
            ->name('admin.permissions.bulk-assign');
            
        Route::get('/permissions/admin-permissions', [PermissionController::class, 'getAdminPermissions'])
            ->name('admin.permissions.get-admin-permissions');
    });
});