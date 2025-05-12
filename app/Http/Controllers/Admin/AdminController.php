<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware('permission:access admin dashboard');
    }
    
    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        // Get counts for stats
        $stats = [
            'users' => User::count(),
            'roles' => Role::count(),
            'permissions' => Permission::count(),
        ];
        
        // Get users registered in the last 7 days
        $lastWeekUsers = User::where('created_at', '>=', Carbon::now()->subDays(7))
            ->count();
        
        // Get users by role
        $usersByRole = Role::withCount('users')->get();
        
        // Recent users
        $recentUsers = User::with('roles')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Get system activity (just a placeholder - in a real app you'd have an activity log)
        $activities = [
            [
                'user' => 'System',
                'action' => 'System started',
                'time' => Carbon::now()->subDays(1)->format('Y-m-d H:i:s'),
                'icon' => 'fa-server',
                'color' => 'success'
            ],
            [
                'user' => 'Admin',
                'action' => 'Created new role',
                'time' => Carbon::now()->subHours(5)->format('Y-m-d H:i:s'),
                'icon' => 'fa-user-tag',
                'color' => 'primary'
            ],
            [
                'user' => 'Admin',
                'action' => 'Updated permissions',
                'time' => Carbon::now()->subHours(3)->format('Y-m-d H:i:s'),
                'icon' => 'fa-key',
                'color' => 'warning'
            ],
            [
                'user' => 'System',
                'action' => 'Backup completed',
                'time' => Carbon::now()->subMinutes(45)->format('Y-m-d H:i:s'),
                'icon' => 'fa-database',
                'color' => 'info'
            ],
        ];
        
        return view('admin.dashboard', compact(
            'stats', 
            'lastWeekUsers', 
            'usersByRole', 
            'recentUsers', 
            'activities'
        ));
    }

    /**
     * Show the password change form
     */
    public function showChangePasswordForm()
    {
        return view('admin.profile.change-password');
    }
    
    /**
     * Update the admin's password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail('The current password is incorrect.');
                }
            }],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'different:current_password'],
        ]);
        
        // Update password
        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);
        
        return redirect()->route('admin.profile.password')
            ->with('success', 'Password updated successfully.');
    }
} 