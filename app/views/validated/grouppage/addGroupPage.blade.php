@extends('layouts.header')
@section('header_content')
    <h5 class="modal-title" id="myModalLabel"><i class="fa fa-institution fa-fw"></i> Create Group Page</h5>
@stop
<div class="container margin-top-xxl">
    {{Form::open(['url' => '/grouppage/addGroupPage', 'data-target'=>'/', 'id'=>'formCreateGroupChat', 'role' => 'form', 'files'=>'true'])}}
      <div class="modal-body">
        <div class="form-group">
            {{Form::text('Name', null, ['id'=>'txtCreateGroupChatName', 'class'=>'form-control', 'placeholder'=>'Group Name'])}}
            <span class="error"></span>
        </div>
        <div class="form-group">
            {{Form::text('subject', null, ['id'=>'txtCreateGroupChatSubject', 'class'=>'form-control', 'placeholder'=>'Group Subject'])}}
            <span class="error"></span>
        </div>
        <div class="form-group">
            {{Form::textarea('description', null, ['id'=>'txtCreateGroupChatDescription', 'class'=>'form-control', 'placeholder'=>'Group Description'])}}
            <span class="error"></span>
        </div>
        <div class="form-group">
            {{Form::text('assistant', null, ['id'=>'txtCreateGroupChatAssistant', 'class'=>'form-control', 'placeholder'=>'Group Assistant'])}}
            <span class="error"></span>
            <div class="searchContainer"></div>
        </div>
      </div>
      <div class="modal-footer">
        {{HTML::decode(Form::submit('Create', ['class'=>'btn btn-primary']))}}
      </div>
    {{Form::close()}}

</div>
