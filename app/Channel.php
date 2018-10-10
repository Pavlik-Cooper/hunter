<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use Sluggable;

    public function getRouteKeyName(){
        return 'slug';
    }
    public function path(){
        return route('channel.show',['channel'=>$this->slug]);
    }
    public function threads(){
        return $this->hasMany(\App\Thread::class);
    }
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

}
