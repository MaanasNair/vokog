@extends('layouts.app')

@section('content')

<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">{{__('Support Desk')}}</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>{{ __('Ticket ID') }}</th>
                    <th>{{ __('Sending Date') }}</th>
                    <th>{{ __('Subject') }}</th>
                    <th>{{ __('User') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Last reply') }}</th>
                    <th>{{ __('Options') }}</th>
                </tr>
            </thead>
            <tbody>
                    @foreach ($tickets as $key => $ticket)
                    <tr>
                        <td>#{{ $ticket->code }}</td>
                        <td>{{ $ticket->created_at }} @if($ticket->viewed == 0) <span class="pull-right badge badge-info">{{ __('New') }}</span> @endif</td>
                        <td>{{ $ticket->subject }}</td>
                        <td>{{ $ticket->user->name }}</td>
                        <td>
                            @if ($ticket->status == 'pending')
                                <span class="badge badge-pill badge-danger">Pending</span>
                            @elseif ($ticket->status == 'open')
                                <span class="badge badge-pill badge-secondary">Open</span>
                            @else
                                <span class="badge badge-pill badge-success">Solved</span>
                            @endif
                        </td>
                        <td>
                            @if (count($ticket->ticketreplies) > 0)
                                {{ $ticket->ticketreplies->last()->created_at }}
                            @else
                                {{ $ticket->created_at }}
                            @endif
                        </td>
                        <td>
                            <a href="{{route('support_ticket.admin_show', encrypt($ticket->id))}}" class="btn-link">{{__('View Details')}}</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection
