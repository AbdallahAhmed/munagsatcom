<?php

namespace App\Console;

use App\Mail\NewsLetters;
use App\Models\Tender;
use App\User;
use Carbon\Carbon;
use Dot\Options\Facades\Option;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;

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
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $tenders = Tender::with(['org', 'org.logo', 'files'])->has('org')->published()
                ->where('last_get_offer_at', '>=', Carbon::now())
                ->take(5)
                ->orderBy('published_at', 'DESC')
                ->get();

            $count = Tender::with(['org', 'org.logo', 'files'])->has('org')->published()
                ->where('last_get_offer_at', '>=', Carbon::now())
                ->where('published_at', '>=', Carbon::now()->subWeek())
                ->count();

            foreach (\Dot\Users\Models\User::where('role_id', 2)->cursor() as $user) {
                try {
                    Mail::to($user->email)->send(new NewsLetters($tenders, $count));
                } catch (\Exception $exception) {

                }
            }
            Option::set('last_news_sent', Carbon::now());
        })->weeklyOn(6, "8:00");
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
