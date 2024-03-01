<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('fixture-odds:update')
            ->daily()
        ->withoutOverlapping()
            ->emailOutputOnFailure('tonnyblair257@gmail.com');

        // $schedule->command('inspire')->hourly();
        $schedule->command('premier-scores:update')
            ->everyMinute()
        ->withoutOverlapping()
            ->emailOutputOnFailure('tonnyblair257@gmail.com');

        // $schedule->command('inspire')->hourly();
        $schedule->command('premier-fixture:update')
            ->daily()
        ->withoutOverlapping()
        ->emailOutputOnFailure('tonnyblair257@gmail.com');
        // $schedule->command('inspire')->hourly();
        $schedule->command('premier-league:update')
            ->daily()
            ->withoutOverlapping()
            ->emailOutputOnFailure('tonnyblair257@gmail.com');

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
