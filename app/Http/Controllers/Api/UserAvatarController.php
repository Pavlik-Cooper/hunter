<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserAvatarController extends Controller
{
    //
    public function store(){
        request()->validate([
            'avatar'=> ['required','image']
        ]);
        // auth()->user() so that user can update only his avatar
        auth()->user()->update([
            // storeAs('avatars','avatar.jpg',public')
            'avatar'=> request()->file('avatar')->store('avatars','public')
        ]);
        return response([],204);
    }
}
