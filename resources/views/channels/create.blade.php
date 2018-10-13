@extends('layouts.app')
@section('header')
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">Create a New Channel</div>

                    <div class="panel-body">
                        <form method="POST" action="/channels/store" onsubmit="this.children[3].children[0].disabled = true;">
                            {{ csrf_field() }}

                            <div class="form-group">
                                @if (count($errors))
                                    <ol class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ol>
                                @endif

                            </div>

                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" value="{{ old('name')}}" id="name" name="name" required>
                            </div>

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
