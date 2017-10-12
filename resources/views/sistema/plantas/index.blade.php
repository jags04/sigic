@extends('layouts.master')
@section('title')
    .:: Plantas ::.
@endsection

@section('styles')
    <link href="{{ URL::to('assets/global/plugins/formstone/dist/css/upload.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/global/plugins/formstone/dist/css/themes/light/upload.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/global/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        tfoot {
            display: table-header-group;
        }
        .ui-autocomplete {
            position: absolute;
            top: 0;
            left: 0;
            cursor: default;
            z-index: 10055 !important;
            max-height: 400px !important;
            max-width: 400px !important;
            overflow-y: auto;
            overflow-x: hidden;
        }
        #cuerpoInfoComp{
            min-height: 600px;
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
            <span>Plantas</span>
        </li>
    </ul>
    <!--<div class="page-toolbar">
            <button type="button" class="btn blue btn-sm btn-outline fa fa-plus" title="agregar"></button>
    </div>-->
@endsection

@section('page-title')
    Plantas
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
                    <table class="table table-striped table-hover" id="dt_plantas" data-lenguaje="{{ URL::to('assets/global/plugins/datatables/spanish.json') }}" data-urldata="{!! route('sistema.plantas.data') !!}">
                        <thead>
                        <tr>
                            <th width="5%">RIF</th>
                            <th>Planta</th>
                            <th>Estado</th>
                            <th>Municipio</th>
                            <th>Parroquia</th>
                            <th>Dirección</th>
                            <th>Estatus</th>
                            <th>F Especifica</th>
                            <th>Teléfono</th>
                            <th>Ámbito</th>
                            <th>Lat</th>
                            <th>Long</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th>Planta</th>
                            <th>Estado</th>
                            <th>Municipio</th>
                            <th>Parroquia</th>
                            <th>Dirección</th>
                            <th>Estatus</th>
                            <th>F Especifica</th>
                            <th>Teléfono</th>
                            <th>Ámbito</th>
                            <th>Lat</th>
                            <th>Long</th>
                            <th>&nbsp;</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div id="addPlanta" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <form id="fAddPlan" action="#" data-accion="{{ route('sistema.plantas.add') }}">
            {{ csrf_field() }}
            <div class="modal-dialog modal-full">
                <div class="modal-content">
                    <div class="modal-body">
                        <!-- BEGIN MARKERS PORTLET-->
                        <div class="portlet light portlet-fit">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span class="caption-subject font-green bold uppercase">Agregar planta</span>
                                </div>
                                <div class="actions">
                                    <a class="btn btn-circle btn-icon-only btn-default" data-dismiss="modal" aria-hidden="true">
                                        <i class="fa fa-close"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <input type="hidden" id="emp_rif" name="emp_rif">
                                <div class="row">

                                    <div class="col-sm-12">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="rsocial" name="rsocial" required onfocus="buscarEmpresa('rsocial', 'emp_rif')">
                                            <label for="rsocial">Razón social (nombre)<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <select class="form-control" id="estado" name="estado" required onchange="getMcpiosPquias('mcpio', 'estado', 'municipio', '{{ route('sistema.getMcpiosPquias') }}'); getAmbitos('estado', 'ambito', '{!! route('sistema.getAmbito') !!}') " >
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
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <select class="form-control" id="status" name="status" required >
                                                <option value=""></option>
                                                <option value="ACTIVO">ACTIVO</option>
                                                <option value="INACTIVO">INACTIVO</option>
                                            </select>
                                            <label for="status">Estatus<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="fespecifica" name="fespecifica" required>
                                            <label for="fespecifica">Función específica<span class="required" aria-required="true">*</span></label>
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
                                            <input type="text" class="form-control" id="telf" name="telf" required data-inputmask="'mask': '9999-9999999'" data-rule-telfv="true">
                                            <label for="telf">Teléfono<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group form-md-line-input has-success">
                                            <select class="form-control" id="ambito" name="ambito" required >
                                                <option value=""></option>
                                            </select>
                                            <label for="ambito">Ámbito<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                   <!-- <div class="col-sm-8">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="ambito" name="ambito" required onfocus="buscarAmbito('ambito', 'estado')">
                                            <label for="ambito">Ámbito</label>
                                        </div>
                                    </div>-->
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

    <div id="updPlanta" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <form id="fUpdPlan" action="#" data-accion="{{ route('sistema.plantas.upd') }}">
            {{ csrf_field() }}
            <input type="hidden" id="id_plan" name="id">
            <div class="modal-dialog modal-full">
                <div class="modal-content">
                    <div class="modal-body">
                        <!-- BEGIN MARKERS PORTLET-->
                        <div class="portlet light portlet-fit">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span class="caption-subject font-green bold uppercase">Actualizar planta</span>
                                </div>
                                <div class="actions">
                                    <a class="btn btn-circle btn-icon-only btn-default" data-dismiss="modal" aria-hidden="true">
                                        <i class="fa fa-close"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <input type="hidden" id="emp_rif2" name="emp_rif">
                                <div class="row">

                                    <div class="col-sm-12">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="rsocial2" name="rsocial" required onfocus="buscarEmpresa('rsocial2', 'emp_rif2')">
                                            <label for="rsocial2">Razón social (nombre)<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <select class="form-control" id="estado2" name="estado" required onchange="getMcpiosPquias('mcpio', 'estado2', 'municipio2', '{{ route('sistema.getMcpiosPquias') }}'); getAmbitos('estado2', 'ambito2', '{!! route('sistema.getAmbito') !!}') " >
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
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <select class="form-control" id="status2" name="status" required >
                                                <option value=""></option>
                                                <option value="ACTIVO">ACTIVO</option>
                                                <option value="INACTIVO">INACTIVO</option>
                                            </select>
                                            <label for="status2">Estatus<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="fespecifica2" name="fespecifica" required>
                                            <label for="fespecifica2">Función específica<span class="required" aria-required="true">*</span></label>
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
                                            <input type="text" class="form-control" id="telf2" name="telf" required data-inputmask="'mask': '9999-9999999'" data-rule-telfv="true">
                                            <label for="telf2">Teléfono<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group form-md-line-input has-success">
                                            <select class="form-control" id="ambito2" name="ambito" required >
                                                <option value=""></option>
                                            </select>
                                            <label for="ambito2">Ámbito<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                   <!-- <div class="col-sm-8">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="ambito2" name="ambito" required onfocus="buscarAmbito('ambito2', 'estado2')">
                                            <label for="ambito2">Ámbito</label>
                                        </div>
                                    </div>-->
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

    <div id="viewPlanta" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-full">
                <div class="modal-content">
                    <div class="modal-body">
                        <!-- BEGIN MARKERS PORTLET-->
                        <div class="portlet light portlet-fit">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span class="caption-subject font-green bold uppercase">Detalle planta</span>
                                </div>
                                <div class="actions">
                                    <a class="btn btn-circle btn-icon-only btn-default" data-dismiss="modal" aria-hidden="true">
                                        <i class="fa fa-close"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div id="cuerpoPlanta"></div>
                            </div>
                        </div>
                        <!-- END MARKERS PORTLET-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-no-border btn-outline green">Aceptar</button>
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


    <div id="addInfoComp" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <form id="fAddInfoComp" action="#" data-accion="{{ route('sistema.plantas.info.add') }}">
            {{ csrf_field() }}
            <input type="hidden" id="planta_id" name="planta_id">
            <div class="modal-dialog modal-full">
                <div class="modal-content">
                    <div class="modal-body">
                        <!-- BEGIN MARKERS PORTLET-->
                        <div class="portlet light portlet-fit">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span class="caption-subject font-green bold uppercase">Agregar información complementaria</span>
                                </div>
                                <div class="actions">
                                    <a class="btn btn-circle btn-icon-only btn-default" data-dismiss="modal" aria-hidden="true">
                                        <i class="fa fa-close"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <input type="hidden" id="emp_rif" name="emp_rif">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="date" class="form-control" id="fecha" name="fecha" required>
                                            <label for="fecha">Fecha<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="mobra" name="mobra" data-type='number' required>
                                            <label for="mobra">Mano de obra<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="cinstalada" name="cinstalada" data-type='number' required>
                                            <label for="cinstalada">Capacidad instalada (mes)<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="coperativa" name="coperativa" data-type='number' required>
                                            <label for="coperativa">Capacidad operativa % (mes)<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="produccion" name="produccion" data-type='number' required>
                                            <label for="produccion">Producción actual (mes)<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="inventario" name="inventario" data-type='number' required>
                                            <label for="inventario">Inventario (días)<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="pprincipal" name="pprincipal"  required>
                                            <label for="pprincipal">Producto principal<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-md-line-input has-success">
                                            <textarea class="form-control" rows="3" id="ncritico" name="ncritico" required></textarea>
                                            <label for="ncritico">Nudo critico (producción)<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-md-line-input has-success">
                                            <textarea class="form-control" rows="3" id="observacion" name="observacion" required></textarea>
                                            <label for="observacion">Observación<span class="required" aria-required="true">*</span></label>
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


    <div id="modalDivInfo" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-full">
                <div class="modal-content">
                    <div class="modal-body">
                        <!-- BEGIN MARKERS PORTLET-->
                        <div class="portlet light portlet-fit">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span class="caption-subject font-green bold uppercase">Detalle información complementaria</span>
                                </div>
                                <div class="actions">
                                    <a class="btn btn-circle btn-icon-only btn-default" data-dismiss="modal" aria-hidden="true">
                                        <i class="fa fa-close"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div id="cuerpoInfoComp"></div>
                            </div>
                        </div>
                        <!-- END MARKERS PORTLET-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-no-border btn-outline green">Aceptar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
    </div>






    <input type="hidden" id="url-find" data-url="{!! route('sistema.plantas.find') !!}">
    <input type="hidden" id="url-del" data-url="{!! route('sistema.plantas.del') !!}">

    <input type="hidden" id="url-info" data-url="{!! route('sistema.plantas.info.data') !!}">

    <input type="hidden" id="url-mapUbicacion" data-url="{!! route('sistema.mapasIndustria') !!}">

    <input type="hidden" id="url-srcEmpresa" data-url="{!! route('sistema.getEmpresaCoord') !!}">
    <input type="hidden" id="url-srcAmbito" data-url="{!! route('sistema.getAmbito') !!}">
    <input type="hidden" id="user-rol" data-rol="{!! Auth::user()->rol !!}">



    <!--<input type="hidden" id="url-uplProduccion" data-url="{{ route('sistema.empresas.uplProduccion') }}">-->

    <!-- END EXAMPLE TABLE PORTLET-->
    <div class="clearfix"></div>
@endsection

@section('scripts')
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyCcFZBu19UJ3rBx2HLn2ldA-6biMN37wh0" type="text/javascript"></script>
    <script src="{{ URL::to('assets/global/plugins/formstone/dist/js/core.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('assets/global/plugins/formstone/dist/js/upload.js') }}" type="text/javascript"></script>

@endsection

@section('script-body')
    <script src="{{ URL::to('assets/global/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('assets/pages/scripts/planta.js') }}" type="text/javascript"></script>
    <script>

    </script>

@endsection
