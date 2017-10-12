@extends('layouts.master')
@section('title')
    .:: MAPAS ::.
@endsection

@section('styles')
    <style>
        iframe{
            width: 100%;
            height: 50vh;
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
            <span>Mapas</span>
        </li>
    </ul>
@endsection

@section('page-title')
    Mapas
    <!--<small>(Registro Único de Industria y Comercio)</small>-->
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <!-- BEGIN BASIC PORTLET-->
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-red"></i>
                        <span class="caption-subject font-red bold uppercase">Industrias</span>
                    </div>
                    <div class="actions">
                        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;" onclick="verMapa('Industrias')">
                            <i class="fa fa-external-link"></i>
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <iframe src="{{ route('sistema.mapasIndustria') }}" frameborder="0"></iframe>
                </div>
            </div>
            <!-- END BASIC PORTLET-->
        </div>
        <div class="col-md-6">
            <!-- BEGIN MARKERS PORTLET-->
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-blue"></i>
                        <span class="caption-subject font-blue bold uppercase">Comercios</span>
                    </div>
                    <div class="actions">
                        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;" onclick="verMapa('Comercios')">
                            <i class="fa fa-external-link"></i>
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <iframe src="{{ route('sistema.mapasComercio') }}" frameborder="0" ></iframe>
                </div>
            </div>
            <!-- END MARKERS PORTLET-->
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <!-- BEGIN BASIC PORTLET-->
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-red"></i>
                        <span class="caption-subject font-red bold uppercase">Ámbitos Industriales</span>
                    </div>
                    <div class="actions">
                        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;" onclick="verMapa('Ambitos')">
                            <i class="fa fa-external-link"></i>
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <iframe src="{{ route('sistema.mapasAmbitos') }}" frameborder="0"></iframe>
                </div>
            </div>
            <!-- END BASIC PORTLET-->
        </div>
        <div class="col-md-6">
            <!-- BEGIN MARKERS PORTLET-->
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-blue"></i>
                        <span class="caption-subject font-blue bold uppercase">Distribución</span>
                    </div>
                    <div class="actions">
                        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;" onclick="alert('Distribucion')">
                            <i class="fa fa-external-link"></i>
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <iframe src="" frameborder="0" ></iframe>
                </div>
            </div>
            <!-- END MARKERS PORTLET-->
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <!-- BEGIN MARKERS PORTLET-->
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-blue"></i>
                        <span class="caption-subject font-blue bold uppercase">Satisfacción Comercial</span>
                    </div>
                    <div class="actions">
                        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;" onclick="alert('Satisfacción Comercial')">
                            <i class="fa fa-external-link"></i>
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <iframe src="" frameborder="0" ></iframe>
                </div>
            </div>
            <!-- END MARKERS PORTLET-->
        </div>
    </div>
    <div class="clearfix"></div>
@endsection

@section('scripts')
   <!--<script src="http://maps.google.com/maps/api/js?key=AIzaSyBZ6ooejXK15F5o-1J-PLjf7EZUG4OliKY&sensor=false" type="text/javascript"></script>
    <script src="{{ URL::to('assets/global/plugins/gmaps/gmaps.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('assets/pages/scripts/maps-google.min.js') }}" type="text/javascript"></script>-->
@endsection

@section('script-body')
    <script>
        function verMapa(cnd){
            var strWindowFeatures = "location=no, menubar=no, titlebar=no, resizable=yes, toolbar=no, menubar=no, width="+$( window ).width()+", height="+$( window ).height();

            var url = (cnd == 'Industrias')? "{!! route('sistema.panelIndustria') !!}" : (cnd == 'Comercios')? "{!! route('sistema.panelComercio') !!}" : "{!! route('sistema.panelAmbitos') !!}";

            window.open( url , "Mapa "+cnd, strWindowFeatures);
        }
        $(function(){

        })
    </script>

@endsection



