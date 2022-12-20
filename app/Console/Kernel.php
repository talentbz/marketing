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
        $schedule->call('App\Http\Controllers\GoogleAdsApiController@getMTD')->hourly();

        // google klaviyo stats
        $schedule->call('App\Http\Controllers\KlApiController@getMTD')->hourly();

        // Tiktok stats
        $schedule->call('App\Http\Controllers\TikController@getMTDCost')->hourly();

        // fb stats
        $schedule->call('App\Http\Controllers\FbApiController@getMTD')->hourly();

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
