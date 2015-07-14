@if(count($activity))
    @extends('layouts.header')
    @section('header_content')
        <h5 class="modal-title pull-left" id="myModalLabel">
            <a href="#">
                <span id="name" data-target="/group/activities/view/{{$activity->id}}">{{$activity->name}}</span>
            </a>
            <i class="fa fa-chevron-right fa-fw"></i>
            Settings
        </h5>
    @stop
    <div class="container margin-top-xxl">
        Under construction
    </div>
@endif