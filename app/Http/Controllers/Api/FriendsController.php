<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FriendsController extends Controller
{
    //
    public function index(User $user){
//        dd("qwef");
        return UserResource::collection($user->friends()->get());
    }
}
