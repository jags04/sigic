@extends('layouts.master')
@section('title')
    .:: USUARIOS ::.
@endsection

@section('styles')
    <link href="{{ URL::to('assets/global/plugins/formstone/dist/css/upload.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::to('assets/global/plugins/formstone/dist/css/themes/light/upload.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('breadcrumb')
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ URL::to('/') }}">Inicio</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Usuarios</span>
        </li>
    </ul>
    <!--<div class="page-toolbar">
            <button type="button" class="btn blue btn-sm btn-outline fa fa-plus" title="agregar"></button>
    </div>-->
@endsection

@section('page-title')
    Usuarios
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
                    <table class="table table-striped table-hover" id="dt_usuarios" data-lenguaje="{{ URL::to('assets/global/plugins/datatables/spanish.json') }}" data-urldata="{!! route('sistema.usuarios.data') !!}">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Telf</th>
                            <th>Usuario</th>
                            <th>Rol</th>
                            <th>Activo</th>
                            <th>&nbsp;</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Telf</th>
                            <th>Usuario</th>
                            <th>Rol</th>
                            <th>Activo</th>
                            <th>&nbsp;</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addUsuarios" tabindex="-1" role="dialog" aria-hidden="true">
        <form id="fAddUsu" action="#" data-accion="{{ route('sistema.usuarios.add') }}">
            {{ csrf_field() }}

        <div class="modal-dialog modal-full">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="portlet light portlet-fit">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-green bold uppercase">Agregar usuario</span>
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
                                        <label for="nombre">Nombre<span class="required" aria-required="true">*</span></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group form-md-line-input has-success">
                                        <input type="text" class="form-control" id="email" name="email" data-rule-email="true" required>
                                        <label for="email">Email<span class="required" aria-required="true">*</span></label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-md-line-input has-success">
                                        <input type="text" class="form-control" id="telefono" name="telefono" required data-inputmask="'mask': '9999-9999999'" data-rule-telfv="true">
                                        <label for="telefono">Teléfono<span class="required" aria-required="true">*</span></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group form-md-line-input has-success">
                                        <input type="text" class="form-control" id="user" name="user" data-rule-remote="{{ route('sistema.usuarios.checkUser') }}" data-msg-remote="Este nombre de usuario ya esta registrado"  required>
                                        <label for="user">Usuario (Colocar el RIF si es una empresa en MAYUSCULA)<span class="required" aria-required="true">*</span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group form-md-line-input has-success">
                                        <select class="form-control" id="rol" name="rol" required >
                                            <option value=""></option>
                                            @foreach($rol as $r)
                                                <option value="{{ $r->id_acceso }}">{{ $r->descripcion }}</option>
                                            @endforeach
                                        </select>
                                        <label for="rol">Rol<span class="required" aria-required="true">*</span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group form-md-line-input has-success">
                                        <select class="form-control" id="status" name="status" required >
                                            <option value=""></option>
                                            <option value="1">Activo</option>
                                            <option value="0">Inactivo</option>
                                        </select>
                                        <label for="status">Estatus<span class="required" aria-required="true">*</span></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group form-md-line-input has-success">
                                        <input type="text" class="form-control" id="empresa" name="empresa"  data-inputmask="'mask': 'R999999999'" data-rule-rif="true">
                                        <label for="empresa">Empresa (Colocar el RIF en MAYUSCULA)</label>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
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


    <div class="modal fade" id="updUsuarios" tabindex="-1" role="dialog" aria-hidden="true">
        <form id="fUpdUsu" action="#" data-accion="{{ route('sistema.usuarios.upd') }}">
            <input type="hidden" name="id_usu" id="id_usu">
            {{ csrf_field() }}
        <div class="modal-dialog modal-full">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="portlet light portlet-fit">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-green bold uppercase">Actualizar usuario (<span id="updNombre"></span>)</span>
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
                                        <label for="nombre2">Nombre<span class="required" aria-required="true">*</span></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group form-md-line-input has-success">
                                        <input type="text" class="form-control" id="email2" name="email" data-rule-email="true" required>
                                        <label for="email2">Email<span class="required" aria-required="true">*</span></label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-md-line-input has-success">
                                        <input type="text" class="form-control" id="telefono2" name="telefono" required data-inputmask="'mask': '9999-9999999'" data-rule-telfv="true">
                                        <label for="telefono2">Teléfono<span class="required" aria-required="true">*</span></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group form-md-line-input has-success">
                                        <input type="text" class="form-control" id="user2" name="user"  required>
                                        <label for="user2">Usuario (Colocar el RIF si es una empresa en MAYUSCULA)<span class="required" aria-required="true">*</span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group form-md-line-input has-success">
                                        <select class="form-control" id="rol2" name="rol" required >
                                            <option value=""></option>
                                            @foreach($rol as $r)
                                                <option value="{{ $r->id_acceso }}">{{ $r->descripcion }}</option>
                                            @endforeach
                                        </select>
                                        <label for="rol2">Rol<span class="required" aria-required="true">*</span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group form-md-line-input has-success">
                                        <select class="form-control" id="status2" name="status" required >
                                            <option value=""></option>
                                            <option value="1">Activo</option>
                                            <option value="0">Inactivo</option>
                                        </select>
                                        <label for="status2">Estatus<span class="required" aria-required="true">*</span></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group form-md-line-input has-success">
                                        <input type="text" class="form-control" id="empresa2" name="empresa"  data-inputmask="'mask': 'R999999999'" data-rule-rif="true">
                                        <label for="empresa2">Empresa (Colocar el RIF en MAYUSCULA)</label>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
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

    <input type="hidden" id="url-find" data-url="{!! route('sistema.usuarios.find') !!}">
    <input type="hidden" id="url-del" data-url="{!! route('sistema.usuarios.del') !!}">
    <input type="hidden" id="url-reset" data-url="{!! route('sistema.usuarios.res') !!}">
    <input type="hidden" id="url-actdes" data-url="{!! route('sistema.usuarios.ades') !!}">

    <!-- END EXAMPLE TABLE PORTLET-->
    <div class="clearfix"></div>
@endsection

@section('scripts')
    <script src="{{ URL::to('assets/global/plugins/formstone/dist/js/core.js') }}" type="text/javascript"></script>
    <!--<script src="{{ URL::to('assets/global/plugins/formstone/dist/js/upload.js') }}" type="text/javascript"></script>-->

@endsection

@section('script-body')
    <script src="{{ URL::to('assets/pages/scripts/usuarios.js') }}" type="text/javascript"></script>
    <script>

    </script>

@endsection