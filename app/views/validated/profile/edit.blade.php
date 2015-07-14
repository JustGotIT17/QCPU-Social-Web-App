@extends('layouts.header')
@section('header_content')
    <h5 class="modal-title" id="myModalLabel">
        <a href="#">
            <span id="name" data-target="/grouppage/view/"></span>
        </a>
        Edit Profile
    </h5>
@stop
<div class="container margin-top-xxl">
    <div class="list-group">
        <div class="list-group-item clearfix">
            <img id="profile-picture" src="{{User::getProfileImage($user->photo)}}" alt="{{$user->photo}}" class="img-responsive img-circle pull-right">
            <span class="pull-left">
                <h3 class="text-info">{{ (strlen($user->Firstname . ' ' . $user->Lastname) < 25) ? $user->Firstname . ' ' . $user->Lastname : substr($user->Firstname . ' ' . $user->Lastname, 0, 25) . '...'}}</h3>
                <p class="text-info"><b><i class="fa fa-male"></i> Gender:</b> {{$user->gender->Gender}} <br/>
                <b><i class="fa fa-shekel"></i> Course:</b> {{$user->course->CourseAbbr}}<br/>
                <b><i class="fa fa-shield"></i> Level:</b>  {{$user->user_type->name}}<br/>
                <span class="btn btn-sm btn-primary margin-top-sm">Change Photo</span>
            </span>
        </div>
    </div>
    <div class="row">
        <div class="container">
            <div class="col-sm-12 margin-top-sm">
                <div class="tabbable">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href=".edit_profile_personal" data-toggle="tab" style="font-size: .75em"><i class="fa fa-user"></i> Personal</a></li>
                        <li><a href=".edit_profile_security" data-toggle="tab" style="font-size: .75em"><i class="fa fa-files-o"></i> Security</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active edit_profile_personal">
                            {{Form::open(['url'=>'users/update/personal', 'class'=>''])}}
                                <div class="form-group margin-top-sm">
                                    {{Form::label('nickname', 'Nickname', ['class'=>'timeago'])}}
                                    {{Form::text('nickname', $user->nickname,['class'=>'form-control', 'placeholder'=>'Nickname'])}}
                                </div>

                                {{Form::submit('Save', ['class'=>'btn btn-sm btn-primary pull-right'])}}
                            {{Form::close()}}
                        </div>
                        <div class="tab-pane edit_profile_security">
                            {{Form::open(['url'=>'users/update/security', 'class'=>''])}}
                                <div class="form-group margin-top-sm">
                                    {{Form::label('pass', 'Current Password', ['class'=>'timeago'])}}
                                    {{Form::text('pass', null,['class'=>'form-control', 'placeholder'=>'******'])}}
                                </div>
                                <div class="form-group">
                                    {{Form::label('newpass', 'New Password', ['class'=>'timeago'])}}
                                    {{Form::text('newpass', null,['class'=>'form-control', 'placeholder'=>'******'])}}
                                </div>
                                <div class="form-group">
                                    {{Form::label('conpass', 'Confirm Password', ['class'=>'timeago'])}}
                                    {{Form::text('conpass', null,['class'=>'form-control', 'placeholder'=>'******'])}}
                                </div>
                                {{Form::submit('Save', ['class'=>'btn btn-sm btn-primary pull-right'])}}
                            {{Form::close()}}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>