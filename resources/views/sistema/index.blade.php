@extends('layouts.master')
@section('title')
    .:: SIGIC ::.
@endsection

@section('styles')
    <style>
        iframe{
            width: 100%;
            height: 35vh;
        }
    </style>
@endsection

@section('breadcrumb')
    <ul class="page-breadcrumb">
        <li>
            <a href="index.html">Inicio</a>
        </li>
    </ul>
@endsection

@section('page-title')
    SIGIC
    <small>(Sistema de Información Geográfica de Industria y Comercio)</small>
@endsection

@section('content')
    <!-- BEGIN DASHBOARD STATS 1-->
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                <div class="visual">
                    <i class="fa fa-check"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $emp_sol }}">0</span>
                    </div>
                    <div class="desc"> Empresas solventes </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                <div class="visual">
                    <i class="fa fa-times"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $emp_nsol }}">0</span>
                    </div>
                    <div class="desc"> Empresas no solventes </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                <div class="visual">
                    <i class="fa fa-shopping-cart"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="{{ $comercios }}">0</span>
                    </div>
                    <div class="desc"> Comercios (Data SIGRUD)</div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
                <div class="visual">
                    <i class="fa fa-gears"></i>
                </div>
                <div class="details">
                    <div class="number"><span data-counter="counterup" data-value="{{ round($prod[0]->produccion, 2) }}"></span>% </div>
                    <div class="desc"> % productividad empresas </div>
                </div>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <!-- BEGIN BASIC PORTLET-->
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=" icon-layers font-red"></i>
                        <span class="caption-subject font-red bold uppercase">Industrias</span>
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

                </div>
                <div class="portlet-body">
                    <iframe src="{{ route('sistema.mapasComercio') }}" frameborder="0" ></iframe>
                </div>
            </div>
            <!-- END MARKERS PORTLET-->
        </div>
    </div>
    <div class="clearfix"></div>
    <!-- END DASHBOARD STATS 1-->
@endsection

@section('scripts')
    <script src="{{ URL::to('assets/global/plugins/counterup/jquery.waypoints.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('assets/global/plugins/counterup/jquery.counterup.min.js') }}" type="text/javascript"></script>
@endsection