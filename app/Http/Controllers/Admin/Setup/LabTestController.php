<?php

namespace App\Http\Controllers\Admin\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LabTest;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class LabTestController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $departments = Department::withTrashed()->orderBy('name')->get();
        $selectedDepartment = request('department');
        
        // Get all lab tests for counting
        $allLabTests = LabTest::withTrashed()->get();
        
        // Calculate department counts
        $departmentCounts = [];
        foreach ($departments as $department) {
            $departmentCounts[$department->id] = $allLabTests->where('department_id', $department->id)->count();
        }
        
        if ($selectedDepartment) {
            $labTests = LabTest::withTrashed()
                ->where('department_id', $selectedDepartment)
                ->orderBy('name')
                ->get();
        } else {
            $labTests = LabTest::withTrashed()->orderBy('name')->get();
        }
        
        return view('admin.setup.lab-test.index', compact('departments', 'labTests', 'selectedDepartment', 'departmentCounts'));
    }

    public function create()
    {
        $departments = Department::withTrashed()->orderBy('name')->get();
        return view('admin.setup.lab-test.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:lab_tests,code',
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'charge' => 'required|numeric|min:0',
        ]);

        try {
            LabTest::create([
                'code' => $request->code,
                'department_id' => $request->department_id,
                'name' => $request->name,
                'description' => $request->description,
                'charge' => $request->charge,
            ]);

            return redirect()->route('admin.setup.lab-test.index')
                ->with('success', 'Lab test created successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to create lab test: ' . $e->getMessage());
        }
    }

    public function show(LabTest $labTest)
    {
        return view('admin.setup.lab-test.show', compact('labTest'));
    }

    public function edit(LabTest $labTest)
    {
        $departments = Department::withTrashed()->orderBy('name')->get();
        return view('admin.setup.lab-test.edit', compact('labTest', 'departments'));
    }

    public function update(Request $request, LabTest $labTest)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:lab_tests,code,' . $labTest->id,
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'charge' => 'required|numeric|min:0',
        ]);

        try {
            $labTest->update([
                'code' => $request->code,
                'department_id' => $request->department_id,
                'name' => $request->name,
                'description' => $request->description,
                'charge' => $request->charge,
            ]);

            return redirect()->route('admin.setup.lab-test.index')
                ->with('success', 'Lab test updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to update lab test: ' . $e->getMessage());
        }
    }

    public function destroy(LabTest $labTest)
    {
        try {
            $labTest->delete();
            return redirect()->route('admin.setup.lab-test.index')
                ->with('success', 'Lab test deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete lab test: ' . $e->getMessage());
        }
    }

    public function restore($id)
    {
        try {
            $labTest = LabTest::withTrashed()->findOrFail($id);
            $labTest->restore();
            
            return redirect()->route('admin.setup.lab-test.index')
                ->with('success', 'Lab test restored successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to restore lab test: ' . $e->getMessage());
        }
    }

    public function forceDelete($id)
    {
        try {
            $labTest = LabTest::withTrashed()->findOrFail($id);
            $labTest->forceDelete();
            
            return redirect()->route('admin.setup.lab-test.index')
                ->with('success', 'Lab test permanently deleted!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to permanently delete lab test: ' . $e->getMessage());
        }
    }
} 