@extends('admin.layouts.layout')

@section('title', 'Admin | Сообщения')
@section('key', 'Admin | Сообщения')
@section('desc', 'Admin | Сообщения')

@section('header-title', 'Сообщения')

@section('content')

<div class="col-md-3">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Folders</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item active">
                        <a href="#" class="nav-link">
                            <i class="fa fa-inbox"></i> Inbox
                            <span class="badge bg-primary float-right">12</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa fa-envelope"></i> Sent
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa fa-file-alt"></i> Drafts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa fa-filter"></i> Junk
                            <span class="badge bg-warning float-right">65</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fa fa-trash-alt"></i> Trash
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card card-primary card-outline">
{{--            <div class="card-header">--}}
{{--                <h3 class="card-title">Read Mail</h3>--}}
{{--            </div>--}}
            <div class="card-body p-0">
                <div class="mailbox-read-info">
                    <h5>Сообщение от <strong>{{$message->name}}</strong></h5>
                    <h6>
                        <i class="fa fa-envelope-o"></i> {{$message->email}}<br>
                        @if($message->phone)
                            <i class="fa fa-phone"></i> {{$message->phone}}
                        @endif
                        <span class="mailbox-read-time float-right">{{getRusDate($message->date_at, 'd %MONTH% Y')}}</span>
                    </h6>
                </div>
{{--                <div class="mailbox-controls with-border text-center">--}}
{{--                    <div class="btn-group">--}}
{{--                        <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Delete">--}}
{{--                            <i class="fa fa-trash-alt"></i></button>--}}
{{--                        <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Reply">--}}
{{--                            <i class="fa fa-reply"></i></button>--}}
{{--                        <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Forward">--}}
{{--                            <i class="fa fa-share"></i></button>--}}
{{--                    </div>--}}
{{--                    <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Print">--}}
{{--                        <i class="fa fa-print"></i></button>--}}
{{--                </div>--}}
                <div class="mailbox-read-message">
                    {!! nl2br($message->message) !!}
                </div>
            </div>
{{--            <div class="card-footer">--}}
{{--                <div class="float-right">--}}
{{--                    <button type="button" class="btn btn-default"><i class="fa fa-reply"></i> Reply</button>--}}
{{--                    <button type="button" class="btn btn-default"><i class="fa fa-share"></i> Forward</button>--}}
{{--                </div>--}}
{{--                <button type="button" class="btn btn-default"><i class="fa fa-trash-alt"></i> Delete</button>--}}
{{--                <button type="button" class="btn btn-default"><i class="fa fa-print"></i> Print</button>--}}
{{--            </div>--}}
        </div>

        @if($message->is_reply())
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Ответ</h3>
            </div>
            <div class="card-body">
                @foreach($message->children as $children)
                    <p>{!!nl2br($children->message)!!}</p>
                @endforeach

            </div>
            <div class="card-footer">

            </div>
        </div>
        @endif

        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Написать ответ</h3>
            </div>
            <div class="card-body">
            {!! Form::open(['route' => ['mails.update', $message->id], 'method' => 'put']) !!}
{{--                <div class="form-group">--}}
{{--                    <input class="form-control" placeholder="Тема письма">--}}
{{--                </div>--}}
                <div class="form-group">
                    <textarea name="message" id="compose-textarea" class="form-control" style="height: 300px" placeholder="Сообщение..."></textarea>
                </div>
            </div>
            <div class="card-footer">
                <div class="float-right">
                    <button type="button" class="btn btn-default"><i class="fa fa-pencil-alt"></i> Черновик</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-envelope"></i> Отправить</button>
                </div>
                <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Очистить</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
