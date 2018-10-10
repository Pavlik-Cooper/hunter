@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        Channels
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            @foreach($channels as $channel)
                                <li class="list-group-item"> <a  href="{{ $channel->path()}}">{{ $channel->name }}</a></li>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
             @include('threads._list')
                <div class="row justify-content-center">
                        {{ $threads->render() }}
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        Trending threads
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($trending as $trend)
                             <li class="list-group-item"><a href="{{ $trend->path()}}">{{ $trend->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @if(Auth::check())
                <chat></chat>
                @endif
            </div>

        </div>
    </div>
@endsection
