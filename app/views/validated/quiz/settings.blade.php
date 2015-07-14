@if(count($quiz))
    @extends('layouts.header')
    @section('header_content')
        <h5 class="modal-title" id="myModalLabel">
            <a href="#">
                <span id="name" data-target="/quiz/view/{{$quiz->id}}">{{$quiz->name}}</span>
            </a>
            <i class="fa fa-chevron-right fa-fw"></i>Settings
        </h5>
    @stop
    <div class="container margin-top-xxl">
        Under constructions
    </div>
@endif