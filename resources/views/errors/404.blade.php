@extends('layouts.blank')

@section('content')
<div class="text-center">
    <h1 class="error-code text-danger">{{__('404')}}</h1>
    <p class="h4 text-uppercase text-bold">{{__('Page Not Found!')}}</p>
    <div class="pad-btm">
        {{__('Sorry, but the page you are looking for has not been found on our server.')}}
    </div>
    <hr class="new-section-sm bord-no">
    <div class="pad-top"><a class="btn btn-primary" href="{{env('APP_URL')}}">{{__('Return Home')}}</a></div>
</div>
@endsection
