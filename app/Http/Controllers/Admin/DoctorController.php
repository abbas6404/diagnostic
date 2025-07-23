<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DoctorController extends Controller
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
     * Show the doctor invoice form
     */
    public function invoice()
    {
        return view('admin.doctor.invoice.index');
    }

    /**
     * Show the due collection page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dueCollection()
    {
        return view('admin.doctor.due_Collection.index');
    }

    /**
     * Show the report page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function report()
    {
        return view('admin.doctor.report.index');
    }
    
    /**
     * Store a doctor invoice
     */
    public function storeInvoice(Request $request)
    {
        // Process and store the invoice
        // This will be implemented later
        
        return redirect()->route('admin.doctor.invoice')->with('success', 'Invoice created successfully');
    }

    // searchDoctors and searchPcps methods removed - now using Livewire components
} 