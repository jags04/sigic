<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\URL;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    //
    public function getIndex()
    {
        return view('sistema.logs.index');
    }

    public function getData(Request $request)
    {
        $logs = DB::table('logs')
            ->select('logs.id',
                'logs.usuario',
                'logs.modulo',
                'logs.accion',
                'logs.empresa',
                DB::raw("to_char(logs.fecha, 'DD/MM/YYYY HH24:MI:SS') as fecha"));



        $datatables = Datatables::of($logs)
            ->filterColumn('fecha', function ($query, $keyword) {
                $query->whereRaw("to_char(fecha, 'DD/MM/YYYY HH24:MI:SS') ilike ?", ["%$keyword%"]);
            });

        if ($datatables->request->get('fecha_inicio') && $datatables->request->get('fecha_fin') ) {
            //$datatable->where('solicitudes.fecha', '=', "$name%");
            //$datatables->whereBetween('logs.fecha', [ $datatables->request->get('fecha_inicio').' 00:00:00', $datatables->request->get('fecha_fin').' 23:59:59' ]);
            $datatables->whereBetween(DB::raw("CAST(logs.fecha AS date)"), [ $datatables->request->get('fecha_inicio'), $datatables->request->get('fecha_fin')]);

        }

        return $datatables->make(true);
    }

    public function getReporteIndustria(Request $request)
    {
        if($request->cnd == 'ESTADO'){
            $logs = DB::table('logs')
                ->join('empresas', 'empresas.rif', '=', 'logs.empresa')
                ->select(
                    DB::raw("count(DISTINCT logs.empresa) as cant"),
                    'empresas.estado as descripcion'
                )
                ->where([['logs.modulo', '=', 'EMPRESAS'],['logs.accion', '=', 'ACTUALIZAR']])
                ->whereBetween('logs.fecha', [$request->f_ini.' 00:00:00' , $request->f_fin.' 23:59:59'])
                ->groupBy('empresas.estado')
                ->orderBy('cant', 'desc');
        }
        else{
            $logs = DB::table('logs')
                ->join('users', 'users.user', '=', 'logs.usuario')
                ->select(
                    DB::raw("count(DISTINCT logs.empresa) as cant"),
                    'logs.usuario as descripcion'
                )
                ->where([
                    ['logs.modulo', '=', 'EMPRESAS'],
                    ['logs.accion', '=', 'ACTUALIZAR']
                ])
                ->whereRaw("(users.rol = 4 or users.rol = 2)")
                ->whereBetween('logs.fecha', [$request->f_ini.' 00:00:00' , $request->f_fin.' 23:59:59'])
                ->groupBy('logs.usuario')
                ->orderBy('cant', 'desc');
        }



        return Datatables::of($logs)->make(true);
    }

    public function getReporteComercio(Request $request)
    {
        if($request->cnd == 'ESTADO'){
            $logs = DB::table('logs')
                ->join('comercios', 'comercios.rif', '=', 'logs.empresa')
                ->select(
                    DB::raw("count(DISTINCT logs.empresa) as cant"),
                    'comercios.estado as descripcion'
                )
                ->where([['logs.accion', 'ilike', DB::raw("concat('%', comercios.rsocial)")],['logs.modulo', '=', 'COMERCIOS'],['logs.accion', 'ilike', '%ACTUALIZAR%']])
                ->whereBetween('logs.fecha', [$request->f_ini.' 00:00:00' , $request->f_fin.' 23:59:59'])
                ->groupBy('comercios.estado')
                ->orderBy('cant', 'desc');

        }
        else{
            $logs = DB::table('logs')
                ->join('users', 'users.user', '=', 'logs.usuario')
                ->join('comercios', 'comercios.rif', '=', 'logs.empresa')
                ->select(
                    DB::raw("count(DISTINCT logs.empresa) as cant"),
                    'logs.usuario as descripcion'
                )
                ->where([['logs.accion', 'ilike', DB::raw("concat('%', comercios.rsocial)")],['logs.modulo', '=', 'COMERCIOS'],['logs.accion', 'ilike', '%ACTUALIZAR%']])
                ->whereRaw("(users.rol = 4 or users.rol = 2)")
                ->whereBetween('logs.fecha', [$request->f_ini.' 00:00:00' , $request->f_fin.' 23:59:59'])
                ->groupBy('logs.usuario')
                ->orderBy('cant', 'desc');
        }



        return Datatables::of($logs)->make(true);
    }

}
