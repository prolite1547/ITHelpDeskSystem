<?php

namespace App\Mail;

use http\Env\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PLDTIssue extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $user;
    public $myAttachments;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->data = $request;
        $this->user = $request->user()->fName;
        $this->myAttachments = $request->attachments;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         $mail = $this->view('emails.PLDTIssue');

         foreach ($this->myAttachments as $attachment){
             $originalFileName = $attachment->getClientOriginalName();
             $fileMimeType = $attachment->getMimeType();
             $mail->attach($attachment->path(),['as'=>$originalFileName,'mime'=>$fileMimeType]);
         }
         return $mail;
    }
}
