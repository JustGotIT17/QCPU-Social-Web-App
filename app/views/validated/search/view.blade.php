<div class="list-group">
    <div class="more_display">
        <div class="list-group-item list-group-item-success clearfix">
            <h4 class="list-group-item-heading pull-left">People</h4>
            <span class="badge pull-right">{{$users->count()}}</span>
        </div>
        <div id="more_group_pages">
            @if(count($users))
                @foreach($users as $user)
                    <div class="list-group-item clearfix">
                        <img src="{{ User::getProfileImage($user->photo)}}" class="post-photo" alt="{{$user->id}}">
                        <span id="name" data-target="/messages/view/{{$user->StudentID}}">{{$user->Firstname . ' ' . $user->Lastname}}</span>

                    </div>
                @endforeach
            @else
                <div class="alert alert-info text-center">
                    <i class="fa fa-meh-o fa-2x"></i><br/>
                    No result for people
                </div>
            @endif
        </div>
    </div>
    <div class="more_display">
        <div class="list-group-item list-group-item-success clearfix">
            <h4 class="list-group-item-heading pull-left">Groups</h4>
            <span class="badge pull-right">{{$groups->count()}}</span>
        </div>
        <div id="more_group_pages">
            @if(count($groups))
                @foreach($groups as $group)
                    <div class="list-group-item clearfix">
                        <span id="name" data-target="/grouppage/view/{{$group->grouppageID}}">{{$group->Name}}</span><br/>
                        <span class="timeago" data-livestamp="{{strtotime($group->created_at)}}"></span>
                    </div>
                @endforeach
            @else
                <div class="alert alert-info text-center">
                    <i class="fa fa-meh-o fa-2x"></i><br/>
                    No result for group pages
                </div>
            @endif
        </div>
    </div>
</div>