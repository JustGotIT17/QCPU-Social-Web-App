@extends('layouts.header')
@section('header_content')
    <h5 class="modal-title" id="myModalLabel">
       Search People
    </h5>
@stop
<div class="container margin-top-xxl">
    <span class="input-group margin-top-sm">
        <span class="input-group-addon"><i class="fa fa-search fa-fw"></i> </span>
        <input type="text" id="txtSearch" class="form-control" placeholder="Search People, Groups...">
    </span>
    <div class="searchContainer margin-top-sm">
    </div>
</div>


