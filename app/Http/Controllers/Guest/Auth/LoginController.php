<?php

namespace App\Http\Controllers\Guest\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login based on their role.
     *
     * @return string
     */
    protected function redirectTo()
    {
        $user = Auth::user();
        
        if (!$user) {
            return route('dashboard');
        }
        
        // Check if user has permission to access admin dashboard
        $adminPermission = Permission::where('name', 'access admin dashboard')->first();
        
        if ($adminPermission) {
            // Check direct permissions
            $hasDirectPermission = DB::table('model_has_permissions')
                ->where('permission_id', $adminPermission->id)
                ->where('model_id', $user->id)
                ->where('model_type', get_class($user))
                ->exists();
                
            if ($hasDirectPermission) {
                return route('admin.dashboard');
            }
            
            // Check role permissions
            $permissionRoles = DB::table('role_has_permissions')
                ->where('permission_id', $adminPermission->id)
                ->pluck('role_id')
                ->toArray();
                
            if (!empty($permissionRoles)) {
                $hasRoleWithPermission = DB::table('model_has_roles')
                    ->where('model_id', $user->id)
                    ->where('model_type', get_class($user))
                    ->whereIn('role_id', $permissionRoles)
                    ->exists();
                    
                if ($hasRoleWithPermission) {
                    return route('admin.dashboard');
                }
            }
        }
        
        // All other users go to user dashboard
        return route('dashboard');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('guest.auth.login');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'login';
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $login = $request->input('login');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        
        $request->merge([$field => $login]);
        
        return $this->guard()->attempt(
            [$field => $request->{$field}, 'password' => $request->password],
            $request->filled('remember')
        );
    }
}
