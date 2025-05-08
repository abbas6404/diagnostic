<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
} 