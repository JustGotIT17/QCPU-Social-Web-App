@extends('layouts.header')
@section('header_content')
    <h5 class="modal-title" id="myModalLabel">
        <a href="#">
            <span id="name" data-target="/messages/{{$groupChat->StudentID == Auth::user()->StudentID ? 'my' : ''}}group/view/{{$groupChat->ID}}">{{$groupChat->Name}}</span>
        </a>
        <i class="fa fa-chevron-right fa-fw"></i>Add Member
    </h5>
@stop
<div class="container margin-top-xxl">
    <div class="list-group-item margin-top-sm">
        <input type="hidden" id="txtGCID" value="{{$id}}">
        {{Form::text('name', null, ['id'=>'txtAddStudentNameToGroupChat', 'class'=>'form-control', 'placeholder'=>'Search People'])}}
        <div class="margin-top-sm" id="addStudentNameToGroupChatSearchContainer">
        </div>
  </div>
</div>
