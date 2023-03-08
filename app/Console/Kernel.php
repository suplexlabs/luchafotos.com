<?php

namespace App\Console;

use App\Console\Commands\RemoveImageDuplicates;
use App\Console\Commands\SyncImageTags;
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
        $schedule->command('roach:run ImpactPhotosSpider')->daily();
        $schedule->command('roach:run ImpactSpider')->daily();
        // $schedule->command('roach:run AEWPhotosSpider')->daily();

        $schedule->command(RemoveImageDuplicates::class)->daily();
        $schedule->command(SyncImageTags::class)->hourly();
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
