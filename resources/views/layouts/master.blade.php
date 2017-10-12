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
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <!--<link href="{{ URL::to('assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css') }}" rel="stylesheet" type="text/css" />-->
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
    <style>
        .md-input {
            padding:10px 10px 10px 5px;
            display:block;
            border-top: none;
            border-left: none;
            border-right: none;
            border-bottom:1px solid #27a4b0 !important;
        }
        .md-input:focus{ outline:none; }

        div.dataTables_length select, div.dataTables_filter input {
            display:block;
            border-top: none;
            border-left: none;
            border-right: none;
            border-bottom:1px solid #27a4b0 !important;
        }
        div.dataTables_length select:focus, div.dataTables_filter input:focus{ outline:none; }
    </style>
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
<input type="hidden" id="auth-rol" data-auth="{{ Auth::user()->rol }}">
<div class="page-wrapper">
    <!-- BEGIN HEADER -->
    <div class="page-header navbar navbar-fixed-top">
        <!-- BEGIN HEADER INNER -->
        <div class="page-header-inner ">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="index.html">
                    <img src="{{ URL::to('assets/layouts/layout/img/logo.png') }}" alt="logo" class="logo-default" /> </a>
                <div class="menu-toggler sidebar-toggler">
                    <span></span>
                </div>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                <span></span>
            </a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <!-- END TODO DROPDOWN -->
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <img alt="" class="img-circle" src="{{ URL::to('assets/layouts/layout/img/avatar.png') }}" />
                            <span class="username username-hide-on-mobile"> {{ Auth::user()->nombre }} ({{ \App\Http\Controllers\UtilidadesController::getRol(Auth::user()->rol) }}) </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                           <!-- <li>
                                <a href="page_user_profile_1.html">
                                    <i class="icon-user"></i> My Profile </a>
                            </li>
                            <li>
                                <a href="app_calendar.html">
                                    <i class="icon-calendar"></i> My Calendar </a>
                            </li>
                            <li>
                                <a href="app_inbox.html">
                                    <i class="icon-envelope-open"></i> My Inbox
                                    <span class="badge badge-danger"> 3 </span>
                                </a>
                            </li>
                            <li>
                                <a href="app_todo.html">
                                    <i class="icon-rocket"></i> My Tasks
                                    <span class="badge badge-success"> 7 </span>
                                </a>
                            </li>
                            <li class="divider"> </li>-->
                            <li>
                                <a href="javascript:;" onclick="cambioClave()">
                                    <i class="icon-lock"></i> Cambio de clave</a>
                            </li>
                            <li>
                                <a href="javascript:;" data-url="{{ route('sistema.salir') }}" data-urlsuccess="{{ route('sistema.acceso') }}" onclick="logout()" id="asalir">
                                    <i class="fa fa-sign-out"></i> Salir </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->

                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END HEADER INNER -->
    </div>
    <!-- END HEADER -->
    <!-- BEGIN HEADER & CONTENT DIVIDER -->
    <div class="clearfix"> </div>
    <!-- END HEADER & CONTENT DIVIDER -->
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        <div class="page-sidebar-wrapper">
            <!-- BEGIN SIDEBAR -->
            <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
            <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
            <div class="page-sidebar navbar-collapse collapse">
                <!-- BEGIN SIDEBAR MENU -->
                <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                @include('agregados.menu')
                <!-- END SIDEBAR MENU -->
                <!-- END SIDEBAR MENU -->
            </div>
            <!-- END SIDEBAR -->
        </div>
        <!-- END SIDEBAR -->
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content">
                <!-- BEGIN PAGE HEADER-->
                <!-- BEGIN PAGE BAR -->
                <div class="page-bar">
                    @yield('breadcrumb')
                    <!--<div class="page-toolbar"></div>-->
                </div>
                <!-- END PAGE BAR -->
                <!-- BEGIN PAGE TITLE-->
                <h1 class="page-title">
                    @yield('page-title')
                </h1>
                <!-- END PAGE TITLE-->
                <!-- END PAGE HEADER-->
                @yield('content')
            </div>
            <!-- END CONTENT BODY -->
        </div>
        <!-- END CONTENT -->
        <!-- BEGIN QUICK SIDEBAR -->
        <a href="javascript:;" class="page-quick-sidebar-toggler">
            <i class="icon-login"></i>
        </a>
    </div>
    <!-- END CONTAINER -->


    <div id="modalCClave" class="modal container fade" tabindex="-1" data-width="600">
        <form id="pCamCla" action="#" data-accion="{{ route('sistema.cambioClave') }}">
            {{ csrf_field() }}
            <div class="modal-body">
                <!-- BEGIN MARKERS PORTLET-->

                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <!-- BEGIN MARKERS PORTLET-->
                    <div class="portlet light portlet-fit">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-green bold uppercase">Cambio de clave</span>
                            </div>

                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group form-md-line-input has-success">
                                        <input type="password" class="form-control" id="clave" name="clave" data-rule-minlength="6" required >
                                        <label for="clave">Nueva clave<span class="required" aria-required="true">*</span></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group form-md-line-input has-success">
                                        <input type="password" class="form-control" id="reclave" name="reclave" data-rule-minlength="6" data-rule-equalto="#clave" required>
                                        <label for="reclave">Repita la clave<span class="required" aria-required="true">*</span></label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- END MARKERS PORTLET-->
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-no-border btn-outline red">Cancelar</button>
                <button type="submit" class="btn btn-no-border btn-outline green">Guardar</button>
            </div>
        </form>
    </div>



    <!-- BEGIN FOOTER -->
    <div class="page-footer">
        <div class="page-footer-inner"> 2017 &copy;
            Geog. Richard Barroeta - <a target="_blank" href="mailto:jesus.antonio.gil.16@gmail.com">Lcdo. Informática Jesús Gil</a>&nbsp;|&nbsp;SIGIC
        </div>
        <div class="scroll-to-top">
            <i class="icon-arrow-up"></i>
        </div>
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
<script src="{{ URL::to('assets/global/plugins/modernizr/modernizr-custom.js') }}"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::to('assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
<!--<script src="{{ URL::to('assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js') }}" type="text/javascript"></script>-->
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
<script src="{{ URL::to('assets/pages/scripts/cambioClave.js') }}" type="text/javascript"></script>
<!--<script src="{{ URL::to('assets/layouts/layout/scripts/demo.min.js') }}" type="text/javascript"></script>
 END THEME LAYOUT SCRIPTS -->



@yield('script-body')

</body>

</html>