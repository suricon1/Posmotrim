@extends('admin.layouts.layout')

@section('title', 'Admin | Сообщения')
@section('key', 'Admin | Сообщения')
@section('desc', 'Admin | Сообщения')

@section('header-title', 'Сообщения')

@section('content')

        <div class="col-md-3">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Folders</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item active">
                            <a href="#" class="nav-link">
                                <i class="fa fa-inbox"></i>  Входящие
                                <span class="badge bg-primary float-right">{{$messages->count()}}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-envelope"></i> Отправленные
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-file-text-o"></i> Черновик
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-filter"></i> Спам
                                <span class="badge bg-warning float-right">65</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa fa-trash-o"></i> Корзина
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Inbox</h3>

                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" placeholder="Search Mail">
                            <div class="input-group-append">
                                <div class="btn btn-primary">
                                    <i class="fa fa-search"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::open(['route' => ['mails.destroy', 1], 'method' => 'DELETE']) !!}
                <div class="card-body p-0">
                    <div class="mailbox-controls">
                        <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                        </button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                        </div>
                        <button type="submit" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                        <div class="float-right">
                            {{$messages->links()}}
                        </div>
                    </div>
                    <div class="table-responsive mailbox-messages">
                        <table class="table table-hover table-striped">
                            <tbody>
                            @foreach($messages as $message)
                            <tr>
                                <td>
                                    <div class="icheck-primary">
                                        <input name="check[]" type="checkbox" value="{{$message->id}}" id="check{{$message->id}}">
                                        <label for="check{{$message->id}}"></label>
                                    </div>
                                </td>
                                <td class="mailbox-star">
                                    @if($message->is_reply())
                                        <i class="fa fa-reply text-success"></i>
                                    @endif
                                </td>
                                <td class="mailbox-name">
                                    @if($message->mark_as_read)
                                        <strong><a href="{{route('mails.show', $message->id)}}">{{$message->name}}</a></strong>
                                    @else
                                        <a href="{{route('mails.show', $message->id)}}">{{$message->name}}</a>
                                    @endif
                                </td>
                                <td class="mailbox-subject">
                                    @if($message->phone)
                                        {{$message->phone}}<br>
                                    @endif
{{--                                    Перенести в хелпер функцию Str::limit--}}
{{--                                    @if($message->mark_as_read)--}}
{{--                                        <strong>{{Str::limit($message->message, 100)}}</strong>--}}
{{--                                    @else--}}
{{--                                        {{Str::limit($message->message, 100)}}--}}
{{--                                    @endif--}}
                                </td>
                                <td class="mailbox-attachment"></td>
                                <td class="mailbox-date">
                                    @if($message->mark_as_read)
                                        <strong>{{getRusDate($message->date_at, 'd %MONTH% Y')}}</strong>
                                    @else
                                        {{getRusDate($message->date_at, 'd %MONTH% Y')}}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer p-0">
                    <div class="mailbox-controls">
                        <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                        </button>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                        </div>
                        <button type="submit" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                        <div class="float-right">
                            {{$messages->links()}}
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>

@endsection

@section('scripts')
    <script>
        $(function () {
            //Enable check and uncheck all functionality
            $('.checkbox-toggle').click(function () {
                var clicks = $(this).data('clicks');
                if (clicks) {
                    //Uncheck all checkboxes  fa-check-square-o
                    $('.mailbox-messages input[type=\'checkbox\']').prop('checked', false);
                    $('.checkbox-toggle .fa.fa-check-square-o').removeClass('fa-check-square-o').addClass('fa-square-o');
                } else {
                    //Check all checkboxes
                    $('.mailbox-messages input[type=\'checkbox\']').prop('checked', true);
                    $('.checkbox-toggle .fa.fa-square-o').removeClass('fa-square-o').addClass('fa-check-square-o');
                }
                $(this).data('clicks', !clicks);
            });
        })
    </script>
@endsection
