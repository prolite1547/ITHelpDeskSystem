<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageCollection extends JsonResource
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
            'full_name' => $this->user->full_name,
            'prof_pic' => base_path()."/storage/profpic/".$this->user_id."/".$this->user->profpic->image,
            'message' => $this->message,
            'created_at' => $this->created_at,
        ];
    }
}
