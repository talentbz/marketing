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

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        // google ads MTD schedule
        $schedule->call('App\Http\Controllers\GoogleAdsApiController@getMTD')->hourly()->timezone('America/New_York');

        // google klaviyo stats
        $schedule->call('App\Http\Controllers\KlApiController@getMTD')->dailyAt('8:50')->timezone('America/New_York');

        // Tiktok stats
        $schedule->call('App\Http\Controllers\TikController@getMTDCost')->everyThirtyMinutes()->timezone('America/New_York');

        // fb stats
        $schedule->call('App\Http\Controllers\FbApiController@getMTD')->everyThirtyMinutes()->timezone('America/New_York');

        //TT stats
        $schedule->call('App\Http\Controllers\TikController@getMTD')->everyThirtyMinutes()->timezone('America/New_York');

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
