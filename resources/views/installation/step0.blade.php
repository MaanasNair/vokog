@extends('layouts.blank')
@section('content')
    <div class="mar-ver pad-btm text-center">
        <h1 class="h3">Active eCommerce CMS Installation</h1>
        <p>You will need to know the following items before
        proceeding.</p>
    </div>
    <ol class="list-group">
        <li class="list-group-item text-semibold"><i class="fa fa-check"></i> Codecanyon purchase code</li>
        <li class="list-group-item text-semibold"><i class="fa fa-check"></i> Database Name</li>
        <li class="list-group-item text-semibold"><i class="fa fa-check"></i> Database Username</li>
        <li class="list-group-item text-semibold"><i class="fa fa-check"></i> Database Password</li>
        <li class="list-group-item text-semibold"><i class="fa fa-check"></i> Database Hostname</li>
    </ol>
    <p style="font-size: 14px;">
        During the installation process, we will check if the files that are needed to be written
        (<strong>.env file</strong>) have
        <strong>write permission</strong>. We will also check if <strong>curl</strong> are enabled on your server or not.
    </p>
    <p style="font-size: 14px;">
        Gather the information mentioned above before hitting the start installation button. If you are ready....
    </p>
    <br>
    <div class="text-center">
        <a href="{{ route('step1') }}" class="btn btn-info text-light">
            Start Installation Process
        </a>
    </div>
@endsection
