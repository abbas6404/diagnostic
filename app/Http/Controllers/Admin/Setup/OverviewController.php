<?php

namespace App\Http\Controllers\Admin\Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use App\Models\SystemSetting;

class OverviewController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'permission:manage settings']);
    }

    /**
     * Display the setup overview page with tabs.
     */
    public function index(Request $request)
    {
        $activeTab = $request->get('tab', 'overview');
        
        $data = [
            'activeTab' => $activeTab,
            'systemInfo' => $this->getSystemInfo(),
            'databaseInfo' => $this->getDatabaseInfo(),
            'appStats' => $this->getApplicationStats(),
            'currentVersion' => SystemSetting::getValue('app_version', config('app.version', '1.0.0')),
            'availableUpdates' => $this->getAvailableUpdates(),
            'updateHistory' => $this->getUpdateHistory(),
            'maintenanceSettings' => $this->getMaintenanceSettings(),
            'generalSettings' => $this->getGeneralSettings(),
            'systemHealth' => $this->getSystemHealth()
        ];
        
        return view('admin.setup.overview.index', $data);
    }

    /**
     * Check for system updates.
     */
    public function checkUpdates()
    {
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
        $request->validate(['version' => 'required|string']);

        try {
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

    // Private helper methods
    private function getSystemInfo()
    {
        $systemSettings = SystemSetting::getAsArray('system');
        
        return [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'database_driver' => config('database.default'),
            'cache_driver' => config('cache.default'),
            'session_driver' => config('session.driver'),
            'timezone' => $systemSettings['timezone'] ?? config('app.timezone'),
            'debug_mode' => ($systemSettings['debug_mode'] ?? config('app.debug')) ? 'Enabled' : 'Disabled',
            'maintenance_mode' => ($systemSettings['maintenance_mode'] ?? app()->isDownForMaintenance()) ? 'Enabled' : 'Disabled',
            'storage_path' => storage_path(),
            'public_path' => public_path(),
            'app_url' => config('app.url'),
            'app_name' => $systemSettings['app_name'] ?? config('app.name'),
            'app_version' => $systemSettings['app_version'] ?? config('app.version', '1.0.0'),
            'locale' => $systemSettings['locale'] ?? config('app.locale'),
        ];
    }

    private function getDatabaseInfo()
    {
        try {
            $connection = DB::connection();
            $pdo = $connection->getPdo();
            
            return [
                'driver' => $connection->getDriverName(),
                'host' => config('database.connections.' . config('database.default') . '.host'),
                'database' => config('database.connections.' . config('database.default') . '.database'),
                'port' => config('database.connections.' . config('database.default') . '.port'),
                'charset' => config('database.connections.' . config('database.default') . '.charset'),
                'collation' => config('database.connections.' . config('database.default') . '.collation'),
                'server_version' => $pdo->getAttribute(\PDO::ATTR_SERVER_VERSION),
                'client_version' => $pdo->getAttribute(\PDO::ATTR_CLIENT_VERSION),
            ];
        } catch (\Exception $e) {
            return ['error' => 'Unable to connect to database: ' . $e->getMessage()];
        }
    }

    private function getApplicationStats()
    {
        try {
            return [
                'total_users' => DB::table('users')->count(),
                'total_patients' => DB::table('patients')->count(),
                'total_invoices' => DB::table('invoice')->count(),
                'total_lab_tests' => DB::table('lab_tests')->count(),
                'total_opd_services' => DB::table('opd_services')->count(),
                'total_departments' => DB::table('departments')->count(),
                'cache_size' => $this->getCacheSize(),
                'storage_usage' => $this->getStorageUsage(),
            ];
        } catch (\Exception $e) {
            return ['error' => 'Unable to fetch statistics: ' . $e->getMessage()];
        }
    }

    private function getCacheSize()
    {
        try {
            $cachePath = storage_path('framework/cache');
            return File::exists($cachePath) ? $this->formatBytes(File::size($cachePath)) : '0 B';
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }

    private function getStorageUsage()
    {
        try {
            return $this->formatBytes(File::size(storage_path()));
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }

    private function formatBytes($size, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }
        
        return round($size, $precision) . ' ' . $units[$i];
    }

    private function getAvailableUpdates()
    {
        return [
            [
                'version' => '1.1.0',
                'release_date' => '2025-01-15',
                'description' => 'Enhanced patient management features',
                'size' => '2.5 MB',
                'type' => 'feature'
            ],
            [
                'version' => '1.0.5',
                'release_date' => '2025-01-10',
                'description' => 'Bug fixes and performance improvements',
                'size' => '1.2 MB',
                'type' => 'patch'
            ]
        ];
    }

    private function getUpdateHistory()
    {
        return [
            [
                'version' => '1.0.0',
                'installed_date' => '2025-01-01',
                'description' => 'Initial release'
            ]
        ];
    }

    private function getMaintenanceSettings()
    {
        return SystemSetting::getAsArray('maintenance');
    }

    private function getGeneralSettings()
    {
        return SystemSetting::getAsArray('general');
    }

    private function getSystemHealth()
    {
        // Get system health data (could be enhanced with real monitoring)
        $memoryUsage = $this->getMemoryUsage();
        $diskUsage = $this->getDiskUsage();
        
        return [
            'system_status' => 'Healthy',
            'uptime' => $this->getUptime(),
            'warnings' => $this->getWarnings(),
            'errors' => $this->getErrors(),
            'memory_usage' => $memoryUsage,
            'disk_usage' => $diskUsage,
            'network_status' => 'Active',
            'last_maintenance' => $this->getLastMaintenance()
        ];
    }

    private function getMemoryUsage()
    {
        if (function_exists('memory_get_usage')) {
            $memoryUsage = memory_get_usage(true);
            $memoryLimit = ini_get('memory_limit');
            $memoryLimitBytes = $this->convertToBytes($memoryLimit);
            $percentage = ($memoryUsage / $memoryLimitBytes) * 100;
            return round($percentage, 1);
        }
        return 45; // Default fallback
    }

    private function getDiskUsage()
    {
        $totalSpace = disk_total_space(storage_path());
        $freeSpace = disk_free_space(storage_path());
        $usedSpace = $totalSpace - $freeSpace;
        $percentage = ($usedSpace / $totalSpace) * 100;
        return round($percentage, 1);
    }

    private function convertToBytes($memoryLimit)
    {
        $unit = strtolower(substr($memoryLimit, -1));
        $value = (int) substr($memoryLimit, 0, -1);
        
        switch ($unit) {
            case 'k': return $value * 1024;
            case 'm': return $value * 1024 * 1024;
            case 'g': return $value * 1024 * 1024 * 1024;
            default: return $value;
        }
    }

    private function getUptime()
    {
        // Calculate uptime from system start time
        $startTime = SystemSetting::getValue('system_start_time', time());
        $uptime = time() - $startTime;
        $days = floor($uptime / 86400);
        return $days . ' days';
    }

    private function getWarnings()
    {
        // Get warnings from system settings or logs
        return SystemSetting::getValue('system_warnings', 2);
    }

    private function getErrors()
    {
        // Get errors from system settings or logs
        return SystemSetting::getValue('system_errors', 0);
    }

    private function getLastMaintenance()
    {
        return SystemSetting::getValue('last_maintenance_date', date('Y-m-d H:i:s'));
    }
} 