<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
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
            'id'=>$this->id,
            'session_id'=>$this->session_id,
            'message'=>$this->message['message'],
            'read_at'=>$this->read_at ? $this->read_at->diffForHumans() : "",
            'created_at'=>$this->created_at->diffForHumans(),
            'type'=>$this->type
        ];
    }
}
