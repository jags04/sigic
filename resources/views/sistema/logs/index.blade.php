@extends('layouts.master')
@section('title')
    .:: LOGS ::.
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
            <span>Logs</span>
        </li>
    </ul>
    <!--<div class="page-toolbar">
            <button type="button" class="btn blue btn-sm btn-outline fa fa-plus" title="agregar"></button>
    </div>-->
@endsection

@section('page-title')
    Logs
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
                    <table class="table table-striped table-hover" id="dt_logs" data-lenguaje="{{ URL::to('assets/global/plugins/datatables/spanish.json') }}" data-urldata="{!! route('sistema.logs.data') !!}">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Módulo</th>
                            <th>Acción</th>
                            <th>RIF Empresa</th>
                            <th>Fecha</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>&nbsp;</th>
                            <th>Usuario</th>
                            <th>Módulo</th>
                            <th>Acción</th>
                            <th>RIF Empresa</th>
                            <th>&nbsp;</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalBsqFecha" tabindex="-1" role="basic" aria-hidden="true">
        <form id="formBsqFcha" action="#" data-accion="{{ route('sistema.usuarios.add') }}">
            {{ csrf_field() }}
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="portlet light portlet-fit">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-green bold uppercase">Busqueda</span>
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
                                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                                        <label for="nombre">Fecha de inicio<span class="required" aria-required="true">*</span></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group form-md-line-input has-success">
                                        <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                                        <label for="nombre">Fecha de fin<span class="required" aria-required="true">*</span></label>
                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-no-border btn-outline red">Cancelar</button>
                    <button type="submit" class="btn btn-no-border btn-outline green">Buscar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
        </form>
    </div>

    <div class="modal fade" id="modalRepFecha" tabindex="-1" role="basic" aria-hidden="true">
        <div class="modal-dialog modal-full">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="portlet light bordered">
                        <div class="portlet-title tabbable-line">
                            <div class="caption">
                                <span class="caption-subject font-green bold uppercase">Reportes de actualización</span>
                            </div>
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#portlet_tab1" data-toggle="tab"> Industrias </a>
                                </li>
                                <li>
                                    <a href="#portlet_tab2" data-toggle="tab"> Comercios </a>
                                </li>

                            </ul>
                        </div>
                        <div class="portlet-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="portlet_tab1">
                                        <form id="fRepInd" action="#" data-accion="{!! route('sistema.logs.reporteIndustria') !!}" >
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group form-md-line-input has-success">
                                                        <input type="date" class="form-control" id="fid" name="fid" required>
                                                        <label for="fid">Fecha de inicio<span class="required" aria-required="true">*</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group form-md-line-input has-success">
                                                        <input type="date" class="form-control" id="ffd" name="ffd" required>
                                                        <label for="ffd">Fecha de fin<span class="required" aria-required="true">*</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group form-md-line-input has-success">
                                                        <select class="form-control" id="tipoi" name="tipoi" required >
                                                            <option value=""></option>
                                                            <option value="ESTADO">ESTADO</option>
                                                            <option value="PERSONA">PERSONA</option>
                                                        </select>
                                                        <label for="tipoi">Tipo<span class="required" aria-required="true">*</span></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <button type="button" id="btnFRepInd" class="btn btn-no-border btn-outline green  pull-right">Buscar</button>
                                                </div>
                                            </div>
                                        </form>
                                        <br><br><br><br>
                                            <div class="row" id="table_repInd" style="display: none">
                                                <div class="col-md-12">
                                                    <table id="dt_repInd" class="table table-striped table-hover text-sm">
                                                        <thead>
                                                        <tr>
                                                            <th class="sort-alpha">Descripción</th>
                                                            <th class="sort-alpha">Cantidad</th>
                                                        </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>

                                    </div>
                                    <div class="tab-pane" id="portlet_tab2">
                                        <form id="fRepCom" action="#" data-accion="{!! route('sistema.logs.reporteComercio') !!}" >
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="form-group form-md-line-input has-success">
                                                        <input type="date" class="form-control" id="fic" name="fic" required>
                                                        <label for="fic">Fecha de inicio<span class="required" aria-required="true">*</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group form-md-line-input has-success">
                                                        <input type="date" class="form-control" id="ffc" name="ffc" required>
                                                        <label for="ffc">Fecha de fin<span class="required" aria-required="true">*</span></label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group form-md-line-input has-success">
                                                        <select class="form-control" id="tipoc" name="tipoc" required >
                                                            <option value=""></option>
                                                            <option value="ESTADO">ESTADO</option>
                                                            <option value="PERSONA">PERSONA</option>
                                                        </select>
                                                        <label for="tipoc">Tipo<span class="required" aria-required="true">*</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <button type="button" id="btnFRepCom" class="btn btn-no-border btn-outline green  pull-right">Buscar</button>
                                                </div>
                                            </div>
                                        </form>
                                        <br><br><br><br>
                                        <div class="row" id="table_repCom" style="display: none">
                                            <div class="col-md-12">
                                                <table id="dt_repCom" class="table table-striped table-hover text-sm">
                                                    <thead>
                                                    <tr>
                                                        <th class="sort-alpha">Descripción</th>
                                                        <th class="sort-alpha">Cantidad</th>
                                                    </tr>
                                                    </thead>
                                                </table>
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

    <!-- END EXAMPLE TABLE PORTLET-->
    <div class="clearfix"></div>
@endsection

@section('scripts')
    <script src="{{ URL::to('assets/global/plugins/formstone/dist/js/core.js') }}" type="text/javascript"></script>
    <!--<script src="{{ URL::to('assets/global/plugins/formstone/dist/js/upload.js') }}" type="text/javascript"></script>-->

@endsection

@section('script-body')
    <script src="{{ URL::to('assets/pages/scripts/logs.js') }}" type="text/javascript"></script>
    <script>

    </script>

@endsection