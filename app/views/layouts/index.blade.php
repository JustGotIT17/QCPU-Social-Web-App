<!DOCTYPE html>
<html ng-app="qcpuApp">
    <head>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <title>QCPU Social-Learning</title>
    {{ HTML::style('jmobile/jquery.mobile-1.4.5.css') }}
    {{ HTML::style('css/bootstrap.min.css') }}
    {{ HTML::style('font-awesome-4.2.0/css/font-awesome.min.css') }}
    {{ HTML::style('css/style.css') }}
    </head>
    <body>

    <div class="">
        @yield('content')
    </div>

        {{ HTML::script('js/jquery.min.js') }}
        {{ HTML::script('js/jquery.scrollTo-1.4.2-min.js') }}
        {{ HTML::script('js/momentjs.js') }}
        {{ HTML::script('js/livestamp.min.js') }}

        <script type="text/javascript">
        $(document).bind("mobileinit", function () {
            $.mobile.ajaxEnabled = false;
            $.mobile.defaultPageTransition = 'slide';
        });
        </script>
        {{ HTML::script('jmobile/jquery.mobile-1.4.5.js') }}
        {{ HTML::script('js/bootstrap.min.js') }}
        {{ HTML::script('js/autolink-min.js') }}
        {{ HTML::script('js/app.js') }}
    </body>

</html>