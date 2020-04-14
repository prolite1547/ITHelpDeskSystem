<?php

namespace App\Http\Controllers;

use App\ConnectionIssueReply;
use App\Mail\ConnectionIssueReply as ConnectionIssueReplyMail;
use App\Ticket;
use App\ConnectionIssue;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ConnectionIssueReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ConnectionIssueReply  $connectionIssueReply
     * @return \Illuminate\Http\Response
     */
    public function show(ConnectionIssueReply $connectionIssueReply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ConnectionIssueReply  $connectionIssueReply
     * @return \Illuminate\Http\Response
     */
    public function edit(ConnectionIssueReply $connectionIssueReply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ConnectionIssueReply  $connectionIssueReply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ConnectionIssueReply $connectionIssueReply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ConnectionIssueReply  $connectionIssueReply
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConnectionIssueReply $connectionIssueReply)
    {
        //
    }

    public function replyConversation($id){

        $html_body = ConnectionIssueReply::findOrFail($id)->html_body;

        return view('replyConvo',['full_convo' => $html_body]);
    }


    public function connIssReplyAPI($id){
        return  new \App\Http\Resources\ConnectionIssueReplyCollection(Ticket::with(['connectionIssueMailReplies' => function($query){
            return $query->latest('reply_date');
        }])->findOrFail($id)->connectionIssueMailReplies
        );
    }

    public function getReplyfromMail($id){
        try{
            $ongoingMailInc = \App\ConnectionIssue::with(['incident.ticket.connectionIssueMailReplies' => function($query){
                $query->latest('reply_date');
            }])->find($id);
            $ticketID =  $ongoingMailInc->incident->ticket->id;
            $subject = $ongoingMailInc->incident->subject . " (TID#{$ticketID})";
                /*latest reply on the database*/
            $latest_reply = $ongoingMailInc->incident->ticket->connectionIssueMailReplies->first(); 
        
            fetchNewConnectionIssueEmailReplies($ticketID,$subject,$latest_reply);
        return response()->json(array('success'=>true), 200);
        }catch(Exception $ex){  
            return response()->json(array('success'=>false), 200);
        }

        return response()->json(array('success'=>false), 200);
    }

    public function replyMail(Request $request){
        
        // |string|min:5|max:500
        $validatedData = $request->validate([
            'to' => 'required',
            'subject' => 'required|string|min:5|max:500',
            'reply' => 'required|string|min:5',
            'reply_attachments.*' => 'file'
        ]);

        $to =  $validatedData['to'];
        $cc =  $request->cc;
        // $cc =  explode(',',$validatedData['cc']);
        // $to = explode(',',$validatedData['to']);
        if($cc){
            Mail::to($to)->cc($cc)->send(new ConnectionIssueReplyMail($validatedData));
        }else{
            Mail::to($to)->send(new ConnectionIssueReplyMail($validatedData));
        }
        $incident_id = $request->incident_id;
        $c_email  = ConnectionIssue::findorfail($incident_id);
        $c_email->to = implode(',', $to);
        if(count($cc) > 0){
            $c_email->cc = implode(',', $cc);
        }else{
            $c_email->cc = '';
        }
        $c_email->save(); 
    }
}
