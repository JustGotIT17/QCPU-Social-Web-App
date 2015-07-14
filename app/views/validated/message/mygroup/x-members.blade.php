@extends('layouts.header')
@section('header_content')
    <h5 class="modal-title" id="myModalLabel">
        <a href="#">
            <span id="name" data-target="/grouppage/view/"></span>
        </a>
        <i class="fa fa-chevron-right fa-fw"></i> Members
    </h5>
@stop
<div class="container margin-top-xxl">
    <div class="list-group">
        @if(count($members))
            @foreach($members as $member)
                <div class="list-group-item">
                    <div class="clearfix">
                        <img src="{{User::getProfileImage($member->user->photo)}}" class="img-responsive post-photo pull-left">
                        <span id="name" data-target="/profile/{{$member->StudentID}}">{{$member->user->Firstname . ' ' . $member->user->Lastname}}</span>
                        <br/><span class="timeago">Joined since </span> <span class="timeago" data-livestamp="{{strtotime($member->created_at)}}"></span>

                    </div>
                </div>
            @endforeach
        @else

        @endif
    </div>

</div>
