@extends('layouts.header')
@section('header_content')
    <h5 class="modal-title" id="myModalLabel">
        <a href="#">
            <span id="name" data-target="/messages/mygroup/view/{{$groupChat->ID}}">{{$groupChat->Name}}</span>
        </a>
        <i class="fa fa-chevron-right fa-fw"></i>
        Message
    </h5>
@stop
<div class="navbar navbar-fixed-top margin-top-xl">
    <br/>
    <div class="modal-header text-center row-full">
        <span id="name" data-target="/messages/group/member/add/{{$id}}" class="col-2"><i class="fa fa-pencil-square-o fa-fw"></i> Add Member</span>
        <span id="name" data-target="/messages/group/member/{{$id}}" class="col-2"><i class="fa fa-adjust fa-fw"></i> Members</span>
    </div>
</div>
<br/><br/><br/>
<div class="container margin-top-xxl">
  <div id="message" class="">
  @if(count($messages))
      @foreach($messages as $message)
      <div class="">
          <div class="post-body clearfix">
              @if($message->StudentID != Auth::user()->StudentID)
                  <p class="triangle-isosceles">
                      {{$message->Message}}
                  </p>
                  <span class="pull-left">
                      <img src="{{User::getProfileImage($message->owner->photo)}}" class="img-responsive img-circle pull-left post-photo" alt="{{$message->owner->photo}}">
                      <span id="name" data-target="/messages/view/{{$message->owner->StudentID}}">{{$message->owner->Firstname . ' ' . $message->owner->Lastname}}</span>
                      {{(User::isOnline($message->owner->lastSeen))}}
                      <br/><span class="timeago"  data-livestamp="{{strtotime($message->created_at)}}"></span>
                  </span>
              @else
                  <div class="message-container clearfix">
                      <p class="triangle-isosceles top">
                          {{$message->Message}}
                      </p>
                      <span class="clearfix">
                          <img src="{{User::getProfileImage($message->owner->photo)}}" class="img-responsive img-circle pull-right post-photo" alt="{{$message->owner->photo}}">

                          <span id="name" data-target="/messages/view/{{$message->owner->StudentID}}" class="pull-right">
                          {{(User::isOnline($message->owner->lastSeen))}}
                          Me</span>
                          <span id="silentPostRequest" data-target="/messages/group/delete/{{$message->ID}}"  data-hide="true" data-parent="message-container" data-accid="{{$message->owner->StudentID}}" data-id="{{$message->ID}}"><i class="fa fa-remove fa-fw pull-right"></i> </span>
                          <br/>
                          <span class="timeago pull-right"  data-livestamp="{{strtotime($message->created_at)}}"></span>
                      </span>
                  </div>
              @endif
          </div>
      @endforeach


  @else
      <div class="alert alert-info">
          No messages
      </div>
  @endif
  </div>
</div>
    {{Form::open(['url' => '/messages/mygroup/reply/'.$id, 'data-target'=>'/messages/mygroup/view/'.$id, 'id'=>'formPostPersonalReply', 'role' => 'form', 'files'=>'true'])}}
        <div class="navbar navbar-default navbar-fixed-bottom" role="navigation">
            <div class="container">
                <div class="input-group margin-top-sm">
                    {{Form::text('message', null, ['id'=>'txtPostReplyMessage', 'class'=>'form-control', 'placeholder'=>'Message'])}}
                    <span class="input-group-btn">
                        {{HTML::decode(Form::submit('Send', ['class'=>'btn btn-primary']))}}
                    </span>
                </div>
            </div>
        </div>
    {{Form::close()}}

</div>