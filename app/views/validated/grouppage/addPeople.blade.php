@if(count($groupPage))
    @extends('layouts.header')
    @section('header_content')
        <h5 class="modal-title" id="myModalLabel">
            <a href="#">
                <span id="name" data-target="/grouppage/view/{{$groupPage->grouppageID}}">{{$groupPage->Name}}</span>
            </a>
            <i class="fa fa-chevron-right fa-fw"></i>Add People
        </h5>
    @stop
    <div class="container margin-top-xxl">
        <span class="input-group margin-top-sm">
            <span class="input-group-addon"><i class="fa fa-search fa-fw"></i> </span>
            <input type="text" id="txtGroupPageAddPeopleSearch" data-id="{{$groupPage->grouppageID}}" class="form-control" placeholder="Search People, Groups...">
        </span>

        <div class="searchContainer">

        </div>

    </div>
@endif