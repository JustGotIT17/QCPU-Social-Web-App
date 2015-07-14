@extends('layouts.header')
@section('header_content')
    <h5 class="modal-title" id="myModalLabel"><i class="fa fa-folder-open-o fa-fw"></i> Files & Folders</h5>
@stop
<div class="container margin-top-xxl">
    <div class="clearfix">
        <span class="">
            {{Form::open(['url' => '/files/add/0', 'id'=>'', 'class'=>'clearfix margin-top-sm', 'role' => 'form', 'files'=>'true'])}}
                <div class="pull-left">
                    <label class="btn-upload-photo btn btn-default">
                        {{ Form::file('files[]', ['multiple' => true, 'accept'=>'files/*','id'=>'','class'=>'hiddenFile']) }}
                        <span><i class="fa fa-upload fa-fw"></i> Choose Files</span>
                    </label>
                </div>
                {{HTML::decode(Form::submit('Upload', ['class'=>'pull-right btn btn-primary']))}}
            {{Form::close()}}
        </span>
    </div>

    <div class="list-group-item more_display margin-top-sm">
        <h4 class="text-info">Files</h4>
        <div id="more_group_pages" >
            @if(count($files))
                @foreach($files as $file)
                    <div class="files-container clearfix margin-top-sm block">
                        <hr id="fit">
                        <span class="pull-left padding-sm margin-top-sm">
                            <span class="">{{$file->filename}}</span><br/>
                            <span class="timeago" data-livestamp="{{strtotime($file->updated_at)}}"></span>
                        </span>
                        <span class="pull-right">
                            <a href="#" class="pull-right" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-angle-down"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right" style="top:25%;" role="menu">
                                <li><a href="{{$file->path}}"><i class="fa fa-download fa-fw"></i> Download</a></li>
                                <li><a href="#"><span id="name" data-target="files/share/{{$file->id}}"><i class="fa fa-share-square fa-fw"></i> Share</span></a></li>
                                <li>
                                    <a href="#"><span id="silentPostRequest" data-target="files/delete/{{$file->id}}" data-parent="files-container" data-id="0" data-message="deleted" data-hide="true"><i class="fa fa-remove fa-fw"></i> Delete</span></a>
                                </li>
                            </ul>
                        </span>
                    </div>
                @endforeach
            @else
                <div class="text-center text-info">No files yet.</div>
            @endif
        </div>
    </div>
    <div class="list-group-item more_display margin-top-sm">
        <span id="name" data-target="/files/folder/add" class="btn btn-sm btn-default pull-right"><i class="fa fa-plus fa-fw"></i> Folder</span>
        <h4 class="text-info">Folders</h4>
        <div id="more_group_pages" >
            @if(count($folders))
                <div class="list-group">
                    @foreach($folders as $folder)

                        <div class="folder-container clearfix margin-top-sm block">
                            <hr id="fit">
                            <span class="pull-left margin-top-sm">
                                <span id="name" data-target="/files/folder/view/{{$folder->id}}"><i class="fa fa-chain fa-fw"></i>{{$folder->name}}</span><br/>
                                <span class="timeago margin-right-sm" data-livestamp="{{strtotime($folder->created_at)}}"></span>
                            </span>
                            <span class="pull-right">
                                <a href="#" class="pull-right" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-angle-down"></i> </a>
                                <ul class="dropdown-menu dropdown-menu-right" style="top:25%;" role="menu">
                                    <li>
                                        <a href="#"><span id="silentPostRequest" data-target="files/folder/delete/{{$folder->id}}" data-parent="folder-container" data-id="0" data-message="deleted" data-hide="true"><i class="fa fa-remove fa-fw"></i> Delete</span></a>
                                    </li>
                                </ul>
                            </span>
                        </div>
                    @endforeach
                </div>
                @else
                    <div class="text-center text-info">No folders yet.</div>
             @endif
        </div>

     </div>
</div>
