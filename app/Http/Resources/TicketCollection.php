<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
             'subject' => $this->subject,
             'details' => $this->details,
             'priority' => $this->priority_name,
             'branch'=> $this->store_name,
             'status_name' => $this->status_name,
             'category' => $this->category,
             'catA_name' => $this->catA_name,
             'assigned_user' => $this->assigned_user,
             'logger' => $this->logger,
             'expiration' => $this->expiration,
             'created_at' => $this->created_at,
             'ticket_group_name' => $this->ticket_group_name
        ];
    }
}
