<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\User;
use App\Rol;

class UserController extends Controller
{
    //
    public function getIndex()
    {
        $rol = DB::table('roles')->select('id_acceso', 'descripcion')->orderBy('id', 'asc')->get();
        return view('sistema.usuarios.index', compact( 'rol'));
    }

    public function getData(Request $request)
    {
        $usuarios = DB::table('users')
            ->join('roles', 'users.rol', '=', 'roles.id_acceso')
            ->select('users.id',
                'users.nombre',
                'users.email',
                'users.telefono',
                'users.user',
                'roles.descripcion AS nrol',
                'users.status');

        $datatables = Datatables::of($usuarios)
            ->addColumn('accion', function ($usuario) {

                $btn = '';
                $btn .= '<a href="javascript:void(0);" class="btn btn-no-border yellow btn-sm btn-outline" onclick="findUpdateUsu('.$usuario->id.')" title="Actualizar"><i class="fa fa-edit fa-lg"></i></a> ';
                $btn .= '<a href="javascript:void(0);" class="btn btn-no-border red btn-sm btn-outline" onclick="deleteUsu('.$usuario->id.')" title="Eliminar"><i class="fa fa-trash-o fa-lg"></i></a> ';
                $btn .= '<a href="javascript:void(0);" class="btn btn-no-border purple btn-sm btn-outline" onclick="resetClaveUsu('.$usuario->id.')" title="Resetear clave"><i class="fa fa-refresh fa-lg"></i></a> ';

                if($usuario->status == 0){
                    $btn .= '<a href="javascript:void(0);" class="btn btn-no-border green-meadow btn-sm btn-outline" onclick="actDesUsu('.$usuario->id.')" title="Activar"><i class="fa fa-check-square-o fa-lg"></i></a> ';
                }
                else{
                    $btn .= '<a href="javascript:void(0);" class="btn btn-no-border green-meadow btn-sm btn-outline" onclick="actDesUsu('.$usuario->id.')" title="Desactivar"><i class="fa fa-square-o fa-lg"></i></a>';
                }

                return  $btn;

            })
            ->editColumn('status', function ($usuario) {
                if(!empty($usuario->status == 1)){
                    return 'SI';
                }
                else{
                    return 'NO';
                }
            })
            ->rawColumns(['accion','activo']);



        return $datatables->make(true);
    }

