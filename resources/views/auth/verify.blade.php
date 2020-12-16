@extends('layouts.blank')

@section('content')
    <div class="cls-content-sm panel">
        <div class="panel-body">
            <h1 class="h3">{{ __('Verify Your Email Address') }}</h1>
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

            {{ __('Before proceeding, please check your email for a verification link.') }}
            {{ __('If you did not receive the email') }}, <a href="{{ route('verification.resend') }}" class="btn-link text-bold text-main">{{ __('Click here to request another') }}</a>.
        </div>
    </div>
@endsection
