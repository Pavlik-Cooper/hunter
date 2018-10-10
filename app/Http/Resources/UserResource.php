<?php

namespace App\Http\Resources;

use App\Chat\Session;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
//        return parent::toArray($request);
        return [
            'id'=> $this->id,
            'name'=>$this->name,
            'avatar'=>$this->avatar,
            'online'=> false,
            'session'=>$this->sessionDetails($this->id),
            'last_msg'=> $this->getLastMsg($this->id)
        ];
    }
    private function sessionDetails($id){
        $session = Session::whereIn('user1_id',[auth()->id(),$id])->whereIn('user2_id',[auth()->id(),$id])->first();
        return new SessionResource($session);
    }
    private function getLastMsg($id){
        $session = Session::whereIn('user1_id',[auth()->id(),$id])->whereIn('user2_id',[auth()->id(),$id])->first();
        return $session->chats->where('user_id',auth()->id())->count() > 0 &&  $session->messages->count() ? $session->messages()->latest()->first()->message : "";
    }

}
