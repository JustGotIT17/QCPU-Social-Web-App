
<div id="onlineUsers">

@if(count($online))
    @foreach($online as $user)
        <div class="list-group-item clearfix">
            <img src="{{User::getProfileImage($user->photo)}}" alt="{{$user->StudentID}}" class="pull-left post-photo"/>
            <span class="pull-right">
                <span class="text-success">{{($user->deviceID == 1) ? '<i class="fa fa-globe"></i>' : '<i class="fa fa-mobile"></i>'}}</span>
            </span>
            <span id="name" class="pull-left" data-target="/messages/view/{{$user->StudentID}}">
                <small>{{ (strlen($user->Firstname . ' ' . $user->Lastname) < 25) ? $user->Firstname . ' ' . $user->Lastname : substr($user->Firstname . ' ' . $user->Lastname, 0, 25) . '...'}}</small>
            </span>

        </div>
    @endforeach
@else
    <div class="">
        <br/>
        <p class="text-center margin-top-sm"> <i class="fa fa-meh-o fa-fw fa-2x"></i> <br/> No online users</p>
    </div>
@endif
</div>
