@if(count($quiz))
    @extends('layouts.header')
    @section('header_content')
        <h5 class="modal-title" id="myModalLabel">
            {{$quiz->name}}
            <i class="fa fa-chevron-right fa-fw"></i> View
        </h5>
    @stop
    <div class="container margin-top-xxl">
        <h4>
            Quiz Details:
            <span class="badge alert-info pull-right">{{date_diff(date_create_from_format('Y-m-d H:i:s',$quiz->deadline), date_create(date("Y-m-d H:i:s")))->format('%a d %h hr %i min %s sec')}} Left</span>
        </h4>
        <hr id="fit"/>
        <div class="margin-top-sm">
            <p>
                <span class="text-primary"><b>Name:</b></span>
                <span class="text-nowrap">{{$quiz->quiz->name}}</span>
            </p>
            <p>
                <span class="text-primary"><b>Topic:</b></span>
                <span class="text-nowrap">{{$quiz->quiz->quizTopic}}</span>
            </p>
                <span class="text-primary"><b>Group:</b></span>
                <span class="text-nowrap">{{$quiz->group_page->Name}}</span>
            </p>
            <p>
                <span class="text-primary"><b>Professor:</b></span>
                <span class="text-nowrap">{{$quiz->owner->Firstname. ' ' . $quiz->owner->Lastname}}</span>
            </p>
            <p>
                <span class="text-primary"><b>Deadline:</b></span>
                <span class="text-nowrap">{{date(MyDate::getDateFormat(), strtotime($quiz->deadline))}}</span>
            </p>
            <p>
                <span class="text-primary"><b>Duration:</b></span>
                <span class="text-nowrap">{{$quiz->duration}} Minutes</span>
            </p>
            <p>
                <span class="text-primary"><b>Date Designated:</b></span>
                <span class="text-nowrap">{{date(MyDate::getDateFormat(), strtotime($quiz->created_at))}}</span>
            </p>
            <span id="name" data-target="/quiz/take/student/{{$quiz->id}}/{{$quiz->group_page->grouppageID}}" class="btn btn-primary margin-top-sm">Take Now</span>
        </div>
    </div>
@endif