@if(count($groupPage))
    @extends('layouts.header')
    @section('header_content')
        <h5 class="modal-title" id="myModalLabel">
            <a href="#">
                <span id="name" data-target="/grouppage/view/{{$groupPage->grouppageID}}">{{$groupPage->Name}}</span>
            </a>
            <i class="fa fa-chevron-right fa-fw"></i>Post
        </h5>
    @stop
    <div class="container margin-top-xxl">
        <div class="clearfix margin-top-sm">
            {{Form::open(['url' => '/grouppage/post/'.$groupPage->grouppageID, 'id'=>'formGroupPostStatus', 'class'=>'', 'role' => 'form', 'files'=>'true'])}}
                {{Form::textarea('message', null, ['di'=>'txtPostGroupStatusMessage', 'class'=>'form-control', 'placeholder'=>'Share something...'])}}
                <div class = "pull-left margin-top-sm">
                    <label class="btn-upload-photo btn btn-default ">
                        {{ Form::file('files[]', ['multiple' => true, 'accept'=>'file/*','id'=>'txtPostGroupFiles','class'=>'hiddenFile']) }}
                        <span><i class="fa fa-upload fa-fw"></i> Upload Files</span>
                    </label>
                     {{ $errors->first('files[]', '<span class=errormsg>*:message</span>') }}
                </div>
                {{Form::submit('Post', ['class'=>'btn btn-primary pull-right margin-top-sm'])}}
            {{Form::close()}}
        </div>
    </div>
@endif