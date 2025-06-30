<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HospitalController extends Controller
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
     * Show the admission page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function admission()
    {
        return view('admin.hospital.admission.index');
    }

    /**
     * Show the bed management page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function bedManagement()
    {
        return view('admin.hospital.bed_management.index');
    }

    /**
     * Show the bed change page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function bedChange()
    {
        return view('admin.hospital.bed_change.index');
    }

    /**
     * Show the discharge page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function discharge()
    {
        return view('admin.hospital.discharge.index');
    }

    /**
     * Show the advance collection page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function advanceCollection()
    {
        return view('admin.hospital.advance_collection.index');
    }

    /**
     * Show the procedure entry page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function procedureEntry()
    {
        return view('admin.hospital.procedure_entry.index');
    }

    /**
     * Show the due collection page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dueCollection()
    {
        return view('admin.hospital.due_collection.index');
    }
} 