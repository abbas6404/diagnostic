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

    /**
     * Show the profile page
     */
    public function showProfile()
    {
        return view('admin.profile.index');
    }

    /**
     * Update the admin's profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'zip' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo_path && file_exists(storage_path('app/public/' . $user->profile_photo_path))) {
                unlink(storage_path('app/public/' . $user->profile_photo_path));
            }
            
            // Store new photo
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
        }

        // Update user data
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => $request->country,
        ]);

        return redirect()->route('admin.profile.index')
            ->with('success', 'Profile updated successfully.');
    }
} 