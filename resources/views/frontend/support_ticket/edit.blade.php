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
                        <!-- Page title -->
                        <div class="page-title">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h2 class="heading heading-6 text-capitalize strong-600 mb-0 d-inline-block">
                                        {{__('Support Ticket Details')}}
                                    </h2>
                                </div>
                                <div class="col-md-6">
                                    <div class="float-md-right">
                                        <ul class="breadcrumb">
                                            <li><a href="{{ route('home') }}">{{__('Home')}}</a></li>
                                            <li><a href="{{ route('dashboard') }}">{{__('Dashboard')}}</a></li>
                                            <li><a href="{{ route('support_ticket.index') }}">{{__('Support Ticket')}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="panel-body">
                            <div class="form-box-content mt-3">
                                <label class="col-sm-2 control-label"><strong>{{__('Subject')}}</strong></label>
                                <div class="col-sm-9">
                                    @php
                                        echo $ticket->subject;
                                    @endphp
                                </div>
                            </div>
                            <br>
                            <div class="form-box-content">
                                <label class="col-sm-2 control-label" for="subject"><strong>{{__('Deatils')}}</strong></label>
                                <div class="col-sm-9">
                                    @php
                                        echo $ticket->details;
                                    @endphp
                                </div>
                            </div>
                            <br>
                            <div class="form-box-content">
                                <label class="col-sm-2 control-label" for="subject"><strong>{{__('Leave A Reply')}}</strong></label>
                                <div class="col-sm-9">
                                    <form class="form-horizontal" action="{{route('support_ticket.seller_store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                        <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                                        <input type="hidden" name="user_id" value="{{$ticket->user_id}}">
                                        <textarea class="editor" name="reply" required></textarea>
                                        <div class="text-right mt-3">
                                            <button class="btn btn-base-1" type="submit">{{__('Send Reply')}}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="form-box-content">
                                @foreach ($ticket_replies as $ticketreply)
                                    <div class="block block-comment">
                                        <div class="block-image">
                                            <img src="{{ asset($ticketreply->user->avatar_original) }}" class="rounded-circle">
                                        </div>
                                        <div class="block-body">
                                            <div class="block-body-inner">
                                                <div class="row no-gutters">
                                                    <div class="col">
                                                        <h3 class="heading heading-6">
                                                            <a href="javascript:;">{{ $ticketreply->user->name }}</a>
                                                        </h3>
                                                        <span class="comment-date">
                                                            {{ date('d-m-Y', strtotime($ticketreply->created_at)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <p class="comment-text">
                                                    @php
                                                        echo $ticketreply->reply;
                                                    @endphp
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                    </div>
                </div>

            </div>
        </div>


</section>
@endsection
