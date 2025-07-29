<?php

namespace App\Http\Controllers\Admin\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LabTest;
use App\Models\Department;
use App\Models\CollectionKit;
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
        $filter = request('filter');
        
        // Get all lab tests for counting based on filter
        if ($filter === 'archive') {
            $allLabTests = LabTest::onlyTrashed()->get();
        } else {
            $allLabTests = LabTest::whereNull('deleted_at')->get();
        }
        
        // Calculate department counts
        $departmentCounts = [];
        foreach ($departments as $department) {
            $departmentCounts[$department->id] = $allLabTests->where('department_id', $department->id)->count();
        }
        
        if ($selectedDepartment) {
            if ($filter === 'archive') {
                $labTests = LabTest::onlyTrashed()
                    ->with('collectionKits')
                    ->where('department_id', $selectedDepartment)
                    ->orderBy('deleted_at', 'desc')
                    ->get();
            } else {
                $labTests = LabTest::whereNull('deleted_at')
                    ->with('collectionKits')
                    ->where('department_id', $selectedDepartment)
                    ->orderBy('name')
                    ->get();
            }
        } else {
            if ($filter === 'archive') {
                $labTests = LabTest::onlyTrashed()
                    ->with('collectionKits')
                    ->orderBy('deleted_at', 'desc')
                    ->get();
            } else {
                $labTests = LabTest::whereNull('deleted_at')
                    ->with('collectionKits')
                    ->orderBy('name')
                    ->get();
            }
        }
        
        // Get counts for filter tabs
        $activeCount = LabTest::whereNull('deleted_at')->count();
        $archiveCount = LabTest::onlyTrashed()->count();
        
        return view('admin.setup.lab-test.index', compact('departments', 'labTests', 'selectedDepartment', 'departmentCounts', 'activeCount', 'archiveCount'));
    }

    public function create()
    {
        $departments = Department::withTrashed()->orderBy('name')->get();
        $collectionKits = CollectionKit::where('status', 'active')
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();
        return view('admin.setup.lab-test.create', compact('departments', 'collectionKits'));
    }

    public function store(Request $request)
    {
        // Debug the incoming request
        \Log::info('Lab test creation request', [
            'all_data' => $request->all(),
            'collection_kits' => $request->collection_kits,
            'has_collection_kits' => $request->has('collection_kits')
        ]);

        $request->validate([
            'code' => 'required|string|max:50|unique:lab_tests,code',
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'charge' => 'required|numeric|min:0',
            'collection_kits' => 'nullable|array',
            'collection_kits.*' => 'exists:collection_kits,id,deleted_at,NULL,status,active',
        ]);

        try {
            $labTest = LabTest::create([
                'code' => $request->code,
                'department_id' => $request->department_id,
                'name' => $request->name,
                'description' => $request->description,
                'charge' => $request->charge,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
            ]);

            // Attach collection kits if selected
            if ($request->has('collection_kits') && !empty($request->collection_kits)) {
                \Log::info('Attaching collection kits', [
                    'lab_test_id' => $labTest->id,
                    'collection_kits' => $request->collection_kits
                ]);
                $labTest->collectionKits()->attach($request->collection_kits);
            }

            return redirect()->route('admin.setup.lab-test.index')
                ->with('success', 'Lab test created successfully!');
        } catch (\Exception $e) {
            \Log::error('Lab test creation error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withInput()
                ->with('error', 'Failed to create lab test: ' . $e->getMessage());
        }
    }

    public function show(LabTest $labTest)
    {
        $labTest->load(['department', 'collectionKits', 'createdBy', 'updatedBy']);
        return view('admin.setup.lab-test.show', compact('labTest'));
    }

    public function edit(LabTest $labTest)
    {
        $departments = Department::withTrashed()->orderBy('name')->get();
        $collectionKits = CollectionKit::where('status', 'active')
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();
        $labTest->load('collectionKits');
        return view('admin.setup.lab-test.edit', compact('labTest', 'departments', 'collectionKits'));
    }

    public function update(Request $request, LabTest $labTest)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:lab_tests,code,' . $labTest->id,
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'charge' => 'required|numeric|min:0',
            'collection_kits' => 'nullable|array',
            'collection_kits.*' => 'exists:collection_kits,id,deleted_at,NULL,status,active',
        ]);

        try {
            $labTest->update([
                'code' => $request->code,
                'department_id' => $request->department_id,
                'name' => $request->name,
                'description' => $request->description,
                'charge' => $request->charge,
                'updated_by' => auth()->id(),
            ]);

            // Force update the timestamp
            $labTest->touch();

            // Sync collection kits
            $labTest->collectionKits()->sync($request->collection_kits ?? []);

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