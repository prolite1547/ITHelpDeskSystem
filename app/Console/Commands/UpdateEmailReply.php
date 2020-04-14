<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateEmailReply extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:emailreps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will update all the latest email replies';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $ongoingMailInc = \App\ConnectionIssue::whereHas('incident.ticket',function($query){
            $query->where('status',2);
        })->with(['incident.ticket.connectionIssueMailReplies' => function($query){
            $query->latest('reply_date');
        }])->get();
            
        foreach ($ongoingMailInc as $connection_issue){
            sleep(30);
            $ticketID =  $connection_issue->incident->ticket->id;
            $subject = $connection_issue->incident->subject . " (TID#{$ticketID})";
            $latest_reply = $connection_issue->incident->ticket->connectionIssueMailReplies->first(); /*latest reply on the database*/
        
            fetchNewConnectionIssueEmailReplies($ticketID,$subject,$latest_reply);
            sleep(30);
        }
    }
}
