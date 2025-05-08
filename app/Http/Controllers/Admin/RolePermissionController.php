<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RolePermissionController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the roles.
     */
    public function roles()
    {
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }
    
    /**
     * Show the form for creating a new role.
     */
    public function createRole()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }
    
    /**
     * Store a newly created role in storage.
     */
    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name',
            'permissions' => 'array',
        ]);
        
        $role = Role::create(['name' => $request->name]);
        
        if ($request->has('permissions')) {
            // Get Permission objects from their IDs
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);
        }
        
        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully');
    }
    
    /**
     * Show the form for editing the specified role.
     */
    public function editRole(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        
        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }
    
    /**
     * Update the specified role in storage.
     */
    public function updateRole(Request $request, Role $role)
    {
        // Debug the request data
        Log::info('Role Update Request', [
            'role_name' => $role->name,
            'permissions' => $request->permissions,
            'all_data' => $request->all()
        ]);
        
        $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
            'permissions' => 'array',
        ]);
        
        // For system roles like Super Admin and Admin, ensure name doesn't change
        if ($role->name === 'Super Admin' || $role->name === 'Admin') {
            // Don't update the name for system roles
        } else {
            $role->update(['name' => $request->name]);
        }
        
        // Special handling for Super Admin role
        if ($role->name === 'Super Admin') {
            // Super Admin always has all permissions
            $role->syncPermissions(Permission::all());
        } else {
            // For all other roles including Admin
            if ($request->has('permissions')) {
                // Get Permission objects from their IDs
                $permissions = Permission::whereIn('id', $request->permissions)->get();
                
                // Debug the permissions being assigned
                Log::info('Role Permission Sync', [
                    'role_name' => $role->name,
                    'permission_ids' => $request->permissions,
                    'permission_count' => $permissions->count(),
                    'permission_names' => $permissions->pluck('name')
                ]);
                
                $role->syncPermissions($permissions);
            } else {
                $role->syncPermissions([]);
            }
        }
        
        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully');
    }
    
    /**
     * Remove the specified role from storage.
     */
    public function destroyRole(Role $role)
    {
        if ($role->name === 'Super Admin') {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Cannot delete Super Admin role');
        }
        
        $role->delete();
        
        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully');
    }
    
    /**
     * Display a listing of the permissions.
     */
    public function permissions()
    {
        $permissions = Permission::all();
        return view('admin.permissions.index', compact('permissions'));
    }
    
    /**
     * Show the form for creating a new permission.
     */
    public function createPermission()
    {
        return view('admin.permissions.create');
    }
    
    /**
     * Store a newly created permission in storage.
     */
    public function storePermission(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name',
        ]);
        
        Permission::create(['name' => $request->name]);
        
        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission created successfully');
    }
    
    /**
     * Display a listing of users with their roles.
     */
    public function users()
    {
        $users = User::with('roles')->get();
        return view('admin.users.index', compact('users'));
    }
    
    /**
     * Show the form for editing user roles.
     */
    public function editUserRoles(User $user)
    {
        $roles = Role::all();
        $userRoles = $user->roles->pluck('id')->toArray();
        
        return view('admin.users.edit', compact('user', 'roles', 'userRoles'));
    }
    
    /**
     * Update user roles.
     */
    public function updateUserRoles(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'array',
        ]);
        
        if ($request->has('roles')) {
            // Get Role objects from their IDs
            $roles = Role::whereIn('id', $request->roles)->get();
            $user->syncRoles($roles);
        } else {
            $user->syncRoles([]);
        }
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User roles updated successfully');
    }
}
