@if(count($groupPage))
    @extends('layouts.header')
    @section('header_content')
        <h5 class="modal-title" id="myModalLabel">
            <a href="#">
                <span id="name" data-target="/grouppage/view/{{$groupPage->grouppageID}}">
                    {{$groupPage->Name}}
                </span>
            </a>
            <i class="fa fa-chevron-right fa-fw"></i>
            Activities
        </h5>
    @stop
    <div class="container margin-top-xxl">
        @if(count($activityGroups))
            <div class="alert alert-info margin-top-sm clearfix">
                <i class="fa fa-info-circle fa-3x pull-left margin-right-sm"></i>
                <span class="pull-left">
                    <b>Heads Up!</b>
                    <br/> You can still submit your revision while the activity is ongoing.
                </span>
            </div>
            <div class="list-group margin-top-sm">
                @foreach($activityGroups as $activityGroup)
                    <div class="list-group-item clearfix">
                        <span class="pull-right">
                            <?php $done = MyDate::onGoing($activityGroup->deadline, date('Y-m-d'));?>
                            {{GroupPageHelper::activityStatus($done)}}
                        </span>
                        <span class="pull-left">
                            {{ count($activityGroup->group_page_activity_files) ? '<i class="fa fa-check-circle fa-fw text-success"></i>' : '' }}
                            <span {{!$done ? 'id="name"' : ''}}  data-target="/grouppage/view/activity/{{$groupPage->grouppageID}}/{{$activityGroup->group_page_activity->id}}">{{$activityGroup->group_page_activity->name}}</span><br/>
                            <span class="timeago">Deadline: {{date(MyDate::getDateFormat(), strtotime($activityGroup->deadline))}}</span><br/>
                            <span class="timeago">Date Designated: {{date(MyDate::getDateFormat(), strtotime($activityGroup->created_at))}}</span>
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info margin-top-sm">No activities yet.</div>
        @endif
    </div>
@endif