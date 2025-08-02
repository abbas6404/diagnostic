<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LabTestResult;
use App\Models\LabTest;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;

class InvestigationReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'permission:access admin dashboard']);
    }

    /**
     * Display the lab reporting page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function testReporting()
    {
        $departments = Department::where('status', 'active')->get();
        
        // Get logged-in user's department
        $userDepartmentId = Auth::user()->department_id;
        
        return view('admin.investigation-reports.reporting.index', compact('departments', 'userDepartmentId'));
    }




}