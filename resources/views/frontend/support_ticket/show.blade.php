@extends('frontend.layouts.app')

@section('content')
<section class="gry-bg py-4 profile">
        <div class="container">
            <div class="row cols-xs-space cols-sm-space cols-md-space">
                <div class="col-lg-3 d-none d-lg-block">
                    @if(Auth::user()->user_type == 'seller')
                        @include('frontend.inc.seller_side_nav')
                    @elseif(Auth::user()->user_type == 'customer')
                        @include('frontend.inc.customer_side_nav')
                    @endif
                </div>

                <div class="col-lg-9">
                    <div class="main-content">
                        <div class="card">
                            <div class="card-header py-3">
                                <h3 class="heading-5">{{ $ticket->subject }} #{{ $ticket->code }}</h3>
                                <ul class="list-inline alpha-6 mb-0">
                                    <li class="list-inline-item">{{ date('h:i:m A d-m-Y', strtotime($ticket->created_at)) }}</li>
                                    <li class="list-inline-item"><span class="badge badge-pill badge-secondary">Open</span></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="border-bottom pb-4">
                                    <form class="" action="{{route('support_ticket.seller_store')}}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                                        <input type="hidden" name="user_id" value="{{$ticket->user_id}}">
                                        <div class="form-group">
                                            <textarea class="form-control editor" name="reply" placeholder="Type your reply" data-buttons="bold,underline,italic,|,ul,ol,|,paragraph,|,undo,redo"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <input type="file" name="attachments[]" id="file-2" class="custom-input-file custom-input-file--2" data-multiple-caption="{count} files selected" multiple />
                                            <label for="file-2" class=" mw-100 mb-0">
                                                <i class="fa fa-upload"></i>
                                                <span>Attach files.</span>
                                            </label>
                                        </div>
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-base-1">{{__('Send Reply')}}</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="pt-4">
                                    @foreach ($ticket_replies as $ticketreply)
                                        @if($ticket->user_id == $ticketreply->user_id)
                                            <div class="block block-comment mb-3 border-0">
                                                <div class="d-flex flex-row-reverse">
                                                    <div class="pl-3">
                                                        <div class="block-image d-block size-40" data-toggle="tooltip" data-title="{{ $ticketreply->user->name }}">
                                                            <img src="{{ asset($ticketreply->user->avatar_original) }}" class="rounded-circle">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ml-5 pl-5">
                                                        <div class="p-3 bg-gray rounded">
                                                            @php echo $ticketreply->reply; @endphp
                                                            @if($ticketreply->files != null && is_array(json_decode($ticketreply->files)))
                                                                <div class="mt-3 clearfix">
                                                                    @foreach (json_decode($ticketreply->files) as $key => $file)
                                                                        <div class="float-right bg-white p-2 rounded ml-2">
                                                                            <a href="{{ asset($file->path) }}" download="{{ $file->name }}" class="file-preview d-block text-black-50" style="width:100px">
                                                                                <div class="text-center h4">
                                                                                    <i class="la la-file"></i>
                                                                                </div>
                                                                                <div class="d-flex">
                                                                                    <div class="flex-grow-1 minw-0">
                                                                                        <div class="text-truncate">
                                                                                            {{ explode('.', $file->name)[0] }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div>
                                                                                        .{{ explode('.', $file->name)[1] }}
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <span class="comment-date alpha-5 text-sm mt-1 d-block text-right">
                                                            {{ date('h:i:m d-m-Y', strtotime($ticketreply->created_at)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="block block-comment mb-3 border-0">
                                                <div class="d-flex">
                                                    <div class="pr-3">
                                                        <div class="block-image d-block size-40" data-toggle="tooltip" data-title="{{ $ticketreply->user->name }}">
                                                            <img src="{{ asset($ticketreply->user->avatar_original) }}" class="rounded-circle" data-toggle="tooltip" data-title="fsdfsf">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 mr-5 pr-5">
                                                        <div class="p-3 bg-gray rounded">
                                                            @php echo $ticketreply->reply; @endphp
                                                            @if($ticketreply->files != null && is_array(json_decode($ticketreply->files)))
                                                                <div class="mt-3 clearfix">
                                                                    @foreach (json_decode($ticketreply->files) as $key => $file)
                                                                        <div class="float-right bg-white p-2 rounded ml-2">
                                                                            <a href="{{ asset($file->path) }}" download="{{ $file->name }}" class="file-preview d-block text-black-50" style="width:100px">
                                                                                <div class="text-center h4">
                                                                                    <i class="la la-file"></i>
                                                                                </div>
                                                                                <div class="d-flex">
                                                                                    <div class="flex-grow-1 minw-0">
                                                                                        <div class="text-truncate">
                                                                                            {{ explode('.', $file->name)[0] }}
                                                                                        </div>
                                                                                    </div>
                                                                                    <div>
                                                                                        .{{ explode('.', $file->name)[1] }}
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <span class="comment-date alpha-5 text-sm mt-1 d-block">
                                                            {{ date('h:i:m d-m-Y', strtotime($ticketreply->created_at)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    <div class="block block-comment mb-3 border-0">
                                        <div class="d-flex flex-row-reverse">
                                            <div class="pl-3">
                                                <div class="block-image d-block size-40">
                                                    <img src="{{ asset($ticket->user->avatar_original) }}" class="rounded-circle">
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ml-5 pl-5">
                                                <div class="p-3 bg-gray rounded">
                                                    @php echo $ticket->details; @endphp
                                                    @if($ticket->files != null && is_array(json_decode($ticket->files)))
                                                        <div class="mt-3 clearfix">
                                                            @foreach (json_decode($ticket->files) as $key => $file)
                                                                <div class="float-right bg-white p-2 rounded ml-2">
                                                                    <a href="{{ asset($file->path) }}" download="{{ $file->name }}" class="file-preview d-block text-black-50" style="width:100px">
                                                                        <div class="text-center h4">
                                                                            <i class="la la-file"></i>
                                                                        </div>
                                                                        <div class="d-flex">
                                                                            <div class="flex-grow-1 minw-0">
                                                                                <div class="text-truncate">
                                                                                    {{ explode('.', $file->name)[0] }}
                                                                                </div>
                                                                            </div>
                                                                            <div>
                                                                                .{{ explode('.', $file->name)[1] }}
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                <span class="comment-date alpha-5 text-sm mt-1 d-block text-right">
                                                    {{ date('h:i:m d-m-Y', strtotime($ticket->created_at)) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
</section>
@endsection
