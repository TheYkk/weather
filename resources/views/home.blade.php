@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif


                    <form method="post" action="">
                        @csrf
                        <div class="form-group">
                            <span>Your city: </span>
                            <input type="City" name="city" class="form-control" value="{{Auth::user()->city}}" id="City" aria-describedby="City" placeholder="City">
                        </div>
                        <div class="form-group">
                            <span>Email time: </span>
                            <input value="{{Auth::user()->email_time}}" type="time" id="time" name="time">
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
