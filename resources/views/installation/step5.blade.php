@extends('layouts.blank')
@section('content')
    <div class="mar-ver pad-btm text-center">
        <h1 class="h3">Shop Settings</h1>
        <p>Fill this form with basic shop information & admin login credentials</p>
    </div>
    <p class="text-muted font-13">
        <form method="POST" action="{{ route('system_settings') }}">
            @csrf
            <div class="form-group">
                <label for="admin_name">Admin Name</label>
                <input type="text" class="form-control" id="admin_name" name="admin_name" required>
            </div>

            <div class="form-group">
                <label for="admin_email">Admin Email</label>
                <input type="email" class="form-control" id="admin_email" name="admin_email" required>
            </div>

            <div class="form-group">
                <label for="admin_password">Admin Password (At least 6 characters)</label>
                <input type="password" class="form-control" id="admin_password" name="admin_password" required>
            </div>

            <div class="form-group">
                <label for="system_name">Shop Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="system_email">Shop Mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="running_session">Shop Address</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>

            <div class="form-group">
                <label for="running_session">Shop Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>

            <div class="form-group">
                <label for="admin_name">Shop Currency</label>
                <select class="form-control" name="system_default_currency" required>
                    @foreach (\App\Currency::all() as $key => $currency)
                        <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-info">Continue</button>
            </div>

        </form>
    </p>
@endsection
