@forelse($threads as  $thread)
    <div class="card" style="margin: 20px;">
        <div class="card-body">
            <article>
                <div class="level">
                    {{--@if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))--}}
                        {{--<h4><strong><a href="{{$thread->path()}}">{{$thread->title}}</a></strong></h4>--}}
                    {{--@else--}}
                        <h4><a href="{{$thread->path()}}">{{$thread->title}}</a></h4>
                    {{--@endif--}}
                    <div class="body flex">
                        <p>{!! $thread->body !!}</p>
                        <strong style="white-space: nowrap; align-self: flex-end">{{ $thread->replies_count }} {{ str_plural('reply',$thread->replies_count) }} </strong>
                    </div>
                </div>
            </article>
            <hr>
        </div>
        <div class="card-footer">
            <strong>
                {{ $thread->visitsForever() }} {{ str_plural('Visit', $thread->visitsForever()) }}
            </strong>

        </div>
    </div>
@empty
    <p>No results</p>
@endforelse