    public function agregarUsuario(Request $request)
    {
        try{
            $usuario = new User();
            $usuario->nombre       = mb_strtoupper($request->nombre);
            $usuario->email        = mb_strtoupper($request->email);
            $usuario->telefono     = mb_strtoupper($request->telefono);
            $usuario->rol          = mb_strtoupper($request->rol);
            $usuario->status       = mb_strtoupper($request->status);
            $usuario->cnd          = '';
            $usuario->empresa      = mb_strtoupper($request->rif);
            $usuario->password     = bcrypt('123456');
            if($request->rol == 30) {
                $usuario->user = trim(mb_strtolower(str_replace('-', '', $request->empresa)));
            }
            else{
                $usuario->user = trim(mb_strtolower($request->user));
            }
            /*
                if (preg_match("/[JGVEC][-][0-9]{8}[-][0-9]$/i", )) {
                    echo "Se encontró una coincidencia.";
                } else {
                    echo "No se encontró ninguna coincidencia.";
                }

            }*/


            if($usuario->save()){
                UtilidadesController::setLog(Auth::user()->user, 'USUARIOS', 'AGREGAR - '.trim(mb_strtolower($request->user)));
                return response()->json(array(
                    'status' => 1,
                    'msg' => 'Registro agregado',
                ));
            }
        }
        catch (QueryException $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => /*$e->getCode().'-'.$e->getMessage()*/UtilidadesController::errorPostgres($e->getCode())
                ));
            }
        }
        catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }

    }

    public function buscarUsuario(Request $request)
    {
        if($request->ajax()) {
            $usuario = DB::table('users')
                ->join('roles', 'users.rol', '=', 'roles.id_acceso')
                ->select('users.id',
                    'users.nombre',
                    'users.email',
                    'users.telefono',
                    'users.user',
                    'users.rol',
                    'users.empresa',
                    'roles.descripcion AS nrol',
                    'users.status')
                ->where('users.id', '=', $request->id)->get();
            return response()->json($usuario);
        }
    }

    public function actualizarUsuario(Request $request)
    {
        try{
            $usuario = User::find($request->id_usu);

            $usuario->nombre       = mb_strtoupper($request->nombre);
            $usuario->email        = mb_strtoupper($request->email);
            $usuario->telefono     = mb_strtoupper($request->telefono);
            $usuario->rol          = mb_strtoupper($request->rol);
            $usuario->status       = mb_strtoupper($request->status);
            $usuario->empresa      = mb_strtoupper($request->rif);


            if($request->rol == 30) {
                $usuario->user = trim(mb_strtolower(str_replace('-', '', $request->empresa)));
            }
            else{
                $usuario->user = trim(mb_strtolower($request->user));
            }


            if($usuario->update()){
                UtilidadesController::setLog(Auth::user()->user, 'USUARIOS', 'ACTUALIZAR - '.trim(mb_strtolower($request->user)));
                return response()->json(array(
                    'status' => 1,
                    'msg' => 'Registro actualizado',
                ));
            }
        }
        catch (QueryException $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => UtilidadesController::errorPostgres($e->getCode())
                ));
            }
        }
        catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }


    }

    public function resetClaveUsuario(Request $request)
    {
        try{
            $user = DB::table('users')->select('user')->where('id', $request->id)->first();
            $usuario = User::find($request->id);

            $usuario->password    = bcrypt('123456');
            $usuario->vez_p = 0;


            if($usuario->update()){
                UtilidadesController::setLog(Auth::user()->user, 'USUARIOS', 'RESET CLAVE - '.$user->user);
                return response()->json(array(
                    'status' => 1,
                    'msg' => 'Registro actualizado',
                ));
            }
        }
        catch (QueryException $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => UtilidadesController::errorPostgres($e->getCode())
                ));
            }
        }
        catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }

    }

    public function eliminarUsuario(Request $request)
    {
        try{
            if($request->ajax()) {
                $user = DB::table('users')->select('user')->where('id', $request->id)->first();
                $deletedRows = User::where('id', $request->id )->delete();
                if ($deletedRows == 1) {
                    UtilidadesController::setLog(Auth::user()->user, 'USUARIOS', 'ELIMINAR - '.$user->user);
                    return response()->json(array(
                        'status' => 1,
                        'msg' => 'Registro eliminado',
                    ));
                } else {
                    return response()->json(array(
                        'status' => 0,
                        'msg' => 'No se pudo eliminar el registro',
                    ));
                }
            }
        }
        catch (QueryException $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => UtilidadesController::errorPostgres($e->getCode())
                ));
            }
        }
        catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }

    }

    public function activarDesactivarUsuario(Request $request)
    {
        try{
            if($request->ajax()) {
                $user = DB::table('users')->select('user')->where('id', $request->id)->first();
                $usuario = User::where('id',$request->id)->first();
                if($usuario->status == 0 ){
                    $usuario->status = 1;
                }
                else{
                    $usuario->status = 0;
                }

                if($usuario->update()){
                    UtilidadesController::setLog(Auth::user()->user, 'USUARIOS', 'ACTIVAR-DESACTIVAR - '.$user->user);

                    return response()->json(array(
                        'status' => 1,
                        'msg' => 'Registro actualizado',
                    ));
                }
                else{
                    return response()->json(array(
                        'status' => 0,
                        'msg' => 'No se pudo actualizar el registro',
                    ));
                }

            }
        }
        catch (QueryException $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => UtilidadesController::errorPostgres($e->getCode())
                ));
            }
        }
        catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }

    }


    public function comprobarUsuario(Request $request)
    {
        try{
            $usuario = User::where('user', $request->user)->count();
            if($usuario == 0){
                return 'true';
            }
            else{
                return 'false';
            }
        }
        catch (QueryException $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => UtilidadesController::errorPostgres($e->getCode())
                ));
            }
        }
        catch (Exception $e) {
            if ($request->ajax()) {
                return response()->json(array(
                    'status' => 0,
                    'msg' => $e->getCode().'-'.$e->getMessage()
                ));
            }
        }

    }


}
