@if(count($quiz))
    @extends('layouts.header')
    @section('header_content')
        <h5 class="modal-title" id="myModalLabel">
            <a href="#">
                <span id="name" data-target="/quiz/view/{{$quiz->id}}">{{$quiz->name}}</span>
            </a>
            <i class="fa fa-chevron-right fa-fw"></i>Designation
        </h5>
    @stop
    <div class="container margin-top-xxl">
        @if(count($groups))
            {{Form::open(['url'=>'/quiz/view/designation/'.$quiz->id, 'class'=>'margin-top-sm clearfix'])}}
                <div class="form-group">
                    {{Form::label('group', 'Group:')}}
                    {{Form::select('group', $groups, null, ['class'=>'form-control'])}}
                </div>
                <div class="form-group">
                    {{Form::label('deadline', 'Deadline:')}}
                    <input name="deadline" id="txtDeadline" onclick="f_CallCalendar('deadline')" type="text" class="form-control">
                </div>
                <div class="form-group">
                    {{Form::label('time', 'Time:')}}
                    {{Time::generateTime('time')}}
                </div>
                <div class="form-group">
                    {{Form::label('duration', 'Duration:')}}
                    {{Form::text('duration', null, ['class'=>'form-control', 'placeholder'=>'How many minutes'])}}
                </div>

                <div class="form-group">
                    {{Form::submit('Submit', ['class'=>'btn btn-sm btn-primary pull-right'])}}
                </div>
            {{Form::close()}}
        @else
            <div class="alert alert-info margin-top-sm">No groups available.</div>
        @endif
        <h4 class="title">Designations</h4>
        <hr id="fit">
        @if(count($designations))
            <div class="list-group margin-top-sm">
                @foreach($designations as $designation)
                     <?php $done = MyDate::onGoing($designation->deadline, date('Y-m-d'));?>

                    <div class="list-group-item clearfix">
                        <a href="#" class="pull-right" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-angle-down"></i> </a>
                         <span class="pull-right margin-right-sm">
                             {{GroupPageHelper::activityStatus($done)}}
                         </span>
                        <ul class="dropdown-menu dropdown-menu-right" style="top:10%;" role="menu">
                            <li><a href="#">
                                <span id="name" data-target="/quiz/view/result/{{$quiz->id . '/' . $designation->id}}">
                                    <i class="fa fa-renren fa-fw"></i> View Result
                                </span>
                                </a>
                            </li>
                            <li><a href="#">
                                <span id="silentPostRequest" data-target="/quiz/delete/designation/{{$designation->id}}" data-hide="true" data-message="delete" data-id="" data-accid="">
                                    <i class="fa fa-remove fa-fw"></i> Delete
                                </span>
                                </a>
                            </li>

                        </ul>
                        <span id="name" data-target="/quiz/view/result/{{$quiz->id . '/' . $designation->id}}">{{$designation->group_page->Name}}</span>
                        <br/>
                        <span class="timeago">{{$designation->group_page->subject}}</span><br/>
                        <span class="timeago">Deadline: {{date(MyDate::getDateFormat(), strtotime($designation->deadline))}}</span><br/>
                        <span class="timeago">Duration: {{$designation->duration}} Minutes</span><br/>
                        <small class="timeago">Date Designated: {{ date(MyDate::getDateFormat(), strtotime($designation->created_at)) }}</small>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info margin-top-sm">No groups designated yet.</div>
        @endif
    </div>
@endif