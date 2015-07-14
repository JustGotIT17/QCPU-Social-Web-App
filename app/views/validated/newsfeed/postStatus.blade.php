<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            {{Form::open(['url' => '/post/status', 'id'=>'formPostStatus', 'role' => 'form', 'files'=>'true'])}}
              <div class="modal-header">
                <span id="btnClosePopUp" class="close pull-right"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></span>

                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-pencil-square-o fa-fw"></i> Post Status</h4>
              </div>
              <div class="modal-body">
                    {{Form::textarea('message', null, ['id'=>'txtPostStatusMessage', 'class'=>'form-control', 'placeholder'=>'Share something...'])}}
              </div>

              <div class="modal-footer clearfix">
                <div class = "pull-left">
                    <label class="btn-upload-photo btn btn-sm btn-default">
                        {{ Form::file('files[]', ['multiple' => true, 'accept'=>'image/*','id'=>'','class'=>'']) }}
                        <span><i class="fa fa-camera fa-fw"></i> Upload Photos</span>
                    </label>
                     {{ $errors->first('files[]', '<span class=errormsg>*:message</span>') }}
                </div>
                {{HTML::decode(Form::submit('Post', ['class'=>'btn btn-primary pull-right']))}}
              </div>
            {{Form::close()}}

        </div>
    </div>
</div>