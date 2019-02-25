<?php

namespace App\Http\Controllers;

use App\ConnectionIssueReply;
use App\Mail\ConnectionIssueReply as ConnectionIssueReplyMail;
use App\Ticket;
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

    public function replyMail(Request $request){

        $validatedData = $request->validate([
            'to' => 'required|string|min:5|max:500',
            'subject' => 'required|string|min:5|max:500',
            'reply' => 'required|string|min:5',
            'reply_attachments.*' => 'file'
        ]);

        $to = explode(',',$validatedData['to']);
        Mail::to($to)->send(new ConnectionIssueReplyMail($validatedData));
    }
}
