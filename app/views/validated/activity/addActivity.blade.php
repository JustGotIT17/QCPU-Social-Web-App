@extends('layouts.header')
@section('header_content')
    <h5 class="modal-title" id="myModalLabel">
        Add Activity
    </h5>
@stop
<div class="container margin-top-xxl">
    {{Form::open(['url' => '/group/activities/add', 'data-target'=>'/', 'id'=>'', 'role' => 'form' ])}}
    <div class="modal-body">
        {{Form::text('name', null, ['id'=>'txtFolderName', 'class'=>'form-control', 'placeholder'=>'Activity Name'])}}
        <br/>
        {{Form::textarea('desc', null, ['id'=>'txtFolderDesc', 'class'=>'form-control', 'placeholder'=>'Activity Description'])}}
    </div>

    <div class="modal-footer">
        {{HTML::decode(Form::submit('Create', ['class'=>'btn btn-primary']))}}
    </div>
    {{Form::close()}}
</div>
