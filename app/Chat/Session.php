<?php

namespace App\Chat;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    //
    protected $guarded = [];
    public function chats(){
        return $this->hasManyThrough(Chat::class,Message::class);
    }
    public function messages(){
        return $this->hasMany(Message::class);
    }
    public function clearChats(){
        $this->chats()->where('user_id',auth()->id())->delete();
    }
    public function deleteMessages(){
        if ($this->chats->count() == 0)  $this->messages()->delete();
    }
    public function block(){
        $this->blocked = true;
        $this->blocked_by = auth()->id();
        $this->save();
    }
    public function unblock(){
        $this->blocked = false;
        $this->blocked_by = null;
        $this->save();
    }
}
