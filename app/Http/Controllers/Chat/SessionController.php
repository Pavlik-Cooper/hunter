<?php

namespace App\Http\Controllers\Chat;

use App\Chat\Session;
use App\Events\NewSessionEvent;
use App\Http\Resources\SessionResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    //
    public function store(Request $request){
        $request->validate(['friend_id'=>'required|exists:users,id']);
       $session = new SessionResource(Session::create(['user1_id'=>auth()->id(),'user2_id'=>$request->friend_id]));
       broadcast(new NewSessionEvent($session, auth()->id()));
       return $session;
    }

}
