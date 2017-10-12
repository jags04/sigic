<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>.:: Acceso - SIGIC ::.</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta name="_token" content="{{ csrf_token() }}">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ URL::to('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/global/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ URL::to('assets/global/css/components-md.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{ URL::to('assets/global/css/plugins-md.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="{{ URL::to('assets/pages/css/login-5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/layouts/layout/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/apps/css/loader.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="{{ URL::to('assets/pages/img/favicon.ico') }}" /> </head>
<!-- END HEAD -->

<body class=" login">
<input type="hidden" id="login-url" value="{{ URL::to('/') }}">
<div class="env-loader">
    <div class="cssload-container">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
<!-- BEGIN : LOGIN PAGE 5-1 -->
<div class="user-login-5">
    <div class="row bs-reset">
        <div class="col-md-6 bs-reset mt-login-5-bsfix">
            <div class="login-bg" style="background-image:url({{ URL::to('assets/pages/img/login/bg1.jpg') }})">
                <img class="login-logo" src="{{ URL::to('assets/pages/img/login/logo.png') }}" /> </div>
        </div>
        <div class="col-md-6 login-container bs-reset mt-login-5-bsfix">
            <div class="login-content">
                <h1>SIGIC</h1>
                <p> Sistema de Información Geográfica de Industria y Comercio</p>
                <form action="javascript:;" class="login-form" method="post" data-accion="{{ route('sistema.validar') }}" data-index="{{ route('sistema.index') }}" id="acceso-sigic">
                    <!--<div class="alert alert-danger display-hide">
                       <button class="close" data-close="alert"></button>
                       <span>El usuario y/o la clave no pueden estar vacios. </span>
                   </div>-->
                   <div class="row">
                       <div class="col-md-12">
                           <input class="form-control form-control-solid placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="Usuario" name="user" id="user" required/>
                       </div>
                       <div class="col-md-12">
                           <input class="form-control form-control-solid placeholder-no-fix form-group" type="password" autocomplete="off" placeholder="Clave" name="password" id="password" required/>
                       </div>
                   </div>
                   <br>
                   <!--<div class="row">
                       <div class="col-md-12 text-right">
                           <span class="pull-right"></span>
                       </div>
                   </div>-->
                    <br><br>

                    <div class="row">
                        <div class="col-sm-4">&nbsp;</div>
                        <div class="col-sm-8 text-right">
                            <button class="btn btn-no-border btn-outline green pull-right" type="submit">Acceder</button>
                        </div>
                    </div>

                    <!-- Register for you recaptcha at https://www.google.com/recaptcha/admin -->
                    <div class="g-recaptcha"
                         data-sitekey="6LdFASwUAAAAABc9cyffiTmIpuljOgMH5T2SZwS4"
                         data-callback="recaptchaOnSubmit"
                         data-size="invisible">
                    </div>

                </form>
                <!-- BEGIN FORGOT PASSWORD FORM -->
                <!-- <form class="forget-form" action="javascript:;" method="post">
                    <h3 class="font-green">Forgot Password ?</h3>
                    <p> Enter your e-mail address below to reset your password. </p>
                    <div class="form-group">
                        <input class="form-control placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="Email" name="email" /> </div>
                    <div class="form-actions">
                        <button type="button" id="back-btn" class="btn green btn-outline">Back</button>
                        <button type="submit" class="btn btn-success uppercase pull-right">Submit</button>
                    </div>
                </form>
                END FORGOT PASSWORD FORM -->
            </div>
            <div class="login-footer">
                <div class="row bs-reset">
                    <div class="col-xs-5 bs-reset">
                        <!--<ul class="login-social">
                            <li>
                                <a href="javascript:;">
                                    <i class="icon-social-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="icon-social-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <i class="icon-social-dribbble"></i>
                                </a>
                            </li>
                        </ul>-->
                    </div>
                    <div class="col-xs-7 bs-reset">
                        <div class="login-copyright ">
                            <p>2017 &copy;
                                Geog. Richard Barroeta - <a target="_blank" href="mailto:jesus.antonio.gil.16@gmail.com">Lcdo. Jesús Gil</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END : LOGIN PAGE 5-1 -->
<!--[if lt IE 9]>
<script src="{{ URL::to('assets/global/plugins/respond.min.js') }}"></script>
<script src="{{ URL::to('assets/global/plugins/excanvas.min.js') }}"></script>
<script src="{{ URL::to('assets/global/plugins/ie8.fix.min.js') }}"></script>

<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="{{ URL::to('assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::to('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/jquery-validation/js/localization/messages_es.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/backstretch/jquery.backstretch.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::to('assets/global/plugins/sweetalert2/sweetalert2.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{ URL::to('assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::to('assets/pages/scripts/login-5.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<!-- END THEME LAYOUT SCRIPTS -->
<script>
    $(document).ready(function()
    {
        $('#clickmewow').click(function()
        {
            $('#radio1003').attr('checked', 'checked');
        });
    })
</script>
</body>

</html>