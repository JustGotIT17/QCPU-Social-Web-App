@extends('layouts.index')
@section('content')

<div data-role="page" id="HomePage">
        <div data-role="panel" data-display="overlay" data-position-fixed="true" data-position="right" id="right-panel">
            <div class="side-panel-header">
            Online users
            </div>
            <div id="onlineList">
            </div>
        </div><!-- /panel -->
        <div data-role="header" data-position="fixed" class="clearfix">
            <span class="btn-right-panel pull-right" onclick='$( "#right-panel" ).panel("open")'><i class="fa fa-bullseye fa-fw"></i></span>
            @if(Auth::user()->UserTypeID === 2)
                <span onclick="displayPopUp('/files')" class="btn-right-panel pull-left"><i class="fa fa-files-o fa-fw" ></i></span>
            @endif
            <!-- for administrator only
            <span id="btnPostStatus" class="btn-right-panel pull-right" data-target="/post/status"><i class="fa fa-pencil-square-o fa-fw"></i></span>
            -->
            <span onclick="displayPopUp('/search')" class="btn-right-panel pull-left"><i class="fa fa-search fa-fw"></i></span>
            <span class="pull-left"  id="titleHeader">Newsfeed</span>

            <div data-role="navbar" id="navbarHeader">
                <ul>
                    <li class="navbar-active" href="/newsfeed" id="#newsfeed"><a href="/newsfeed"><i class="fa fa-newspaper-o"></i></a></li>
                    <li id="#messages" href="/messages"><a href="/messages"><i class="fa fa-envelope "></i></a></li>
                    <li id="#notifications" href="/notification"><a href="/notification"><i class="fa fa-globe "></i></a></li>
                    <li id="#more" href="/more"><a href="/more"><i class="fa fa-bars"></i></a></li>
                </ul>
            </div>
        </div>
        <div id="postCommentsModal">

        </div>

        <div id="wrapper" >
            <div id="mask">
                <div id="newsfeed" data-role="main" class="box container main">

                    @if ($message = Session::get('message'))
                            @if($url = Session::get('url'))
                                <div class="notif">
                                    <span class="message">{{{ $message }}}</span><br/><br/>
                                    <span id="btnCloseNotifPopUp" class="btn btn-default">Okay</span>
                                    <span id="name" onclick="$(this).closest('.notif').hide()" data-target="{{{$url}}}" class="btn btn-default">View</span>
                                </div>
                            @else
                                <script>JavascriptAPI.showToast({{{$message}}})</script>
                            @endif


                    @endif

                </div>
                <div id="messages" data-role="main" class="box container main">

                </div>
                <div id="notifications" data-role="main" class="box container main">

                </div>
                <div id="more" data-role="main" class="box container main">

                </div>
            </div>
        </div>
    </div>
    </div>

@stop
