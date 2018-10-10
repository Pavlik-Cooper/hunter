@extends('layouts.app')
@section('header')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">Create a New Thread</div>

                    <div class="panel-body">
                        <form method="POST" action="/threads">
                        {{ csrf_field() }}

                            <div class="form-group">
                                @if (count($errors))
                                    <ol class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ol>
                                @endif
                                <label for="channel_id">Choose a Channel:</label>
                                <select name="channel_id" id="channel_id" class="form-control" required>
                                    <option value="">Choose One...</option>

                                    @foreach ($channels as $channel)
                                        <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
                                            {{ $channel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" class="form-control" value="{{ old('title')}}" id="title" name="title" required>
                            </div>

                            <div class="form-group">
                                <label for="body">Body:</label>
                                {{--<wysiwyg name="body"></wysiwyg>--}}
                                <textarea class="form-control" value="{{ old('body')}}" id="body" rows="6" name="body" required></textarea>
                            </div>
                            {{--<div class="form-group">--}}
                                {{--<div class="g-recaptcha" data-sitekey="6LeewGIUAAAAAPgaTyag-TlgArxPG4u0vW14-5hF"></div>--}}
                            {{--</div>--}}
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Publish</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
