@if(count($quiz))
    @extends('layouts.header')
    @section('header_content')
        <h5 class="modal-title" id="myModalLabel">
            <a href="#">
                <span id="name" data-target="/quiz/view/{{$quiz->id}}">{{$quiz->name}}</span>
            </a>
            <i class="fa fa-chevron-right fa-fw"></i>
            <a href="#">
                <span id="name" data-target="/quiz/view/designation/{{$quiz->id}}">Designation</span>
            </a>
            <i class="fa fa-chevron-right fa-fw"></i>
            @foreach($quiz->group_page as $group)
                <a href="#">
                    <span id="name" data-target="/grouppage/view/{{$group->grouppageID}}">{{$group->Name}}</span>
                </a>

            @endforeach
            <i class="fa fa-chevron-right fa-fw"></i>Result
        </h5>
    @stop
    <div class="container margin-top-xxl">
        @if(count($quizResults))
            <div class="list-group margin-top-sm">
                @foreach($quizResults as $quizResult)
                    <div class="list-group-item clearfix">
                        <img src="{{User::getProfileImage($quizResult->owner->photo)}}" class="post-photo pull-left">
                        <span id="name" data-target="/messages/view/{{$quizResult->owner->StudentID}}">
                            {{$quizResult->owner->Firstname . ' ' . $quizResult->owner->Lastname}}
                        </span><span class="timeago">{{$quizResult->owner->StudentID }}</span>
                        <p class="text-primary"><b>Score:</b> {{$quizResult->score . ' / ' . $quizResult->totalItems}}</p>
                        <small class="timeago">{{date(MyDate::getDateFormat(), strtotime($quizResult->created_at))}}</small>
                    </div>
                @endforeach
            </div>
        @else

        @endif
    </div>
@endif