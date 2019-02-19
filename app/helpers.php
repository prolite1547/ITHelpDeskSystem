<?php

use App\Caller;
use App\Category;
use App\Status;
use App\Ticket;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

if (! function_exists('selectArray')) {
        function selectArray($group = '',$model,$id,$name){

            if($group){
                $category = $model::find($group);
                $rows = $category->categories;
            }else{
                $rows = $model::all();
            }




            $select = [];
            foreach ($rows as $category) {
                $select = array_add($select,$category->$id,$category->$name);
            }


            return $select;
        }
    }

    if (! function_exists('lookupCategories')) {
        //iterates array and look up the id to the categories table to get the value
        function lookupCategories($array){

            $lookupCategories = [];
            foreach ($array as $key => $value) {
                if($data = Category::find($value)){
                    $lookupCategories[$key] = $data;
                }
            }

            return $lookupCategories;
        }
    }

    if (! function_exists('groupListSelectArray')) {
        function groupListSelectArray($model,$groupName,$relationship,$value,$name){

            $records = $model::with($relationship)->get();
            $dataArray = [];
            foreach ($records as $row){
                if($row->$relationship->count() !== 0){
                    $dataArray[$row->$groupName] = $row->$relationship->pluck($name,$value)->toArray();
                }
            }
            return $dataArray;
        }


    }

if (! function_exists('ticketTypeCount')) {
    function ticketTypeCount($type,$id = ''){

        if($type === 'all'){
            $tickets = Ticket::all();
        }elseif($type === 'status'){
            $tickets = Ticket::whereStatus($id)->get();
        }elseif($type === 'user'){
            $tickets = User::find($id)->assignedTickets;
        }

        $ticketCount = $tickets->count();
        $incident = $request = $others = 0;
        foreach ($tickets as $ticket){
            if($ticket->type === 1){
                $incident++;
            }elseif ($ticket->type === 2){
                $request++;
            }else{
                $others++;
            }
        }

        return compact('incident','request','ticketCount');
    }
}

if (! function_exists('addCaller')) {
    function addCaller($data){
        $caller = $caller = "{$data['fName']} {$data['mName']} {$data['lName']}";

        $fetchedCaller = Caller::where(DB::raw('CONCAT_WS(" ",fName,mName,lName)'),'like',$caller)->first();
        if($fetchedCaller === null){
            return $caller_id = Caller::create($data)->id;
        }else {
            return $caller_id = $fetchedCaller->id;
        }
    }
}

if (! function_exists('validateLoggersTicketStatus')) {
    function validateLoggersTicketStatus($user_id){
        $user_tickets = DB::table('users as u')
            ->where('u.id',$user_id)
            ->whereNotNull('t.id')
            ->where(function ($query){
                $query->orWhere(['t.priority' => null,'t.expiration' => null,'i.subject' => null,'i.details' => null,'i.category' => null,'i.catA' => null,'i.catB' => null,'t.group' => null]);
            })
            ->leftJoin('tickets as t','u.id','t.logged_by')
            ->leftJoin('incidents as i','t.incident_id','i.id')
            ->select('t.id','t.incident_id','t.priority','t.expiration','i.subject','i.details','i.category','i.catA','i.catB')
            ->first();

        return $user_tickets;
    }
}

if (! function_exists('getNotificationContent')) {
    function getNotificationContent($userID){
        $userRejectedTickets = Ticket::whereStatus(5)->whereAssignee($userID)->count();

        if($userRejectedTickets !== 0){
            return $userRejectedTickets > 1 ?  "You have {$userRejectedTickets} rejected tickets!" : "You have {$userRejectedTickets} rejected ticket!";
        }else{
            return false;
        }
    }
}
if (! function_exists('cleanInputs')) { /*uppercase words and remove extra white spaces*/
    function cleanInputs($string){

        if($string !== ''){
            return $cleanString = ucwords(preg_replace('/\s+/', ' ', rtrim(ltrim(strtolower($string)))));
        }else {
            return $string;
        }
    }
}

if (! function_exists('getNumberOfTicketsOnASpecStatus')) { /*uppercase words and remove extra white spaces*/
    function getNumberOfTicketsOnASpecStatus(){

        $ticketStatuses = Status::all()->pluck('name','id')->toArray();
        $ticketCounts = array();
        $ticketCounts['All'] =  Ticket::all()->count();
        foreach ($ticketStatuses as $key => $value){
            if($value === 'Fixed'){
                $count = Status::findOrFail($key)->tickets->whereIn('group',getGroupIDDependingOnUser())->count();
            }else{
                $count = Status::findOrFail($key)->tickets->count();
            }
            $ticketCounts[$value] = $count;
        }

        return $ticketCounts;
    }
}

if (! function_exists('getGroupIDDependingOnUser')) { /*uppercase words and remove extra white spaces*/
    function getGroupIDDependingOnUser(){

        $authRoleID = Auth::user()->role->id;
        $authPositionID = Auth::user()->position->id;


        $group = [4 => [1],5 => [2],'all' => [1,2]];

        /*4 is equivalent to admin user*/
        if($authRoleID !== 4){

            if($authPositionID !== 1 && $authPositionID !== 2){
                $groupID = $group[$authPositionID];
            }else{
                $groupID = $group[4];
            }

        }else {
            $groupID = $group['all'];
        }


        return $groupID;
    }
}


if (! function_exists('fetchNewConnectionIssueEmailReplies')) { /*uppercase words and remove extra white spaces*/
     function fetchNewConnectionIssueEmailReplies(int $ticketID,string $subject,$latest_reply){
        $date = \Carbon\Carbon::now()->format('d.m.Y');
        $email_unique = "tid#$ticketID";
        $oClient = new \Webklex\IMAP\Client;
        $oClient->connect();

        $inboxFolder = $oClient
            ->getFolder('INBOX');

        $inboxMessages = $inboxFolder
            ->query()
            ->since($date)
            ->subject($subject)
            ->body($email_unique)
            ->setFetchFlags(false)
            ->setFetchBody(true)
            ->setFetchAttachment(true)
            ->get();


        $latestInboxMessage = $inboxMessages->first();


        if($latestInboxMessage !== null){
            $plain_text = $latestInboxMessage->getTextBody();
            $html_body = $latestInboxMessage->getHTMLBody();
            $reply = (new \EmailReplyParser\Parser\EmailParser())->parse($latestInboxMessage->getTextBody())->getVisibleText();
            $hasAttachments = $latestInboxMessage->getAttachments()->count();
            $subject = $latestInboxMessage->getSubject();
            $from = json_encode($latestInboxMessage->getFrom());
            $to = json_encode($latestInboxMessage->getTo());
            $cc = json_encode($latestInboxMessage->getCC());
            $reply_to = $latestInboxMessage->getInReplyTo();
            $reply_date = $latestInboxMessage->getDate();
            $ticket_id = $ticketID;

            $connection_issue = new \App\ConnectionIssueReply;
            $connection_issue_fillable = $connection_issue->getFillable();


            if (is_null($latest_reply)) { /*IF MAIL HAS NO REPLY YET THEN INSERT*/
                $connection_issue->create(compact($connection_issue_fillable));
            } else if (($latest_reply->reply !== $reply && !$latest_reply->reply_date->equalTo($reply_date))) {
                $connection_issue->create(compact($connection_issue_fillable));
            }

        }
    }
}

?>
