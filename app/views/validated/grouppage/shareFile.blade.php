@if(count($file))
    @extends('layouts.header')
    @section('header_content')
        <h5 class="modal-title" id="myModalLabel">
            <a href="#">
                <span id="name" data-target="/files">
                    Files
                </span>
            </a>
            <i class="fa fa-chevron-right fa-fw"></i>
            Share
        </h5>
    @stop
    <div class="container margin-top-xxl">
        @if(count($groups))
            {{ Form::open(['url' => "/files/share/". $file->id, 'role' => 'form']) }}
            <div class="list-group margin-top-sm">
                <div class="list-group-item clearfix">
                    <span class="badge alert-success">Available: {{$groups->count()}}</span>
                    <h4 class="list-group-item-heading">Share to Groups</h4>
                    <hr id="fit" style="margin-top: 10px;">
                    <div style="margin-top: 10px;" class="form-group">
                        {{Form::textarea('message', null, ['class'=>'form-control', 'placeholder'=>'Message'])}}
                    </div>
                </div>
                    @foreach($groups as $group)
                        <div class="list-group-item clearfix">
                            <span class="pull-right">
                                {{Form::checkbox('groups[]', $group->grouppageID)}}
                            </span>
                            <span class="pull-left">
                                {{$group->Name}}
                            </span>
                        </div>
                    @endforeach
             </div>
             {{Form::submit('Share', ['class'=>'btn btn-primary pull-right'])}}
             {{Form::close()}}
        @else
            <div class="alert alert-info">No groups available</div>
        @endif
    </div>
@else
    <div class="alert alert-info">File not found.</div>
@endif
