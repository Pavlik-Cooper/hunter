@component('profiles.activities.activity')
    @slot('heading')
         <a href="{{ $activity->subject->favorited->path() }}">{{ $profileUser->name }} favorited a reply</a>
    @endslot

    @slot('body')
        {{ $activity->subject->favorited->body }}
    @endslot
@endcomponent


{{-- alternatively --}}

{{--@include('profiles.activities.activity',[--}}
{{--'heading' => 'some heading',--}}
{{--'body'=> 'some body'--}}
{{--])--}}
