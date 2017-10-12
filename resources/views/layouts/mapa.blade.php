<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta name="_token" content="{{ csrf_token() }}">
    <!-- <meta content="Preview page of Metronic Admin Theme #1 for interactive google map samples" name="description" />
    <meta content="" name="author" />
    BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/global/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ URL::to('assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{ URL::to('assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{ URL::to('assets/layouts/layout/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/layouts/layout/css/themes/light2.min.css') }}" rel="stylesheet" type="text/css" id="style_color" />
    <link href="{{ URL::to('assets/layouts/layout/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/apps/css/loader.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="{{ URL::to('assets/pages/img/favicon.ico') }}" /> </head>

    <style>
    #map{
        height:  100vh;
        width: 100%;
    }
    iframe{
        height:  30vh;
        width: 100%;
    }

    .md-input {
        padding:10px 10px 10px 5px;
        display:block;
        border-top: none;
        border-left: none;
        border-right: none;
        border-bottom:1px solid #27a4b0 !important;
    }
    .md-input:focus{ outline:none; }

   </style>
   @yield('styles')
<!-- END HEAD -->

<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-sidebar-closed">
<div class="env-loader">
    <div class="cssload-container">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
<div class="page-wrapper">
    @yield('content')
</div>

<!--[if lt IE 9]>
<script src="{{ URL::to('assets/global/plugins/respond.min.js') }}"></script>
<script src="{{ URL::to('assets/global/plugins/excanvas.min.js') }}"></script>
<script src="{{ URL::to('assets/global/plugins/ie8.fix.min.js') }}"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="{{ URL::to('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
@yield('scripts')
<script>
    $(document).ajaxStart(function() {
        $(".env-loader").show();
    }).ajaxStop(function() {
        $(".env-loader").hide();
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('meta[name="_token"]').attr('content')
        }
    });
    function hideLoad()
    {
        var loaddiv = $('.env-loader');
        if (loaddiv == null)
        {
            alert("Sorry can't find the loaddiv");
            return;
        }
        //div found
        loaddiv.hide();
    }

    // A function to hide the loading message
    function showLoad()
    {
        var loaddiv = $('.env-loader');
        if (loaddiv == null)
        {
            alert("Sorry can't find your loaddiv");
            return;
        }
        //div found
        loaddiv.show();
    }

</script>

@yield('script-body')
</body>
</html>