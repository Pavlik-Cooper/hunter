@extends('layouts.app')
@section('content')
    <thread-view :thread="{{ $thread }}" inline-template>
        <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card" style="margin-bottom: 20px;" v-cloak>
                    <div class="card-header">
                        <a href="{{ route('profile',$thread->creator->name) }}">{{ $thread->creator->name }}</a> posted:
                        <div v-if="editing">
                            <input type="text" class="form-control" v-model="title">
                        </div>
                        <a v-else href="{{ $thread->path() }}">@{{title}}</a>
                    </div>
                    <div class="card-body">
                        <div v-if="editing">
                            <textarea v-model="body" name="body" class="form-control"></textarea>
                        </div>
                        <div v-else>@{{ body }}</div>
                    </div>
                    <div class="card-footer d-flex">
                        @can('update',$thread)
                            <button v-if="!editing" @click="editing = true" class="btn btn-info">Edit</button>
                            <button v-else @click="cancel" class="btn btn-info">Cancel</button>

                            <div v-if="editing" class="actions ml-auto">
                                <button :disabled="disabled" @click="update" class="btn btn-xs btn-default mr-4">Update</button>

                                <form class="pull-right" action="{{ $thread->path() }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-xs btn-danger">Delete thread</button>
                                </form>
                            </div>
                        @endcan
                    </div>
                </div>

                <newreply ref="first" :is-first="true" :thread="{{$thread}}"></newreply>

                <p v-if="!signedIn" class="text-center mb-8">Please <a href="/login">sign in </a>to participate in this discussion</p>

                <replies offset="0" :items="items"></replies>
                <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="fetchPosts()"></pagination>
            </div>

            <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <p>
                                This thread was published {{ $thread->created_at->diffForHumans() }} by
                                <a href="{{ route('profile',['user'=>$thread->creator->name]) }}">{{ $thread->creator->name }}</a>, and currently
                                has <span v-text="RepliesCount"></span> {{ str_plural('comment', $thread->replies_count) }}
                            </p>
                            @if (Auth::check())
                            <subscribe-button :active="{{json_encode($thread->IsSubscribed)}}"></subscribe-button>
                            @endif
                        </div>
                    </div>
            </div>
        </div>
    </div>
    </thread-view>
@endsection
