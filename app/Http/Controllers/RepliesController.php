<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth')->except('index');
    }

    public function index($channelID,Thread $thread){
//        return $thread->with(['replies'=> function($query){
//            $query->whereNull('parent_id')->orderBy('created_at','asc');
//        }])->first();
        if (request()->wantsJson()){
            $replies = $thread->replies()->whereNull('parent_id')->orderBy('created_at','asc')->paginate(3);
            $response = [
                'pagination' => [
                    'total' => $replies->total(),
                    'per_page' => $replies->perPage(),
                    'current_page' => $replies->currentPage(),
                    'last_page' => $replies->lastPage(),
                    'from' => $replies->firstItem(),
                    'to' => $replies->lastItem()
                ],
                'data' => $replies
            ];
            return response()->json($response);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function store(Request $request,$channelId, Thread $thread)
    {
        try{
            $request->validate([
                'parent_id'=>'nullable|exists:replies,id,thread_id,'.$thread->id,
                'body'=>'required'
            ]);
        }catch (ValidationException $e){
            return response()->json([
                'success'=>false,
                'errors'=>$e->errors(),
                ], 422);
        }
        $reply = $thread->addReply([
            'user_id'=> auth()->id(),
            'parent_id'=> request('parent_id'),
            'body'=> request('body')
        ]);
        $reply->load(['owner','thread']);
        return response()->json([
            'success'=>true,
            'reply'=>$reply
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reply $reply)
    {
        $this->authorize('update',$reply);
        try {
            $request->validate(['body'=>'required']);
        }
        catch (ValidationException $e){
            return response()->json([
                'success'=>false,
                'errors'=>$e->errors(),
            ], 422);
        }
        $reply->body = $request->body;
        $reply->save();
        return response()->json([
            'success'=>true,
            'reply'=>$reply
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $reply->delete();
    }
}
