@if(count($quiz))
    @extends('layouts.header')
    @section('header_content')
        <h5 class="modal-title" id="myModalLabel">
            <a href="#">
                <span id="name" data-target="/quiz/view/{{$quiz->id}}">{{$quiz->name}}</span>
            </a>
            <i class="fa fa-chevron-right fa-fw"></i>Add Question
        </h5>
    @stop

    <div class="container margin-top-xxl">
        {{Form::open(['url'=>'/quiz/question/create/'.$quiz->id, 'class'=>'margin-top-sm', 'id'=>''])}}
            <div class="form-group">
                {{Form::textarea('question', null, ['class'=>'form-control', 'placeholder'=>'Item Question'])}}
            </div>
            <div class="form-group">
                {{Form::text('choiceA', null, ['class'=>'form-control', 'placeholder'=>'Choice A'])}}
            </div>

            <div class="form-group">
                {{Form::text('choiceB', null, ['class'=>'form-control', 'placeholder'=>'Choice B'])}}
            </div>
            <div class="form-group">
                {{Form::text('choiceC', null, ['class'=>'form-control', 'placeholder'=>'Choice C'])}}
            </div>
            <div class="form-group">
                {{Form::text('choiceD', null, ['class'=>'form-control', 'placeholder'=>'Choice D'])}}
            </div>

            <div class="form-group">
                {{Form::label('answer','Answer')}}
                {{Form::select('answer', $ans, null, ['class'=>'form-control'])}}
            </div>
            <div class="form-group">
                {{Form::submit('Create', ['class'=>'btn btn-sm btn-primary pull-right'])}}
            </div>
        {{Form::close()}}
    </div>
@endif