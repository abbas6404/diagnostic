<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Models\SystemSetting;
use App\Models\LabTestOrder;
use Carbon\Carbon;

class LabTestOrderHelper
{
    /**
     * Generate lab test order number with consistent format
     * Uses the format setting from database
     */
    public static function generateOrderNumber()
    {
        $prefix = SystemSetting::getValue('lab_test_order_prefix', 'LTO');
        $startNumber = (int) SystemSetting::getValue('lab_test_order_start', '1');
        $format = SystemSetting::getValue('lab_test_order_format', 'prefix-yymmdd-number');
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
            $existingOrders = DB::table('lab_test_orders')
                ->where('order_no', 'like', $prefix . '%')
                ->orderBy('order_no', 'desc')
                ->get();
            
            $maxNumber = $startNumber - 1;
            foreach ($existingOrders as $order) {
                $numberPart = substr($order->order_no, strlen($prefix));
                if (is_numeric($numberPart) && !str_contains($order->order_no, '-') && strlen($numberPart) <= 6) {
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
            $existingOrders = DB::table('lab_test_orders')
                ->where('order_no', 'like', $prefix . '-%')
                ->orderBy('order_no', 'desc')
                ->get();
            
            $maxNumber = $startNumber - 1;
            foreach ($existingOrders as $order) {
                if (preg_match('/^' . preg_quote($prefix) . '-(\d+)$/', $order->order_no, $matches)) {
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
        
        // Get the last order number for this period
        $lastOrder = DB::table('lab_test_orders')
            ->where('order_no', 'like', $searchPattern)
            ->orderBy('order_no', 'desc')
            ->first();

        if ($lastOrder) {
            // Extract the number from the last order number
            $lastNumber = self::extractNumberFromId($lastOrder->order_no, $format, $prefix, $today);
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
     * Extract number from order number based on format
     */
    private static function extractNumberFromId($orderNo, $format, $prefix, $today)
    {
        switch ($format) {
            case 'prefix-yymmdd-number':
                if (preg_match('/-(\d+)$/', $orderNo, $matches)) {
                    return intval($matches[1]);
                }
                break;
            
            case 'prefixyymmddnumber':
                $datePart = $today->format('ymd');
                $numberPart = substr($orderNo, strlen($prefix . $datePart));
                if (is_numeric($numberPart)) {
                    return intval($numberPart);
                }
                break;
            
            case 'prefix-yymm-number':
                if (preg_match('/-(\d+)$/', $orderNo, $matches)) {
                    return intval($matches[1]);
                }
                break;
            
            case 'prefixyymmnumber':
                $datePart = $today->format('ym');
                $numberPart = substr($orderNo, strlen($prefix . $datePart));
                if (is_numeric($numberPart)) {
                    return intval($numberPart);
                }
                break;
            
            case 'prefix-yy-number':
                if (preg_match('/-(\d+)$/', $orderNo, $matches)) {
                    return intval($matches[1]);
                }
                break;
            
            case 'prefixyynumber':
                $datePart = $today->format('y');
                $numberPart = substr($orderNo, strlen($prefix . $datePart));
                if (is_numeric($numberPart)) {
                    return intval($numberPart);
                }
                break;
            
            case 'prefix-number':
                if (preg_match('/-(\d+)$/', $orderNo, $matches)) {
                    return intval($matches[1]);
                }
                break;
            
            case 'prefixnumber':
                $numberPart = substr($orderNo, strlen($prefix));
                if (is_numeric($numberPart)) {
                    return intval($numberPart);
                }
                break;
        }
        
        return 0;
    }
} 