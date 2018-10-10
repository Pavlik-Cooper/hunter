<?php

namespace App\Chat;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    //
    protected $guarded = [];
    protected $casts = ['read_at'=>'datetime'];
    public function message(){
        return $this->belongsTo(Message::class);
    }
//    public function user(){
//        return $this->belongsTo(User::class);
//    }
    public function markAsRead(){
        $this->update(['read_at'=>Carbon::now()]);
    }
}
