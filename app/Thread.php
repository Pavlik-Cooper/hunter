<?php

namespace App;

use App\Events\ThreadHasNewReply;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use JordanMiguel\LaravelPopular\Traits\Visitable;

class Thread extends Model
{
    use RecordsActivity, Sluggable,Visitable;
    //
    protected $fillable = ['*'];
    protected $appends = ['IsSubscribed'];
    public function getRouteKeyName(){
        return 'slug';
    }
    public function path(){
//        return route('threads.show',['channel'=>$this->channel->slug,'thread'=>$this->slug]);
        return "/threads/{$this->channel->slug}/{$this->slug}";
    }

    public function channel(){
        return $this->belongsTo('App\Channel');
    }
    public function creator(){
        return $this->belongsTo('App\User','user_id');
    }
    public function replies(){
        return $this->hasMany(Reply::class);
    }
    public function subscriptions(){
        return $this->hasMany(ThreadSubscription::class);
    }
    public function subscribe($user_id = null){
        $this->subscriptions()->create(['user_id'=> $user_id ?: auth()->id()]);
    }
    public function unsubscribe($user_id = null){
        $this->subscriptions()->where('user_id', $user_id ?: auth()->id())->delete();
    }
    public function getIsSubscribedAttribute(){
        return $this->subscriptions()->where('user_id',auth()->id())->exists();
    }
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
   protected static function boot(){
       parent::boot();
       // thread replies count for all the routs
       static::addGlobalScope('replyCount',function ($builder){
           $builder->withCount('replies');
       });
       static::deleting(function ($thread){
           // in order to trigger RecordsActivity trait static::deleting() method
           // to delete activity for each reply. Simple $thread->replies()->delete() doesn't work here
           $thread->replies->each->delete();
       });


   }
   public function getRepliesTree(){
       return $this->replies()->whereNull('parent_id')->orderBy('created_at','asc')->get();
   }
    public function addReply($reply){
        $reply = $this->replies()->create($reply);

        event(new ThreadHasNewReply($reply));

        return $reply;
    }
}
