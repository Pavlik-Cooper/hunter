@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name }} published <a href="{{ $activity->subject->path() }}">{{ $activity->subject->title }}</a>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent


{{-- alternatively --}}

{{--@include('profiles.activities.activity',[--}}
{{--'heading' => 'some heading',--}}
{{--'body'=> 'some body'--}}
{{--])--}}
