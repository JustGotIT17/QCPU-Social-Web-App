@if(count($quiz))
    @extends('layouts.header')
    @section('header_content')
        <h5 class="modal-title" id="myModalLabel">
            <a href="#">
                <span id="name" data-target="/quiz/view/{{$quiz->id}}">{{$quiz->name}}</span>
            </a>
            <i class="fa fa-chevron-right fa-fw"></i> View
        </h5>
    @stop
    <div class="navbar navbar-static-top margin-top-xxl">
        <div class="modal-header text-center row-full">
            <span id="name" data-target="/quiz/question/create/{{$quiz->id}}" class="col-3"><i class="fa fa-plus-square fa-fw"></i> Add Question</span>
            <span id="name" data-target="/quiz/view/designation/{{$quiz->id}}" class="col-3"><i class="fa fa-adjust fa-fw"></i> Designation</span>
            <span id="name" data-target="/quiz/settings/{{$quiz->id}}" class="col-3"><i class="fa fa-cog fa-fw"></i> Settings</span>
        </div>
    </div>
    <div class="container clearfix">
        @if(count($quizItems))
            <h4 class="title">Quiz Items<span class="badge pull-right">{{$quizItems->count()}}</span></h4>

            <hr id="fit">
            <div class="list-group margin-top-sm">
                <?php $counter = 1; ?>
                @foreach($quizItems as $quizItem)
                    <div class="list-group-item margin-top-sm">
                        <a href="#" class="pull-right" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-angle-down"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-right" style="top:10%;" role="menu">
                            <li>
                                <a href="#">
                                    <span id="name" data-target="/quiz/question/edit/{{$quizItem->id}}"><i class="fa fa-edit fa-fw"></i> Edit</span>
                                </a>
                            </li>
                            <li><a href="#">
                                <span id="silentPostRequest" data-target="/quiz/question/delete/{{$quizItem->id}}" data-hide="true" data-message="delete" data-id="{{Auth::user()->StudentID}}" data-accid="{{$quizItem->id}}">
                                    <i class="fa fa-remove fa-fw"></i> Delete
                                </span>
                                </a>
                            </li>
                        </ul>
                        <p class="margin-top-sm">{{ $counter ++ . '. ' .$quizItem->question}}</p>
                        <div class="form-group margin-top-sm">
                            @foreach($quizItem->quiz_item_choices as $choices)
                                {{'A. ' . $choices->choice1}}<br/>
                                {{'B. ' . $choices->choice2}}<br/>
                                {{'C. ' . $choices->choice3}}<br/>
                                {{'D. ' . $choices->choice4}}<br/>
                            @endforeach
                        </div>
                        <hr id="fit">
                        @foreach($quizItem->quiz_item_answer as $answer)
                            <p>Answer: {{$answer->answer}}</p>
                        @endforeach
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info">No quiz items yet.</div>
        @endif
    </div>
@endif