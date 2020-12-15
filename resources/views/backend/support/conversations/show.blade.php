@extends('backend.layouts.app')

@section('content')

<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">#{{ $conversation->title }} (Between @if($conversation->sender != null) {{ $conversation->sender->name }} @endif and @if($conversation->receiver != null) {{ $conversation->receiver->name }} @endif)
            </h5>
        </div>

        <div class="card-body">
            @foreach($conversation->messages as $message)
                <div class="media mb-2">
                  <img class="avatar avatar-sm m-3" @if($message->user != null) src="{{ uploaded_asset($message->user->avatar_original) }}" @endif alt="{{ translate('Image') }}">
                  <div class="media-body">
                    <h6 class="mt-0">
                        @if ($message->user != null)
                            {{ $message->user->name }}
                        @endif
                    </h6>
                    <p class="text-muted">{{$message->created_at}}</p>
                    <p>
                        {{ $message->message }}
                    </p>
                  </div>
                </div>
            @endforeach
            @if (Auth::user()->id == $conversation->receiver_id)
                <form action="{{ route('messages.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
                    <div class="row">
                        <div class="col-md-12">
                            <textarea class="form-control" rows="4" name="message" placeholder="{{ translate('Type your reply') }}" required></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="text-right">
                        <button type="submit" class="btn btn-info">{{translate('Send')}}</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>

@endsection
