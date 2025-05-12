<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Check if the current user has a specific permission
     * 
     * @param string $permission
     * @return bool
     */
    private function userHasPermission($permission)
    {
        $userId = Auth::id();
        
        // Check direct permissions
        $hasDirectPermission = DB::table('model_has_permissions')
            ->join('permissions', 'model_has_permissions.permission_id', '=', 'permissions.id')
            ->where('model_has_permissions.model_id', $userId)
            ->where('model_has_permissions.model_type', User::class)
            ->where('permissions.name', $permission)
            ->exists();
            
        if ($hasDirectPermission) {
            return true;
        }
        
        // Check permissions via roles
        $hasRolePermission = DB::table('model_has_roles')
            ->join('role_has_permissions', 'model_has_roles.role_id', '=', 'role_has_permissions.role_id')
            ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->where('model_has_roles.model_id', $userId)
            ->where('model_has_roles.model_type', User::class)
            ->where('permissions.name', $permission)
            ->exists();
            
        return $hasRolePermission;
    }

    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::with('roles')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        // Check if user has permission to assign roles
        if (!$this->userHasPermission('assign permissions')) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You do not have permission to create users with roles.');
        }
        
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        // Check if user has permission to assign roles
        if (!$this->userHasPermission('assign permissions')) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You do not have permission to assign roles.');
        }
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Password::defaults()],
            'roles' => ['required', 'array'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Convert role IDs to integers and retrieve role names or objects
        $roles = Role::whereIn('id', array_map('intval', $request->roles))->get();
        $user->syncRoles($roles);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        // Get all roles
        $roles = Role::all();
        $userRoles = $user->roles->pluck('id')->toArray();
        
        // Check if current user can assign permissions
        $canAssignRoles = $this->userHasPermission('assign permissions');
        
        return view('admin.users.edit', compact('user', 'roles', 'userRoles', 'canAssignRoles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
        ];
        
        // Only require roles if user has permission to assign them
        if ($this->userHasPermission('assign permissions')) {
            $rules['roles'] = ['required', 'array'];
        }

        // Password is optional on update
        if ($request->filled('password')) {
            $rules['password'] = Password::defaults();
        }

        $request->validate($rules);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // Only update roles if user has permission to assign them
        if ($this->userHasPermission('assign permissions') && $request->has('roles')) {
            // Convert role IDs to integers and retrieve role names or objects
            $roles = Role::whereIn('id', array_map('intval', $request->roles))->get();
            $user->syncRoles($roles);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting self
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        // Check if user is Super Admin
        $isSuperAdmin = DB::table('model_has_roles')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('model_has_roles.model_id', $user->id)
            ->where('model_has_roles.model_type', User::class)
            ->where('roles.name', 'Super Admin')
            ->exists();

        // Prevent deleting the original super admin
        if ($isSuperAdmin && $user->email === 'superadmin@example.com') {
            return back()->with('error', 'Cannot delete the system Super Admin account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
} 