<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OpdController extends Controller
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
     * Show the invoice page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function invoice()
    {
        return view('admin.opd.invoice.index');
    }
    
    /**
     * Store a newly created invoice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeInvoice(Request $request)
    {
        // Validate the request
        $request->validate([
            'patient_id_hidden' => 'required',
            'name_en' => 'required',
            'receipt_no' => 'nullable',
            'invoice_date' => 'required|date',
            'service_ids' => 'required|array',
            'service_ids.*' => 'required|integer'
        ]);
        
        // Save the invoice (implementation to be added based on your data model)
        // This is just a placeholder that will allow the form to submit successfully
        
        // Flash success message
        session()->flash('success', 'OPD Invoice saved successfully!');
        
        // Redirect back to invoice page
        return redirect()->route('admin.opd.invoice');
    }

    /**
     * Show the due collection page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dueCollection()
    {
        return view('admin.opd.due_Collection.index');
    }

    /**
     * Show the re-print page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function rePrint()
    {
        return view('admin.opd.re_Print.index');
    }
} 