@extends('layouts.login')

@section('content')

@php
    $generalsetting = \App\GeneralSetting::first();
@endphp

<div class="flex-row">
    <div class="flex-col-xl-6 blank-index d-flex align-items-center justify-content-center"
    @if ($generalsetting->admin_login_sidebar != null)
        style="background-image:url('{{ asset($generalsetting->admin_login_sidebar) }}');"
    @else
        style="background-image:url('{{ asset('img/bg-img/login-box.jpg') }}');"
    @endif>

    </div>
    <div class="flex-col-xl-6">
        <div class="pad-all">
        <div class="text-center">
            <br>
			@if($generalsetting->logo != null)
                <img src="{{ asset($generalsetting->logo) }}" class="" height="44">
            @else
                <img src="{{ asset('frontend/images/logo/logo.png') }}" class="" height="44">
            @endif
            
            <br>
            <br>
            <br>

        </div>
            <form class="pad-hor" method="POST" role="form" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="Email">
                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="Password">
                    @if ($errors->has('password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="checkbox pad-btm text-left">
                            <input id="demo-form-checkbox" class="magic-checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="demo-form-checkbox">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="checkbox pad-btm text-right">
                            <a href="{{ route('password.request') }}" class="btn-link">{{__('Forgot password')}} ?</a>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block">
                    {{ __('Login') }}
                </button>
            </form>
            {{-- <div class="col-sm-6">
                <div class="cls-content-sm panel" style="width: 100% !important;">
                    <div class="pad-all">
                        <table class="table table-responsive table-bordered">
                            <tbody>
                                <tr>
                                    <td>admin@example.com</td>
                                    <td>123456</td>
                                    <td><button class="btn btn-info btn-xs" onclick="autoFill()">copy</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</div>


@endsection

@section('script')
    <script type="text/javascript">
        function autoFill(){
            $('#email').val('admin@example.com');
            $('#password').val('123456');
        }
    </script>
@endsection
