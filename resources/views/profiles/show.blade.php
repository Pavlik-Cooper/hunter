@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
               <div class="page-header row justify-content-center">
                   <avatar-form :user="{{ $profileUser }}"></avatar-form>
               </div>

                {{-- since activities are grouped by date, the
                keys are date itself and values are arrays of activities--}}

                @foreach($activities as $date => $activityGroup)
                    <h3>{{ $date }}</h3>
                    @foreach($activityGroup as $activity)
                        @include("profiles.activities.{$activity->type}")
                    @endforeach
                @endforeach

                <div class="row justify-content-center">
                        {{--{{ $threads->links() }}--}}
                </div>
            </div>
        </div>
    </div>
@endsection
