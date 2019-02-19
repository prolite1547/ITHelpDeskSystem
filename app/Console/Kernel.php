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
        $schedule->call(function () {
            $ongoingMailInc = \App\Ticket::whereHas('incident' , function($query){
                $query->whereNotNull('connection_id');
            })->with(['connectionIssueMailReplies' => function($query){
                $query->latest('reply_date');
            },'incident:id,subject'])->get();


            foreach ($ongoingMailInc as $ticket){
                $ticketID =  $ticket->id;
                $subject = $ticket->incident->subject;
                $latest_reply = $ticket->connectionIssueMailReplies->first();

                fetchNewConnectionIssueEmailReplies($ticketID,$subject,$latest_reply);
            }
        })->everyMinute()->runInBackground();
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
