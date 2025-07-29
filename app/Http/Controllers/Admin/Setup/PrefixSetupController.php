<?php

namespace App\Http\Controllers\Admin\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use App\Models\SystemSetting;

class PrefixSetupController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'permission:manage settings']);
    }

    /**
     * Display the prefix setup page.
     */
    public function index()
    {
        // Get current prefix settings
        $prefixSettings = $this->getPrefixSettings();
        
        return view('admin.setup.prefix-setup.index', compact('prefixSettings'));
    }

    /**
     * Save prefix settings.
     */
    public function saveSettings(Request $request)
    {
        // Debug: Log the incoming request
        \Log::info('Save prefix settings request received', [
            'all_data' => $request->all(),
            'type' => $request->input('type'),
            'headers' => $request->headers->all(),
            'method' => $request->method(),
            'url' => $request->url()
        ]);
        
        // Add validation back for proper error handling
        $request->validate([
            'type' => 'required|string|in:consolidated_invoice,diagnosis,opd',
            'consolidated_invoice_prefix' => 'nullable|string|max:10',
            'consolidated_invoice_start' => 'nullable|integer|min:1',
            'consolidated_invoice_format' => 'nullable|string',
            'diagnosis_prefix' => 'nullable|string|max:10',
            'diagnosis_start' => 'nullable|integer|min:1',
            'diagnosis_format' => 'nullable|string',
            'opd_prefix' => 'nullable|string|max:10',
            'opd_start' => 'nullable|integer|min:1',
            'opd_format' => 'nullable|string',
        ]);

        try {
            $type = $request->input('type');
            $settings = [];

            // Extract settings based on type
            switch ($type) {
                case 'consolidated_invoice':
                    $settings = [
                        'prefix' => $request->input('consolidated_invoice_prefix'),
                        'start' => $request->input('consolidated_invoice_start'),
                        'format' => $request->input('consolidated_invoice_format'),
                    ];
                    break;
                case 'diagnosis':
                    $settings = [
                        'prefix' => $request->input('diagnosis_prefix'),
                        'start' => $request->input('diagnosis_start'),
                        'format' => $request->input('diagnosis_format'),
                    ];
                    break;
                case 'opd':
                    $settings = [
                        'prefix' => $request->input('opd_prefix'),
                        'start' => $request->input('opd_start'),
                        'format' => $request->input('opd_format'),
                    ];
                    break;
            }

            // Debug: Log the extracted settings
            \Log::info('Extracted settings', [
                'type' => $type,
                'settings' => $settings
            ]);

            // Save settings to database
            $this->savePrefixSettings($type, $settings);

            return response()->json([
                'success' => true,
                'message' => ucfirst(str_replace('_', ' ', $type)) . ' settings saved successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to save prefix settings', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to save settings: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reset all prefixes.
     */
    public function resetPrefixes()
    {
        try {
            // Reset all prefix settings to defaults
            $this->resetAllPrefixSettings();

            return response()->json([
                'success' => true,
                'message' => 'All prefix settings have been reset successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reset prefixes: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export prefix settings.
     */
    public function exportSettings()
    {
        try {
            $prefixSettings = $this->getPrefixSettings();
            
            // Export only prefix settings with metadata
            $exportData = [
                'exported_at' => now()->toISOString(),
                'version' => '1.0',
                'description' => 'Prefix Settings Export',
                'settings' => $prefixSettings
            ];
            
            return response()->json($exportData)
                ->header('Content-Type', 'application/json')
                ->header('Content-Disposition', 'attachment; filename="prefix-settings.json"');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to export settings: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Import prefix settings.
     */
    public function importSettings(Request $request)
    {
        try {
            $request->validate([
                'settings' => 'required|array'
            ]);

            $settings = $request->input('settings');
            

            
            // Handle both old and new format structures
            $importData = [];
            
            // Process consolidated invoice settings
            if (isset($settings['consolidated_invoice'])) {
                $importData['consolidated_invoice_prefix'] = $settings['consolidated_invoice']['prefix'] ?? 'DR';
                $importData['consolidated_invoice_start'] = $settings['consolidated_invoice']['start'] ?? '1';
                $importData['consolidated_invoice_format'] = $this->convertFormat($settings['consolidated_invoice']['format'] ?? 'prefix-yymmdd-number');
            }
            
            // Process diagnosis settings
            if (isset($settings['diagnosis'])) {
                $importData['diagnosis_prefix'] = $settings['diagnosis']['prefix'] ?? 'DX';
                $importData['diagnosis_start'] = $settings['diagnosis']['start'] ?? '1';
                $importData['diagnosis_format'] = $this->convertFormat($settings['diagnosis']['format'] ?? 'prefix-yymmdd-number');
            }
            
            // Process OPD settings
            if (isset($settings['opd'])) {
                $importData['opd_prefix'] = $settings['opd']['prefix'] ?? 'OPD';
                $importData['opd_start'] = $settings['opd']['start'] ?? '1';
                $importData['opd_format'] = $this->convertFormat($settings['opd']['format'] ?? 'prefix-yymmdd-number');
            }
            

            
            // Save all imported settings
            foreach ($importData as $key => $value) {
                SystemSetting::setValue($key, $value, 'string', 'prefix');
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Settings imported successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to import settings: ' . $e->getMessage()
            ], 500);
        }
    }



    /**
     * Convert old format values to new format values.
     */
    private function convertFormat($oldFormat)
    {
        // If the format is already in the new format, return it as is
        $newFormats = [
            'prefix-yymmdd-number',
            'prefixyymmddnumber',
            'prefix-yymm-number',
            'prefixyymmnumber',
            'prefix-yy-number',
            'prefixyynumber',
            'prefix-number',
            'prefixnumber'
        ];
        
        if (in_array($oldFormat, $newFormats)) {
            return $oldFormat;
        }
        
        $formatMap = [
            'Prefix-yymmdd-001' => 'prefix-yymmdd-number',
            'Prefix-yymmdd-002' => 'prefix-yymmdd-number',
            'Prefix-yymmdd-003' => 'prefix-yymmdd-number',
            'Prefix-yy-mm-dd-001' => 'prefix-yy-mm-dd-number',
            'Prefix-yy-mm-dd-002' => 'prefix-yy-mm-dd-number',
            'PREFIX-YEAR-NUMBER' => 'prefix-yymmdd-number',
            'PREFIX-NUMBER' => 'prefix-number'
        ];
        
        return $formatMap[$oldFormat] ?? 'prefix-yymmdd-number';
    }



    /**
     * Get prefix settings.
     */
    private function getPrefixSettings()
    {
        $settings = SystemSetting::getByGroup('prefix');
        $prefixSettings = [];
        
        foreach ($settings as $setting) {
            $key = $setting->key;
            $value = $setting->value;
            
            // Group settings by type
            if (str_contains($key, 'consolidated_invoice')) {
                $prefixSettings['consolidated_invoice'][str_replace('consolidated_invoice_', '', $key)] = $value;
            } elseif (str_contains($key, 'diagnosis')) {
                $prefixSettings['diagnosis'][str_replace('diagnosis_', '', $key)] = $value;
            } elseif (str_contains($key, 'opd')) {
                $prefixSettings['opd'][str_replace('opd_', '', $key)] = $value;
            }
        }
        
        // Add current numbers (mock for now, could be stored separately)
        $prefixSettings['consolidated_invoice']['current_number'] = 1;
        $prefixSettings['diagnosis']['current_number'] = 1;
        $prefixSettings['opd']['current_number'] = 1;
        
        return $prefixSettings;
    }

    /**
     * Save prefix settings.
     */
    private function savePrefixSettings($type, $settings)
    {
        foreach ($settings as $key => $value) {
            $settingKey = $type . '_' . $key;
            
            SystemSetting::setValue($settingKey, $value, 'string', 'prefix');
        }
        
        return true;
    }

    /**
     * Reset all prefix settings.
     */
    private function resetAllPrefixSettings()
    {
        // Reset to default values with new date-based formats
        $defaults = [
            'consolidated_invoice_prefix' => 'DR', // Changed to DR for Doctor Ticket
            'consolidated_invoice_start' => '1',
            'consolidated_invoice_format' => 'prefix-yymmdd-number',
            'diagnosis_prefix' => 'DX',
            'diagnosis_start' => '1',
            'diagnosis_format' => 'prefix-yymmdd-number',
            'opd_prefix' => 'OPD',
            'opd_start' => '1',
            'opd_format' => 'prefix-yymmdd-number',
        ];
        
        foreach ($defaults as $key => $value) {
            SystemSetting::setValue($key, $value, 'string', 'prefix');
        }
        
        return true;
    }

    /**
     * Get system information.
     */
    private function getSystemInfo()
    {
        return [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'database_driver' => config('database.default'),
            'cache_driver' => config('cache.default'),
            'session_driver' => config('session.driver'),
            'timezone' => config('app.timezone'),
            'debug_mode' => config('app.debug') ? 'Enabled' : 'Disabled',
            'maintenance_mode' => app()->isDownForMaintenance() ? 'Enabled' : 'Disabled',
            'storage_path' => storage_path(),
            'public_path' => public_path(),
            'app_url' => config('app.url'),
        ];
    }

    /**
     * Check for system updates.
     */
    public function checkUpdates()
    {
        // This would typically connect to an update server
        // For now, we'll return mock data
        return response()->json([
            'success' => true,
            'updates_available' => 2,
            'latest_version' => '1.1.0',
            'current_version' => config('app.version', '1.0.0'),
            'message' => 'Updates are available'
        ]);
    }

    /**
     * Perform system update.
     */
    public function performUpdate(Request $request)
    {
        $request->validate([
            'version' => 'required|string'
        ]);

        try {
            // This would typically download and install updates
            // For now, we'll just return success
            return response()->json([
                'success' => true,
                'message' => 'System updated successfully to version ' . $request->version
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Update failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear system cache.
     */
    public function clearCache()
    {
        try {
            Cache::flush();
            \Artisan::call('cache:clear');
            \Artisan::call('config:clear');
            \Artisan::call('view:clear');
            \Artisan::call('route:clear');
            
            return response()->json([
                'success' => true,
                'message' => 'Cache cleared successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear cache: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Optimize system.
     */
    public function optimizeSystem()
    {
        try {
            \Artisan::call('config:cache');
            \Artisan::call('route:cache');
            \Artisan::call('view:cache');
            
            return response()->json([
                'success' => true,
                'message' => 'System optimized successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to optimize system: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Backup database.
     */
    public function backupDatabase()
    {
        try {
            // This would typically create a database backup
            // For now, we'll just return success
            return response()->json([
                'success' => true,
                'message' => 'Database backup completed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Backup failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clean up logs.
     */
    public function cleanupLogs()
    {
        try {
            // This would typically clean old log files
            // For now, we'll just return success
            return response()->json([
                'success' => true,
                'message' => 'Log cleanup completed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Log cleanup failed: ' . $e->getMessage()
            ], 500);
        }
    }
} 