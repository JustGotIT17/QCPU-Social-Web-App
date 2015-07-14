@if(count($activity))
    @extends('layouts.header')
    @section('header_content')
        <h5 class="modal-title pull-left" id="myModalLabel">
            <a href="#">
                <span id="name" data-target="/group/activities/view/{{$activity->id}}">{{$activity->name}}</span>
            </a>
            <i class="fa fa-chevron-right fa-fw"></i>
            View Submission
        </h5>
    @stop
    <div class="container margin-top-xxl">
        @if(count($groupActivityFiles))
            <h4 class="title"><i class="fa fa-files-o"></i> Files Submitted <span class="badge pull-right alert-info">{{$groupActivityFiles->count()}}</span> </h4>
            <hr id="fit" />
            <div class="list-group margin-top-sm">
                @foreach($groupActivityFiles as $groupActivityFile)
                    <div class="list-group-item clearfix">
                        <div class="clearfix">
                            <img src="{{User::getProfileImage($groupActivityFile->owner->photo)}}" class="post-photo pull-left">
                            <span id="name" data-target="/messages/view/{{$groupActivityFile->owner->StudentID}}" class="pull-left">{{$groupActivityFile->owner->Firstname . ' ' . $groupActivityFile->owner->Lastname}}</span>
                            <br/>
                            <span class="timeago pull-left" data-livestamp="{{strtotime($groupActivityFile->created_at)}}"></span>
                        </div>
                        <hr id="fit">
                        <div class="margin-top-md">


                            <span class="list-group-item clearfix">
                                <a href="#" class="pull-right" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-angle-down"></i> </a>
                                <ul class="dropdown-menu dropdown-menu-right" style="top:10%;" role="menu">
                                    <li><a href="{{$groupActivityFile->path}}" class=""><i class="fa fa-download fa-fw"></i> Download</a></li>
                                </ul>
                                <span class="pull-left">
                                     <span>{{$groupActivityFile->filename}}</span>
                                </span>
                            </span>

                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info margin-top-sm">No files yet.</div>
        @endif
    </div>
@endif