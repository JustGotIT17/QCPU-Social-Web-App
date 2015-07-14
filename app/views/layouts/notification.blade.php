<div id="notificationContainer">
    @if(count($notifications))
        @foreach($notifications as $notification)
            <div class="list-group-item padding-sm clearfix">
                <small class="pull-left text-noti-msg">
                    <b>{{$notification->owner->Firstname . ' ' . $notification->owner->Lastname}}</b>
                    {{$notification->notification_event->event . '<span id="name" data-target="/grouppage/view/activity/'.$notification->grouppageID.'/'.$notification->group_page_activity->id.'">'.$notification->group_page_activity->name.'</span>'}}
                </small>
                <img src="{{User::getProfileImage($notification->owner->photo)}}" class="post-photo pull-right">
                <br/><span class="pull-left timeago" data-livestamp="{{strtotime($notification->created_at)}}"></span>
            </div>

        @endforeach
    @else
        <div class="text-center margin-top-sm">
            <i class="fa fa-meh-o fa-fw fa-2x"></i>
            <br/> No Notification
        </div>
    @endif
</div>


