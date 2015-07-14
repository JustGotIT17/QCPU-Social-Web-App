@if(count($activity))
    @extends('layouts.header')
    @section('header_content')
        <h5 class="modal-title" id="myModalLabel">
            <a href="#">
                <span id="name" data-target="/grouppage/view/{{$activity->grouppageID}}">
                    {{$activity->group_page->Name}}<i class="fa fa-chevron-right fa-fw"></i>
                </span>
            </a>
            <a href="#">
                <span id="name" data-target="/grouppage/view/activities/{{$activity->grouppageID}}">
                    Activity
                </span>
            </a>
            <i class="fa fa-chevron-right fa-fw"></i>
            {{$activity->group_page_activity->name}}</h5>
    @stop

    <div class="container margin-top-xxl">
        {{Form::open(['url' => '/group/activities/submit/'.$activity->id, 'id'=>'', 'class'=>'clearfix', 'role' => 'form', 'files'=>'true'])}}
            <div class = "pull-left margin-top-sm">
                <label class="btn-upload-photo btn btn-sm btn-default ">
                    {{ Form::file('files[]', ['multiple' => true, 'accept'=>'files/*','id'=>'','class'=>'hiddenFile']) }}
                    <span><i class="fa fa-upload fa-fw"></i> Upload Files</span>
                </label>
                 {{ $errors->first('files[]', '<span class=errormsg>*:message</span>') }}

            </div>
            {{Form::submit('Submit', ['class'=>'btn btn-primary margin-top-sm pull-right'])}}
        {{Form::close()}}
        <hr id="fit">
        <div class="">
            <h4 class="title">Description:</h4>
            <p class="text-info">{{$activity->group_page_activity->description}}</p>
            <small class="timeago">Posted on: {{date('M-d-Y', strtotime($activity->created_at))}}</small>
            <h4 class="title">Submission Deadline</h4>
            <p class="text-info">{{date('M-d-Y', strtotime($activity->deadline))}}|Days Remaining: {{date_diff(date_create(date('M-d-Y')), date_create($activity->deadline))->days}}</p>
        </div>
        <hr id="fit">
        @if(count($submittedFile))
            <div class="list-group">
                <div class="list-group-item">
                    <img src="{{User::getProfileImage($submittedFile->owner->photo)}}" class="post-photo pull-left">
                    <span id="name" data-target="/messages/view/{{$submittedFile->owner->StudentID}}">{{$submittedFile->owner->Firstname . ' ' . $submittedFile->owner->Lastname}}</span>
                    <br/>
                    <span class="timeago" data-livestamp="{{strtotime($submittedFile->created_at)}}"></span>
                    <hr id="fit" />
                    <div class="clearfix">
                        <span class="pull-right">
                            <a href="#" class="pull-right" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-angle-down"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right" style="top:10%;" role="menu">
                                <li><a href="{{$submittedFile->path}}" class=""><i class="fa fa-download fa-fw"></i> Download</a></li>
                            </ul>
                        </span>
                        <span class="pull-left">
                            <span>{{$submittedFile->filename}}</span>
                        </span>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-info">No file submitted yet.</div>
        @endif
    </div>
@endif