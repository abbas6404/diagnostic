<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Models\SystemSetting;
use App\Models\InvoiceReturn;
use Carbon\Carbon;

class InvoiceReturnHelper
{
    /**
     * Generate invoice return number with consistent format
     * Uses the format setting from database
     */
    public static function generateReturnNumber()
    {
        $prefix = SystemSetting::getValue('return_prefix', 'RET');
        $startNumber = (int) SystemSetting::getValue('return_start', '1');
        $format = SystemSetting::getValue('return_format', 'prefix-yymmdd-number');
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
            $existingReturns = DB::table('invoice_returns')
                ->where('return_no', 'like', $prefix . '%')
                ->orderBy('return_no', 'desc')
                ->get();
            
            $maxNumber = $startNumber - 1;
            foreach ($existingReturns as $return) {
                $numberPart = substr($return->return_no, strlen($prefix));
                if (is_numeric($numberPart) && !str_contains($return->return_no, '-') && strlen($numberPart) <= 6) {
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
            $existingReturns = DB::table('invoice_returns')
                ->where('return_no', 'like', $prefix . '-%')
                ->orderBy('return_no', 'desc')
                ->get();
            
            $maxNumber = $startNumber - 1;
            foreach ($existingReturns as $return) {
                if (preg_match('/^' . preg_quote($prefix) . '-(\d+)$/', $return->return_no, $matches)) {
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
        
        // Get the last return number for this period
        $lastReturn = DB::table('invoice_returns')
            ->where('return_no', 'like', $searchPattern)
            ->orderBy('return_no', 'desc')
            ->first();

        if ($lastReturn) {
            // Extract the number from the last return number
            $lastNumber = self::extractNumberFromId($lastReturn->return_no, $format, $prefix, $today);
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
     * Extract number from return number based on format
     */
    private static function extractNumberFromId($returnNo, $format, $prefix, $today)
    {
        switch ($format) {
            case 'prefix-yymmdd-number':
                if (preg_match('/-(\d+)$/', $returnNo, $matches)) {
                    return intval($matches[1]);
                }
                break;
            
            case 'prefixyymmddnumber':
                $datePart = $today->format('ymd');
                $numberPart = substr($returnNo, strlen($prefix . $datePart));
                if (is_numeric($numberPart)) {
                    return intval($numberPart);
                }
                break;
            
            case 'prefix-yymm-number':
                if (preg_match('/-(\d+)$/', $returnNo, $matches)) {
                    return intval($matches[1]);
                }
                break;
            
            case 'prefixyymmnumber':
                $datePart = $today->format('ym');
                $numberPart = substr($returnNo, strlen($prefix . $datePart));
                if (is_numeric($numberPart)) {
                    return intval($numberPart);
                }
                break;
            
            case 'prefix-yy-number':
                if (preg_match('/-(\d+)$/', $returnNo, $matches)) {
                    return intval($matches[1]);
                }
                break;
            
            case 'prefixyynumber':
                $datePart = $today->format('y');
                $numberPart = substr($returnNo, strlen($prefix . $datePart));
                if (is_numeric($numberPart)) {
                    return intval($numberPart);
                }
                break;
            
            case 'prefix-number':
                if (preg_match('/-(\d+)$/', $returnNo, $matches)) {
                    return intval($matches[1]);
                }
                break;
            
            case 'prefixnumber':
                $numberPart = substr($returnNo, strlen($prefix));
                if (is_numeric($numberPart)) {
                    return intval($numberPart);
                }
                break;
        }
        
        return 0;
    }
} 