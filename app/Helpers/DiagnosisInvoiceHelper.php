<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Models\SystemSetting;
use App\Models\Invoice;
use Carbon\Carbon;

class DiagnosisInvoiceHelper
{
    /**
     * Generate diagnosis invoice number with consistent format
     * Uses the format setting from database
     */
    public static function generateDiagnosisInvoiceNumber()
    {
        $prefix = SystemSetting::getValue('diagnosis_prefix', 'DIA');
        $startNumber = (int) SystemSetting::getValue('diagnosis_start', '1');
        $format = SystemSetting::getValue('diagnosis_format', 'prefix-yymmdd-number');
        $today = Carbon::now();
        
        // Get the next number for today
        $nextId = self::getNextNumberForToday($prefix, $format, $today, $startNumber);
        $counter = str_pad($nextId, 3, '0', STR_PAD_LEFT);

        // Apply format based on setting
        switch ($format) {
            case 'prefix-yymmdd-number':
                return $prefix . '-' . $today->format('ymd') . '-' . $counter;
            
            case 'prefixyymmddnumber':
                return $prefix . $today->format('ymd') . $counter;
            
            case 'prefix-yymm-number':
                return $prefix . '-' . $today->format('ym') . '-' . $counter;
            
            case 'prefixyymmnumber':
                return $prefix . $today->format('ym') . $counter;
            
            case 'prefix-yy-number':
                return $prefix . '-' . $today->format('y') . '-' . $counter;
            
            case 'prefixyynumber':
                return $prefix . $today->format('y') . $counter;
            
            case 'prefix-number':
                return $prefix . '-' . $counter;
            
            case 'prefixnumber':
                return $prefix . $counter;
            
            default:
                // Default to prefix-yymmdd-number
                return $prefix . '-' . $today->format('ymd') . '-' . $counter;
        }
    }

    /**
     * Get the next number for today based on format
     */
    private static function getNextNumberForToday($prefix, $format, $today, $startNumber)
    {
        // Special handling for prefixnumber format
        if ($format === 'prefixnumber') {
            $existingInvoices = DB::table('invoices')
                ->where('invoice_no', 'like', $prefix . '%')
                ->orderBy('invoice_no', 'desc')
                ->get();
            
            $maxNumber = $startNumber - 1;
            foreach ($existingInvoices as $invoice) {
                $numberPart = substr($invoice->invoice_no, strlen($prefix));
                if (is_numeric($numberPart) && !str_contains($invoice->invoice_no, '-') && strlen($numberPart) <= 6) {
                    $number = intval($numberPart);
                    if ($number > $maxNumber) {
                        $maxNumber = $number;
                    }
                }
            }
            
            return $maxNumber + 1;
        }
        
        // Special handling for prefix-number format
        if ($format === 'prefix-number') {
            $existingInvoices = DB::table('invoices')
                ->where('invoice_no', 'like', $prefix . '-%')
                ->orderBy('invoice_no', 'desc')
                ->get();
            
            $maxNumber = $startNumber - 1;
            foreach ($existingInvoices as $invoice) {
                if (preg_match('/^' . preg_quote($prefix) . '-(\d+)$/', $invoice->invoice_no, $matches)) {
                    $number = intval($matches[1]);
                    if ($number > $maxNumber) {
                        $maxNumber = $number;
                    }
                }
            }
            
            return $maxNumber + 1;
        }
        
        // Build search pattern based on format
        $searchPattern = self::buildSearchPattern($prefix, $format, $today);
        
        // Get the last invoice number for this period
        $lastInvoice = DB::table('invoices')
            ->where('invoice_no', 'like', $searchPattern)
            ->orderBy('invoice_no', 'desc')
            ->first();

        if ($lastInvoice) {
            // Extract the number from the last invoice number
            $lastNumber = self::extractNumberFromId($lastInvoice->invoice_no, $format, $prefix, $today);
            return $lastNumber + 1;
        }

        return $startNumber;
    }

    /**
     * Build search pattern for the given format
     */
    private static function buildSearchPattern($prefix, $format, $today)
    {
        switch ($format) {
            case 'prefix-yymmdd-number':
                return $prefix . '-' . $today->format('ymd') . '-%';
            
            case 'prefixyymmddnumber':
                return $prefix . $today->format('ymd') . '%';
            
            case 'prefix-yymm-number':
                return $prefix . '-' . $today->format('ym') . '-%';
            
            case 'prefixyymmnumber':
                return $prefix . $today->format('ym') . '%';
            
            case 'prefix-yy-number':
                return $prefix . '-' . $today->format('y') . '-%';
            
            case 'prefixyynumber':
                return $prefix . $today->format('y') . '%';
            
            case 'prefix-number':
                return $prefix . '-%';
            
            case 'prefixnumber':
                return $prefix . '%';
            
            default:
                return $prefix . '-' . $today->format('ymd') . '-%';
        }
    }

    /**
     * Extract number from invoice number based on format
     */
    private static function extractNumberFromId($invoiceNo, $format, $prefix, $today)
    {
        switch ($format) {
            case 'prefix-yymmdd-number':
                if (preg_match('/-(\d+)$/', $invoiceNo, $matches)) {
                    return intval($matches[1]);
                }
                break;
            
            case 'prefixyymmddnumber':
                $datePart = $today->format('ymd');
                $numberPart = substr($invoiceNo, strlen($prefix . $datePart));
                if (is_numeric($numberPart)) {
                    return intval($numberPart);
                }
                break;
            
            case 'prefix-yymm-number':
                if (preg_match('/-(\d+)$/', $invoiceNo, $matches)) {
                    return intval($matches[1]);
                }
                break;
            
            case 'prefixyymmnumber':
                $datePart = $today->format('ym');
                $numberPart = substr($invoiceNo, strlen($prefix . $datePart));
                if (is_numeric($numberPart)) {
                    return intval($numberPart);
                }
                break;
            
            case 'prefix-yy-number':
                if (preg_match('/-(\d+)$/', $invoiceNo, $matches)) {
                    return intval($matches[1]);
                }
                break;
            
            case 'prefixyynumber':
                $datePart = $today->format('y');
                $numberPart = substr($invoiceNo, strlen($prefix . $datePart));
                if (is_numeric($numberPart)) {
                    return intval($numberPart);
                }
                break;
            
            case 'prefix-number':
                if (preg_match('/-(\d+)$/', $invoiceNo, $matches)) {
                    return intval($matches[1]);
                }
                break;
            
            case 'prefixnumber':
                $numberPart = substr($invoiceNo, strlen($prefix));
                if (is_numeric($numberPart)) {
                    return intval($numberPart);
                }
                break;
        }
        
        return 0;
    }
} 