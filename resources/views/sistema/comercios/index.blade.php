@extends('layouts.master')
@section('title')
    .:: COMERCIOS ::.
@endsection

@section('styles')
    <link href="{{ URL::to('assets/global/plugins/formstone/dist/css/upload.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/global/plugins/formstone/dist/css/themes/light/upload.css') }}" rel="stylesheet" type="text/css" />
    <style>
        tfoot {
            display: table-header-group;
        }
    </style>
@endsection

@section('breadcrumb')
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ URL::to('/') }}">Inicio</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Comercios</span>
        </li>
    </ul>
    <!--<div class="page-toolbar">
            <button type="button" class="btn blue btn-sm btn-outline fa fa-plus" title="agregar"></button>
    </div>-->
@endsection

@section('page-title')
    Comercios
    <!--<small>(Registro Único de Industria y Comercio)</small>-->
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                   <!-- <div class="caption font-dark">
                        <i class="icon-settings font-dark"></i>
                        <span class="caption-subject bold uppercase">Buttons</span>
                    </div>-->
                    <div class="tools"> </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-hover" id="dt_comercios" data-lenguaje="{{ URL::to('assets/global/plugins/datatables/spanish.json') }}" data-urldata="{!! route('sistema.comercios.data') !!}">
                        <thead>
                        <tr>
                            <th>RIF</th>
                            <th>Comercios</th>
                            <th>Estado</th>
                            <th>Municipio</th>
                            <th>Parroquia</th>
                            <th>Localidad</th>
                            <th>Teléfonos</th>
                            <th>Lat</th>
                            <th>Long</th>
                            <th>Dist</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>&nbsp;</th>
                            <th>Comercios</th>
                            <th>Estado</th>
                            <th>Municipio</th>
                            <th>Parroquia</th>
                            <th>Localidad</th>
                            <th>&nbsp;</th>
                            <th>Lat</th>
                            <th>Long</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div id="addComercios" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <form id="fAddCom" action="#" data-accion="{{ route('sistema.comercios.add') }}">
            {{ csrf_field() }}
            <div class="modal-dialog modal-full">
                <div class="modal-content">
                    <div class="modal-body">
                        <!-- BEGIN MARKERS PORTLET-->
                        <div class="portlet light portlet-fit">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span class="caption-subject font-green bold uppercase">Agregar Comercio</span>
                                </div>
                                <div class="actions">
                                    <a class="btn btn-circle btn-icon-only btn-default" data-dismiss="modal" aria-hidden="true">
                                        <i class="fa fa-close"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="rif" name="rif" required data-inputmask="'mask': 'R999999999'" data-rule-rif="true">
                                            <label for="rif">RIF<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="rsocial" name="rsocial" required>
                                            <label for="rsocial">Razón social (nombre)<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <select class="form-control" id="estado" name="estado" required onchange="getMcpiosPquias('mcpio', 'estado', 'municipio', '{{ route('sistema.getMcpiosPquias') }}') " >
                                                <option value=""></option>
                                                @foreach($estado as $edo)
                                                    <option value="{{ $edo->nombre }}">{{ $edo->nombre }}</option>
                                                @endforeach
                                            </select>
                                            <label for="estado">Estado<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <select class="form-control" id="municipio" name="municipio" required onchange="getMcpiosPquias('pquia', 'municipio', 'parroquia', '{{ route('sistema.getMcpiosPquias') }}', 'estado') ">
                                                <option value=""></option>
                                            </select>
                                            <label for="municipio">Municipio<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <select class="form-control" id="parroquia" name="parroquia" required >
                                                <option value=""></option>
                                            </select>
                                            <label for="parroquia">Parroquia<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                                            <label for="direccion">Dirección<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group form-md-line-input has-success">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-control">
                                                    <input type="text" class="form-control " id="coordenadas" name="coordenadas" placeholder="0.0,0.0" required @if(Auth::user()->rol != 10 ) readonly @endif>
                                                    <label for="form_control_1">Coordenadas</label>
                                                </div>
                                                <span class="input-group-btn btn-right">
                                        <button class="btn btn-no-border btn-outline green fa fa-map-marker" type="button" onclick="getCoordenadas('coordenadas')" title="Agregar coordenadas"></button>
                                    </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="telf1" name="telefonos[]" required data-inputmask="'mask': '9999-9999999'" data-rule-telfv="true">
                                            <label for="telf1">Teléfono 1<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="telf2" name="telefonos[]" data-inputmask="'mask': '9999-9999999'" data-rule-telfv="true">
                                            <label for="telf2">Teléfono 2</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="telf3" name="telefonos[]" required data-inputmask="'mask': '9999-9999999'" data-rule-telfv="true">
                                            <label for="telf1">Teléfono 3</label>
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
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </form>
    </div>

    <div id="updComercios" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true">
        <form id="fUpdCom" action="#" data-accion="{{ route('sistema.comercios.upd') }}">
            <input type="hidden" name="id_com" id="id_com">
            {{ csrf_field() }}
            <div class="modal-dialog modal-full">
                <div class="modal-content">
                    <div class="modal-body">
                        <!-- BEGIN MARKERS PORTLET-->
                        <div class="portlet light portlet-fit">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span class="caption-subject font-green bold uppercase">Actualizar Comercio</span>
                                </div>
                                <div class="actions">
                                    <a class="btn btn-circle btn-icon-only btn-default" data-dismiss="modal" aria-hidden="true">
                                        <i class="fa fa-close"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="rif2" name="rif" required data-inputmask="'mask': 'R999999999'" data-rule-rif="true">
                                            <label for="rif2">RIF<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="rsocial2" name="rsocial" required>
                                            <label for="rsocial2">Razón social (nombre)<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <select class="form-control" id="estado2" name="estado" required onchange="getMcpiosPquias('mcpio', 'estado2', 'municipio2', '{{ route('sistema.getMcpiosPquias') }}') " >
                                                <option value=""></option>
                                                @foreach($estado as $edo)
                                                    <option value="{{ $edo->nombre }}">{{ $edo->nombre }}</option>
                                                @endforeach
                                            </select>
                                            <label for="estado2">Estado<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <select class="form-control" id="municipio2" name="municipio" required onchange="getMcpiosPquias('pquia', 'municipio2', 'parroquia2', '{{ route('sistema.getMcpiosPquias') }}', 'estado2') ">
                                                <option value=""></option>
                                            </select>
                                            <label for="municipio2">Municipio<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <select class="form-control" id="parroquia2" name="parroquia" required >
                                                <option value=""></option>
                                            </select>
                                            <label for="parroquia2">Parroquia<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="direccion2" name="direccion" required>
                                            <label for="direccion2">Dirección<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group form-md-line-input has-success">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-control">
                                                    <input type="text" class="form-control " id="coordenadas2" name="coordenadas" placeholder="0.0,0.0" required @if(Auth::user()->rol != 10 ) readonly @endif>
                                                    <label for="coordenadas2">Coordenadas</label>
                                                </div>
                                                <span class="input-group-btn btn-right">
                                        <button class="btn btn-no-border btn-outline green fa fa-map-marker" type="button" onclick="getCoordenadas('coordenadas2')" title="Agregar coordenadas"></button>
                                    </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="telf12" name="telefonos[]" required data-inputmask="'mask': '9999-9999999'" data-rule-telfv="true">
                                            <label for="telf12">Teléfono 1<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="telf22" name="telefonos[]" data-inputmask="'mask': '9999-9999999'" data-rule-telfv="true">
                                            <label for="telf22">Teléfono 2</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="telf32" name="telefonos[]" required data-inputmask="'mask': '9999-9999999'" data-rule-telfv="true">
                                            <label for="telf32">Teléfono 3</label>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <!-- END MARKERS PORTLET-->
                    </div>


                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-no-border btn-outline red">Cancelar</button>
                        <button type="submit" class="btn btn-no-border btn-outline green">Actualizar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </form>
    </div>

    <div class="modal fade" id="detalleCom" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-full">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="portlet light portlet-fit">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-green bold uppercase">Detalle Comercio</span>
                            </div>
                            <div class="actions">
                                <a class="btn btn-circle btn-icon-only btn-default" data-dismiss="modal" aria-hidden="true">
                                    <i class="fa fa-close"></i>
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="tabbable-line">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_1_1" data-toggle="tab"> Info. General</a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_2" data-toggle="tab"> Ubicación</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade active in" id="tab_1_1"></div>

                                    <div class="tab-pane fade" id="tab_1_2">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!--<div id="mapUbi"></div>-->
                                                <iframe  frameborder="0" id="mapUbicacion" style="width: 100%; height: 60vh"></iframe>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div id="modalMapa" class="modal fade draggable-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="portlet light portlet-fit">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-green bold uppercase">Obtener coordenadas</span>
                            </div>
                            <div class="actions">
                                <a class="btn btn-circle btn-icon-only btn-default" data-dismiss="modal" aria-hidden="true">
                                    <i class="fa fa-close"></i>
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <iframe  frameborder="0" id="iframeMapa" style="width: 100%; height: 65vh" data-url="{!! route('sistema.getCoordMap') !!}"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div id="modalDetSubastas" class="modal fade draggable-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="portlet light portlet-fit">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-green bold uppercase">Detalles de Subastas DICOM (<span id="rsocialSubastas"></span> )</span>
                            </div>
                            <div class="actions">
                                <a class="btn btn-circle btn-icon-only btn-default" data-dismiss="modal" aria-hidden="true">
                                    <i class="fa fa-close"></i>
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div id="cuerpoSubastas"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <input type="hidden" id="url-find" data-url="{!! route('sistema.comercios.find') !!}">
    <input type="hidden" id="url-del" data-url="{!! route('sistema.comercios.del') !!}">
    <input type="hidden" id="url-view" data-url="{!! route('sistema.comercios.view') !!}">

    <input type="hidden" id="url-mapUbicacion" data-url="{!! route('sistema.mapasComercio') !!}">


    <!-- END EXAMPLE TABLE PORTLET-->
    <div class="clearfix"></div>
@endsection

@section('scripts')
    <script src="{{ URL::to('assets/global/plugins/formstone/dist/js/core.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('assets/global/plugins/formstone/dist/js/upload.js') }}" type="text/javascript"></script>

@endsection

@section('script-body')
    <script src="{{ URL::to('assets/pages/scripts/comercio.js') }}" type="text/javascript"></script>
    <script>

    </script>

@endsection