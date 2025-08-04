<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Models\SystemSetting;
use Carbon\Carbon;

class DoctorTicketHelper
{
    /**
     * Generate doctor ticket number with daily reset for each doctor
     * Each doctor's tickets start from 1 every day
     */
    public static function generateTicketNumber($doctorId)
    {
        $ticketPrefix = SystemSetting::getValue('doctor_ticket_prefix', 'DT');
        $ticketFormat = SystemSetting::getValue('doctor_ticket_format', 'prefix-yymmdd-number');
        $today = Carbon::now();
        
        // Get the next number for today for this specific doctor
        $nextId = self::getNextNumberForToday($ticketPrefix, $ticketFormat, $today, $doctorId);
        $counter = str_pad($nextId, 3, '0', STR_PAD_LEFT);

        // Apply format based on setting
        switch ($ticketFormat) {
            case 'prefix-yymmdd-number':
                return $ticketPrefix . '-' . $today->format('ymd') . '-' . $counter;
            
            case 'prefixyymmddnumber':
                return $ticketPrefix . $today->format('ymd') . $counter;
            
            case 'prefix-yymm-number':
                return $ticketPrefix . '-' . $today->format('ym') . '-' . $counter;
            
            case 'prefixyymmnumber':
                return $ticketPrefix . $today->format('ym') . $counter;
            
            case 'prefix-yy-number':
                return $ticketPrefix . '-' . $today->format('y') . '-' . $counter;
            
            case 'prefixyynumber':
                return $ticketPrefix . $today->format('y') . $counter;
            
            case 'prefix-number':
                return $ticketPrefix . '-' . $counter;
            
            case 'prefixnumber':
                return $ticketPrefix . $counter;
            
            case 'prefix-drcode-number':
                // Get doctor's code from users table
                $doctorCode = DB::table('users')->where('id', $doctorId)->value('code');
                $doctorCode = $doctorCode ?: 'DR' . str_pad($doctorId, 3, '0', STR_PAD_LEFT);
                return $ticketPrefix . '-' . $doctorCode . '-' . $counter;
            
            default:
                // Default to prefix-yymmdd-number
                return $ticketPrefix . '-' . $today->format('ymd') . '-' . $counter;
        }
    }

    /**
     * Get the next number for today for this specific doctor
     */
    private static function getNextNumberForToday($prefix, $format, $today, $doctorId)
    {
        // Special handling for prefixnumber format
        if ($format === 'prefixnumber') {
            $existingTickets = DB::table('consultant_tickets')
                ->where('doctor_id', $doctorId)
                ->whereDate('ticket_date', $today->toDateString())
                ->where('ticket_no', 'like', $prefix . '%')
                ->orderBy('ticket_no', 'desc')
                ->get();
            
            $maxNumber = 0;
            foreach ($existingTickets as $ticket) {
                $numberPart = substr($ticket->ticket_no, strlen($prefix));
                if (is_numeric($numberPart) && !str_contains($ticket->ticket_no, '-') && strlen($numberPart) <= 6) {
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
            $existingTickets = DB::table('consultant_tickets')
                ->where('doctor_id', $doctorId)
                ->whereDate('ticket_date', $today->toDateString())
                ->where('ticket_no', 'like', $prefix . '-%')
                ->orderBy('ticket_no', 'desc')
                ->get();
            
            $maxNumber = 0;
            foreach ($existingTickets as $ticket) {
                if (preg_match('/^' . preg_quote($prefix) . '-(\d+)$/', $ticket->ticket_no, $matches)) {
                    $number = intval($matches[1]);
                    if ($number > $maxNumber) {
                        $maxNumber = $number;
                    }
                }
            }
            
            return $maxNumber + 1;
        }
        
        // Special handling for prefix-drcode-number format
        if ($format === 'prefix-drcode-number') {
            // Get doctor's code from users table
            $doctorCode = DB::table('users')->where('id', $doctorId)->value('code');
            $doctorCode = $doctorCode ?: 'DR' . str_pad($doctorId, 3, '0', STR_PAD_LEFT);
            
            $existingTickets = DB::table('consultant_tickets')
                ->where('doctor_id', $doctorId)
                ->whereDate('ticket_date', $today->toDateString())
                ->where('ticket_no', 'like', $prefix . '-' . $doctorCode . '-%')
                ->orderBy('ticket_no', 'desc')
                ->get();
            
            $maxNumber = 0;
            foreach ($existingTickets as $ticket) {
                if (preg_match('/^' . preg_quote($prefix . '-' . $doctorCode . '-') . '(\d+)$/', $ticket->ticket_no, $matches)) {
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
        
        // Get the last ticket number for this doctor today
        $lastTicket = DB::table('consultant_tickets')
            ->where('doctor_id', $doctorId)
            ->whereDate('ticket_date', $today->toDateString())
            ->where('ticket_no', 'like', $searchPattern)
            ->orderBy('ticket_no', 'desc')
            ->first();

        if ($lastTicket) {
            // Extract the number from the last ticket number
            $lastNumber = self::extractNumberFromId($lastTicket->ticket_no, $format, $prefix, $today);
            return $lastNumber + 1;
        }

        return 1; // Start from 1 for each doctor each day
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
            
            case 'prefix-drcode-number':
                // This format requires doctor-specific search pattern, handled separately
                return $prefix . '-%';
            
            default:
                return $prefix . '-' . $today->format('ymd') . '-%';
        }
    }

    /**
     * Extract number from ticket number based on format
     */
    private static function extractNumberFromId($ticketNo, $format, $prefix, $today)
    {
        switch ($format) {
            case 'prefix-yymmdd-number':
                if (preg_match('/-(\d+)$/', $ticketNo, $matches)) {
                    return intval($matches[1]);
                }
                break;
            
            case 'prefixyymmddnumber':
                $datePart = $today->format('ymd');
                $numberPart = substr($ticketNo, strlen($prefix . $datePart));
                if (is_numeric($numberPart)) {
                    return intval($numberPart);
                }
                break;
            
            case 'prefix-yymm-number':
                if (preg_match('/-(\d+)$/', $ticketNo, $matches)) {
                    return intval($matches[1]);
                }
                break;
            
            case 'prefixyymmnumber':
                $datePart = $today->format('ym');
                $numberPart = substr($ticketNo, strlen($prefix . $datePart));
                if (is_numeric($numberPart)) {
                    return intval($numberPart);
                }
                break;
            
            case 'prefix-yy-number':
                if (preg_match('/-(\d+)$/', $ticketNo, $matches)) {
                    return intval($matches[1]);
                }
                break;
            
            case 'prefixyynumber':
                $datePart = $today->format('y');
                $numberPart = substr($ticketNo, strlen($prefix . $datePart));
                if (is_numeric($numberPart)) {
                    return intval($numberPart);
                }
                break;
            
            case 'prefix-number':
                if (preg_match('/-(\d+)$/', $ticketNo, $matches)) {
                    return intval($matches[1]);
                }
                break;
            
            case 'prefixnumber':
                $numberPart = substr($ticketNo, strlen($prefix));
                if (is_numeric($numberPart)) {
                    return intval($numberPart);
                }
                break;
            
            case 'prefix-drcode-number':
                // Extract number from format like DT-DR001-001
                if (preg_match('/-(\d+)$/', $ticketNo, $matches)) {
                    return intval($matches[1]);
                }
                break;
        }
        
        return 0;
    }
} 