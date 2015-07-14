@if(count($folder))
@extends('layouts.header')
@section('header_content')
    <h5 class="modal-title pull-left" id="myModalLabel"><i class="fa fa-folder-open-o fa-fw"></i>
        <a href="#">
            <span id="name" data-target="/files"> Files & Folder</span>
        </a>
        <i class="fa fa-chevron-right fa-fw"></i>{{$folder->name}}
    </h5>
@stop
<div class="container margin-top-xxl">
    {{Form::open(['url' => '/files/add/' . $folder->id . '/', 'id'=>'formPostStatus', 'class'=>'clearfix', 'role' => 'form', 'files'=>'true'])}}
        <div class="pull-left">
            <label class="btn-upload-photo btn btn-sm btn-default">
                {{ Form::file('files[]', ['multiple' => true, 'accept'=>'files/*','id'=>'','class'=>'hiddenFile']) }}
                <span><i class="fa fa-upload fa-fw"></i> Choice Files</span>
            </label>
             {{ $errors->first('files[]', '<span class=errormsg>*:message</span>') }}
        </div>
        {{HTML::decode(Form::submit('Upload', ['class'=>'pull-right btn btn-primary']))}}
    {{Form::close()}}
    @if(count($files))
        <div class="list-group margin-top-sm">
            @foreach($files as $file)
                <div class="files-container list-group-item clearfix">
                    <span class="pull-left">
                        <span class="">{{$file->filename}}</span><br/>
                        <span class="timeago" data-livestamp="{{strtotime($file->updated_at)}}"></span>
                    </span>
                    <span class="pull-right">
                        <a href="#" class="pull-right" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-angle-down"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-right" style="top:25%;" role="menu">
                            <li><a href="{{$file->path}}" id="name"><i class="fa fa-download fa-fw"></i> Download</a></li>
                            <li><a href="#"><span id="name" data-target="files/share/{{$file->id}}"><i class="fa fa-share-square fa-fw"></i> Share</span></a></li>
                            <li>
                                <a href="#"><span id="silentPostRequest" data-target="files/delete/{{$file->id}}" data-parent="files-container" data-id="0" data-message="deleted" data-hide="true"><i class="fa fa-remove fa-fw"></i> Delete</span></a>
                            </li>

                        </ul>

                    </span>

                </div>
            @endforeach
        </div>
    @endif
  </div>

@endif
