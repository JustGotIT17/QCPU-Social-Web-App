@extends('layouts.header')
@section('header_content')
    <h5 class="modal-title" id="myModalLabel"><i class="fa fa-folder fa-fw"></i> Create Folder</h5>
@stop
{{Form::open(['url' => '/files/folder/add', 'role' => 'form' ])}}

    <div class="modal-body margin-top-xxl">
        {{Form::text('name', null, ['id'=>'txtFolderName', 'class'=>'form-control', 'placeholder'=>'Folder Name'])}}
        <br/>
        {{Form::textarea('desc', null, ['id'=>'txtFolderDesc', 'class'=>'form-control', 'placeholder'=>'Folder Description'])}}
    </div>
    <div class="modal-footer">
        {{HTML::decode(Form::submit('Create', ['class'=>'btn btn-primary']))}}
    </div>
{{Form::close()}}
