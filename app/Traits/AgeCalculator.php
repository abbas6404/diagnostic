<?php

namespace App\Traits;

use Carbon\Carbon;

trait AgeCalculator
{
    /**
     * Calculate age from date of birth.
     *
     * @param  string|null  $dob
     * @return array
     */
    private function calculateAge($dob)
    {
        if (!$dob) {
            return ['years' => 0, 'months' => 0, 'days' => 0];
        }

        try {
            $dob = Carbon::parse($dob);
            $now = Carbon::now();
            
            // If date of birth is in the future, return 0
            if ($dob->isFuture()) {
                return ['years' => 0, 'months' => 0, 'days' => 0];
            }
            
            // Calculate the difference
            $diff = $now->diff($dob);
            
            return [
                'years' => max(0, $diff->y),
                'months' => max(0, $diff->m),
                'days' => max(0, $diff->d)
            ];
        } catch (\Exception $e) {
            return ['years' => 0, 'months' => 0, 'days' => 0];
        }
    }

    /**
     * Format age display for templates.
     *
     * @param  int|null  $years
     * @param  int|null  $months
     * @param  int|null  $days
     * @return string
     */
    private function formatAge($years, $months, $days)
    {
        $years = $years ?? 0;
        $months = $months ?? 0;
        $days = $days ?? 0;
        
        $ageParts = [];
        
        if ($years > 0) {
            $ageParts[] = $years . ' year' . ($years > 1 ? 's' : '');
        }
        if ($months > 0) {
            $ageParts[] = $months . ' month' . ($months > 1 ? 's' : '');
        }
        if ($days > 0) {
            $ageParts[] = $days . ' day' . ($days > 1 ? 's' : '');
        }
        
        if (empty($ageParts)) {
            return 'N/A';
        }
        
        return implode(' ', $ageParts);
    }
} 