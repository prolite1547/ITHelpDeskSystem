<?php

namespace App\Http\Controllers;

use App\Http\Resources\TicketCollection as TicketResource;
use App\Http\Resources\TicketDetailResource as TicketDetailResource;
use App\Http\Resources\MessageCollection as MessageResource;
use App\Ticket;
use App\Status;
use App\Message;
 
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class ApiController extends Controller
{
     public function get_tickets($status){
        $statuses = Status::whereNotIn('name', ['fixed','closed'])->pluck('name')->toArray();
        $query = DB::table('v_tickets')->select('v_tickets.id', 'v_tickets.priority_name', 'v_tickets.status_id','v_tickets.status_name', 'v_tickets.expiration', 'v_tickets.created_at',
        'v_tickets.subject', 'v_tickets.details', 'v_tickets.category','v_tickets.catA_name',
        'v_tickets.assigned_user',
        'v_tickets.store_name',
        'v_tickets.logger',
        'v_tickets.ticket_group_name',
        'v_tickets.times_extended')
        ->when(in_array(strtolower($status), array_map('strtolower', $statuses), true), function ($query) use ($status) {
            $get_status = Status::where('name', $status)->firstOrFail();
            return $query->whereStatusId($get_status->id)->limit(10)->get();
        })
        ->when($status === 'my', function ($query) {
            return $query->limit(10)->get(); 
            // $query->whereAssigneeId(Auth::id())->where('status_id', '!=', 3)->limit(10)->get();
        })
        ->when($status === 'all', function ($query) {
            return $query->limit(10)->get(); 
            // $query->whereAssigneeId(Auth::id())->where('status_id', '!=', 3)->limit(10)->get();
        });
        return TicketResource::collection($query);
     }

     public function get_messages($id){
        $query =  Message::with('user', 'user.profpic')->where('ticket_id', '=', $id)->get();
        return MessageResource::collection($query);
     }

     public function get_ticket_details($id){

        $ticket = Ticket::findOrFail($id);

        if ($ticket->status === 1) {
            $incomplete_ticket = checkTicketDataIfIncomplete($id);
            if ($incomplete_ticket['incomplete'] && ($incomplete_ticket['logged_by'] === $request->user()->id)) {
                return redirect()->route('incompleteTicket', ['id' => $id]);
            }
        }

        if ($ticket->issue->incident_type === \App\Call::class) {
            $relationArray = [
                'issue.incident.loggedBy',
                'statusRelation',
                'issue.incident.caller',
                'typeRelation',
                'issue.incident.contact.store',
                'assigneeRelation',
                'issue.categoryRelation',
                'issue.catARelation',
                'issue',
                'issue.getFiles'
            ];
        } else {
            $relationArray = [
                'userLogged',
                'statusRelation',
                'typeRelation',
                'assigneeRelation',
                'issue.categoryRelation',
                'issue.catARelation',
                'issue',
                'issue.getFiles',
                'connectionIssueMailReplies' => function ($query) {
                    $query->latest();
                }
            ];

        }
        $query  = $ticket::with($relationArray)->where('id', '=', $id)->get();
        return TicketDetailResource::collection($query);
     }
}
