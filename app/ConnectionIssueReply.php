<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConnectionIssueReply extends Model
{
    protected $fillable = [
      'plain_text',
      'html_body',
      'reply',
      'hasAttachments',
      'subject',
      'from',
      'to',
      'cc',
      'reply_to',
      'reply_date',
        'ticket_id'
    ];

    protected $dates = ['reply_date'];

    public function ticket(){
        return $this->belongsTo('App\Ticket');
    }
}
