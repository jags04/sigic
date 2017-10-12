@extends('layouts.master')
@section('title')
    .:: EMPRESAS ::.
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
            <span>Empresas</span>
        </li>
    </ul>
    <!--<div class="page-toolbar">
            <button type="button" class="btn blue btn-sm btn-outline fa fa-plus" title="agregar"></button>
    </div>-->
@endsection

@section('page-title')
    Empresas
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
                    <table class="table table-striped table-hover" id="dt_empresas" data-lenguaje="{{ URL::to('assets/global/plugins/datatables/spanish.json') }}" data-urldata="{!! route('sistema.empresas.data') !!}">
                        <thead>
                        <tr>
                            <th>RIF</th>
                            <th>Empresa</th>
                            <th>Estado</th>
                            <th>Municipio</th>
                            <th>Parroquia</th>
                            <th>Localidad</th>
                            <th>Trabajadores</th>
                            <th>CIIU</th>
                            <th>Act económica</th>
                            <th>CNP</th>
                            <th>Fuente</th>
                            <th>Sector</th>
                            <th>Subsector</th>
                            <th>Motor</th>
                            <th>Estatus</th>
                            <th>R legal</th>
                            <th>CI</th>
                            <th>Teléfonos</th>
                            <th>Email</th>
                            <th>Lat</th>
                            <th>Long</th>
                            <th title="Numero de asignaciones DICOM">A DICOM</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>&nbsp;</th>
                            <th>Empresa</th>
                            <th>Estado</th>
                            <th>Municipio</th>
                            <th>Parroquia</th>
                            <th>Localidad</th>
                            <th>Trabajadores</th>
                            <th>CIIU</th>
                            <th>Act económica	</th>
                            <th>CNP</th>
                            <th>Fuente</th>
                            <th>Sector</th>
                            <th>Subsector</th>
                            <th>Motor</th>
                            <th>Estatus</th>
                            <th>R legal</th>
                            <th>CI</th>
                            <th>Teléfonos</th>
                            <th>Email</th>
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


    <div id="addEmpresa" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <form id="fAddEmp" action="#" data-accion="{{ route('sistema.empresas.add') }}">
            {{ csrf_field() }}
            <div class="modal-dialog modal-full">
                <div class="modal-content">
                    <div class="modal-body">
                        <!-- BEGIN MARKERS PORTLET-->
                        <div class="portlet light portlet-fit">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span class="caption-subject font-green bold uppercase">Agregar empresa</span>
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
                                    <div class="col-sm-10">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="localidad" name="localidad" required>
                                            <label for="localidad">Dirección<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="trabajadores" name="trabajadores" data-type='number' required>
                                            <label for="trabajadores">Nº de trabajadores<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <select class="form-control" id="motor" name="motor" required onchange="getSectorSubsectorActeco('sector', 'motor','sector','{{ route('sistema.empresas.sectorSubsector') }}')">
                                                <option value=""></option>
                                                @foreach($motores as $motor)
                                                    <option value="{{ $motor->motor }}">{{ $motor->motor }}</option>
                                                @endforeach
                                            </select>
                                            <label for="motor">Motor<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <select class="form-control" id="sector" name="sector" required onchange="getSectorSubsectorActeco('sub','sector','subsector','{{ route('sistema.empresas.sectorSubsector') }}')">
                                                <option value=""></option>
                                            </select>
                                            <label for="sector">Sector<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <select class="form-control" id="subsector" name="subsector" required onchange="getSectorSubsectorActeco('ciiu','subsector','ciiu','{{ route('sistema.empresas.sectorSubsector') }}')" >
                                                <option value=""></option>
                                            </select>
                                            <label for="subsector">Subsector<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group form-md-line-input has-success">
                                            <select class="form-control" id="ciiu" name="ciiu" required >
                                                <option value=""></option>
                                            </select>
                                            <label for="subsector">CIIU - Actividad económica<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <select class="form-control" id="status" name="status" required >
                                                <option value=""></option>
                                                <option value="NO TIENE DEUDA">NO TIENE DEUDA</option>
                                                <option value="TIENE DEUDA">TIENE DEUDA</option>
                                                <option value="SIN RESPUESTA">SIN RESPUESTA</option>
                                            </select>
                                            <label for="status">Estatus SENIAT<span class="required" aria-required="true">*</span></label>
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
                                            <input type="text" class="form-control" id="rlegal" name="rlegal" required>
                                            <label for="rlegal">Representante legal<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="ci" name="ci" required data-type='number'>
                                            <label for="ci">Cédula de identidad<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="email" name="email" data-rule-email="true" required>
                                            <label for="email">Email<span class="required" aria-required="true">*</span></label>
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

    <div id="updEmpresa" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true">
        <form id="fUpdEmp" action="#" data-accion="{{ route('sistema.empresas.upd') }}">
            <input type="hidden" name="id_emp" id="id_emp">
            {{ csrf_field() }}
            <div class="modal-dialog modal-full">
                <div class="modal-content">
                    <div class="modal-body">
                        <!-- BEGIN MARKERS PORTLET-->
                        <div class="portlet light portlet-fit">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span class="caption-subject font-green bold uppercase">Actualizar empresa (<span id="updRsocial"></span>)</span>
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
                                            <label for="rif">RIF<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="rsocial2" name="rsocial" required>
                                            <label for="rsocial">Razón social (nombre)<span class="required" aria-required="true">*</span></label>
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
                                            <label for="estado">Estado<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <select class="form-control" id="municipio2" name="municipio" required onchange="getMcpiosPquias('pquia', 'municipio2', 'parroquia2', '{{ route('sistema.getMcpiosPquias') }}', 'estado2') ">
                                                <option value=""></option>
                                            </select>
                                            <label for="municipio">Municipio<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <select class="form-control" id="parroquia2" name="parroquia" required >
                                                <option value=""></option>
                                            </select>
                                            <label for="parroquia">Parroquia<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-10">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="localidad2" name="localidad" required>
                                            <label for="localidad">Dirección<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="trabajadores2" name="trabajadores" data-type='number' required>
                                            <label for="trabajadores">Nº de trabajadores<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <select class="form-control" id="motor2" name="motor" required onchange="getSectorSubsectorActeco('sector', 'motor2','sector2','{{ route('sistema.empresas.sectorSubsector') }}')">
                                                <option value=""></option>
                                                @foreach($motores as $motor)
                                                    <option value="{{ $motor->motor }}">{{ $motor->motor }}</option>
                                                @endforeach
                                            </select>
                                            <label for="motor">Motor<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <select class="form-control" id="sector2" name="sector" required onchange="getSectorSubsectorActeco('sub','sector2','subsector2','{{ route('sistema.empresas.sectorSubsector') }}')">
                                                <option value=""></option>
                                            </select>
                                            <label for="sector">Sector<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <select class="form-control" id="subsector2" name="subsector" required onchange="getSectorSubsectorActeco('ciiu','subsector2','ciiu2','{{ route('sistema.empresas.sectorSubsector') }}')" >
                                                <option value=""></option>
                                            </select>
                                            <label for="subsector">Subsector<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group form-md-line-input has-success">
                                            <select class="form-control" id="ciiu2" name="ciiu" required >
                                                <option value=""></option>
                                            </select>
                                            <label for="subsector">CIIU - Actividad económica<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <select class="form-control" id="status2" name="status" required >
                                                <option value=""></option>
                                                <option value="NO TIENE DEUDA">NO TIENE DEUDA</option>
                                                <option value="TIENE DEUDA">TIENE DEUDA</option>
                                                <option value="SIN RESPUESTA">SIN RESPUESTA</option>
                                            </select>
                                            <label for="status">Estatus SENIAT<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group form-md-line-input has-success">
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-control">
                                                    <input type="text" class="form-control " id="coordenadas2" name="coordenadas" placeholder="0.0,0.0" required @if(Auth::user()->rol != 10 ) readonly @endif>
                                                    <label for="form_control_1">Coordenadas</label>
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
                                            <input type="text" class="form-control" id="rlegal2" name="rlegal" required>
                                            <label for="rlegal">Representante legal<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="ci2" name="ci" required data-type='number'>
                                            <label for="ci">Cédula de identidad<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="email2" name="email" data-rule-email="true" required>
                                            <label for="email">Email<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="telf12" name="telefonos[]" required data-inputmask="'mask': '9999-9999999'" data-rule-telfv="true">
                                            <label for="telf1">Teléfono 1<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="telf22" name="telefonos[]" data-inputmask="'mask': '9999-9999999'" data-rule-telfv="true">
                                            <label for="telf2">Teléfono 2</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="telf32" name="telefonos[]" required data-inputmask="'mask': '9999-9999999'" data-rule-telfv="true">
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
                        <button type="submit" class="btn btn-no-border btn-outline green">Actualizar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </form>
    </div>

    <div class="modal fade" id="uplDicom" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="portlet light portlet-fit">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-green bold uppercase">Cargar archivo DICOM</span>
                            </div>
                            <div class="actions">
                                <a class="btn btn-circle btn-icon-only btn-default" data-dismiss="modal" aria-hidden="true">
                                    <i class="fa fa-close"></i>
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <!--<form action="upload.php" class="dropzone"></form>-->
                            <form action="#" method="GET" class="form demo_form">
                                <div class="upload_dicom"></div>
                                <div class="filelists">
                                    <h5>Completados</h5>
                                    <ol class="filelist complete"></ol>
                                    <h5>En cola</h5>
                                    <ol class="filelist queue"></ol>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-no-border btn-outline green">Aceptar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="uplProduccion" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="portlet light portlet-fit">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-green bold uppercase">Cargar producción</span>
                            </div>
                            <div class="actions">
                                <a class="btn btn-circle btn-icon-only btn-default" data-dismiss="modal" aria-hidden="true">
                                    <i class="fa fa-close"></i>
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <!--<form action="upload.php" class="dropzone"></form>-->
                            <form action="#" method="GET" class="form demo_form">
                                <div class="upload"></div>
                                <div class="filelists">
                                    <h5>Completados</h5>
                                    <ol class="filelist complete"></ol>
                                    <h5>En cola</h5>
                                    <ol class="filelist queue"></ol>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-no-border btn-outline green">Aceptar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="cDataExt" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="portlet light bordered">
                        <div class="portlet-title tabbable-line">
                            <div class="caption">
                                <span class="caption-subject font-green bold uppercase">Cargar data externa</span>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#portlet_tab1" data-toggle="tab"> DICOM </a>
                                </li>
                                <li>
                                    <a href="#portlet_tab2" data-toggle="tab"> SAIISE </a>
                                </li>

                            </ul>
                        </div>
                        <div class="portlet-body">
                            @if(Auth::user()->rol == 10 || Auth::user()->rol == 1)
                                <div class="tab-content">
                                    <div class="tab-pane active" id="portlet_tab1">
                                        <form id="fbsqDicom" action="#" data-accion="{!! route('sistema.empresas.searchDicom') !!}" >
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group form-md-line-input has-success">
                                                        <input type="date" class="form-control" id="fid" name="fid" required>
                                                        <label for="fid">Fecha de inicio<span class="required" aria-required="true">*</span></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group form-md-line-input has-success">
                                                        <input type="date" class="form-control" id="ffd" name="ffd" required>
                                                        <label for="ffd">Fecha de fin<span class="required" aria-required="true">*</span></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <button type="submit" class="btn btn-no-border btn-outline green  pull-right">Cargar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane" id="portlet_tab2">
                                        <form id="fbsqSaiise" action="#" data-accion="{!! route('sistema.empresas.searchSaiise') !!}" >
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group form-md-line-input has-success">
                                                        <input type="date" class="form-control" id="fis" name="fis" required>
                                                        <label for="fis">Fecha de inicio<span class="required" aria-required="true">*</span></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group form-md-line-input has-success">
                                                        <input type="date" class="form-control" id="ffs" name="ffs" required>
                                                        <label for="ffs">Fecha de fin<span class="required" aria-required="true">*</span></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <button type="submit" class="btn btn-no-border btn-outline green  pull-right">Cargar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <h4>No tienes privilegios para ver esta funcionalidad</h4>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="detalleEmp" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-full">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="portlet light portlet-fit">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-green bold uppercase">Detalle empresa</span>
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

                                    <li>
                                        <a href="#tab_1_3" tabindex="-1" data-toggle="tab"> Producción</a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_4" tabindex="-1" data-toggle="tab"> Prod (Histórico)</a>
                                    </li>

                                    <li>
                                        <a href="#tab_1_5" tabindex="-1" data-toggle="tab"> Asig div</a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_6" tabindex="-1" data-toggle="tab"> Asig div (Histórico)</a>
                                    </li>

                                    <li>
                                        <a href="#tab_1_7" tabindex="-1" data-toggle="tab"> Prod/Asig div</a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_8" tabindex="-1" data-toggle="tab"> Prod/Asig div (Histórico)</a>
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

                                    <div class="tab-pane fade" id="tab_1_3">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- --><iframe style="width: 100%; height: 100vh" frameborder="0" id="grafProdUn" ></iframe>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab_1_4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- --><iframe style="width: 100%; height: 100vh" frameborder="0" id="grafProdUnHist" ></iframe>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab_1_5">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- --><iframe style="width: 100%; height: 100vh" frameborder="0" id="grafAsigUn" ></iframe>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab_1_6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- --><iframe style="width: 100%; height: 100vh" frameborder="0" id="grafAsigUnHist" ></iframe>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="tab-pane fade" id="tab_1_7">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- --><iframe style="width: 100%; height: 100vh" frameborder="0" id="grafProd" ></iframe>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="tab_1_8">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!----><iframe style="width: 100%; height: 100vh" frameborder="0" id="grafProdHist" ></iframe>
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

    <input type="hidden" id="url-find" data-url="{!! route('sistema.empresas.find') !!}">
    <input type="hidden" id="url-del" data-url="{!! route('sistema.empresas.del') !!}">
    <input type="hidden" id="url-view" data-url="{!! route('sistema.empresas.view') !!}">
    <input type="hidden" id="url-dicom" data-url="{!! route('sistema.empresas.searchDicom') !!}">
    <input type="hidden" id="url-saiise" data-url="{!! route('sistema.empresas.searchSaiise') !!}">
    <input type="hidden" id="url-dicomSubasta" data-url="{!! route('sistema.empresas.detalleDicomSubastas') !!}">

    <input type="hidden" id="url-uplProduccion" data-url="{{ route('sistema.empresas.uplProduccion') }}">
    <input type="hidden" id="url-uplDicom" data-url="{{ route('sistema.empresas.uplDicom') }}">

    <input type="hidden" id="url-mapUbicacion" data-url="{!! route('sistema.mapasIndustria') !!}">
    <input type="hidden" id="url-dataProdAnual" data-url="{!! route('sistema.dataProdAsigAnual') !!}">

    <input type="hidden" id="url-dataProdUn" data-url="{!! route('sistema.dataProduccion') !!}">
    <input type="hidden" id="url-dataProdUnHist" data-url="{!! route('sistema.dataProduccion') !!}">
    <input type="hidden" id="url-dataAsigUn" data-url="{!! route('sistema.dataAsignacion') !!}">
    <input type="hidden" id="url-dataAsigUnHist" data-url="{!! route('sistema.dataAsignacion') !!}">

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
    <script src="{{ URL::to('assets/pages/scripts/empresa.js') }}" type="text/javascript"></script>
    <script>

    </script>

@endsection