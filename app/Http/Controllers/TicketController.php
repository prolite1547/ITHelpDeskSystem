<?php

namespace App\Http\Controllers;

use App\Call;
use App\CategoryB;
use App\CategoryC;
use App\ConnectionIssue;
use App\File;
use App\Http\Requests\StoreTicket;
use App\Incident;
use App\Mail\PLDTIssue;
use App\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getTicket($id)
    {

        $ticket = Ticket::with([
            'incident.call.loggedBy',
            'statusRelation',
            'incident.call.callerRelation',
            'typeRelation',
            'incident.call.contact.store',
            'assigneeRelation',
            'incident.categoryRelation',
            'incident.catARelation',
            'incident',
            'incident.getFiles',
            'ticketMessages'
        ])
            ->findOrFail($id)->toArray();

        return response()->json($ticket);
    }

    public function lookupView(Request $request,$id)
    {
        $ticket = Ticket::findOrFail($id);

        /*1 means Open Ticket*/
        if($ticket->status === 1) {
            $incomplete_ticket = checkTicketDataIfIncomplete($id);
            if($incomplete_ticket['incomplete'] && ($incomplete_ticket['logged_by'] === $request->user()->id)){
                return redirect()->route('incompleteTicket', ['id' => $id]);
            }else{
                return redirect()->back();
            }
        }

        /*CHECK IF TICKET IS CREATED THROUGH CALL OR EMAIL*/
        if ($ticket->incident->call_id) {
            $relationArray = [
                'incident.call.loggedBy',
                'statusRelation',
                'incident.call.callerRelation',
                'typeRelation',
                'incident.call.contact.store',
                'assigneeRelation',
                'incident.categoryRelation',
                'incident.catARelation',
                'incident',
                'incident.getFiles'
            ];
        } else {
            $relationArray = [
                'userLogged',
                'statusRelation',
                'typeRelation',
                'assigneeRelation',
                'incident.categoryRelation',
                'incident.catARelation',
                'incident',
                'incident.getMailData',
                'incident.getFiles',
                'connectionIssueMailReplies' => function ($query) {
                    $query->latest();
                }
            ];

        }

         $ticket::with($relationArray)
            ->findOrFail($id);

        return view("ticket.ticket_lookup", ['ticket' => $ticket]);
    }

    public function addTicketView()
    {
        $userID = Auth::user()->id;

        /*CHECK IF USER STILL HAS UNCOMPLETED TICKET DATA'S*/
        $uncompleted_ticket = validateLoggersTicketStatus($userID);

        if ($uncompleted_ticket['incomplete'] === true) {
            return redirect()->route('incompleteTicket', ['id' => $uncompleted_ticket['ticket_id']]);
        }else{
            return view('ticket.add_ticket');
        }



    }

    public function incompleteTicket($id)
    {

        $ticket = Ticket::findOrFail($id);

        if ($ticket->logged_by === Auth::id()) {
            return view('ticket.incomplete', compact('ticket'));
        } else {
            return redirect()->back();
        }

    }

    public function addTicket(StoreTicket $request)
    {
        /*INSERT/FETCH THEN GET CALLER ID*/
        $caller_id = addCaller($request->except(['_token', 'store']));
        $requester_id = $request->user()->id;

        $insert_data = DB::transaction(function () use ($request, $caller_id, $requester_id) {

            /*INSERT CALL RECORD*/
            $call = Call::create(['caller_id' => $caller_id, 'user_id' => $requester_id])
                ->incident()->create()
                ->ticket()->create(['store' => $request->store, 'status' => 1, 'logged_by' => $requester_id]);

            return $call;
        });

        /*FETCH ID OF THE INSERTED TICKET*/
        $ticket_id = $insert_data->incident->ticket->id;

        return response(compact('ticket_id'));

    }

    public function addTicketDetails(StoreTicket $request)
    {


        /*ID OF THE TICKET AND INCIDENT THAT THE DETAILS WILL BE INSERTED TO*/
        $ticket_id = $request->ticket_id;

        /*INCIDENT_ID OF THE TICKET THE DETAILS WILL BE INSERTED TO*/
        $incident_id = Ticket::findOrFail($ticket_id)->incident_id;

        /*FETCH THE EXPIRATION HOURS COLUMN*/
        $expiration_hours = CategoryB::findOrFail($request->catB)->getExpiration->expiration;
        $catA = CategoryB::findOrFail($request->catB)->group->id;

        /*GENERATE TE EXPIRATION DATE*/
        $expiration_date = Carbon::now()->addHours($expiration_hours);

        /*ADD EXPIRATION IN REQUEST ARRAY*/
        $request->request->add(array('expiration' => $expiration_date, 'catA' => $catA));

        /*CHECK IF THE STATUS OF TICKET WILL BE OPEN OR ONGOING*/
        $request->request->add(self::assignStatus($request->assignee));

        DB::transaction(function () use ($request, $incident_id, $ticket_id) {

            Incident::findOrFail($incident_id)->update($request->only('subject', 'details', 'category', 'catA', 'catB'));
            $ticket = Ticket::findOrFail($ticket_id);
            $ticket->update($request->only('expiration', 'type', 'priority', 'assignee', 'status', 'group'));

            /*CREATE DIRECTORY NAME*/
            $ticketDirectoryName = str_replace(':', '', preg_replace('/[-,\s]/', '_', $ticket->created_at)) . '_' . $ticket_id;

            /*CHECK IF REQUEST CONTAINS A FILE AND STORE IT*/
            if ($request->hasFile('attachments')) {
                foreach ($request->attachments as $attachment) {

                    $original_name = $attachment->getClientOriginalName();
                    $mime_type = $attachment->getMimeType();
                    $original_ext = $attachment->getClientOriginalExtension();
                    $path = $attachment->store("$ticketDirectoryName", 'ticket');

                    File::create(['incident_id' => $incident_id, 'path' => $path, 'original_name' => $original_name, 'mime_type' => $mime_type, 'extension' => $original_ext]);
                };
            }

        });


        return redirect()->route('lookupTicketView', ['id' => $ticket_id]);


    }


    public function open()
    {

        $ticketTotals = ticketTypeCount('status', 1);

        return view('ticket.openTickets', $ticketTotals);
    }

    public function ongoing()
    {

        $ticketTotals = ticketTypeCount('status', 2);
        return view('ticket.ongoingTickets', $ticketTotals);
    }

    public function expired()
    {

        $ticketTotals = ticketTypeCount('status', 6);
        return view('ticket.expiredTickets', $ticketTotals);
    }

    public function closed()
    {

        $ticketTotals = ticketTypeCount('status', 3);
        return view('ticket.closedTickets', $ticketTotals);
    }

    public function fixed()
    {

        $ticketTotals = ticketTypeCount('status', 4);
        return view('ticket.fixedTickets', $ticketTotals);
    }

    public function all()
    {

        $ticketTotals = ticketTypeCount('all');
        return view('ticket.allTickets', $ticketTotals);
    }

    public function forVerification()
    {

        return view('ticket.openTickets');
    }

    public function userTickets()
    {
        $ticketTotals = ticketTypeCount('user', Auth::id());
        return view('ticket.myTickets', $ticketTotals);
    }

    public function delete($id)
    {
        $this->authorize('delete', Ticket::class);
        Ticket::findOrFail($id)->delete();


        return redirect()->route('myTickets');
    }

    public function edit($id, StoreTicket $request)
    {
        try {
            DB::beginTransaction();
            $bool = true;
            if ($request->filled(['incident'])) {
                $incident = Ticket::findOrFail($id)->incident;

                foreach ($request->incident as $key => $value) {
                    $incident->$key = $value;
                }
                $incident->save();

            }

            if ($request->filled(['ticket'])) {
                $ticket = Ticket::findOrFail($id);
                foreach ($request->ticket as $key => $value) {
                    $ticket->$key = $value;
                }

                /*CHECK IF THE STATUS OF TICKET WILL BE OPEN OR ONGOING*/
                $status = self::assignStatus($request->ticket['assignee']);
                $ticket->status = $status['status'];
                $ticket->save();
            }

            if ($request->filled(['fileID'])) {
                foreach ($request->fileID as $id) {
                    $file = File::findOrFail($id);
                    if (Storage::disk('ticket')->delete($file->path)) $file->delete();
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            $bool = $e;
            DB::rollback();
        }


        return response()->json(['success' => $bool]);

    }

    public function editModal($id)
    {
        $ticket = Ticket::with([
            'incident.call.loggedBy',
            'statusRelation',
            'incident.call.callerRelation',
            'typeRelation',
            'incident.call.contact.store',
            'assigneeRelation',
            'incident.categoryRelation',
            'incident.catARelation',
            'incident',
        ])
            ->findOrFail($id);
        $view = view('modal.ticket_edit', ['ticket' => $ticket]);
        $viewString = strlen($view->render());
        return response()->view('modal.ticket_edit', ['ticket' => $ticket])->header('Content-Encoding', 'none')->header('Content-Length', $viewString);
    }

    public function addFile($id, Request $request)
    {

        $ticket = Ticket::findOrFail($id);
        $destination = $ticket->getFileDirectoryFolder();

        foreach ($request->file as $attachment) {

            $original_name = $attachment->getClientOriginalName();
            $mime_type = $attachment->getMimeType();
            $original_ext = $attachment->getClientOriginalExtension();
            $path = $attachment->store($destination, 'ticket');

            File::create(['incident_id' => $ticket->incident->id, 'path' => $path, 'original_name' => $original_name, 'mime_type' => $mime_type, 'extension' => $original_ext]);
        };
    }

    public function print($id)
    {
        $ticket = Ticket::all()->where('id', $id);
        return view('layouts.printTicket')->with('ticket', $ticket);
    }

    public function addConnectionIssue(Request $request)
    {
        $validation = [
            'to' => 'required|string',
            'subject' => 'required|string|min:5',
            'cc' => 'string|nullable',
            'details' => 'required|string|min:5',
            'branch' => 'required|numeric',
            'contact_number' => 'required|string|min:5',
            'contact_person' => 'required|string|min:5',
        ];
        $voice = ['tel' => 'required|string|min:5'];
        $data = ['pid' => 'required|string|min:5'];

        $catC = $request->concern;
        /*GET CATEGORY B id*/
        $catB = CategoryC::findOrFail($catC)->catB;
        /*GET CATEGORY A id*/
        $catB_relations = CategoryB::with('group:id', 'getExpiration:id,expiration')->findOrFail($catB);

        /*ADD TO REQUEST PARAMETER BAG*/
        $request->request->add(['catC' => $catC, 'category' => 3, 'catB' => $catB, 'catA' => $catB_relations->group->id]);

        /*16 IS THE ID OF THE CATEGORY B VOICE*/
        if ($catB === 16) {
            $validation = $validation + $voice;

        } elseif ($catB === 17) {
            $validation = $validation + $data;
        } else {
            $validation = $validation + $data + $voice;
        }

        $request->validate($validation);
        $expiration = Carbon::now()->addHours($catB_relations->getExpiration->expiration);

        if ($catB_relations->name === 'Both') {
            $td_header = 'PID/TEL';
            $concern_number = "{$request->pid}/{$request->tel}";
        } elseif ($catB_relations->name === 'Data') {
            $td_header = 'PID';
            $concern_number = $request->pid;
        } elseif ($catB_relations->name === 'Voice') {
            $td_header = 'TEL';
            $concern_number = $request->tel;
        } else {
            $td_header = 'UNKNOWN';
        }


        $ticket_id = DB::transaction(function () use ($expiration, $request, $td_header, $concern_number) {
            /*INSERT TO DATABASE*/
            $ticket_id = ConnectionIssue::create($request->only(['cc', 'to', 'account', 'pid', 'tel', 'contact_person', 'contact_number']))
                ->incident()->create($request->only(['subject', 'details', 'catC', 'catB', 'catA', 'category']))
                ->ticket()->create(['assignee' => $request->user()->id, 'logged_by' => $request->user()->id, 'type' => 1, 'priority' => 4, 'status' => 2, 'store' => $request->branch, 'group' => 1, 'expiration' => $expiration])->id;

            /*SEND MAIL*/
            $mail = new Mail;
            $to = explode(',', $request->to);

            /*include cc if request has cc*/
            if (!is_null($request->cc)) {
                $cc = explode(',', $request->cc);
                $mail::to($to)->cc($cc)->send(new PLDTIssue($request, $ticket_id, $td_header, $concern_number));
            } else {
                $mail::to($to)->send(new PLDTIssue($request, $ticket_id, $td_header, $concern_number));
            }

            return $ticket_id;

        });

        if (!is_null($ticket_id)) {
            return response()->json(['response' => 'emailConIssueSentSuccess', 'data' => ['ticket_id' => $ticket_id]]);
        }

    }

    public function editStatus(StoreTicket $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->status = 4;
        $ticket->fixed_date = Carbon::now();
        $ticket->save();
    }

    public function reject(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->status = 5;
        $ticket->save();
        $rejected_by = Auth::id();
        $ticket->rejectData()->create(['reason' => $request->reason, 'rejected_by' => $rejected_by]);

        return redirect()->route('lookupTicketView', ['id' => $id]);
    }

    public function rejectForm($id)
    {
        return view('modal.rejectForm', ['id' => $id]);
    }

    public function rejectFormDetails($id)
    {
        $ticket = Ticket::findOrFail($id);
        $rejectData = $ticket->rejectData->first();
        return view('modal.reject_lookup', compact('ticket', 'rejectData'));
    }

    public function getExtendForm($id)
    {
        return view('modal.extendForm', ['id' => $id]);
    }

    public function ticketExtendDetails($id)
    {
        $ticket_extensions = Ticket::findOrFail($id)->extended()->latest()->get();
        return view('ticketExtendDetails', ['ticket_extensions' => $ticket_extensions]);
    }

    private static function assignStatus($assignee)
    {
        /*GET ID'S OF THE OPEN AND ONGOING CATEGORY IN THE CATEGORY TABLE*/
        $openID = 1;
        $ongoingID = 2;

        if (!$assignee) {
            $status = ['status' => $openID];
        } else {
            $status = ['status' => $ongoingID];
        }

        return $status;
    }
}
