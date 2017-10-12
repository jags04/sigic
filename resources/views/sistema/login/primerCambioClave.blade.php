@extends('layouts.blank')
@section('title')
    .:: CAMBIO DE CLAVE ::.
@endsection
@section('styles')
    <link href="{{ URL::to('assets/global/plugins/passtrength/dist/css/passtrength.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form id="pCamCla" action="#" data-accion="{{ route('sistema.cambioClave') }}">
                {{ csrf_field() }}
                <input type="hidden" name="user_id" value="{{ $user_id }}">
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

                        <div class="row">
                            <div class="col-sm-12 text-right">
                                <button type="submit" class="btn btn-no-border btn-outline green">Guardar</button>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- END MARKERS PORTLET-->
            </form>
        </div>
    </div>

    <input type="hidden" id="url-index" data-url="{!! route('sistema.index') !!}">
    <input type="hidden" id="cnd-cambio" data-valor="0">
    <div class="clearfix"></div>
    <br><br><br><br><br>
    <br><br><br><br><br>
    <br><br><br><br><br>
@endsection

@section('scripts')
    <script src="{{ URL::to('assets/global/plugins/formstone/dist/js/core.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('assets/global/plugins/passtrength/dist/js/jquery.passtrength.min.js') }}" type="text/javascript"></script>
@endsection

@section('script-body')
    <script src="{{ URL::to('assets/pages/scripts/cambioClave.js') }}" type="text/javascript"></script>
@endsection