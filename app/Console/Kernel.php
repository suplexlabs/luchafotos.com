<?php

namespace App\Console;

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
        //
    ];

    protected function bootstrappers()
    {
        return array_merge(
            [\Bugsnag\BugsnagLaravel\OomBootstrapper::class],
            parent::bootstrappers(),
        );
    }

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // crawlers
        $schedule->command('roach:run WWEVideosSpider')->twiceDaily();
        $schedule->command('roach:run WWEShowsSpider')->everySixHours();
        $schedule->command('roach:run ImpactPhotosSpider')->weekly();
        $schedule->command('roach:run ImpactSpider')->daily();
        // $schedule->command('roach:run AEWPhotosSpider')->daily();

        // backups
        // $schedule->command('backup:clean')->daily()->at('01:00')->timezone('America/New_York');
        // $schedule->command('backup:run')->daily()->at('01:30')->timezone('America/New_York');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
