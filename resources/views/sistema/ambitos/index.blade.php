@extends('layouts.master')
@section('title')
    .:: Ambitos industriales ::.
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
            <span>Ambitos industriales</span>
        </li>
    </ul>
    <!--<div class="page-toolbar">
            <button type="button" class="btn blue btn-sm btn-outline fa fa-plus" title="agregar"></button>
    </div>-->
@endsection

@section('page-title')
    Ambitos industriales
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
                    <table class="table table-striped table-hover" id="dt_ambitos" data-lenguaje="{{ URL::to('assets/global/plugins/datatables/spanish.json') }}" data-urldata="{!! route('sistema.ambitos.data') !!}">
                        <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th>Municipio</th>
                            <th>Parroquia</th>
                            <th>Superficie (ha)</th>
                            <th>Registros</th>
                            <th>Parcelas</th>
                            <th>Inmuebles activos</th>
                            <th>Inmuebles inactivos</th>
                            <th>Ppal act económica</th>
                            <th>Ppal act productiva</th>
                            <th title="Nº poligonos">Pol</th>

                            <th>Productividad</th>
                            <th>Plantas activas</th>

                            <th>Foto</th>
                            <th>Mapa</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th></th>
                            <th>Estado</th>
                            <th>Municipio</th>
                            <th>Parroquia</th>
                            <th>Superficie (ha)</th>
                            <th>Registros</th>
                            <th>Parcelas</th>
                            <th>Inmuebles activos</th>
                            <th>Inmuebles inactivos</th>
                            <th>Ppal act económica</th>
                            <th>Ppal act productiva</th>
                            <th>&nbsp;</th>
                            <th></th>
                            <th></th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                            <th>&nbsp;</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="addAmbitos" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <form id="fAddAmb" action="#" data-accion="{{ route('sistema.ambitos.add') }}">
            {{ csrf_field() }}
            <div class="modal-dialog modal-full">
                <div class="modal-content">
                    <div class="modal-body">
                        <!-- BEGIN MARKERS PORTLET-->
                        <div class="portlet light portlet-fit">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span class="caption-subject font-green bold uppercase">Agregar Ambito</span>
                                </div>
                                <div class="actions">
                                    <a class="btn btn-circle btn-icon-only btn-default" data-dismiss="modal" aria-hidden="true">
                                        <i class="fa fa-close"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                                            <label for="nombre">Nombre del ámbito<span class="required" aria-required="true">*</span></label>
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
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="superficie" name="superficie" data-type='number' required>
                                            <label for="superficie">Superficie (ha)<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="registros" name="registros" data-type='number' required>
                                            <label for="registros">Nº de registros<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="parcelas" name="parcelas" data-type='number' required>
                                            <label for="parcelas">Nº de parcelas<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="iactivos" name="iactivos" data-type='number' required>
                                            <label for="iactivos">Inmuebles activos<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="iinactivos" name="iinactivos" data-type='number' required>
                                            <label for="iinactivos">Inmuebles inactivos<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="paeconomica" name="paeconomica" required>
                                            <label for="paeconomica">Principal actividad económica<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="paproductiva" name="paproductiva" required>
                                            <label for="paproductiva">Principal actividad productiva<span class="required" aria-required="true">*</span></label>
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

    <div id="updAmbitos" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <form id="fUpdAmb" action="#" data-accion="{{ route('sistema.ambitos.upd') }}">
            <input type="hidden" name="id_amb" id="id_amb">
            {{ csrf_field() }}
            <div class="modal-dialog modal-full">
                <div class="modal-content">
                    <div class="modal-body">
                        <!-- BEGIN MARKERS PORTLET-->
                        <div class="portlet light portlet-fit">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span class="caption-subject font-green bold uppercase">Actualizar Ambito (<span id="lbAmbito"></span>)</span>
                                </div>
                                <div class="actions">
                                    <a class="btn btn-circle btn-icon-only btn-default" data-dismiss="modal" aria-hidden="true">
                                        <i class="fa fa-close"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="nombre2" name="nombre" required>
                                            <label for="nombre2">Nombre del ámbito<span class="required" aria-required="true">*</span></label>
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
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="superficie2" name="superficie" data-type='number' required>
                                            <label for="superficie2">Superficie (ha)<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="registros2" name="registros" data-type='number' required>
                                            <label for="registros2">Nº de registros<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="parcelas2" name="parcelas" data-type='number' required>
                                            <label for="parcelas2">Nº de parcelas<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="iactivos2" name="iactivos" data-type='number' required>
                                            <label for="iactivos2">Inmuebles activos<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="iinactivos2" name="iinactivos" data-type='number' required>
                                            <label for="iinactivos2">Inmuebles inactivos<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="paeconomica2" name="paeconomica" required>
                                            <label for="paeconomica2">Principal actividad económica<span class="required" aria-required="true">*</span></label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group form-md-line-input has-success">
                                            <input type="text" class="form-control" id="paproductiva2" name="paproductiva" required>
                                            <label for="paproductiva2">Principal actividad productiva<span class="required" aria-required="true">*</span></label>
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

    <div id="modalCuerpoDetalleAmb" class="modal fade draggable-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog  modal-full">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="portlet light portlet-fit">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span class="caption-subject font-green bold uppercase">Detalle de ámbito</span>
                                </div>
                                <div class="actions">
                                    <a class="btn btn-circle btn-icon-only btn-default" data-dismiss="modal" aria-hidden="true">
                                        <i class="fa fa-close"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div id="cuerpoDetalleAmb"></div>
                                <iframe  frameborder="0" id="mapUbiAmbito" style="width: 100%; height: 50vh" data-url="{{ route('sistema.mapasAmbitos') }}"></iframe>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.modal-content-->
            </div>
            <!-- /.modal-dialog -->
    </div>

    <div id="modalMapaPol" class="modal fade draggable-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <form id="fUplPolAmb" action="#" data-accion="{{ route('sistema.ambitos.uplPol') }}">
            <input type="hidden" name="id_amb" id="id_amb_pol">
            {{ csrf_field() }}
            <div class="modal-dialog  modal-full">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="portlet light portlet-fit">
                            <div class="portlet-title">
                                <div class="caption">
                                    <span class="caption-subject font-green bold uppercase">Dibujar poligono</span>
                                </div>
                                <div class="actions">
                                    <a class="btn btn-circle btn-icon-only btn-default" data-dismiss="modal" aria-hidden="true">
                                        <i class="fa fa-close"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <iframe  frameborder="0" id="iframeMapa" style="width: 100%; height: 65vh" data-url="{!! route('sistema.getCoordMap') !!}"></iframe>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group form-md-line-input">
                                            <textarea class="form-control" rows="3" placeholder="" @if(Auth::user()->rol != 10) readonly="readonly" @endif required id="coordenadas" name="coordenadas"></textarea>
                                            <label for="form_control_1">Coordenadas del polígono</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-9"></div>
                                    <div class="col-md-1">
                                        <button type="button" data-dismiss="modal" class="btn btn-no-border btn-outline red">Cancelar</button>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-no-border btn-outline green">Agregar polígono</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.modal-content
                <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-no-border btn-outline red">Cancelar</button>
            <button type="submit" class="btn btn-no-border btn-outline green">Agregar polígono</button>
        </div>-->
            </div>
            <!-- /.modal-dialog -->
        </form>
    </div>


    <div class="modal fade" id="uplFoto" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="portlet light portlet-fit">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-green bold uppercase">Cargar Foto</span>
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
                    <button type="button"  data-dismiss="modal" class="btn btn-no-border btn-outline green">Aceptar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>



    <input type="hidden" id="url-find" data-url="{!! route('sistema.ambitos.find') !!}">
    <input type="hidden" id="url-del" data-url="{!! route('sistema.ambitos.del') !!}">
    <input type="hidden" id="url-view" data-url="{!! route('sistema.ambitos.view') !!}">
    <input type="hidden" id="url-uplFoto" data-url="{!! route('sistema.ambitos.uplFoto') !!}">
    <input type="hidden" id="url-delFoto" data-url="{!! route('sistema.ambitos.delFoto') !!}">




    <!-- END EXAMPLE TABLE PORTLET-->
    <div class="clearfix"></div>
@endsection

@section('scripts')
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyCcFZBu19UJ3rBx2HLn2ldA-6biMN37wh0" type="text/javascript"></script>
    <script src="{{ URL::to('assets/global/plugins/formstone/dist/js/core.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('assets/global/plugins/formstone/dist/js/upload.js') }}" type="text/javascript"></script>

@endsection

@section('script-body')
    <script src="{{ URL::to('assets/pages/scripts/ambitos.js') }}" type="text/javascript"></script>
    <script>

    </script>

@endsection