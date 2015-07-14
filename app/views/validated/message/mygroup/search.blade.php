@if(count($users))
    @foreach($users as $user)
        <div class="list-group-item clearfix">
            <img src="{{ User::getProfileImage($user->photo)}}" class="post-photo  pull-left" alt="{{$user->id}}">
            <span class="pull-left">
                {{$user->Firstname . ' ' . $user->Lastname}}
                {{(User::isOnline($user->lastSeen))}}
            </span>
            <br/>
            <small class="timeago pull-left">{{$user->course->CourseName}}</small>
            @if(count($user->group_chat_member))
                <div class="pull-right badge" style="color: white; background-color: #00a0df; font-weight: normal;">Member</div>
            @else
                <a href="/messages/mygroup/{{$id}}/add/{{$user->StudentID}}" style="color: white;" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus"></i> </a>
            @endif
        </div>
    @endforeach
@else
    <div class="alert-info">No result</div>
@endif