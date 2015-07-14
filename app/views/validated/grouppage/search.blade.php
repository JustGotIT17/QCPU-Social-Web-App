@if($user)
    <div class="list-group-item clearfix">
        <img src="{{User::getProfileImage($user->photo)}}" class="post-photo pull-left">
        <span id="name" data-target="messages/view/{{$user->StudentID}}" data-id="{{$user->StudentID}}">{{$user->Firstname . ' ' . $user->Lastname}}</span>
        <br/><span class="timeago">Member since </span> <span class="timeago" data-livestamp="{{strtotime($user->created_at)}}"></span>
    </div>
@else
    <div class="alert alert-info">No user found</div>
@endif