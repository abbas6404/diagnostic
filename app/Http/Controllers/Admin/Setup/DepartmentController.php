<?php

namespace App\Http\Controllers\Admin\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $filter = request('filter');
        
        if ($filter === 'archive') {
            $departments = Department::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        } else {
            $departments = Department::whereNull('deleted_at')->orderBy('name')->get();
        }
        
        // Get counts for filter tabs
        $activeCount = Department::whereNull('deleted_at')->count();
        $archiveCount = Department::onlyTrashed()->count();
        
        return view('admin.setup.department.index', compact('departments', 'activeCount', 'archiveCount'));
    }

    public function create()
    {
        return view('admin.setup.department.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
            'description' => 'nullable|string|max:500',
        ]);

        try {
            Department::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            return redirect()->route('admin.setup.department.index')
                ->with('success', 'Department created successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to create department: ' . $e->getMessage());
        }
    }

    public function show(Department $department)
    {
        return view('admin.setup.department.show', compact('department'));
    }

    public function edit(Department $department)
    {
        return view('admin.setup.department.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id,
            'description' => 'nullable|string|max:500',
        ]);

        try {
            $department->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            return redirect()->route('admin.setup.department.index')
                ->with('success', 'Department updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to update department: ' . $e->getMessage());
        }
    }

    public function destroy(Department $department)
    {
        try {
            $department->delete();
            return redirect()->route('admin.setup.department.index')
                ->with('success', 'Department deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete department: ' . $e->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $department = Department::withTrashed()->findOrFail($id);
            $department->restore();
            
            return redirect()->route('admin.setup.department.index')
                ->with('success', 'Department restored successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore department: ' . $e->getMessage());
        }
    }

    public function forceDelete($id)
    {
        try {
            $department = Department::withTrashed()->findOrFail($id);
            $department->forceDelete();
            
            return redirect()->route('admin.setup.department.index')
                ->with('success', 'Department permanently deleted!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to permanently delete department: ' . $e->getMessage());
        }
    }
} 