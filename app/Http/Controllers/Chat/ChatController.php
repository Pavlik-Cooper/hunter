<?php

namespace App\Http\Controllers\Chat;

use App\Chat\Session;
use App\Events\BlockEvent;
use App\Events\MsgReadEvent;
use App\Events\PrivateChatEvent;
use App\Http\Resources\ChatResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    //
    public function index(Session $session){
//        return response(['err'=>true],404);
        return ChatResource::collection($session->chats->where('user_id',auth()->id()));
    }


    public function store(Request $request, Session $session){
       $request->validate(['message'=>'required']);

       $message = $session->messages()->create(['message'=>$request->message]);
             // for the user who sent
        $chat = $message->chats()->create(['session_id'=>$session->id,'user_id'=>auth()->id(),'type'=>0]);
            // for the user who received
       $message->chats()->create(['session_id'=>$session->id,'user_id'=>$request->to_user,'type'=>1]);

        broadcast(new PrivateChatEvent($chat,$message->message));

        return response($message,200);
    }
    public function markAsRead(Session $session){
          $session->chats->where('read_at',null)->where('type',0)->
         where('user_id','!=',auth()->id())->each(function ($chat){
             $chat->markAsRead();
             broadcast(new MsgReadEvent(new ChatResource($chat)))->toOthers();
          });
    }
    public function clear(Session $session){
       $session->clearChats();
       $session->deleteMessages();
       return response(['success'=>true],200);
    }
    public function block(Session $session){
        $session->block();
        broadcast(new BlockEvent($session->id,true));
        return response(null,201);
    }
    public function unblock(Session $session){
        $session->unblock();
        broadcast(new BlockEvent($session->id,false));
        return response(null,201);
    }
}
