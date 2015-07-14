@if(count($activity))
    @extends('layouts.header')
    @section('header_content')
        <h5 class="modal-title pull-left" id="myModalLabel">Activity <i class="fa fa-chevron-right fa-fw"></i> {{$activity->name}}</h5>
    @stop
    <div class="navbar navbar-static-top margin-top-xxl">
        <div class="modal-header text-center row-full">
            <span id="name" data-target="/group/activities/view/designation/{{$activity->id}}" class="col-2 divider"><i class="fa fa-pencil-square-o fa-fw"></i> Designation</span>
            <span id="name" data-target="/group/activities/view/settings/{{$activity->id}}" class="col-2"><i class="fa fa-cog fa-fw"></i> Settings</span>
        </div>
    </div>

    <div class="container">
        <h5 class="text-info">Description:</h5>
        <hr id="fit">
        <p class="margin-top-sm">{{$activity->description}}</p>
        <h5 class="text-info">Designated Groups</h5>
        <hr id="fit">
        @if(count($activityGroups))
            <div class="list-group margin-top-sm">
                @foreach($activityGroups as $activityGroup)
                    <?php $done = MyDate::onGoing($activityGroup->deadline, date('Y-m-d'));?>

                    <div class="list-group-item clearfix">
                        <span class="pull-left">
                            <span id="name" data-target="/group/activities/view/submission/{{$activityGroup->id}}/{{$activity->id}}">{{$activityGroup->group_page->Name}}</span><br/>
                            <span class="timeago">Deadline: {{date(MyDate::getDateFormat(), strtotime($activityGroup->deadline))}}</span><br/>
                            <span class="timeago">Date Designation: {{date(MyDate::getDateFormat(), strtotime($activityGroup->created_at))}}</span>
                        </span>
                        <span class="pull-right">
                            {{GroupPageHelper::activityStatus($done)}}
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info">No groups yet.</div>
        @endif
    </div>



@else
    <div class="alert alert-info">Error no such activity exists</div>
@endif
