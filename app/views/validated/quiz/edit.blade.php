@if(count($quiz))
    @extends('layouts.header')
    @section('header_content')
        <h5 class="modal-title" id="myModalLabel">
            <a href="#">
                <span id="name" data-target="/quiz/view/{{$quiz->id}}">{{$quiz->name}}</span>
            </a>
            <i class="fa fa-chevron-right fa-fw"></i>Edit Question
        </h5>
    @stop
    <div class="container margin-top-xxl">
        @if(count($quizItem))
            {{Form::open(['url'=>'/quiz/question/save/'. $quizItem->id, 'class'=>'margin-top-sm'])}}
                <div class="form-group">
                    {{Form::label('question', 'Question:')}}
                    {{Form::textarea('question', $quizItem->question, ['class'=>'form-control'])}}
                </div>
                <div class="form-group margin-top-sm">
                    @foreach($quizItem->quiz_item_choices as $choices)
                        <div class="form-group">
                            {{Form::label('choiceA', 'Choice A:')}}
                            {{Form::text('choiceA', $choices->choice1, ['class'=>'form-control', 'placeholder'=>'Choice A'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('choiceB', 'Choice B:')}}
                            {{Form::text('choiceB', $choices->choice2, ['class'=>'form-control', 'placeholder'=>'Choice B'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('choiceC', 'Choice C:')}}
                            {{Form::text('choiceC', $choices->choice3, ['class'=>'form-control', 'placeholder'=>'Choice C'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('choiceD', 'Choice D:')}}
                            {{Form::text('choiceD', $choices->choice4, ['class'=>'form-control', 'placeholder'=>'Choice D'])}}
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    @foreach($quizItem->quiz_item_answer as $answer)
                        {{Form::label('answer', 'Answer')}}
                        {{Form::select('answer', $ans, $answer->answer, ['class'=>'form-control'])}}
                    @endforeach
                </div>
                {{Form::submit('Submit', ['class'=>'btn btn-sm btn-primary pull-right'])}}
            {{Form::close()}}
        @endif
    </div>
@endif