<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Example;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;

class DashboardController extends Controller
{
    /**
     * A pure helper function to calculate percentage growth.
     * * @param int $current
     * @param int $previous
     * @return int|float
     */
    private function calculateGrowth(int $current, int $previous): int|float
    {
        if ($previous === 0) {
            return $current > 0 ? 100 : 0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }

    /**
     * Return comprehensive metrics for the admin dashboard.
     */
    public function metrics(Request $request)
    {
        // 1. Database Size (MySQL/MariaDB specific)
        // Shows you can step outside Eloquent when needed for performance stats.
        $dbSize = DB::table('information_schema.TABLES')
            ->selectRaw('round(sum(data_length + index_length) / 1024 / 1024, 2) as size_mb')
            ->where('table_schema', config('database.connections.mysql.database'))
            ->value('size_mb');

        // 2. Server Health
        // memory_get_usage returns bytes. We'll format this on the frontend.
        $memoryUsage = memory_get_usage(true);

        // 3. User Growth Logic (Functional approach)
        // We get the count for this month vs last month to calculate a percentage.
        $usersThisMonth = User::where('created_at', '>=', now()->startOfMonth())->count();
        $usersLastMonth = User::whereBetween('created_at', [
            now()->subMonth()->startOfMonth(),
            now()->subMonth()->endOfMonth(),
        ])->count();

        $growthPercentage = $this->calculateGrowth($usersThisMonth, $usersLastMonth);

        return response()->json([
            'counts' => [
                'categories' => Category::count(),
                'examples'   => Example::count(),
                'users'      => User::count(),
            ],
            'system' => [
                'laravel_version' => app()->version(),
                'php_version'     => phpversion(),
                'database_size_mb'=> (float) $dbSize,
                'memory_usage_b'  => $memoryUsage,
                'server_load'     => sys_getloadavg()[0] ?? 0, // 1-minute load average
            ],
            'activity' => [
                'users_today'      => User::whereDate('created_at', now()->toDateString())->count(),
                'growth_rate'      => $growthPercentage,
                'failed_jobs'      => DB::table('failed_jobs')->count(), // Checks if your queues are breaking
            ],
        ]);
    }
}
