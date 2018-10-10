<?php

namespace App\Http\Controllers;

use App\Reply;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function store(Request $request,Reply $reply)
    {
        //
        $reply->favorite();

    }

    public function destroy(Reply $reply){
        $reply->unfavorite();
    }
}
