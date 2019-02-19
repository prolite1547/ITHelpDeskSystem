<?php

namespace App\Mail;

use App\CategoryC;
use http\Env\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Store;

class PLDTIssue extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $user;
    public $myAttachments;
    public $incidentSubject;
    public $branch;
    public $concern;
    public $ticket_id;
    public $td_header;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request,$ticket_id,$td_header)
    {
        $this->data = $request;
        $this->user = $request->user()->fName;
        $this->myAttachments = $request->attachments;
        $this->incidentSubject = $request->subject;
        $this->branch = $this->getBranchName($request->branch);
        $this->concern = $this->getConcernName($request->concern);
        $this->ticket_id = $ticket_id;
        $this->td_header = $td_header;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         $mail = $this->subject($this->incidentSubject)
             ->view('emails.PLDTIssue');

        if($this->data->has('attachments')){
            if ($this->data->file('attachments')->isValid()) {
                foreach ($this->myAttachments as $attachment) {
                    $originalFileName = $attachment->getClientOriginalName();
                    $fileMimeType = $attachment->getMimeType();
                    $mail->attach($attachment->path(), ['as' => $originalFileName, 'mime' => $fileMimeType]);
                }
            }
        }
         return $mail;
    }

    private function getBranchName($id){
        return Store::findOrFail($id)->store_name;
    }

    private function getConcernName($id){
        return CategoryC::findOrFail($id)->name;
    }
}
