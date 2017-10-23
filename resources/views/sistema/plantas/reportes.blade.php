@extends('layouts.master')
@section('title')
    .:: Reportes ::.
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
            <span>Reportes</span>
        </li>
    </ul>
    <!--<div class="page-toolbar">
            <button type="button" class="btn blue btn-sm btn-outline fa fa-plus" title="agregar"></button>
    </div>-->
@endsection

@section('page-title')
    Reportes
    <!--<small>(Registro Único de Industria y Comercio)</small>-->
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-4 col-xs-12 col-sm-6">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject bold uppercase">Plantas actualizadas</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <form id="qryPlanAct">
                        {{ csrf_field()  }}
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group form-md-line-input has-success">
                                    <input type="date" class="form-control" id="fp1" name="f1" required>
                                    <label for="fp1">Fecha inicio<span class="required" aria-required="true">*</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group form-md-line-input has-success">
                                    <input type="date" class="form-control" id="fp2" name="f2" required>
                                    <label for="fp2">Fecha fin<span class="required" aria-required="true">*</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-no-border btn-outline green  pull-right">Consultar</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="col-lg-4 col-xs-12 col-sm-6">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject bold uppercase">% de productividad ámbitos</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <form id="qryPorProd">
                        {{ csrf_field()  }}
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group form-md-line-input has-success">
                                    <input type="date" class="form-control" id="fpp1" name="f1" required>
                                    <label for="fpp1">Fecha inicio<span class="required" aria-required="true">*</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group form-md-line-input has-success">
                                    <input type="date" class="form-control" id="fpp2" name="f2" required>
                                    <label for="fpp2">Fecha fin<span class="required" aria-required="true">*</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-no-border btn-outline green  pull-right">Consultar</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="col-lg-4 col-xs-12 col-sm-6">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject bold uppercase">% de productividad estados</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <form id="qryPorProdEdo">
                        {{ csrf_field()  }}
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group form-md-line-input has-success">
                                    <input type="date" class="form-control" id="fpe1" name="f1" required>
                                    <label for="fpe1">Fecha inicio<span class="required" aria-required="true">*</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group form-md-line-input has-success">
                                    <input type="date" class="form-control" id="fpe2" name="f2" required>
                                    <label for="fpe2">Fecha fin<span class="required" aria-required="true">*</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-no-border btn-outline green  pull-right">Consultar</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-xs-12 col-sm-6">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject bold uppercase">Segmentación Plantas</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <form id="qryPlanSeg">
                        {{ csrf_field()  }}
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group form-md-line-input has-success">
                                    <input type="date" class="form-control" id="fps1" name="f1" required>
                                    <label for="fps1">Fecha inicio<span class="required" aria-required="true">*</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group form-md-line-input has-success">
                                    <input type="date" class="form-control" id="fps2" name="f2" required>
                                    <label for="fps2">Fecha fin<span class="required" aria-required="true">*</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-no-border btn-outline green  pull-right">Consultar</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div id="modalPlantasActualizadas" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-full">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- BEGIN MARKERS PORTLET-->
                    <div class="portlet light portlet-fit">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-green bold uppercase">Reporte Plantas Actualizadas (<span id="divNFecha"></span>)</span>
                            </div>
                            <div class="actions">
                                <a class="btn btn-circle btn-icon-only btn-default" data-dismiss="modal" aria-hidden="true">
                                    <i class="fa fa-close"></i>
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <br><br><br>
                            <table class="table table-striped table-hover" style="width: 100% !important;" id="dt_pAct" data-lenguaje="{{ URL::to('assets/global/plugins/datatables/spanish.json') }}" data-urldata="{!! route('sistema.preportes.getPlantasAct') !!}">
                                <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>RIF</th>
                                    <th>Empresa</th>
                                    <th>Sector</th>
                                    <th>Subsector</th>
                                    <th>R legal</th>
                                    <th>CI</th>
                                    <th>Telefonos</th>
                                    <th>Estado</th>
                                    <th>Municipio</th>
                                    <th>Parroquia</th>
                                    <th>Estatus</th>
                                    <th>Ámbito</th>
                                    <th>Telf. planta</th>
                                    <th>M obra</th>
                                    <th>Cap instalada (mes)</th>
                                    <th>Cap operativa (mes)</th>
                                    <th>Produccion (mes)</th>
                                    <th>Inventario (dias)</th>
                                    <th>P principal</th>
                                    <th>N critico</th>
                                    <th>Observación</th>
                                    <th>Foto</th>
                                </tr>
                                </thead>
                            </table>
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

    <div id="modalPorcentajeAmbitos" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-full">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- BEGIN MARKERS PORTLET-->
                    <div class="portlet light portlet-fit">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-green bold uppercase">Reporte Porcentaje de produccion ámbitos (<span id="divPNFecha"></span>)</span>
                            </div>
                            <div class="actions">
                                <a class="btn btn-circle btn-icon-only btn-default" data-dismiss="modal" aria-hidden="true">
                                    <i class="fa fa-close"></i>
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <br><br><br>
                            <table class="table table-striped table-hover" style="width: 100% !important;" id="dt_pPorPro" data-lenguaje="{{ URL::to('assets/global/plugins/datatables/spanish.json') }}" data-urldata="{!! route('sistema.preportes.getPocentajeProd') !!}">
                                <thead>
                                <tr>
                                    <th>Estado</th>
                                    <th>Municipio</th>
                                    <th>Parroquia</th>
                                    <th>Ámbito</th>
                                    <th>% de producción</th>
                                </tr>
                                </thead>
                            </table>
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

    <div id="modalPorcentajeEstados" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-full">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- BEGIN MARKERS PORTLET-->
                    <div class="portlet light portlet-fit">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-green bold uppercase">Reporte Porcentaje de produccion estados (<span id="divEPNFecha"></span>)</span>
                            </div>
                            <div class="actions">
                                <a class="btn btn-circle btn-icon-only btn-default" data-dismiss="modal" aria-hidden="true">
                                    <i class="fa fa-close"></i>
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <br><br><br>
                            <table class="table table-striped table-hover" style="width: 100% !important;" id="dt_pPorProEdo" data-lenguaje="{{ URL::to('assets/global/plugins/datatables/spanish.json') }}" data-urldata="{!! route('sistema.preportes.getPocentajeProdEdo') !!}">
                                <thead>
                                <tr>
                                    <th>Estado</th>
                                    <th>% de producción</th>
                                </tr>
                                </thead>
                            </table>
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

    <div id="modalPlantasSeg" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-full">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- BEGIN MARKERS PORTLET-->
                    <div class="portlet light portlet-fit">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-green bold uppercase">Segmentación plantas (<span id="divSegFecha"></span>)</span>
                            </div>
                            <div class="actions">
                                <a class="btn btn-circle btn-icon-only btn-default" data-dismiss="modal" aria-hidden="true">
                                    <i class="fa fa-close"></i>
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <br><br><br>
                                    <table class="table table-striped table-hover" style="width: 100% !important;" id="dt_pSeg" data-lenguaje="{{ URL::to('assets/global/plugins/datatables/spanish.json') }}" data-urldata="{!! route('sistema.preportes.getPlantasSeg') !!}" data-urlgrafico="{!! route('sistema.preportes.getPlantasSegGraf') !!}">
                                        <thead>
                                        <tr>
                                            <th>Descripcion</th>
                                            <th>Cantidad</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="col-md-8">
                                    <iframe id="ifrGrafSegPlan" frameborder="0" width="100%" height="500" scrolling="no"></iframe>
                                </div>
                            </div>

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
    <script src="{{ URL::to('assets/pages/scripts/preportes.js') }}" type="text/javascript"></script>
    <script>

    </script>

@endsection
