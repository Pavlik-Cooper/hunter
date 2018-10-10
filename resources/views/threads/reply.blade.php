<reply :attributes="{{ $reply }}" inline-template v-cloak>
<div id="{{ 'reply-' . $reply->id }}" class="card" style="margin: 20px">
    <div class="card-header">
        <a href="{{ route('profile',$reply->owner->name) }}">{{$reply->owner->name}}</a> said
        {{$reply->created_at->diffForHumans()}}
    </div>

    <div class="card-body">
        <div v-if="editing">
            <div class="form-group">
                <div class="form-group">
                    <textarea class="form-control" v-model="body">{{$reply->body}}</textarea>
                </div>
                <button class="btn btn-xs btn-primary" @click="update">Update</button>
                <button class="btn btn-xs" @click="editing = false">Cancel</button>
            </div>
        </div>
        <div v-else v-text="body">
            {{$reply->body}}
        </div>

        <favorite :reply="{{ $reply }}"></favorite>

        @can('update',$reply)
            <div class="flex" >
                <button class="btn btn-danger btn-small" @click="destroy">Delete</button>
                <button class="btn btn-xs btn-default" @click="editing = true" style="">Edit</button>
            </div>
        @endcan
    </div>
</div>
</reply>