<?php

namespace App\Http\Controllers;

use App\Channel;
use Illuminate\Http\Request;

class ChannelsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(){
        return view('channels.create');
    }
    public function store(Request $request){
        $request->validate(['name'=>'required']);
        $channel = new Channel;
        $channel->name = $request->name;
        $channel->save();
        return redirect()->back()->with(['flash'=>['type'=>'s','message'=>'Yor channel has been published']]);
    }
}
