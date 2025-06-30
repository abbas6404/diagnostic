<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
     * Show the new patient registration form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function newPatient()
    {
        return view('admin.registration.newPatient.index');
    }

    /**
     * Show the list of patients.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function patientList()
    {
        return view('admin.registration.patients.index');
    }
} 