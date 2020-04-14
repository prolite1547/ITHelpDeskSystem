<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'ticket_id' => $this->id,
            'status' => $this->statusRelation->name,
            'caller' => $this->issue->incident->caller->full_name,
            'caller_position' =>$this->issue->incident->caller->position->position,
            'logged_date' => $this->created_at,
            'expiration' => $this->getOriginal('expiration'),
            'logged_by' => $this->userLogged->full_name,
            'priority' => $this->priorityRelation->name,
            'type' => $this->typeRelation->name,
            'store_name' => $this->store->store_name,
            'assigned_to' => $this->assigneeRelation->full_name,
            'user_role' => $this->assigneeRelation->role->role,
            'category' => $this->issue->categoryRelation->name . " - " . $this->issue->catARelation->name . " - ". $this->issue->catBRelation->name,
        ];
    }
}
