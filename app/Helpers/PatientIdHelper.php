<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Models\SystemSetting;
use App\Models\Patient;
use Carbon\Carbon;


class PatientIdHelper
{
    /**
     * Generate a unique patient ID
     * Format: Based on system settings (prefix-yymmdd-number by default)
     */
    public static function generatePatientId($mode = 'daily')
    {
        // Get system settings
        $prefix = SystemSetting::getValue('patient_prefix', 'P');
        $startNumber = (int) SystemSetting::getValue('patient_start', '1');
        $format = SystemSetting::getValue('patient_format', 'prefix-yymmdd-number');
        
        $now = Carbon::now();

        // Create date key based on reset mode
        if ($mode === 'daily') {
            $dateKey = $now->format('ymd');  // 250804
        } elseif ($mode === 'monthly') {
            $dateKey = $now->format('ym');   // 2508
        } elseif ($mode === 'yearly') {
            $dateKey = $now->format('y');    // 25
        } else {
            throw new \Exception("Invalid mode");
        }

        // Count how many patients already created for this period
        $count = Patient::where('patient_id', 'like', "$prefix-$dateKey-%")->count() + $startNumber;

        // Format the counter
        $counter = str_pad($count, 3, '0', STR_PAD_LEFT);  // 001, 002...

        return "$prefix-$dateKey-$counter";
    }

    /**
     * Generate patient ID using the logic from DoctorInvoice
     * Format: PREFIX + YYMMDD + 3-digit sequential number (no dashes)
     */
    public static function generatePatientIdFromDoctorInvoice()
    {
        $patientPrefix = SystemSetting::getValue('patient_prefix', 'P');
        $startNumber = (int) SystemSetting::getValue('patient_start', '1');
        $today = Carbon::now();
        $datePrefix = $today->format('ymd'); // Format: YYMMDD
        
        // Get the last patient ID for today
        $lastPatientToday = DB::table('patients')
            ->where('patient_id', 'like', $patientPrefix . $datePrefix . '%')
            ->orderBy('patient_id', 'desc')
            ->first();

        $nextId = $startNumber;
        if ($lastPatientToday) {
            // Extract the sequential number from the last patient ID
            $lastNumber = substr($lastPatientToday->patient_id, strlen($patientPrefix . $datePrefix));
            if (is_numeric($lastNumber)) {
                $nextId = intval($lastNumber) + 1;
            }
        }

        return $patientPrefix . $datePrefix . str_pad($nextId, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Generate patient ID with consistent format
     * Uses the format setting from database
     */
    public static function generatePatientIdConsistent()
    {
        $prefix = SystemSetting::getValue('patient_prefix', 'P');
        $startNumber = (int) SystemSetting::getValue('patient_start', '1');
        $format = SystemSetting::getValue('patient_format', 'prefix-yymmdd-number');
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
            // For prefixnumber format, we only want simple sequential numbers (PP001, PP002, etc.)
            // Not IDs with dates or other formats
            $existingPatients = DB::table('patients')
                ->where('patient_id', 'like', $prefix . '%')
                ->orderBy('patient_id', 'desc')
                ->get();
            
            $maxNumber = $startNumber - 1;
            foreach ($existingPatients as $patient) {
                $numberPart = substr($patient->patient_id, strlen($prefix));
                // Only consider if it's a simple number (no dashes, no dates)
                if (is_numeric($numberPart) && !str_contains($patient->patient_id, '-') && strlen($numberPart) <= 6) {
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
            // For prefix-number format, we only want simple prefix-number format (PP-001, PP-002, etc.)
            // Not IDs with dates or other formats
            $existingPatients = DB::table('patients')
                ->where('patient_id', 'like', $prefix . '-%')
                ->orderBy('patient_id', 'desc')
                ->get();
            
            $maxNumber = $startNumber - 1;
            foreach ($existingPatients as $patient) {
                // Only consider if it's a simple prefix-number format (no dates)
                // Pattern: PP-001, PP-002, etc. (not PP-250804-001)
                if (preg_match('/^' . preg_quote($prefix) . '-(\d+)$/', $patient->patient_id, $matches)) {
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
        
        // Get the last patient ID for this period
        $lastPatient = DB::table('patients')
            ->where('patient_id', 'like', $searchPattern)
            ->orderBy('patient_id', 'desc')
            ->first();

        if ($lastPatient) {
            // Extract the number from the last patient ID
            $lastNumber = self::extractNumberFromId($lastPatient->patient_id, $format, $prefix, $today);
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
                // For prefixnumber, we need to find the highest number after prefix
                // This will be handled specially in getNextNumberForToday
                return $prefix . '%';
            
            default:
                return $prefix . '-' . $today->format('ymd') . '-%';
        }
    }

    /**
     * Extract number from patient ID based on format
     */
    private static function extractNumberFromId($patientId, $format, $prefix, $today)
    {
        switch ($format) {
            case 'prefix-yymmdd-number':
                // Extract number after last dash (e.g., P-250804-014 -> 014)
                if (preg_match('/-(\d+)$/', $patientId, $matches)) {
                    return intval($matches[1]);
                }
                break;
            
            case 'prefixyymmddnumber':
                // Extract last 3 digits (e.g., P250804014 -> 014)
                $datePart = $today->format('ymd');
                $numberPart = substr($patientId, strlen($prefix . $datePart));
                if (is_numeric($numberPart)) {
                    return intval($numberPart);
                }
                break;
            
            case 'prefix-yymm-number':
                // Extract number after last dash (e.g., P-2508-014 -> 014)
                if (preg_match('/-(\d+)$/', $patientId, $matches)) {
                    return intval($matches[1]);
                }
                break;
            
            case 'prefixyymmnumber':
                // Extract last 3 digits (e.g., P2508014 -> 014)
                $datePart = $today->format('ym');
                $numberPart = substr($patientId, strlen($prefix . $datePart));
                if (is_numeric($numberPart)) {
                    return intval($numberPart);
                }
                break;
            
            case 'prefix-yy-number':
                // Extract number after last dash (e.g., P-25-014 -> 014)
                if (preg_match('/-(\d+)$/', $patientId, $matches)) {
                    return intval($matches[1]);
                }
                break;
            
            case 'prefixyynumber':
                // Extract last 3 digits (e.g., P25014 -> 014)
                $datePart = $today->format('y');
                $numberPart = substr($patientId, strlen($prefix . $datePart));
                if (is_numeric($numberPart)) {
                    return intval($numberPart);
                }
                break;
            
            case 'prefix-number':
                // Extract number after dash (e.g., P-014 -> 014)
                if (preg_match('/-(\d+)$/', $patientId, $matches)) {
                    return intval($matches[1]);
                }
                break;
            
            case 'prefixnumber':
                // Extract all digits after prefix (e.g., PP014 -> 014, PP2584021 -> 2584021)
                $numberPart = substr($patientId, strlen($prefix));
                if (is_numeric($numberPart)) {
                    return intval($numberPart);
                }
                break;
        }
        
        return 0;
    }
}
