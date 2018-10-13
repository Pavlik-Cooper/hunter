<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','confirmation_token','avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $appends = ['IsFriend'];
    public function activities(){
        return $this->hasMany('App\Activity');
    }
    public function confirm(){
        $this->confirmed = true;
        $this->confirmation_token = null;
        $this->save();
    }
    public function getAvatarAttribute($avatar)
    {   if (!is_null($avatar) && starts_with($avatar,'http')) return $avatar;
        return asset($avatar && Storage::exists('public/'.$avatar) ? 'storage/' . $avatar : 'images/avatars/default-avatar.jpg');
    }
    public function friends(){
        return $this->belongsToMany(User::class,'friends','user_id','friend_id');
    }
    public function getIsFriendAttribute(){
        return $this->friends()->where('friend_id',auth()->id())->exists();
    }
}
