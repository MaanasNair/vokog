@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <a href="{{ route('languages.create')}}" class="btn btn-rounded btn-info pull-right">{{__('Add New Language')}}</a>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">{{__('Language')}}</h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered demo-dt-basic" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('Name')}}</th>
                            <th>{{__('Code')}}</th>
                            <th>{{__('RTL')}}</th>
                            <th width="10%">{{__('Options')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($languages as $key => $language)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $language->name }}</td>
                                <td>{{ $language->code }}</td>
                                <td><label class="switch">
                                    <input onchange="update_rtl_status(this)" value="{{ $language->id }}" type="checkbox" <?php if($language->rtl == 1) echo "checked";?> >
                                    <span class="slider round"></span></label>
                                </td>
                                <td>
                                    <div class="btn-group dropdown">
                                        <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                                            {{__('Actions')}} <i class="dropdown-caret"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li><a href="{{route('languages.show', encrypt($language->id))}}">{{__('Translation')}}</a></li>
                                            <li><a href="{{route('languages.edit', encrypt($language->id))}}">{{__('Edit')}}</a></li>
                                            @if($language->code != 'en')
                                                <li><a onclick="confirm_modal('{{route('languages.destroy', $language->id)}}');">{{__('Delete')}}</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        function update_rtl_status(el){
            if(el.checked){
                var status = 1;
            }
            else{
                var status = 0;
            }
            $.post('{{ route('languages.update_rtl_status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
                if(data == 1){
                    location.reload();
                }
                else{
                    showAlert('danger', 'Something went wrong');
                }
            });
        }
    </script>
@endsection