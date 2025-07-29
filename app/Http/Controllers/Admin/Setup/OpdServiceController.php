<?php

namespace App\Http\Controllers\Admin\Setup;

use App\Http\Controllers\Controller;
use App\Models\OpdService;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpdServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $departments = Department::withTrashed()->orderBy('name')->get();
        $selectedDepartment = request('department');
        $filter = request('filter');
        
        // Get all OPD services for counting based on filter
        if ($filter === 'archive') {
            $allOpdServices = OpdService::onlyTrashed()->get();
        } else {
            $allOpdServices = OpdService::whereNull('deleted_at')->get();
        }
        
        // Calculate department counts
        $departmentCounts = [];
        foreach ($departments as $department) {
            $departmentCounts[$department->id] = $allOpdServices->where('department_id', $department->id)->count();
        }
        
        if ($selectedDepartment) {
            if ($filter === 'archive') {
                $opdServices = OpdService::onlyTrashed()
                    ->where('department_id', $selectedDepartment)
                    ->orderBy('deleted_at', 'desc')
                    ->get();
            } else {
                $opdServices = OpdService::whereNull('deleted_at')
                    ->where('department_id', $selectedDepartment)
                    ->orderBy('name')
                    ->get();
            }
        } else {
            if ($filter === 'archive') {
                $opdServices = OpdService::onlyTrashed()
                    ->orderBy('deleted_at', 'desc')
                    ->get();
            } else {
                $opdServices = OpdService::whereNull('deleted_at')
                    ->orderBy('name')
                    ->get();
            }
        }
        
        // Get counts for filter tabs
        $activeCount = OpdService::whereNull('deleted_at')->count();
        $archiveCount = OpdService::onlyTrashed()->count();
        
        return view('admin.setup.opd-service.index', compact('departments', 'opdServices', 'selectedDepartment', 'departmentCounts', 'activeCount', 'archiveCount'));
    }

    public function create()
    {
        $departments = Department::withTrashed()->orderBy('name')->get();
        return view('admin.setup.opd-service.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:opd_services,code',
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'charge' => 'required|numeric|min:0',
        ]);

        try {
            OpdService::create([
                'code' => $request->code,
                'department_id' => $request->department_id,
                'name' => $request->name,
                'description' => $request->description,
                'charge' => $request->charge,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);

            return redirect()->route('admin.setup.opd-service.index')
                ->with('success', 'OPD service created successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to create OPD service: ' . $e->getMessage());
        }
    }

    public function show(OpdService $opdService)
    {
        $opdService->load(['department', 'createdBy', 'updatedBy']);
        return view('admin.setup.opd-service.show', compact('opdService'));
    }

    public function edit(OpdService $opdService)
    {
        $departments = Department::withTrashed()->orderBy('name')->get();
        return view('admin.setup.opd-service.edit', compact('opdService', 'departments'));
    }

    public function update(Request $request, OpdService $opdService)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:opd_services,code,' . $opdService->id,
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'charge' => 'required|numeric|min:0',
        ]);

        try {
            $opdService->update([
                'code' => $request->code,
                'department_id' => $request->department_id,
                'name' => $request->name,
                'description' => $request->description,
                'charge' => $request->charge,
                'updated_by' => auth()->id(),
            ]);

            // Force update the timestamp
            $opdService->touch();

            return redirect()->route('admin.setup.opd-service.index')
                ->with('success', 'OPD service updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to update OPD service: ' . $e->getMessage());
        }
    }

    public function destroy(OpdService $opdService)
    {
        try {
            $opdService->delete();
            return redirect()->route('admin.setup.opd-service.index')
                ->with('success', 'OPD service deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete OPD service: ' . $e->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $opdService = OpdService::withTrashed()->findOrFail($id);
            $opdService->restore();
            
            return redirect()->route('admin.setup.opd-service.index')
                ->with('success', 'OPD service restored successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore OPD service: ' . $e->getMessage());
        }
    }

    public function forceDelete($id)
    {
        try {
            $opdService = OpdService::withTrashed()->findOrFail($id);
            $opdService->forceDelete();
            
            return redirect()->route('admin.setup.opd-service.index')
                ->with('success', 'OPD service permanently deleted!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to permanently delete OPD service: ' . $e->getMessage());
        }
    }
} 