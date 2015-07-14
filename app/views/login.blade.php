<!DOCTYPE html>
<html>
    <head>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <title>QCPU Social-Learning</title>
    {{ HTML::style('css/bootstrap.min.css') }}
    {{ HTML::style('font-awesome-4.2.0/css/font-awesome.min.css') }}
    <style>
        #btnLogin {
            width:100%;
            padding: 10px 0px;
        }
    </style>
    </head>
    <body>
    <div class="container margin-top-sm">
        <div class="col-xs-10 col-sm-10 col-md-6 col-lg-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3 col-lg-offset-3">
            <div id="divLoginSection" style="zoom: .90">
                <div style="background-color: rgba(0,0,0,.3); margin-top: 5%; padding-top: 20px; border-radius: 5px;">
                    <div>
                        <center><img src="images/logo1.png" height="75px" width="auto"></center>
                        <h4 class="text-center"  style="color: #f5f5f5; letter-spacing: 2px; text-shadow: 1px 1px 10px gray;">
                            QCPU APP<br/>
                            Social-Learning
                        </h4>
                        <hr id="fit">
                        <h5 class="text-center"  style="color: rgba(255, 255, 255, 0.85)"><i class="fa fa-lock fa-fw"></i> Secured Login</h5>

                    </div>
                    <div class="panel-body">
                         @if ($errors->has('AccountID') || $errors->has('password'))
                             {{ $errors->first('AccountID', '<script>JavascriptAPI.showToast(":message")</script>') }}
                             {{ $errors->first('password', '<script>JavascriptAPI.showToast(":message")</script>') }}
                        @endif

                        {{ Form::open(['url' => '/login', 'class' => 'form-horizontal form-login', 'autocomplete'=>'off', 'role' => 'form']) }}
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-user fa-fw"></i></div>
                                {{ Form::text('AccountID', Input::old('AccountID'), ['class' => 'form-control', 'placeHolder' => 'Account ID']) }}

                                </div>

                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-key fa-fw"></i></div>
                                    {{ Form::password('password', ['class' => 'form-control', 'placeHolder' => 'Password']) }}
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::submit('Login', ['class'=>'btn btn-primary', 'id'=>'btnLogin']) }}
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ HTML::script('js/jquery.min.js')  }}
    {{ HTML::script('js/jquery.backstretch.js')  }}
    <script type="text/javascript">
    $.backstretch([
              "images/qcpians/IT.png",
              "images/qcpians/EM.png",
              "images/qcpians/ECE.png",
              "images/qcpians/IE.png"
            ], {
            	fade: 750,		//Speed of Fade
            	duration: 3000 	//Time of image display
            });
    </script>

    </body>
</html>