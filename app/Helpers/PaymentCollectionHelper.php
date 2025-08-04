<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Models\SystemSetting;
use App\Models\PaymentCollection;
use Carbon\Carbon;

class PaymentCollectionHelper
{
    /**
     * Generate payment collection number with consistent format
     * Uses the format setting from database
     */
    public static function generateCollectionNumber()
    {
        $prefix = SystemSetting::getValue('collection_prefix', 'COL');
        $startNumber = (int) SystemSetting::getValue('collection_start', '1');
        $format = SystemSetting::getValue('collection_format', 'prefix-yymmdd-number');
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
            $existingCollections = DB::table('payment_collections')
                ->where('collection_no', 'like', $prefix . '%')
                ->orderBy('collection_no', 'desc')
                ->get();
            
            $maxNumber = $startNumber - 1;
            foreach ($existingCollections as $collection) {
                $numberPart = substr($collection->collection_no, strlen($prefix));
                if (is_numeric($numberPart) && !str_contains($collection->collection_no, '-') && strlen($numberPart) <= 6) {
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
            $existingCollections = DB::table('payment_collections')
                ->where('collection_no', 'like', $prefix . '-%')
                ->orderBy('collection_no', 'desc')
                ->get();
            
            $maxNumber = $startNumber - 1;
            foreach ($existingCollections as $collection) {
                if (preg_match('/^' . preg_quote($prefix) . '-(\d+)$/', $collection->collection_no, $matches)) {
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
        
        // Get the last collection number for this period
        $lastCollection = DB::table('payment_collections')
            ->where('collection_no', 'like', $searchPattern)
            ->orderBy('collection_no', 'desc')
            ->first();

        if ($lastCollection) {
            // Extract the number from the last collection number
            $lastNumber = self::extractNumberFromId($lastCollection->collection_no, $format, $prefix, $today);
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
     * Extract number from collection number based on format
     */
    private static function extractNumberFromId($collectionNo, $format, $prefix, $today)
    {
        switch ($format) {
            case 'prefix-yymmdd-number':
                if (preg_match('/-(\d+)$/', $collectionNo, $matches)) {
                    return intval($matches[1]);
                }
                break;
            
            case 'prefixyymmddnumber':
                $datePart = $today->format('ymd');
                $numberPart = substr($collectionNo, strlen($prefix . $datePart));
                if (is_numeric($numberPart)) {
                    return intval($numberPart);
                }
                break;
            
            case 'prefix-yymm-number':
                if (preg_match('/-(\d+)$/', $collectionNo, $matches)) {
                    return intval($matches[1]);
                }
                break;
            
            case 'prefixyymmnumber':
                $datePart = $today->format('ym');
                $numberPart = substr($collectionNo, strlen($prefix . $datePart));
                if (is_numeric($numberPart)) {
                    return intval($numberPart);
                }
                break;
            
            case 'prefix-yy-number':
                if (preg_match('/-(\d+)$/', $collectionNo, $matches)) {
                    return intval($matches[1]);
                }
                break;
            
            case 'prefixyynumber':
                $datePart = $today->format('y');
                $numberPart = substr($collectionNo, strlen($prefix . $datePart));
                if (is_numeric($numberPart)) {
                    return intval($numberPart);
                }
                break;
            
            case 'prefix-number':
                if (preg_match('/-(\d+)$/', $collectionNo, $matches)) {
                    return intval($matches[1]);
                }
                break;
            
            case 'prefixnumber':
                $numberPart = substr($collectionNo, strlen($prefix));
                if (is_numeric($numberPart)) {
                    return intval($numberPart);
                }
                break;
        }
        
        return 0;
    }
} 