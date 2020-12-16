@extends('layouts.blank')

@section('content')

<div class="cls-content-lg panel">
    <div class="panel-body">
        <div class="mar-ver pad-btm">
            <h1 class="h3">{{__('Create a New Account')}}</h1>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus placeholder="Full Name">

                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="password">

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="Email">

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confrim Password">
                    </div>
                </div>
            </div>
            <div class="checkbox pad-btm text-left">
                <input id="demo-form-checkbox" class="magic-checkbox" type="checkbox" required>
                <label for="demo-form-checkbox">{{__('I agree with the')}} <a href="#" class="btn-link text-bold">{{__('Terms and Conditions')}}</a></label>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">
                {{ __('Register') }}
            </button>
        </form>
    </div>
    <div class="pad-all">
        {{__('Already have an account')}} ? <a href="{{route('login')}}" class="btn-link mar-rgt text-bold">{{__('Sign In')}}</a>

        <div class="media pad-top bord-top">
            <div class="pull-right">
                <a href="#" class="pad-rgt"><i class="demo-psi-facebook icon-lg text-primary"></i></a>
                <a href="#" class="pad-rgt"><i class="demo-psi-twitter icon-lg text-info"></i></a>
                <a href="#" class="pad-rgt"><i class="demo-psi-google-plus icon-lg text-danger"></i></a>
            </div>
            <div class="media-body text-left text-main text-bold">
                {{__('Sign Up with')}}
            </div>
        </div>
    </div>
</div>

@endsection
