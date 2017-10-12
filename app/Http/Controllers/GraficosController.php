<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\URL;
//use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;

use App\Produccion;

class GraficosController extends Controller
{
    //
    public static function getDataProduccion(Request $request)
    {
        $result = array();
        $des = array();
        $ttlo ='';
        $cnd = '';
        $data = DB::table('produccion')
            ->join('empresas', 'empresas.rif', '=', 'produccion.rif')
            ->select(
                DB::raw('upper(rsocial) as rsocial'),
                'produccion.rif',
                DB::raw("date_part('year', fecha) as anio"),
                DB::raw("sum(produccion) as produccion ")
            )
            ->where('produccion.rif', $request->rif)
            ->groupBy('rsocial', 'produccion.rif', 'fecha')
            ->orderBy('fecha', 'asc')->get();

        $len = count($data);

        if($len != 0){
            $color = UtilidadesController::rnd_color('l');
            foreach($data as $d ){
                $cat[] = $d->anio;
                $des[] = '{ "tipo": "'.$d->anio.'", "cantidad": '.round($d->produccion, 2).', "color": "'.$color.'" }';
            }

            array_push($result,
                ['des' => $des],
                ['titulo' => $data[0]->rsocial],
                ['ttlo' => 'Produccion Anual' ]
            );
            return view('sistema.graficos.produccion', compact('result'));
        }
        else{
            return view('sistema.errors.404');
        }

    }

    public static function getDataAsignacion(Request $request)
    {
        $result = array();
        $des = array();
        $ttlo ='';
        $cnd = '';
        $data = DB::select(DB::raw(UtilidadesController::generarQueryAsignacionHistorico($request->rif)));

        $len = count($data);

        //dd($data);

        if($len != 0){
            $color = UtilidadesController::rnd_color('l');
            foreach($data as $d ){
                $cat[] = $d->anio;
                $des[] = '{ "tipo": "'.$d->anio.'", "cantidad": '.round($d->asignacion, 2).', "color": "'.$color.'" }';
            }

            array_push($result,
                ['des' => $des],
                ['titulo' => $data[0]->rsocial],
                ['ttlo' => 'Asignación Anual' ]
            );
            return view('sistema.graficos.produccion', compact('result'));
        }
        else{
            return view('sistema.errors.404');
        }

    }



    public static function getDataProduccionAsignacionAnual(Request $request)
    {
        $result = array();
        $des = array();
        $ttlo ='';
        $cnd = '';

        $dproduccion = DB::table('produccion')->select("rif", DB::raw("date_part('year', fecha) as anio"))->where('rif', $request->rif )->orderBy('anio', 'asc')->get();

        if(count($dproduccion) != 0){
            $query = UtilidadesController::generarQueryProduccionAsignacion($dproduccion);
            $data = DB::select( DB::raw($query));

            $color = UtilidadesController::rnd_color('l');
            $color2 = UtilidadesController::rnd_color('l');

            foreach($data as $d ){
                $cat[] = $d->anio;
                //$data = $d->produccion ;
                //$des[] = "{ 'name' : '".$cat."', 'y' : ".$data.", 'color' : '".UtilidadesController::rnd_color('d')."', 'pulled' : true }{ "tipo": "'.$d->ano.'", "cantidad": '.$d->produccion.', "color": "'.$color.'" }";
                $des[] = '{ "anio": '.$d->anio.',"produccion": '.round($d->produccion, 2).',"asignacion": '.round($d->asignacion, 2).', "color": "'.$color.'" , "color2": "'.$color2.'"  }';
            }

            array_push($result,
                ['des' => $des],
                ['titulo' => $data[0]->rsocial],
                ['color' => UtilidadesController::rnd_color() ],
                ['color' => UtilidadesController::rnd_color() ],
                ['cnd' => $request->cnd ]
            );
            return view('sistema.graficos.prodAsigAnual', compact('result'));
        }
        else{
            return view('sistema.errors.404');
        }

    }

}
