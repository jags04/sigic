<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\URL;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

use App\Estado;
use App\Comercio;

class ComerciosController extends Controller
{
    //
    public function getIndex()
    {
        $estado = Estado::orderBy('nombre', 'asc')->get();
        return view('sistema.comercios.index', compact('estado'));
    }

    public function getData(Request $request)
    {
        $comercios = DB::table('comercios')
            ->select(
                "comercios.id",
                "comercios.rif",
                "comercios.rsocial",
                "comercios.estado",
                "comercios.municipio",
                "comercios.parroquia",
                "comercios.direccion",
                "comercios.telf",
                "comercios.latitud",
                "comercios.longitud",
                DB::raw("'dist' as dist")
            );

        $data = Datatables::of($comercios)
            ->addColumn('accion', function ($com) {

                $btn = '';
                if(Auth::user()->rol != 6 ) {
                    $btn .= '<a href="javascript:void(0);" class="btn btn-no-border yellow btn-sm btn-outline" onclick="findUpdateCom('.$com->id.')" title="Actualizar"><i class="fa fa-edit fa-lg"></i></a> ';
                    if(Auth::user()->rol == 10 || Auth::user()->rol == 1){
                        $btn .='<a href="javascript:void(0);" class="btn btn-no-border red btn-sm btn-outline" onclick="deleteCom('.$com->id.')" title="Eliminar"><i class="fa fa-trash-o fa-lg"></i></a> ';
                    }
                    /*$btn .= '<a href="javascript:void(0);" class="btn btn-no-border purple btn-sm btn-outline" onclick="uploadProduccion(\''.$com->rif.'\')" title="Cargar producción"><i class="fa fa-upload fa-lg"></i></a> ';*/
                }
                $btn .='<a href="javascript:void(0);" class="btn btn-no-border green btn-sm btn-outline" onclick="viewCom('.$com->id.')" title="Detalle"><i class="fa fa-eye fa-lg"></i></a>';

                return  $btn;
            })
            ->rawColumns(['dist','accion']);

        return  $data->make(true);

    }

    public function agregarComercio(Request $request)
    {
        try{
            $comercio = new Comercio();

            $comercio->rif = mb_strtoupper($request->rif);
            $comercio->rsocial = mb_strtoupper($request->rsocial);
            $comercio->estado = mb_strtoupper($request->estado);
            $comercio->municipio = mb_strtoupper($request->municipio);
            $comercio->parroquia = mb_strtoupper($request->parroquia);
            $comercio->direccion = mb_strtoupper($request->direccion);
            $comercio->telf = mb_strtoupper(implode(';', $request->telefonos));
            if($request->coordenadas != ''){
                $coord = explode(',', $request->coordenadas);
                $comercio->latitud = mb_strtoupper($coord[1]);
                $comercio->longitud = mb_strtoupper($coord[0]);
            }

            if($comercio->save()){
                UtilidadesController::setLog(Auth::user()->user, 'COMERCIOS', 'AGREGAR - '.mb_strtoupper($request->rsocial), $request->rif);
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

    public function buscarComercio(Request $request)
    {
        if($request->ajax()) {
            $comercios = DB::table('comercios')
                /*->join('estados', 'comercios.edo', '=', 'estados.id')
                ->join('municipios', 'comercios.mcpio', '=', 'municipios.id')
                ->join('parroquias', 'comercios.pquia', '=', 'parroquias.id')
                ->join('users', 'comercios.usuario', '=', 'users.id')*/
                ->select(
                    "comercios.id",
                    "comercios.rif",
                    "comercios.rsocial",
                    "comercios.estado",
                    "comercios.municipio",
                    "comercios.parroquia",
                    "comercios.direccion",
                    "comercios.telf",
                    DB::raw("concat(comercios.longitud,',',comercios.latitud) as coordenadas")
                )
                ->where('comercios.id', '=', $request->id)->get();
            return response()->json($comercios);
        }
    }

    public function actualizarComercio(Request $request)
    {
        try{
            $comercio = Comercio::find($request->id_com);

            $comercio->rif = mb_strtoupper($request->rif);
            $comercio->rsocial = mb_strtoupper($request->rsocial);
            $comercio->estado = mb_strtoupper($request->estado);
            $comercio->municipio = mb_strtoupper($request->municipio);
            $comercio->parroquia = mb_strtoupper($request->parroquia);
            $comercio->direccion = mb_strtoupper($request->direccion);
            $comercio->telf = mb_strtoupper(implode(';', $request->telefonos));
            if($request->coordenadas != ''){
                $coord = explode(',', $request->coordenadas);
                $comercio->latitud = mb_strtoupper($coord[1]);
                $comercio->longitud = mb_strtoupper($coord[0]);
            }

            if($comercio->update()){
                UtilidadesController::setLog(Auth::user()->user, 'COMERCIOS', 'ACTUALIZAR - '.mb_strtoupper($request->rsocial), $request->rif );
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
                    'msg' => $e->getCode().'-'.$e->getMessage()/*UtilidadesController::errorPostgres($e->getCode())*/
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

    public function eliminarComercio(Request $request)
    {
        if($request->ajax()) {
            try{
                $rif_emp = DB::table('comercios')->select('rsocial')->where('id', $request->id )->first();
                $deletedRows = Comercio::where('id', $request->id )->delete();
                if ($deletedRows == 1) {
                    UtilidadesController::setLog(Auth::user()->user, 'COMERCIOS', 'ELIMINAR - '.$rif_emp->rsocial);
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

    public function verComercio(Request $request)
    {
        if($request->ajax()) {

            $comercios = DB::table('comercios')
                /*->join('estados', 'comercios.edo', '=', 'estados.id')
                ->join('municipios', 'comercios.mcpio', '=', 'municipios.id')
                ->join('parroquias', 'comercios.pquia', '=', 'parroquias.id')
                ->join('users', 'comercios.usuario', '=', 'users.id')*/
                ->select(
                    "comercios.id",
                    "comercios.rif",
                    "comercios.rsocial",
                    "comercios.estado",
                    "comercios.municipio",
                    "comercios.parroquia",
                    "comercios.direccion",
                    "comercios.telf",
                    DB::raw("concat(comercios.longitud,',',comercios.latitud) as coordenadas")
                )
                ->where('comercios.id', '=', $request->id)->get();

            return response()->json($comercios);

        }
    }
}
