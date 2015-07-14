@extends('......layouts.header')
@section('header_content')
    <h5 class="modal-title" id="myModalLabel">
        <a href="#">
            <span id="name" data-target="/messages/group/view/{{$groupChat->ID}}">{{$groupChat->Name}}</span>
        </a>
        <i class="fa fa-chevron-right fa-fw"></i>Members
    </h5>
@stop
<div class="container margin-top-xxl">
    @if(count($members))
        <div class="list-group">
            @foreach($members as $member)
                <div class="list-group-item clearfix">
                    @if($groupChat->StudentID == Auth::user()->StudentID)
                        <span class="pull-right">
                             <a href="#" class="pull-right" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-angle-down"></i> </a>
                             <ul class="dropdown-menu dropdown-menu-right" style="top:10%;" role="menu">
                                <li><a href="#">
                                    <span id="silentPostRequest" data-parent="list-group-item"
                                    data-target="/messages/group/member/delete/{{$groupChat->ID}}" data-hide="true" data-message="delete" data-id="{{$groupChat->ID}}" data-accid="{{$member->StudentID}}">
                                        <i class="fa fa-remove fa-fw"></i> Delete
                                    </span>
                                    </a>
                                </li>
                             </ul>
                        </span>
                    @endif
                    <div class="">
                        <img src="{{User::getProfileImage($member->active_users->photo)}}" class="img-responsive img-circle post-photo pull-left">
                        <span id="name" class="" data-target="/messages/view/{{$member->StudentID}}">{{$member->active_users->Firstname .' '. $member->active_users->Lastname}}</span>
                        <br/>
                        <small class="timeago">{{date(MyDate::getDateFormat(), strtotime($member->created_at))}}</small>
                    </div>

                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            No members yet.
        </div>
    @endif
</div>