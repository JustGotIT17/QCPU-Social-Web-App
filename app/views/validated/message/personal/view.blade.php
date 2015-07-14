@extends('layouts.header')
@section('header_content')
    <h5 class="modal-title" id="myModalLabel">
        <a href="#">
            <span id="name" data-target="/messages/view/{{$user->StudentID}}">
                {{$user->Firstname . ' ' . $user->Lastname}}
            </span>
        </a>
        <i class="fa fa-chevron-right fa-fw"></i>
        Message
    </h5>
@stop
    <div id="message" class="container margin-top-xxl">
    @if(count($messages))
        @foreach($messages as $message)
        <div class="">
            <div class="post-body">
                @if($message->sender->StudentID != Auth::user()->StudentID)
                    <p class="triangle-isosceles">
                        {{$message->Message}}
                    </p>
                    <span class="pull-left">
                        <img src="{{User::getProfileImage($message->sender->photo)}}" class="img-responsive img-circle pull-left post-photo" alt="{{$message->sender->photo}}">
                        <span id="name" data-target="/messages/view/{{$message->sender->StudentID}}">{{$message->sender->Firstname . ' ' . $message->sender->Lastname}}</span>
                        {{(User::isOnline($message->sender->lastSeen))}}
                        <br/><span class="timeago"  data-livestamp="{{strtotime($message->created_at)}}"></span>
                    </span>
                @else
                <div class="message-container clearfix">

                    <p class="triangle-isosceles top">
                        {{$message->Message}}
                    </p>
                    <span class="clearfix">
                        <img src="{{User::getProfileImage($message->sender->photo)}}" class="img-responsive img-circle pull-right post-photo" alt="{{$message->sender->photo}}">
                        {{(User::isOnline($message->sender->lastSeen))}}
                        <span id="name" data-target="/messages/view/{{$message->sender->StudentID}}" class="pull-right">Me</span>
                        <span id="silentPostRequest" data-target="/messages/personal/delete/{{$message->id}}" data-hide="true" data-parent="message-container" data-accid="{{$message->sender->StudentID}}" data-id="{{$message->id}}"><i class="fa fa-remove fa-fw pull-right"></i> </a>
                        <br/>
                        <span class="timeago pull-right"  data-livestamp="{{strtotime($message->created_at)}}"></span>

                    </span>
                </div>

                @endif
            </div>
        </div>
        @endforeach
    @else
        <div class="alert alert-info">
            No messages
        </div>
    @endif
    </div>
    <div class="navbar navbar-default navbar-fixed-bottom">
        {{Form::open(['url' => '/messages/personal/reply/' .$user->StudentID, 'data-target'=>'/messages/view/' .$user->StudentID, 'id'=>'formPostPersonalReply', 'role' => 'form'])}}
        <div class="modal-body clearfix">
            <div class="input-group">
                {{Form::text('message', null, ['id'=>'txtPostReplyMessage', 'class'=>'form-control', 'placeholder'=>'Message here...'])}}
                <span class="input-group-btn"><input type="submit" value="Send" class="btn btn-primary"></span>
            </div>
        </div>
        {{Form::close()}}
    </div>
    {{ HTML::script('js/message_script.js') }}
