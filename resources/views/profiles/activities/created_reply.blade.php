@component('profiles.activities.activity')
    @slot('heading')
        {{ $profileUser->name }} replied to
        {{-- $activity->reply->thread --}}
        <a href="{{ $activity->subject->path() }}">"{{  $activity->subject->getReplyActivityTitle() }}"</a>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent

