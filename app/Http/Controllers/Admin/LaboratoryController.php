<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaboratoryController extends Controller
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
     * Show the test results page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function testResults()
    {
        return view('admin.laboratory.test_results.index');
    }

    /**
     * Show the sample collection page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function sampleCollection()
    {
        return view('admin.laboratory.sample_collection.index');
    }

    /**
     * Show the lab equipment page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function labEquipment()
    {
        return view('admin.laboratory.lab_equipment.index');
    }
} 