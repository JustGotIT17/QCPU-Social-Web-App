<?php $isAdmin = GroupPage::isAdmin($groupPage->grouppageID, Auth::user()->StudentID) ?>
<?php $isMember = (GroupPage::isMember($groupPage->grouppageID, Auth::user()->StudentID)) ? true : false ?>
@if(count($groupPage))
    @extends('layouts.header')
    @section('header_content')
        <h5 class="modal-title" id="myModalLabel">
            <a href="#">
                <span id="name" data-target="/grouppage/view/{{$groupPage->grouppageID}}">{{$groupPage->Name}}</span>
            </a>
            <i class="fa fa-chevron-right fa-fw"></i> Settings
        </h5>
    @stop

    <div class="container margin-top-xxl">
        <div class="list-group margin-top-sm">
            @if($isAdmin)
                <div class="list-group-item clearfix">
                    <span id="silentPostRequest" data-id="{{$groupPage->grouppageID}}" data-accid="{{Auth::user()->StudentID}}" data-message="Deleting..." data-target="/grouppage/delete" class="btn btn-sm btn-danger pull-right"><i class="fa fa-remove fa-fw"></i> Delete Group</span>
                    <h5 class="text-danger">Delete this group page</h5>
                </div>
            @elseif($isMember)
                <div class="list-group-item clearfix">
                    <span id="silentPostRequest" class="btn btn-sm btn-danger pull-right" data-message="Successfully left" data-target="grouppage/leave" data-id="{{$groupPage->grouppageID}}" data-accid="{{Auth::user()->StudentID}}">
                        <i class="fa fa-reply fa-fw"></i>
                        Leave
                    </span>
                    <h5 class="text-danger">Leave this group page</h5>
                </div>
            @endif
        </div>
    </div>
@endif