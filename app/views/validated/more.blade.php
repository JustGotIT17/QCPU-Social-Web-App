<div class="row">
    <div class="container">
        <div id="link" class="list-group">
            <div class="list-group-item">
                <div class="list-group-item-heading clearfix" >
                    <img src="{{User::getProfileImage(Auth::user()->photo)}}" height="auto" width="100px" class="pull-right img-circle img-responsive">
                    <span class="text-info" style="font-size: 1.3em; font-weight: bold;">
                        {{Auth::user()->Firstname . ' ' . Auth::user()->Lastname}}
                        <small class="timeago">{{Auth::user()->nickname}}</small>
                    </span>
                    <br/>
                    <p class="text-info"><b><i class="fa fa-male"></i> Gender:</b> {{$user->gender->Gender}} <br/>
                    <b><i class="fa fa-shekel"></i> Course:</b> {{$user->course->CourseAbbr}}<br/>
                    <b><i class="fa fa-shield"></i> Level:</b>  {{$user->user_type->name}}<br/>
                </div>
            </div>
            <div class="list-group-item margin-top-sm item-heading">
                <span class="list-group-item-heading" >Manage Account</span>
            </div>
            <div class="list-group-item margin-top-sm">
            <span id="name" data-target="/profile/{{Auth::user()->StudentID}}"><i class="fa fa-user fa-fw"></i> Edit Profile</span>
            </div>
            @if(Auth::user()->UserTypeID === 2)
                <div class="list-group-item margin-top-sm more_display">
                <a href="#"><span id="name" data-target="/files"><i class="fa fa-folder fa-fw"></i> Files & Folders</span></a>
                    <span class="arrow btn btn-xs btn-default pull-right"><i class="fa fa-chevron-down fa-fw"></i> </span>
                    <span id="name" data-target="/files/folder/add" class="btn btn-xs btn-default pull-right margin-right-sm"><i class="fa fa-plus fa-fw"></i> </span>
                    <div class="row margin-top-sm">
                        <div id="more_group_pages" class="margin-top-sm">
                            @if(count($files))
                                <span class="group_header_title">Files <span class="badge badge-blue pull-right">{{$files->count()}}</span> </span>
                                @foreach($files as $file)

                                    <div class="margin-top-sm list-group-item clearfix" style="">
                                        <i class="fa fa-files-o fa-fw"></i>
                                        <a id="name" href="{{$file->path}}">
                                            {{$file->filename}}
                                        </a>
                                        <small class="label-description pull-right">{{ date('M-d-y h:i A', strtotime($file->created_at)) }}</small>
                                    </div>
                                @endforeach
                            @else
                                <div class="margin-top-sm text-center">No Files yet</div>
                            @endif
                             @if(count($fileFolders))
                                <span class="group_header_title">Folders <span class="badge badge-blue pull-right">{{$fileFolders->count()}}</span> </span>
                                @foreach($fileFolders as $fileFolder)
                                    <div class="margin-top-sm list-group-item clearfix">
                                        <i class="fa fa-folder-o fa-fw"></i>
                                        <span id="name" data-target="/files/folder/view/{{$fileFolder->id}}">
                                            {{$fileFolder->name}}
                                        </span>
                                        <small class="label-description pull-right">{{ date('M-d-y h:i A', strtotime($fileFolder->created_at)) }}</small>
                                    </div>

                                @endforeach
                            @else
                                <div class="margin-top-sm text-center">No folders yet</div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
                <div class="list-group-item clearfix margin-top-sm more_display">
                    <span class="arrow btn btn-xs btn-default pull-right"><i class="fa fa-chevron-down fa-fw"></i> </span>
                    @if(Auth::user()->UserTypeID === 2)
                        <span id="name" data-target="/grouppage/addGroupPage" class="btn btn-xs btn-default pull-right margin-right-sm"><i class="fa fa-plus fa-fw"></i> </span>
                    @endif
                    <a href="#">
                        <i class="fa fa-group fa-fw"></i> Groups <span class="badge pull-right badge-blue margin-right-sm">
                            {{$groupPages->count() > 0 ? $groupPages->count() : $adminGroupPages->count()}}
                        </span></a>

                    <div class="row margin-top-sm">
                        <div id="more_group_pages" class="margin-top-sm">
                        @if(count($adminGroupPages))
                        <!--
                        <span class="group_header_title">Group Pages You Admin <span class="badge pull-right"></span> </span>
                        -->
                            @foreach($adminGroupPages as $group)
                            <div class="margin-top-sm list-group-item" style=""><i class="fa fa-chain fa-fw"></i>
                                <span id="name" data-target="/grouppage/view/{{$group->grouppageID}}">{{$group->Name}}</span>
                                <small class="label-description pull-right">{{ date('M-d-y h:i A', strtotime($group->created_at)) }}</small>
                            </div>
                            @endforeach
                        @endif
                        @if(count($groupPages))
                        <!--
                        <span class="group_header_title">Group Pages You Member <span class="badge pull-right"></span></span>
                        -->
                            @foreach($groupPages as $group)
                                <div class="margin-top-sm list-group-item" style="">
                                    <i class="fa fa-chain fa-fw"></i>
                                    <span id="name" data-target="/grouppage/view/{{$group->group_pages->grouppageID}}">
                                        {{$group->group_pages->Name}}
                                    </span>
                                    <small class="label-description pull-right">{{ date('M-d-y h:i A', strtotime($group->created_at)) }}</small>
                                </div>
                            @endforeach
                        @endif
                        @if(!count($adminGroupPages) && !count($groupPages))
                            <div class="margin-top-sm text-center">No groups yet</div>
                        @endif
                        </div>
                    </div>
                </div>
                <div class="list-group-item margin-top-sm more_display">
                    <a href="#"><span><i class="fa fa-adn fa-fw"></i> Activities </span></a>
                        <span class="arrow btn btn-xs btn-default pull-right"><i class="fa fa-chevron-down fa-fw"></i> </span>
                        @if(Auth::user()->UserTypeID === 2)
                            <span id="name" data-target="/group/activities/addActivities" class="btn btn-xs btn-default pull-right margin-right-sm"><i class="fa fa-plus fa-fw"></i> </span>
                        @endif
                        <small class="badge badge-blue margin-right-sm">{{$activities->count()}}</small>
                        <div class="row margin-top-sm">
                            <div id="more_group_pages" class="margin-top-sm">
                                 @if(count($activities))
                                    @if(Auth::user()->UserTypeID === 2)
                                        @foreach($activities as $activity)
                                        <div class="margin-top-sm list-group-item clearfix" style="color: rgba(0,0,0,.5)">
                                            <i class="fa fa-chain fa-fw"></i>
                                            <span id="name" data-target="/group/activities/view/{{$activity->id}}">
                                                {{$activity->name}}
                                            </span>
                                            <small class="label-description pull-right">{{ date('M-d-y h:i A', strtotime($activity->created_at)) }}</small>
                                        </div>
                                        @endforeach
                                    @else
                                        @foreach($activities as $activity)
                                            <div class="margin-top-sm list-group-item clearfix" style="color: rgba(0,0,0,.5)">
                                                <span class="pull-right">
                                                    <?php $done = MyDate::onGoing($activity->deadline, date('Y-m-d H:i:s'));?>
                                                    {{ !$done ? '<span class="badge alert-info">Ongoing</span>' : '<span class="badge alert-danger">Closed</span>' }}
                                                </span>
                                                <span class="pull-left">
                                                    {{ count($activity->group_page_activity_files) ? '<i class="fa fa-check-circle fa-fw text-success"></i>' : '' }}
                                                    <span {{!$done ? 'id="name" data-target="/grouppage/view/activity/'.$activity->grouppageID.'/'.$activity->group_page_activity->id.'"' : ''}}>{{$activity->group_page_activity->name}}</span><br/>
                                                    <span class="timeago">Deadline: {{date(MyDate::getDateFormat(), strtotime($activity->deadline))}}</span><br/>
                                                    <span class="timeago">Date Designated: {{date(MyDate::getDateFormat(), strtotime($activity->created_at))}}</span>
                                                </span>
                                            </div>
                                        @endforeach
                                    @endif
                                @else
                                    <div class="margin-top-sm text-center">No activities yet</div>
                                @endif
                            </div>
                        </div>
                    </div>


            <div class="list-group-item margin-top-sm clearfix more_display">
                <a href="#">
                    <span><i class="fa fa-question-circle fa-fw"></i> Quizzes</span>

                </a>
                <span class="arrow btn btn-xs btn-default pull-right"><i class="fa fa-chevron-down fa-fw"></i> </span>
                @if(Auth::user()->UserTypeID === 2)
                    <span id="name" data-target="/quiz/create" class="btn btn-xs btn-default pull-right margin-right-sm"><i class="fa fa-plus fa-fw"></i> </span>
                @endif
                <span class="badge badge-blue margin-right-sm">{{ (Auth::user()->UserTypeID == 2) ? $quizzes->count() : ''}}</span>
                <div class="row margin-top-sm">
                    <div id="more_group_pages" class="margin-top-sm">
                        <!--
                        <span class="group_header_title">Group Pages You Admin <span class="badge pull-right"></span> </span>
                        -->
                        @if(Auth::user()->UserTypeID == 2)
                            @foreach($quizzes as $quiz)
                                <div class="margin-top-sm list-group-item" style="">
                                    <small class="label-description pull-right">{{ date('M-d-y h:i A', strtotime($quiz->created_at)) }}</small>
                                    <span id="name" data-target="/quiz/view/{{$quiz->id}}">{{$quiz->name}}</span>
                                    <Br/>
                                    <small class="timeago">{{$quiz->quizTopic}}</small>
                                </div>
                            @endforeach
                        @elseif(Auth::user()->UserTypeID == 3)
                            @if(count($quizzes))
                                @foreach($quizzes as $quiz)
                                    @if(count($quiz->group_page_member))
                                        <hr id="fit">
                                        <div class="margin-top-sm list-group-item" style="border: 0px;">
                                            <small class="label-description pull-right">{{ date('M-d-y h:i A', strtotime($quiz->created_at)) }}</small>
                                            <span id="name" data-target="/quiz/view/student/{{$quiz->quiz->id}}/{{$quiz->group_page->grouppageID}}">{{$quiz->quiz->name}}</span>
                                            <Br/>
                                            <small class="timeago">
                                                Topic: {{$quiz->quiz->quizTopic}}<br/>
                                                Group: {{$quiz->group_page->Name}}
                                            </small>
                                        </div>
                                    @else
                                        <div class="margin-top-sm text-center">No quiz yet</div>
                                    @endif
                                @endforeach
                            @else
                                <div class="margin-top-sm text-center">No quiz yet</div>
                            @endif
                        @else
                            <div class="margin-top-sm text-center">Quiz not available</div>
                        @endif
                    </div>
                </div>
            </div>
            <!--
            <div class="list-group-item margin-top-sm">
                <a href="#"><span id="name" data-target="#"><i class="fa fa-archive fa-fw"></i> Archives</span></a>
            </div>
            <div class="list-group-item margin-top-sm">
                <a href="#"><i class="fa fa-cogs fa-fw"></i> Settings</a>
            </div>
            -->
            <div class="list-group-item margin-top-sm">
                <a href="#" onclick="jsAPI.openAlertDialogFromJava(this);"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
            </div>
        </div>
    </div>
</div>