<div class="list-group">
    @if(count($users) && count($groupPageID))
        @foreach($users as $user)
            <div class="list-group-item clearfix">
                <span class="pull-right">
                    @if(count($user->group_page_member) || count($user->group_page_owner))
                        <span class="badge badge-blue">Member</span>
                    @else
                        <span class="btn btn-sm btn-primary" id="silentPostRequest" data-target="grouppage/search/add" data-id="{{$groupPageID}}" data-accid="{{$user->StudentID}}" data-message="Added">Add To Group</span>
                    @endif
                </span>
                <span class="pull-left">
                    <img src="{{User::getProfileImage($user->photo)}}" class="post-photo pull-left">
                    <span id="name" data-target="/messages/view/{{$user->StudentID}}">{{$user->Firstname . ' ' . $user->Lastname}}</span>
                </span>
            </div>
        @endforeach
    @else
        <div class="list-group-item">
            <span class="alert-info text-center">No result found.</span>
        </div>
    @endif
</div>