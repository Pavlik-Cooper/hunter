<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Inspections\Spam;
use App\Rules\SpamFree;
use App\Thread;
use Config;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
    }

    public function index(Channel $channel)
    {
        $threads = Thread::latest();
        if ($channel->exists){
            $threads = $channel->threads();
        }
        $threads =  $threads->paginate(5);
        $trending = Thread::popularAllTime()->take(config('settings.trending'))->get();
        return view('threads.index',compact('threads','trending','channels'));
    }

    public function create()
    {
        //
        return view('threads.create');
    }

    public function store(Request $request, Spam $spam)
    {
        $request->validate([
            'title'=>['required',new SpamFree],
            'body'=>['required',new SpamFree],
            'channel_id'=> 'required|exists:channels,id'
        ]);
        $thread = new Thread;
        $thread->title = $request->title;
        $thread->body = $request->body;
        $thread->user_id = auth()->id();
        $thread->channel_id = $request->channel_id;
        $thread->save();
        return redirect($thread->path())->with(['flash'=>['type'=>'s','message'=>'Yor thread has been published']]);
    }

    public function show($channel,Thread $thread)
    {
        $thread->visit();
        $thread->load('channel');
        return view('threads.show',['thread'=>$thread]);
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $channel, Thread $thread)
    {
        $this->authorize('update',$thread);
        $request->validate([
            'body'=>'required',
            'title'=>'required'
        ]);
        if ($request->wantsJson()){
            $thread->body = $request->body;
            $thread->title = $request->title;
            $thread->save();
        }
    }

    public function destroy($channel,Thread $thread)
    {
        $this->authorize('update',$thread);
        $thread->delete();
        return redirect('/');

    }
}
