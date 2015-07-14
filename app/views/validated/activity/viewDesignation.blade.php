@extends('layouts.header')
@section('header_content')
    <h5 class="modal-title pull-left" id="myModalLabel">
        <a href="#">
            <span id="name" data-target="/group/activities/view/{{$activity->id}}">{{$activity->name}}</span>
        </a>
        <i class="fa fa-chevron-right fa-fw"></i>
        Add Group designation
    </h5>
@stop
<div class="container margin-top-xxl">
    @if(count($groups))
        {{Form::open(['url'=>'group/activities/designation/submit', 'class'=>'margin-top-sm clearfix'])}}
            <div class="form-group">
                {{Form::hidden('grouppageactivityID', $activity->id)}}
                {{ Form::label('group', 'Select Group:', ['class'=>'']) }}
                {{ Form::select('group', $groups, null, ['class' => 'form-control']) }}
            </div>
            <div class="form-group">
               <label for="deadline">Deadline of submission</label>
               <input name="deadline" id="txtDeadline" type="text" onclick="f_CallCalendar('deadline')" class="form-control">
            </div>
            <div class="form-group">
                {{Form::label('time', 'Time:')}}
                {{$time}}
            </div>
            {{Form::submit('Submit', ['class'=>'btn btn-primary pull-right'])}}
        {{Form::close()}}
    @else
        <div class="alert alert-info margin-top-sm">No groups available.</div>
    @endif

</div>