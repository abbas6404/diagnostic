<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DiagnosticsController extends Controller
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
        return view('admin.diagnostics.invoice.index');
    }

    /**
     * Show the invoice return page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function invoiceReturn()
    {
        return view('admin.diagnostics.invoiceReturn.index');
    }

    /**
     * Show the due collection page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dueCollection()
    {
        return view('admin.diagnostics.due_Collection.index');
    }

    /**
     * Show the re-print page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function rePrint()
    {
        return view('admin.diagnostics.re_Print.index');
    }

    /**
     * Show the report page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function report()
    {
        return view('admin.diagnostics.report.index');
    }
} 