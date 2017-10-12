<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\URL;
//use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Session;
use Exception;


use App\Empresa;
use App\Comercio;
use App\User;

class IndexController extends Controller
{
    //
    public function getIndex()
    {
        if(Auth::user()->vez_p == 0){
            $user_id = Auth::user()->id;
            return view('sistema.login.primerCambioClave', compact('user_id'));
        }
        else{
            $comercios = DB::table('comercios')->count();
            $emp_sol = DB::table('empresas')->where('status', '=', 'NO TIENE DEUDA')->count();
            $emp_nsol = DB::table('empresas')->where('status', '=', 'TIENE DEUDA')->count();
            $prod = DB::table('planta_info_comp')->join('plantas', 'planta_info_comp.planta_id', '=', 'plantas.id')
                ->select(DB::raw("avg(planta_info_comp.coperativa) as produccion"))
                //->where("plantas.fespecifica", "ilike", "%PRODUCC%")
                ->get();
            return view('sistema.index',compact('comercios','emp_sol','emp_nsol', 'prod'));
        }

    }

    public function getLogin()
    {
        return view('sistema.login.index');
    }

    public function postLogin(Request $request)
    {
        try{
            if(!empty($request['g-recaptcha-response'])){
                if(!Auth::attempt(['user' => $request->user, 'password' => $request->password, 'status' => 1 ])){
                    return response()->json(array(
                        'status' => '0',
                        'msg' => 'Error, no se pudo validar sus datos o el usuario esta inactivo',
                    ));
                }
                else{
                    UtilidadesController::setLog($request->user, 'ACCESO',$request->ip() );
                    return response()->json(array('status' => '1'));
                }
            }
            else{
                return response()->json(array(
                    'status' => '0',
                    'msg' => 'Hubo un problema!!!<br>Intente de nuevo el acceso',
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

    public function getLogout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('sistema.acceso');
    }

    public function cambiarClave(Request $request)
    {
        try{
            $usuario = User::find($request['user_id']);
            $usuario->password    =bcrypt($request['clave']);
            $usuario->vez_p   = 1;

            $usuario->update();
            //UtilidadesController::setLog(Auth::user()->user, 'CAMBIO DE CLAVE','CORRECTO' );
            return response()->json(array(
                'status' => 1,
                'msg' => 'Clave cambiada',
            ));

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
