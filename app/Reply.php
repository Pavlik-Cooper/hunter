<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    // see Favoritable trait

    use RecordsActivity, Favoritable;

    protected $guarded = [];
    protected $appends = ["replies","isFavorited","FavoritesCount"];
    protected $with = ['owner','thread'];
//
    public function path(){
        return $this->thread->path() . "#reply-{$this->id}";
    }
    public function getRepliesAttribute(){
        return $this->hasMany('App\Reply','parent_id','id')->orderBy('created_at','asc')->get();
    }
    public function owner(){
        return $this->belongsTo('App\User','user_id','id');
    }
    public function thread(){
        return $this->belongsTo(\App\Thread::class);
    }
    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($reply){
            // in order to trigger RecordsActivity trait static::deleting() method
            // to delete activity for each reply. Simple $thread->replies()->delete() doesn't work here
//            $reply->where('parent_id',);
            static::where('parent_id',$reply->id)->get()->each->delete();
        });

    }
    public function getReplyActivityTitle(){
        return static::where('id',$this->parent_id)->exists() ? str_limit(static::where('id',$this->parent_id)->first()->body,35) : $this->thread->title;
    }
//    public static function add($request){
//        $reply = new static;
//        $reply->thread_id = $request->thread_id;
//        $reply->parent_id = $request->parent_id;
//        $reply->user_id = $request->user_id;
//        $reply->body = $request->body;
//        $reply->save();
//        return $reply;
//    }

}
