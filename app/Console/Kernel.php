<?php

namespace App\Console;

use App\Models\Backup;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Storage;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        // run schedule every day at 7pm
        $schedule->command('attendance:check')->dailyAt('19:00');
        // run schedule every day at 1am
        $schedule->command('backup:clean')->daily()->at('01:00');
        // $schedule->command('backup:run --only-db --filename=HRMO-DB-BACKUP-' . Carbon::now()->format('Y-m-d') . '.zip')->everyMinute();
        // you can comment the command bellow and uncomment the one above to run the backup every minute
        $schedule->command('backup:run --only-db --filename=HRMO-DB-BACKUP-' . Carbon::now()->format('Y-m-d') . '.zip')->daily()->at('01:00');

        // run schedule every month
        $schedule->command('employee:update-attendance')->everyMinute();
        $schedule->command('employee:slp')->monthly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
