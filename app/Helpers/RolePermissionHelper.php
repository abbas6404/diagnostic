<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class RolePermissionHelper
{
    /**
     * Check if the current user has a specific role
     *
     * @param string|array $roles
     * @return bool
     */
    public static function hasRole($roles): bool
    {
        if (!Auth::check()) {
            return false;
        }
        
        return Auth::user()->hasRole($roles);
    }
    
    /**
     * Check if the current user has any of the given roles
     *
     * @param array $roles
     * @return bool
     */
    public static function hasAnyRole(array $roles): bool
    {
        if (!Auth::check()) {
            return false;
        }
        
        return Auth::user()->hasAnyRole($roles);
    }
    
    /**
     * Check if the current user has all of the given roles
     *
     * @param array $roles
     * @return bool
     */
    public static function hasAllRoles(array $roles): bool
    {
        if (!Auth::check()) {
            return false;
        }
        
        return Auth::user()->hasAllRoles($roles);
    }
    
    /**
     * Check if the current user has a specific permission
     *
     * @param string|array $permissions
     * @return bool
     */
    public static function hasPermission($permissions): bool
    {
        if (!Auth::check()) {
            return false;
        }
        
        return Auth::user()->hasPermissionTo($permissions);
    }
    
    /**
     * Check if the current user has any of the given permissions
     *
     * @param array $permissions
     * @return bool
     */
    public static function hasAnyPermission(array $permissions): bool
    {
        if (!Auth::check()) {
            return false;
        }
        
        return Auth::user()->hasAnyPermission($permissions);
    }
    
    /**
     * Get all roles of the current user
     *
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public static function getUserRoles()
    {
        if (!Auth::check()) {
            return collect();
        }
        
        return Auth::user()->roles;
    }
    
    /**
     * Get all permissions of the current user
     *
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public static function getUserPermissions()
    {
        if (!Auth::check()) {
            return collect();
        }
        
        return Auth::user()->getAllPermissions();
    }
} 