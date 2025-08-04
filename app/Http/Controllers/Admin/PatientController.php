<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PatientController extends Controller
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
     * Display a listing of patients.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $query = DB::table('patients')
            ->select('patients.*');
        
        // Filter by status (active/archived)
        if ($request->has('status') && $request->status == 'archived') {
            $query->whereNotNull('deleted_at');
        } else {
            $query->whereNull('deleted_at');
        }
        
        $query->orderBy('id', 'desc');
            
        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
  
                  ->orWhere('patient_id', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }
        
        // Apply patient type filter
        if ($request->has('patient_type') && !empty($request->patient_type)) {
            $query->where('patient_type', $request->patient_type);
        }
        
        $patients = $query->paginate(10)->withQueryString();
        $isArchived = $request->has('status') && $request->status == 'archived';
            
        return view('admin.registration.index', compact('patients', 'isArchived'));
    }
    
    /**
     * Show the form for creating a new patient.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('admin.registration.create');
    }

    /**
     * Display the specified patient.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show($id)
    {
        $patient = DB::table('patients')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
        
        if (!$patient) {
            return redirect()->route('admin.patients.index')
                ->with('error', 'Patient not found');
        }
        
        return view('admin.registration.show', compact('patient'));
    }
    
    /**
     * Show the form for editing the specified patient.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit($id)
    {
        $patient = DB::table('patients')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();
        
        if (!$patient) {
            return redirect()->route('admin.patients.index')
                ->with('error', 'Patient not found');
        }
        
        // Calculate age from DOB if available
        $ageData = [];
        if ($patient->dob) {
            $dob = new \DateTime($patient->dob);
            $now = new \DateTime();
            $diff = $now->diff($dob);
            
            $ageData = [
                'age_year' => $diff->y,
                'age_month' => $diff->m,
                'age_day' => $diff->d
            ];
        }
        
        return view('admin.registration.edit', compact('patient', 'ageData'));
    }
    
    /**
     * Update the specified patient in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validate the request
        $validated = $request->validate([
            'reg_date' => 'required|date',
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|string|max:20',
            'blood_group' => 'nullable|string|max:10',
            'religion' => 'nullable|string|max:50',
            'occupation' => 'nullable|string|max:100',
            'reg_fee' => 'nullable|numeric',
            'nationality' => 'nullable|string|max:100',
            'patient_type' => 'nullable|string|max:50',
            'age_year' => 'nullable|numeric|min:0|max:150',
            'age_month' => 'nullable|numeric|min:0|max:12',
            'age_day' => 'nullable|numeric|min:0|max:31',
        ]);
        
        // Calculate DOB from age if age is provided and DOB is not
        if (empty($validated['dob']) && ($request->filled('age_year') || $request->filled('age_month') || $request->filled('age_day'))) {
            $years = max(0, (int)$request->input('age_year', 0));
            $months = max(0, (int)$request->input('age_month', 0));
            $days = max(0, (int)$request->input('age_day', 0));
            
            // Ensure reasonable age limits
            if ($years > 150) $years = 150;
            if ($months > 12) $months = 12;
            if ($days > 31) $days = 31;
            
            $dob = now();
            $dob->subYears($years);
            $dob->subMonths($months);
            $dob->subDays($days);
            
            // Ensure calculated DOB is not in the future
            if ($dob->isFuture()) {
                return back()->withInput()
                    ->with('error', 'Invalid age values. Please check the age or date of birth.');
            }
            
            $validated['dob'] = $dob->format('Y-m-d');
        }
        
        // Remove age fields from validated data as they're not in the database
        unset($validated['age_year'], $validated['age_month'], $validated['age_day']);
        
        // Add updated_by field
        $validated['updated_by'] = Auth::id();
        $validated['updated_at'] = now();
        
        // Update patient record
        $updated = DB::table('patients')
            ->where('id', $id)
            ->update($validated);
        
        if ($updated) {
            return redirect()->route('admin.patients.index')
                ->with('success', 'Patient updated successfully');
        } else {
            return back()->withInput()
                ->with('error', 'Error updating patient. Please try again.');
        }
    }
    
    /**
     * Remove the specified patient from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Soft delete by updating the deleted_at timestamp
        $deleted = DB::table('patients')
            ->where('id', $id)
            ->update([
                'deleted_at' => now(),
                'updated_at' => now(),
                'updated_by' => Auth::id()
            ]);
        
        if ($deleted) {
            return redirect()->route('admin.patients.index')
                ->with('success', 'Patient archived successfully');
        } else {
            return redirect()->route('admin.patients.index')
                ->with('error', 'Error archiving patient');
        }
    }

    /**
     * Restore a soft-deleted patient.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        // Restore by setting deleted_at to null
        $restored = DB::table('patients')
            ->where('id', $id)
            ->update([
                'deleted_at' => null,
                'updated_at' => now(),
                'updated_by' => Auth::id()
            ]);
        
        if ($restored) {
            return redirect()->route('admin.patients.index')
                ->with('success', 'Patient restored successfully');
        } else {
            return redirect()->route('admin.patients.index')
                ->with('error', 'Error restoring patient');
        }
    }
} 