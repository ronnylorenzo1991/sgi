<?php

namespace App\Console;

use App\Console\Commands\DailyTaskRun;
use App\Console\Commands\DailyTaskStop;
use App\Console\Commands\NaightlyTaskRun;
use App\Console\Commands\NightlyTaskRun;
use App\Console\Commands\NightlyTaskStop;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        DailyTaskRun::class,
        DailyTaskStop::class,
        NightlyTaskRun::class,
        NightlyTaskStop::class
    ];

    /**
     * Get the timezone that should be used by default for scheduled events.
     *
     * @return \DateTimeZone|string|null
     */
    protected function scheduleTimezone()
    {
        return 'America/Santiago';
    }

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('nightlytask:stop')->dailyAt('07:00');
        $schedule->command('dailytask:run')->dailyAt('07:01');
        $schedule->command('dailytask:stop')->dailyAt('18:00');
        $schedule->command('nightlytask:run')->dailyAt('18:01');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
