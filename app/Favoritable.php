<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

trait Favoritable
{
    /**
     * Boot the trait.
     */
    protected static function bootFavoritable()
    {
        static::deleting(function ($model) {
            // if we delete reply or thread to which reply belongs to,
            // then we should delete all the favorites and then all the activities of of favorites will be
            //deleted also because of RecordsActivity trait that Favorite model uses
            $model->favorites->each->delete();
        });
    }


    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];

        if (! $this->favorites()->where($attributes)->exists()) {
            return $this->favorites()->create($attributes);
        }
    }

    public function unfavorite()
    {
        $attributes = ['user_id' => auth()->id()];
        // here in addition we use ->get()->each->delete() in order to delete activities of favorites
       if($this->favorites()->where($attributes)->exists()){
           return $this->favorites()->where($attributes)->get()->each->delete();
       }
    }

    public function getIsFavoritedAttribute()
    {
        return ! ! $this->favorites->where('user_id', auth()->id())->count();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}
