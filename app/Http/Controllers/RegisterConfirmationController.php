<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class RegisterConfirmationController extends Controller
{
    //
    public function index(){
        if (request('token') == null) return redirect('/');
        $user = User::where('confirmation_token',request('token'))
            ->firstOrfail();

        $user->confirm();
        return redirect('/')->with(['flash'=>['type'=>'s','message'=>'You have successfully confirmed your account']]);
    }
}
