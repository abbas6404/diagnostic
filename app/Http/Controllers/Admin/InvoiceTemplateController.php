<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\AgeCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InvoiceTemplateController extends Controller
{
    use AgeCalculator;
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
     * Show the invoice templates index page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.invoice-templates.index');
    }

    /**
     * Show the default invoice template.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showDefault()
    {
        return view('admin.invoice-templates.test');
    }

    /**
     * Show the compact invoice template.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showCompact()
    {
        return view('admin.invoice-templates.test');
    }

    /**
     * Show the professional invoice template.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showProfessional()
    {
        return view('admin.invoice-templates.test');
    }

    /**
     * Show the receipt template.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showReceipt()
    {
        return view('admin.invoice-templates.test');
    }

    /**
     * Show the laboratory invoice template.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showLaboratory()
    {
        return view('admin.invoice-templates.test');
    }

    /**
     * Show the test invoice template.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showTest()
    {
        return view('admin.invoice-templates.test');
    }

    /**
     * Show the doctor consultant invoice template with data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showDoctorConsultant(Request $request)
    {
        // Get invoice ID from request
        $invoiceId = $request->get('invoice_id');
        
        \Log::info('Doctor Consultant Template accessed', [
            'invoice_id' => $invoiceId,
            'request_params' => $request->all()
        ]);
        
        if (!$invoiceId) {
            // Return template with sample data for preview
            return view('admin.invoice-templates.doctor-consultant', [
                'invoice' => (object)[
                    'invoice_no' => 'INV-001',
                    'invoice_date' => date('d/m/Y'),
                    'total_amount' => 500,
                    'discount_amount' => 0,
                    'payable_amount' => 500,
                    'paid_amount' => 500,
                    'due_amount' => 0,
                    'remarks' => 'Sample consultation'
                ],
                'patient' => (object)[
                    'patient_id' => 'P-001',
                    'name' => 'John Doe',
                    'age_years' => 25,
                    'age_months' => 6,
                    'age_days' => 15,
                    'phone' => '+880-1XXX-XXXXXX',
                    'patient_type' => 'new',
                    'address' => 'Dhaka, Bangladesh'
                ],
                'doctor' => (object)[
                    'name' => 'Dr. Smith'
                ],
                'ticket' => (object)[
                    'ticket_no' => 'DT-001',
                    'ticket_date' => date('d/m/Y'),
                    'ticket_time' => date('H:i')
                ]
            ]);
        }

        try {
            // Get invoice details
            $invoice = DB::table('invoices')->where('id', $invoiceId)->first();
            
            \Log::info('Invoice data fetched', [
                'invoice_id' => $invoiceId,
                'invoice_found' => $invoice ? 'yes' : 'no',
                'invoice_data' => $invoice
            ]);
            
            if (!$invoice) {
                abort(404, 'Invoice not found');
            }

            // Get patient details
            $patient = DB::table('patients')->where('id', $invoice->patient_id)->first();
            
            // Calculate age from date of birth
            if ($patient && $patient->dob) {
                $age = $this->calculateAge($patient->dob);
                $patient->age_years = $age['years'];
                $patient->age_months = $age['months'];
                $patient->age_days = $age['days'];
            } else {
                $patient->age_years = 0;
                $patient->age_months = 0;
                $patient->age_days = 0;
            }
            
            // Get consultant ticket details (contains doctor and ticket info)
            $consultantTicket = DB::table('consultant_tickets')
                ->where('invoice_id', $invoiceId)
                ->first();
            
            // Get doctor details from consultant ticket
            $doctor = null;
            if ($consultantTicket && $consultantTicket->doctor_id) {
                $doctor = DB::table('users')->where('id', $consultantTicket->doctor_id)->first();
            }
            
            // Get ticket details from consultant ticket
            $ticket = (object)[
                'ticket_no' => $consultantTicket->ticket_no ?? 'DT-001',
                'ticket_date' => $consultantTicket->ticket_date ?? $invoice->invoice_date,
                'ticket_time' => $consultantTicket->ticket_time ?? date('H:i')
            ];

            return view('admin.invoice-templates.doctor-consultant', [
                'invoice' => $invoice,
                'patient' => $patient,
                'doctor' => $doctor,
                'ticket' => $ticket
            ]);

        } catch (\Exception $e) {
            abort(500, 'Error loading invoice data: ' . $e->getMessage());
        }
    }



    /**
     * Print invoice with specific template.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function printInvoice(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'template' => 'required|string'
        ]);

        try {
            $invoiceId = $request->input('invoice_id');
            $template = $request->input('template');

            // Generate print URL based on template
            $printUrl = route('admin.invoice-templates.' . $template, ['invoice_id' => $invoiceId]);

            return response()->json([
                'success' => true,
                'message' => 'Print job sent successfully',
                'print_url' => $printUrl
            ]);

        } catch (\Exception $e) {
            \Log::error('Error printing invoice: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error sending print job'
            ], 500);
        }
    }

    /**
     * Get invoice data for templates.
     *
     * @param  int  $invoiceId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInvoiceData($invoiceId)
    {
        try {
            // Get invoice details
            $invoice = DB::table('invoices')->where('id', $invoiceId)->first();
            
            if (!$invoice) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invoice not found'
                ], 404);
            }

            // Get patient details
            $patient = DB::table('patients')->where('id', $invoice->patient_id)->first();
            
            // Get consultant ticket details (contains doctor and ticket info)
            $consultantTicket = DB::table('consultant_tickets')
                ->where('invoice_id', $invoiceId)
                ->first();
            
            // Get doctor details from consultant ticket
            $doctor = null;
            if ($consultantTicket && $consultantTicket->doctor_id) {
                $doctor = DB::table('users')->where('id', $consultantTicket->doctor_id)->first();
            }

            return response()->json([
                'success' => true,
                'invoice' => $invoice,
                'patient' => $patient,
                'doctor' => $doctor,
                'consultant_ticket' => $consultantTicket,
                'message' => 'Invoice data retrieved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving invoice data: ' . $e->getMessage()
            ], 500);
        }
    }
} 