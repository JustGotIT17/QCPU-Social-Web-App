@extends('layouts.header')
@section('header_content')
    <h5 class="modal-title" id="myModalLabel">
        <a href="#">
            <span id="name" data-target="/grouppage/view/"></span>
        </a>
        <h5 class="modal-title pull-left" id="myModalLabel">Quiz <i class="fa fa-chevron-right fa-fw"></i>Create</h5>
    </h5>
@stop

<div class="container margin-top-xxl">
    {{Form::open(['url'=>'/quiz/create', 'class'=>'margin-top-sm'])}}
        <div class="form-group">
            {{Form::label('name','Quiz Name')}}
            {{Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'eg. Quiz 1'])}}
        </div>
        <div class="form-group">
            {{Form::label('topic','Topic')}}
            {{Form::text('topic', null, ['class'=>'form-control', 'placeholder'=>'eg. General Physics'])}}
        </div>
        <div class="form-group">
            {{Form::submit('Create', ['class'=>'btn btn-sm btn-primary pull-right'])}}
        </div>

    {{Form::close()}}
</div>
