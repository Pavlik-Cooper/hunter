<?php

namespace App\Http\Controllers\Api;

use App\Friend;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FriendsController extends Controller
{
    public function index(User $user){
        return UserResource::collection($user->friends()->get());
    }
    public function store(Request $request,User $user){
        Friend::create(['user_id'=>$user->id,'friend_id'=>auth()->id()]);
    }
    public function destroy(Request $request,User $user){

        Friend::where('user_id',$user->id)->where('friend_id',auth()->id())->delete();
    }
}
