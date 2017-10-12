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
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ URL::to('assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/global/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ URL::to('assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{ URL::to('assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{ URL::to('assets/layouts/layout/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/layouts/layout/css/themes/light2.min.css') }}" rel="stylesheet" type="text/css" id="style_color" />
    <link href="{{ URL::to('assets/apps/css/loader.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="{{ URL::to('assets/pages/img/favicon.ico') }}" />
    @yield('styles')

    <link href="{{ URL::to('assets/layouts/layout/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
</head>

<!-- END HEAD -->

<body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-sidebar-closed" >
<div class="env-loader">
    <div class="cssload-container">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
<div class="page-wrapper">

    <!-- BEGIN CONTAINER -->
    <div class="page-container">
       @yield('content')
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <div class="page-footer">
        <div class="page-footer-inner"> 2017 &copy;
            Geog. Richard Barroeta - <a target="_blank" href="mailto:jesus.antonio.gil.16@gmail.com">Lcdo. Informática Jesús Gil</a>&nbsp;|&nbsp;SIGIC
        </div>
        <!--<div class="scroll-to-top">
            <i class="icon-arrow-up"></i>
        </div>-->
    </div>
    <!-- END FOOTER -->
</div>

<!--[if lt IE 9]>
<script src="{{ URL::to('assets/global/plugins/respond.min.js') }}"></script>
<script src="{{ URL::to('assets/global/plugins/excanvas.min.js') }}"></script>
<script src="{{ URL::to('assets/global/plugins/ie8.fix.min.js') }}"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="{{ URL::to('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::to('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/jquery-validation/js/localization/messages_es.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/sweetalert2/sweetalert2.min.js') }}" type="text/javascript"></script>

@yield('scripts')
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{ URL::to('assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/scripts/sigic.js') }}" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->

<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="{{ URL::to('assets/layouts/layout/scripts/layout.min.js') }}" type="text/javascript"></script>
<!--<script src="{{ URL::to('assets/layouts/layout/scripts/demo.min.js') }}" type="text/javascript"></script>
 END THEME LAYOUT SCRIPTS -->



@yield('script-body')

</body>

</html>