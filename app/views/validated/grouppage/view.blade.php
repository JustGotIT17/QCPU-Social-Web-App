<div class="">
    <?php $isAdmin = (GroupPage::isAdmin($groupPages->grouppageID, Auth::user()->StudentID)) ? true : false ?>
    <?php $isAssistant = (GroupPage::isAssistant($groupPages->grouppageID, Auth::user()->StudentID)) ? true : false ?>
    <?php $isMember = (GroupPage::isMember($groupPages->grouppageID, Auth::user()->StudentID)) ? true : false ?>
    @if(count($groupPages))
        @extends('layouts.header')
        @section('header_content')
            <h5 class="modal-title" id="myModalLabel"><i class="fa fa-institution fa-fw"></i> {{$groupPages->Name}}</h5>
        @stop
        @if($isMember || $isAdmin)
            <div class="navbar navbar-fixed-top margin-top-xl">
                <br/>
                <div class="modal-header text-center row-full">
                    <span id="name" data-target="grouppage/post/{{$groupPages->grouppageID}}" class="col-4"><i class="fa fa-pencil-square-o fa-fw"></i> Post</span>
                    <span id="name" data-target="/grouppage/view/activities/{{$groupPages->grouppageID}}" class="col-4"><i class="fa fa-adjust fa-fw"></i> Activities</span>
                    @if($isAdmin || $isAssistant)
                        <span id="name" data-target="/grouppage/view/people/{{$groupPages->grouppageID}}" class="col-4"><i class="fa fa-plus-square fa-fw"></i> People</span>
                    @endif
                    <span id="name" data-target="/grouppage/view/settings/{{$groupPages->grouppageID}}" class="col-4"><i class="fa fa-cog fa-fw"></i> Settings</span>
                </div>
            </div>
        @endif
    @endif
    <br/><br/><br/>
    <div class="container margin-top-xxl">
    @if(count($joins) && ($isAdmin || $isAssistant))
        <div class="alert alert-info text-center margin-top-sm">
            <i class="fa fa-info fa-fw fa-2x"></i><br/>
            Group page has {{$joins->count()}} pending join request.<br/>
            Check it on members tab.
        </div>
    @endif
    @if($isMember || $isAdmin)
        <div class="col-sm-12">
                <div class="tabbable">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href=".group_page_posts" data-toggle="tab" style="font-size: .75em"><i class="fa fa-user"></i> Posts</a></li>
                    <li><a href=".group_page_files" data-toggle="tab" style="font-size: .75em"><i class="fa fa-files-o"></i> Files</a></li>
                    <li><a href=".group_page_members" data-toggle="tab" style="font-size: .75em"><i class="fa fa-users"></i> Members</a></li>
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active group_page_posts">
                        <div class="list-group margin-top-sm">
                            @if(count($groupPosts))
                                @foreach($groupPosts as $post)
                                    <div class="list-group-item margin-top-sm">
                                        @if(Auth::user()->StudentID == $post->owner->StudentID || $isAdmin)
                                            <a href="#" class="pull-right" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-angle-down"></i> </a>
                                            <ul class="dropdown-menu dropdown-menu-right" style="top:10%;" role="menu">
                                                <li><a href="#">
                                                    <span id="silentPostRequest" data-parent="list-group-item" data-target="/grouppage/post/{{$post->grouppagepostID}}/delete" data-hide="true" data-message="delete" data-id="{{$groupPages->grouppageID}}" data-accid="{{$post->StudentID}}">
                                                        <i class="fa fa-remove fa-fw"></i> Delete Post
                                                    </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        @endif
                                        <div class="post-header clearfix">
                                            <img src="{{User::getProfileImage($post->owner->photo)}}" class="img-responsive pull-left post-photo" alt="{{$post->owner->photo}}">
                                            <span id="name" href="#" data-target="/messages/view/{{$post->owner->StudentID}}">{{$post->owner->Firstname . ' ' . $post->owner->Lastname}}</span>
                                            <br/><span class="timeago" data-livestamp="{{strtotime($post->created_at)}}"></span>
                                        </div>
                                        <hr id="fit">
                                        <div class="post-body">
                                            {{$post->Message}}
                                            @if(count($post->group_page_files))
                                            <hr id="fit">
                                                <div class="margin-top-sm">
                                                    <span class="timeago">uploaded {{$post->group_page_files->count()}} {{$post->group_page_files->count() > 1 ? 'files' : 'file'}}</span>
                                                    @foreach($post->group_page_files as $file)
                                                        <span class="list-group-item clearfix">
                                                            <span class="pull-right">
                                                                <a href="#" class="pull-right" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-angle-down"></i> </a>
                                                                <ul class="dropdown-menu dropdown-menu-right" style="top:10%;" role="menu">
                                                                    <li><a href="{{$file->path}}" class=""><i class="fa fa-download fa-fw"></i> Download</a></li>
                                                                </ul>
                                                            </span>
                                                            <span class="pull-left">
                                                                <span>{{$file->filename}}</span>
                                                            </span>
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="comment-box">
                                        <div class="col-2">
                                            <span id="name" class="divider" data-target="/grouppage/{{$groupPages->grouppageID}}/post/{{$post->grouppagepostID}}/comment/">
                                                <i class="fa fa-comment-o fa-fw"></i> {{$post->comments()->count()}} Comment{{$post->comments()->count() > 1 ? 's' : ''}}
                                            </span>
                                        </div>
                                        <div class="col-2">
                                            <span id="silentPostRequest" data-target="/grouppage/post/star" data-message="Star" data-hide="false" data-id="{{$post->grouppagepostID}}" data-accid="{{Auth::user()->StudentID}}">
                                                <i class="fa fa-star fa-fw {{ count($post->my_stars) ? ' text-primary':''}}"></i>
                                                <span class="starCount" data-star="{{count($post->my_stars) ? 'true' : 'false'}}">
                                                    {{$post->stars()->count()}}
                                                </span>
                                                <span class="starName">
                                                    Star{{$post->stars()->count() > 1 ? 's' : ''}}
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                @endforeach

                            @else
                                <div class="alert alert-info">No post yet.</div>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane group_page_files">
                        <div class="list-group margin-top-sm">
                        @if(count($groupPosts))
                            <div class="list-group margin-top-sm">
                                @foreach($groupPosts as $post)
                                    @if(count($post->group_page_files))
                                        @foreach($post->group_page_files as $file)
                                            <div class="list-group-item clearfix">
                                                <span class="pull-left">
                                                    <div class="pull-left row-full">{{$file->filename}}</div><br/>
                                                    <span class="timeago pull-left">Uploaded by {{$post->owner->Firstname . ' ' . $post->owner->Lastname}}</span><br/>
                                                    <span class="timeago" data-livestamp="{{strtotime($file->updated_at)}}"></span>
                                                </span>
                                                <span class="pull-right">
                                                    <a href="#" class="pull-right" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-angle-down"></i> </a>
                                                    <ul class="dropdown-menu dropdown-menu-right" style="top:10%;" role="menu">
                                                        <li><a href="{{$file->path}}"><i class="fa fa-download fa-fw"></i> Download</a></li>
                                                    </ul>
                                                </span>
                                            </div>
                                        @endforeach
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info">No files yet.</div>
                        @endif
                        </div>

                    </div>
                    <div class="tab-pane group_page_members">

                        <div class="list-group margin-top-sm">
                            @if(count($joins) && ($isAdmin || $isAssistant))
                                <div class="more_display">
                                    <div class="list-group-item list-group-item-success clearfix">
                                        <h4 class="list-group-item-heading pull-left">Join Request</h4>
                                        <span class="badge pull-right">{{$joins->count()}}</span>
                                    </div>
                                    <div id="more_group_pages">
                                        @foreach($joins as $join)
                                            <div class="list-group-item clearfix">
                                                <span class="pull-right">
                                                    <span id="silentGetRequest" class="btn btn-sm btn-primary" data-message="accepted" data-target="/grouppage/join/accept/{{$join->id}}"><i class="fa fa-check"></i></span>
                                                </span>
                                                <img src="{{User::getProfileImage($join->user->photo)}}" class="pull-left post-photo img-responsive">
                                                <span id="name" data-target="/messages/view/{{$join->StudentID}}">{{$join->user->Firstname . ' ' . $join->user->Lastname}}</span>
                                                <br/><span class="timeago">Member since </span> <span class="timeago" data-livestamp="{{strtotime($join->created_at)}}"></span>

                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="list-group margin-top-sm">
                            @if(count($admin))
                                <div class="list-group-item clearfix">
                                    <img src="{{User::getProfileImage($admin->photo)}}" class="pull-left post-photo img-responsive">
                                    <span id="name" data-target="/messages/view/{{$admin->StudentID}}">{{$admin->Firstname . ' ' . $admin->Lastname}}</span><br/>
                                    <span class="timeago">Administrator</span>
                                </div>
                            @else
                                <h5 class="text-center text-info">No assistant</h5>
                            @endif
                            @if(count($assistant))
                                <div class="list-group-item clearfix">
                                    <img src="{{User::getProfileImage($assistant->photo)}}" class="pull-left post-photo img-responsive">
                                    <span id="name" data-target="/messages/view/{{$assistant->StudentID}}">{{$assistant->Firstname . ' ' . $assistant->Lastname}}</span><br/>
                                    <span class="timeago">Assistant Administrator</span>
                                </div>
                            @else
                                <h5 class="text-center text-info">No assistant</h5>
                            @endif
                            @if(count($members))
                                @foreach($members as $member)
                                    @if($groupPages->assistantID != $member->StudentID)
                                        <div class="list-group-item clearfix">
                                                @if(GroupPage::isAdmin($groupPages->grouppageID, Auth::user()->StudentID))
                                                    <a href="#" class="pull-right" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-angle-down"></i> </a>
                                                    <ul class="dropdown-menu dropdown-menu-right" style="top:30%;" role="menu">
                                                        <li><a href="#"><span id="silentPostRequest" data-message="Successfully changed" data-target="grouppage/assign/assistant/" data-id="{{$groupPages->grouppageID}}" data-accid="{{$member->StudentID}}"><i class="fa fa-adn fa-fw"></i> Make Assistant</span></a></li>
                                                        <li class="divider"></li>
                                                        <li><a href="#"><span id="silentPostRequest" data-message="Successfully left" data-target="grouppage/leave/force" data-id="{{$groupPages->grouppageID}}" data-accid="{{$member->StudentID}}"><i class="fa fa-reply fa-fw"></i> Force Leave</span></a></li>
                                                    </ul>
                                                @elseif(Auth::user()->StudentID == $member->StudentID)
                                                    <a href="#" class="pull-right" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-angle-down"></i> </a>
                                                    <ul class="dropdown-menu dropdown-menu-right" style="top:30%;" role="menu">
                                                        <li>
                                                            <a href="#">
                                                                <span id="silentPostRequest" data-message="Successfully left" data-target="grouppage/leave" data-id="{{$groupPages->grouppageID}}" data-accid="{{$member->StudentID}}">
                                                                    <i class="fa fa-reply fa-fw"></i>
                                                                    Leave
                                                                </span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                @endif
                                            <img src="{{User::getProfileImage($member->owner->photo)}}" class="pull-left post-photo img-responsive">
                                            <span id="name" data-target="/messages/view/{{$member->owner->StudentID}}">{{$member->owner->Firstname . ' ' . $member->owner->Lastname}}</span>
                                            <br/><span class="timeago">Member since </span> <span class="timeago" data-livestamp="{{strtotime($member->created_at)}}"></span>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                  </div>
                </div>
            </div>
        @else
            <div class="alert alert-info margin-top-sm text-center">
                <i class="fa fa-info-circle fa-fw fa-3x"></i><br/> Sorry, you don't have rights to access this group.<br/>
                Please join to group and wait for request confirmation.<br/><br/>
                @if(GroupPageJoin::isRequested($groupPages->grouppageID))
                    <span class="btn btn-primary">Request already sent</span>
                @else
                    <span id="silentGetRequest" class="btn btn-primary" data-message="Request has been sent" data-target="/grouppage/join/{{$groupPages->grouppageID}}">Join Group</span>
                @endif
            </div>

        @endif
    </div>
</div>