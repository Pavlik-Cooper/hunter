<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];
    public function subject(){
        return $this->morphTo();
    }
    public static function feed($user){
        // or just static::where('user_id',$user->id)
        return  $user->activities()
            ->latest()
            ->take(50)
            ->with('subject')
            ->get()
            ->groupBy(function ($activity){
                // in order to group only by date, because date with time is always unique
                return $activity->created_at->format('Y-m-d');
            });
    }
}
