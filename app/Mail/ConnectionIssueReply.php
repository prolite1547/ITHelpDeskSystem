<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConnectionIssueReply extends Mailable
{
    use Queueable, SerializesModels;

    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->data = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->subject($this->data['subject'])
            ->view('emails.conIssueReply');
        if(array_key_exists('reply_attachments', $this->data)){
                foreach ($this->data['reply_attachments'] as $attachment) {
                    $originalFileName = $attachment->getClientOriginalName();
                    $fileMimeType = $attachment->getMimeType();
                    $mail->attach($attachment->path(), ['as' => $originalFileName, 'mime' => $fileMimeType]);
                }
        }
        return $mail;
    }
}
