<?php

namespace App;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'type',
        'store_id',
        'store_type',
        'incident_id',
        'assignee',
        'priority',
        'status',
        'expiration',
        'created_at',
        'logged_by',
        'fixed_date',
        'group'
    ];


    public function userLogged()
    {
        return $this->belongsTo('App\User', 'logged_by');
    }

    public function store()
    {
        return $this->morphTo();
    }

    public function issue()
    {
        return $this->morphTo();
    }

    public function assigneeRelation()
    {
        return $this->belongsTo('App\User', 'assignee')->withDefault(['id' => null]);
    }

    public function priorityRelation()
    {
        return $this->belongsTo('App\Priority', 'priority');
    }

    public function statusRelation()
    {
        return $this->belongsTo('App\Status', 'status');
    }

    public function typeRelation()
    {
        return $this->belongsTo('App\Type', 'type');
    }

    public function ticketMessages()
    {
        return $this->hasMany('App\Message')->latest('created_at');
    }

    public function fixTicket()
    {
        return $this->hasMany('App\Fix', 'ticket_id', 'id');
    }

    public function getFileDirectoryFolder()
    {

        $date = str_replace(':', '', preg_replace('/[-,\s]/', '_', $this->created_at));

        return "{$date}_{$this->id}";
    }

    public function getExpirationAttribute($value)
    {
        $now = Carbon::now();
        if ($now > $value) {
            return 'Expired';
        } else {
            return Carbon::parse($value)->diffForHumans($now);
        }

    }

    public static function TicketCategory($category)
    {
        return static::leftJoin(
            'incidents',
            'incidents.id', '=', 'tickets.incident_id'
        )->where('category', '=', $category);
    }

    public function SDC()
    {
        return $this->hasOne('App\SystemDataCorrection', 'ticket_no');
    }

    public function MDC()
    {
        return $this->hasOne('App\ManualDataCorrection', 'ticket_no');
    }

    public function rejectData()
    {
        return $this->hasMany('App\Reject', 'ticket_id', 'id')->latest()->limit(1);
    }

    public function extended()
    {
        return $this->hasMany('App\Extend');
    }


    public function connectionIssueMailReplies()
    {
        return $this->hasMany('App\ConnectionIssueReply', 'ticket_id', 'id');
    }

    public function resolve()
    {
        return $this->hasOne('App\Resolve');
    }
}
