@extends('layouts.blank')
@section('content')
    <div class="mar-ver pad-btm text-center">
        <h1 class="h3">Congratulations!!!</h1>
        <p>You have successfully completed the installation process. Please Login to continue.</p>
    </div>
    <div class="text-center">
        <a href="{{ env('APP_URL') }}" class="btn btn-primary">Go to Home</a>
        <a href="{{ env('APP_URL') }}/admin" class="btn btn-success">Login to Admin panel</a>
		<br />
    </div>
@endsection
