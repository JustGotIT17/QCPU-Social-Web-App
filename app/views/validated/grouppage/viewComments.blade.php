@if($post)
    @extends('layouts.header')
    @section('header_content')
        <h5 class="modal-title" id="myModalLabel">
            <a href="#">
                <span id="name" data-target="/grouppage/view/{{$groupPage->grouppageID}}">{{$groupPage->Name}}</span>
            </a>
            <i class="fa fa-chevron-right fa-fw"></i>{{$comments->count() > 1 ? $comments->count() .' Comments' : $comments->count() .' Comment'}}
        </h5>
    @stop
    <div class="container margin-top-xxl">
        <div class="modal-header text-center row-full">
            {{Form::open(['url' => '/grouppage/comment/post', 'data-target'=>'/grouppage/'.$groupPage->grouppageID.'/post/'.$post->grouppagepostID.'/comment', 'id'=>'formPostRequest', 'role' => 'form' ])}}
                <div class="form-group">
                    <span class="input-group">
                        {{Form::hidden('id',$groupPage->grouppageID)}}
                        {{Form::hidden('pid',$post->grouppagepostID)}}
                        {{Form::text('message', null, ['id'=>'txtPostReplyMessage', 'class'=>'form-control', 'placeholder'=>'write comment'])}}
                        <span class="input-group-addon">
                            <i class="fa fa-paper-plane"></i>
                        </span>
                    </span>
                </div>
            {{Form::close()}}
        </div>
    </div>
    <div class="container margin-top-xxl">

        <div class="margin-top-sm">
           <div class="post-header clearfix">
               <img src="{{User::getProfileImage($post->owner->photo)}}" class="img-responsive pull-left post-photo" alt="{{$post->owner->photo}}">
               <span id="name" data-target="/messages/view/{{$post->owner->StudentID}}">{{$post->owner->Firstname . ' ' . $post->owner->Lastname}}</span><br/>
               <span class="timeago" data-livestamp="{{strtotime($post->created_at)}}"></span>
           </div>
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

       <div class="margin-top-sm">
            @if(count($comments))
                @foreach($comments as $comment)
                    <div class="post-header list-group-item clearfix" style="padding: 2px;">
                        @if(Auth::user()->StudentID == $comment->StudentID)
                            <span id="silentPostRequest" data-id="{{$comment->groupcommentboxID}}" data-accid="{{$comment->owner->StudentID}}" data-target="/grouppage/post/comment/delete" data-hide="true" data-message="deleted">
                                <i class="fa fa-remove pull-right margin-right-sm margin-top-sm text-danger"></i>
                            </span>
                        @endif
                        <img src="{{User::getProfileImage($comment->owner->photo)}}" class="post-photo pull-left">
                        <span id="name" data-target="/messages/view/{{$comment->owner->StudentID}}">{{$comment->owner->Firstname . ' ' . $comment->owner->Lastname}}</span>
                        <span class="timeago" data-livestamp="{{strtotime($comment->created_at)}}"></span><br/>
                        <span>{{$comment->groupcomment}}</span>


                    </div>

                @endforeach
            @else
                <div class="alert alert-info">No comments yet.</div>
            @endif
       </div>
    </div>
</div>
@endif