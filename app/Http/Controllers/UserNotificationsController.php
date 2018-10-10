<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserNotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
//        unreadNotifications
        return auth()->user()->notifications;
    }
    public function destroy($user, $notification_id = null){
       if ($notification_id) return auth()->user()->notifications()->findOrFail($notification_id)->markAsRead();
        auth()->user()->notifications->markAsRead();
    }
}
