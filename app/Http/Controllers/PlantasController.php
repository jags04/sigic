<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\URL;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

use League\Csv\Reader;
use PDF;
use Image;

use App\Http\Controllers\UtilidadesController;
use App\Estado;
use App\Planta;
use App\InfoComplemantaria;

class PlantasController extends Controller
{
    //
    public function getIndex()
    {
        $estado = Estado::orderBy('nombre', 'asc')->get();
        $ssciiu = DB::table('ciiu_seccion')->orderBy('sec', 'asc')->get();
        $motores = DB::table('clasificacion_emp')->select('motor')->groupBy('motor')->orderBy('motor', 'asc')->get();
        return view('sistema.plantas.index', compact('estado', 'ssciiu', 'motores'));
    }

    public function getData(Request $request)
    {
        $plantas = DB::table('plantas')
            ->join('empresas', 'empresas.rif', '=', 'plantas.emp_rif')
            /*->join('municipios', 'empresas.mcpio', '=', 'municipios.id')
            ->join('parroquias', 'empresas.pquia', '=', 'parroquias.id')
            ->join('users', 'empresas.usuario', '=', 'users.id')*/
            ->select(
                "plantas.id",
                "empresas.rif",
                "empresas.rsocial",
                "plantas.estado",
                "plantas.municipio",
                "plantas.parroquia",
                "plantas.direccion",
                "plantas.status",
                "plantas.fespecifica",
                "plantas.telf",
                "plantas.ambito",
                "plantas.latitud",
                "plantas.longitud",
                DB::raw("(select count(*) from planta_info_comp where planta_id = plantas.id) as visita"),
                DB::raw("(select foto from planta_info_comp where planta_id = plantas.id order by fecha desc  limit 1 offset 0) as foto"));

        return Datatables::of($plantas)
            ->editColumn('rif', function ($plan) {
                $ver = '';
                if($plan->visita > 0){
                    $ver = '<span class="text-info"><strong>'.$plan->rif.'</strong></span>';
                }
                else{
                    $ver = $plan->rif;
                }
                return $ver;
            })
            ->addColumn('accion', function ($pla) {
                $btn = '';
                if(Auth::user()->rol != 6 ) {
                    $btn .= '<a href="javascript:void(0);" class="btn btn-no-border yellow btn-sm btn-outline" onclick="findUpdatePlan('.$pla->id.')" title="Actualizar"><i class="fa fa-edit fa-lg"></i></a> ';
                    if(Auth::user()->rol == 10 || Auth::user()->rol == 1){
                        $btn .='<a href="javascript:void(0);" class="btn btn-no-border red btn-sm btn-outline" onclick="deletePlan('.$pla->id.')" title="Eliminar"><i class="fa fa-trash-o fa-lg"></i></a> ';
                    }
                 }
                $btn .='<a href="javascript:void(0);" class="btn btn-no-border green btn-sm btn-outline" onclick="viewPlan('.$pla->id.')" title="Detalle"><i class="fa fa-eye fa-lg"></i></a>';

                $bag = '';
                if($pla->visita != 0){
                    if(empty($pla->foto)){
                        $bag = '<span class="badge badge-danger"> NO </span>';
                    }
                    else{
                        $bag = '<span class="badge badge-success"> SI </span>';
                    }
                }
                $btn .='<a href="javascript:void(0);" class="btn btn-no-border purple btn-sm btn-outline" onclick="infoPlan('.$pla->id.')" title="Agregar información complementaria"><i class="fa fa-list-ol fa-lg"></i></a>   '.$bag;

                return  $btn;
            })
            /*->filterColumn('fecha', function ($query, $keyword) {
                $query->whereRaw("to_char(fecha, 'DD/MM/YYYY') ilike ?", ["%$keyword%"]);
            })*/
            ->rawColumns(['rif','accion'])
            ->make(true);

    }

    public function agregarPlanta(Request $request)
    {
        try{
            $planta = new Planta();

            $planta->estado = mb_strtoupper($request->estado, 'UTF-8');
            $planta->municipio = mb_strtoupper($request->municipio, 'UTF-8');
            $planta->parroquia= mb_strtoupper($request->parroquia, 'UTF-8');
            $planta->direccion= mb_strtoupper($request->direccion, 'UTF-8');
            $planta->status= mb_strtoupper($request->status, 'UTF-8');
            $planta->fespecifica= mb_strtoupper($request->fespecifica, 'UTF-8');
            $planta->telf= mb_strtoupper($request->telf, 'UTF-8');
            $planta->ambito= mb_strtoupper($request->ambito, 'UTF-8');
            if($request->coordenadas != ''){
                $coord = explode(',', $request->coordenadas);
                $planta->latitud = mb_strtoupper($coord[1]);
                $planta->longitud = mb_strtoupper($coord[0]);
            }
            $planta->emp_rif = mb_strtoupper($request->emp_rif, 'UTF-8');

            if($planta->save()){
                UtilidadesController::setLog(Auth::user()->user, 'PLANTAS', 'AGREGAR', $request->emp_rif);
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

    public function buscarPlanta(Request $request)
    {
        if($request->ajax()) {
            $plantas = DB::table('plantas')
                ->join('empresas', 'empresas.rif', '=', 'plantas.emp_rif')
                /*->join('municipios', 'empresas.mcpio', '=', 'municipios.id')
                ->join('parroquias', 'empresas.pquia', '=', 'parroquias.id')
                ->join('users', 'empresas.usuario', '=', 'users.id')*/
                ->select(
                    "plantas.id",
                    "empresas.rif",
                    "empresas.rsocial",
                    "plantas.estado",
                    "plantas.municipio",
                    "plantas.parroquia",
                    "plantas.direccion",
                    "plantas.status",
                    "plantas.fespecifica",
                    "plantas.telf",
                    "plantas.ambito",
                    DB::raw("concat(plantas.longitud,',',plantas.latitud) as coordenadas"))
                ->where('plantas.id', '=', $request->id)->get();
            return response()->json($plantas);
        }
    }

    public function actualizarPlanta(Request $request)
    {
        try{
            $planta = Planta::find($request->id);

            $planta->estado = mb_strtoupper($request->estado, 'UTF-8');
            $planta->municipio = mb_strtoupper($request->municipio, 'UTF-8');
            $planta->parroquia= mb_strtoupper($request->parroquia, 'UTF-8');
            $planta->direccion= mb_strtoupper($request->direccion, 'UTF-8');
            $planta->status= mb_strtoupper($request->status, 'UTF-8');
            $planta->fespecifica= mb_strtoupper($request->fespecifica, 'UTF-8');
            $planta->telf= mb_strtoupper($request->telf, 'UTF-8');
            $planta->ambito= mb_strtoupper($request->ambito, 'UTF-8');
            if($request->coordenadas != ''){
                $coord = explode(',', $request->coordenadas);
                $planta->latitud = mb_strtoupper($coord[1]);
                $planta->longitud = mb_strtoupper($coord[0]);
            }
            $planta->emp_rif = mb_strtoupper($request->emp_rif, 'UTF-8');


            if($planta->update()){
                UtilidadesController::setLog(Auth::user()->user, 'PLANTA', 'ACTUALIZAR', mb_strtoupper($request->rif));
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

    public function eliminarPlanta(Request $request)
    {
        if($request->ajax()) {
            try{
                $rif_emp = DB::table('plantas')->select('emp_rif')->where('id', $request->id )->first();
                $deletedRows = Planta::where('id', $request->id )->delete();
                if ($deletedRows == 1) {
                    UtilidadesController::setLog(Auth::user()->user, 'PLANTAS', 'ELIMINAR - '.$rif_emp->emp_rif);
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

    public function agregarInfoComplementaria(Request $request)
    {
        try{
            $arr = UtilidadesController::cambiarComasNumeroArray($request->except(['_token']));
            $arr = array_map('strtoupper', $arr );

            if(InfoComplemantaria::create($arr)){
                UtilidadesController::setLog(Auth::user()->user, 'PLANTAS-INFO COMPL', 'AGREGAR - '.$request->planta_id);
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

    public function getDataInfoComplementaria(Request $request)
    {
        if($request->ajax()) {
            $info = $plantas = DB::table('planta_info_comp')
                ->join( 'plantas', 'planta_info_comp.planta_id', '=', 'plantas.id')
                ->join( 'empresas', 'plantas.emp_rif', '=', 'empresas.rif')
                ->select(
                    'empresas.rsocial',
                    'plantas.ambito',
                    'planta_info_comp.id',
                    'planta_info_comp.fecha',
                    'planta_info_comp.mobra',
                    'planta_info_comp.cinstalada',
                    'planta_info_comp.coperativa',
                    'planta_info_comp.produccion',
                    'planta_info_comp.inventario',
                    'planta_info_comp.pprincipal',
                    'planta_info_comp.ncritico',
                    'planta_info_comp.observacion',
                    'planta_info_comp.foto',
                    'planta_info_comp.planta_id')->where('planta_info_comp.planta_id', $request->id)->get();
            $returnHTML = view('sistema.plantas.info', compact('info'))->render();
            return $returnHTML;
        }
    }

    public function eliminarInfoComplementaria(Request $request)
    {
        if($request->ajax()) {
            try{
                $deletedRows = InfoComplemantaria::where('id', $request->id )->delete();
                if ($deletedRows == 1) {
                    UtilidadesController::setLog(Auth::user()->user, 'PLANTAS-INFO COMPL', 'ELIMINAR - '.$request->id);
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

    public function subirFoto(Request $request)
    {
        try{
            //dd($request->all());
            $image = $request->file('file');
            $name = explode('.', $image->getClientOriginalName());
            $input['imagename'] = time().'_'.$name[0].'.'.$image->getClientOriginalExtension();
            //dd($image->getRealPath());
            $destinationPath = public_path().'/imagenes/plantas';

            if($image->move($destinationPath, $input['imagename'])){
                $img = Image::make($destinationPath.'/'.$input['imagename']);
                $img->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                if($img->save($destinationPath.'/'.$input['imagename'],90)){
                    $info = InfoComplemantaria::find($request->id);

                            $info->foto = $input['imagename'];


                    if($info->update()){
                        UtilidadesController::setLog(Auth::user()->user, 'PLANTAS-INFO COMPL FOTO', 'ACTUALIZAR - '.$request->id);
                        return response()->json(array(
                            'status' => 1,
                            'msg' => 'Imagen cargada',
                        ));
                    }
                }
            };

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

    public function eliminarFoto(Request $request)
    {
        if($request->ajax()) {
            try{

                $error = 0;
                        $foto = DB::table('planta_info_comp')->select('foto')->where('id', $request->id)->first();
                        if(unlink(public_path().'/imagenes/plantas/'.$foto->foto)) {
                            $visita = InfoComplemantaria::find($request->id);
                            $visita->foto = '';
                            $visita->update();
                            $error = 0;
                        }
                        else{
                            $error = 1;
                        }


                if($error == 0){
                    return response()->json(array(
                        'status' => 1,
                        'msg' => 'Foto eliminada'
                    ));
                }
                else{
                    return response()->json(array(
                        'status' => 0,
                        'msg' => 'No se pudo eliminar la foto'
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

    public function buscarInfoComplementaria(Request $request)
    {
        $info = DB::table('planta_info_comp')
            /*->join( 'plantas', 'planta_info_comp.planta_id', '=', 'plantas.id')
            ->join( 'empresas', 'plantas.emp_rif', '=', 'empresas.rif')*/
            ->select(
                'planta_info_comp.id',
                'planta_info_comp.fecha',
                'planta_info_comp.mobra',
                'planta_info_comp.cinstalada',
                'planta_info_comp.coperativa',
                'planta_info_comp.produccion',
                'planta_info_comp.inventario',
                'planta_info_comp.pprincipal',
                'planta_info_comp.ncritico',
                'planta_info_comp.observacion',
                'planta_info_comp.planta_id')->where('planta_info_comp.id', $request->id)->get();
        return response()->json($info);

    }

    public function actualizarInfoComplementaria(Request $request)
    {
        try{

            $arr = UtilidadesController::cambiarComasNumeroArray($request->except(['_token', 'id']));
            $arr = array_map('strtoupper', $arr );

            if(InfoComplemantaria::updateOrCreate(['id' => $request->id], $arr)){
                UtilidadesController::setLog(Auth::user()->user, 'PLANTAS-INFO COMPL', 'ACTUALIZAR - '.$request->emp_rif);
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

    public function getIndexReportes(){
        return view('sistema.plantas.reportes');
    }

    public function getPlantasActualizadas(Request $request)
    {
        $plantas = DB::table('planta_info_comp')
            ->join('plantas', 'planta_info_comp.planta_id', '=', 'plantas.id')
            ->join('empresas', 'plantas.emp_rif', '=', 'empresas.rif')
            ->select(
                DB::raw("to_char(planta_info_comp.fecha, 'DD/MM/YYYY') as fecha"),
                "empresas.rif",
                "empresas.rsocial",
                "empresas.sector",
                "empresas.subsector",
                "empresas.rlegal",
                "empresas.ci",
                "empresas.telefonos",
                "plantas.estado",
                "plantas.municipio",
                "plantas.parroquia",
                "plantas.status",
                "plantas.ambito",
                "plantas.telf",
                "planta_info_comp.mobra",
                "planta_info_comp.cinstalada",
                "planta_info_comp.coperativa",
                "planta_info_comp.produccion",
                "planta_info_comp.inventario",
                "planta_info_comp.pprincipal",
                "planta_info_comp.ncritico",
                "planta_info_comp.observacion",
                "planta_info_comp.foto")
                ->whereBetween('planta_info_comp.fecha', [$request->f1, $request->f2]);

        return Datatables::of($plantas)
            ->editColumn('foto', function ($plan) {
                $foto = (empty($plan->foto))? 'NO' : 'SI';
                return $foto;
            })
            ->filterColumn('fecha', function ($query, $keyword) {
                $query->whereRaw("to_char(fecha, 'DD/MM/YYYY') ilike ?", ["%$keyword%"]);
            })
            ->make(true);
    }

    public function getPocentajeProd(Request $request)
    {
        $ambitos = DB::table('planta_info_comp')
            ->join('plantas', 'planta_info_comp.planta_id', '=', 'plantas.id')
            ->select(
                "plantas.estado",
                "plantas.municipio",
                "plantas.parroquia",
                "plantas.ambito",
                DB::raw("avg(planta_info_comp.coperativa) as produccion"))
            //->where("plantas.fespecifica", "ilike", "%PRODUCC%")
            ->whereBetween('planta_info_comp.fecha', [$request->f1, $request->f2])
            ->groupBy('plantas.estado')
            ->groupBy('plantas.municipio')
            ->groupBy('plantas.parroquia')
            ->groupBy('plantas.ambito');

        return Datatables::of($ambitos)
            ->editColumn('produccion', function ($amb) {
                return round($amb->produccion, 2);
            })
           /* ->filterColumn('fecha', function ($query, $keyword) {
                $query->whereRaw("to_char(fecha, 'DD/MM/YYYY') ilike ?", ["%$keyword%"]);
            })*/
            ->make(true);
    }

    public function getPocentajeProdEdo(Request $request)
    {
        $ambitos = DB::table('planta_info_comp')
            ->join('plantas', 'planta_info_comp.planta_id', '=', 'plantas.id')
            ->select(
                "plantas.estado",
                DB::raw("avg(planta_info_comp.coperativa) as produccion"))
            //->where("plantas.fespecifica", "ilike", "%PRODUCC%")
            ->whereBetween('planta_info_comp.fecha', [$request->f1, $request->f2])
            ->groupBy('plantas.estado');

        return Datatables::of($ambitos)
            ->editColumn('produccion', function ($amb) {
                return round($amb->produccion, 2);
            })
            /* ->filterColumn('fecha', function ($query, $keyword) {
                 $query->whereRaw("to_char(fecha, 'DD/MM/YYYY') ilike ?", ["%$keyword%"]);
             })*/
            ->make(true);
    }

    public function getPlantasSegmentacion(Request $request)
    {


        $gran = DB::table('plantas')
            ->join('planta_info_comp', 'planta_info_comp.planta_id', '=', 'plantas.id')
            ->select(
                DB::raw("'3 GRANDE' as descripcion"),
                DB::raw("count(*) as cant"))
            ->where('planta_info_comp.mobra', '>', '100')
            ->whereBetween('planta_info_comp.fecha', [$request->f1, $request->f2])
            ->orderBy('descripcion', 'asc');



        $med = DB::table('plantas')
            ->join('planta_info_comp', 'planta_info_comp.planta_id', '=', 'plantas.id')
            ->select(
                DB::raw("'2 MEDIANA' as descripcion"),
                DB::raw("count(*) as cant"))
            ->where([['planta_info_comp.mobra', '>', '50'],['planta_info_comp.mobra', '<=', '100']])
            ->whereBetween('planta_info_comp.fecha', [$request->f1, $request->f2])
            ->union($gran);


        $peq = DB::table('plantas')
            ->join('planta_info_comp', 'planta_info_comp.planta_id', '=', 'plantas.id')
            ->select(
                DB::raw("'1 PEQUEÑA' as descripcion"),
                DB::raw("count(*) as cant"))
            ->where('planta_info_comp.mobra', '<=', '50')
            ->whereBetween('planta_info_comp.fecha', [$request->f1, $request->f2])
        ->union($med);
        return Datatables::of($peq)
            ->make(true);
    }

    public function getPlantasSegGrafico(Request $request)
    {
        $data = array();

        $gran = DB::table('plantas')
            ->join('planta_info_comp', 'planta_info_comp.planta_id', '=', 'plantas.id')
            ->select(
                DB::raw("'GRANDE' as descripcion"),
                DB::raw("count(*) as cant"))
            ->where('planta_info_comp.mobra', '>', '100')
            ->whereBetween('planta_info_comp.fecha', [$request->f1, $request->f2]);

        $med = DB::table('plantas')
            ->join('planta_info_comp', 'planta_info_comp.planta_id', '=', 'plantas.id')
            ->select(
                DB::raw("'MEDIANA' as descripcion"),
                DB::raw("count(*) as cant"))
            ->where([['planta_info_comp.mobra', '>', '50'],['planta_info_comp.mobra', '<=', '100']])
            ->whereBetween('planta_info_comp.fecha', [$request->f1, $request->f2])
            ->union($gran);

        $peq = DB::table('plantas')
            ->join('planta_info_comp', 'planta_info_comp.planta_id', '=', 'plantas.id')
            ->select(
                DB::raw("'PEQUEÑA' as descripcion"),
                DB::raw("count(*) as cant"))
            ->where('planta_info_comp.mobra', '<=', '50')
            ->whereBetween('planta_info_comp.fecha', [$request->f1, $request->f2])
            ->union($med)
        ->get();

        foreach ($peq as $p){

            $data[] = "{name: '".$p->descripcion."', y: ".$p->cant.", sliced: true }";
        }

        $datos = [
            ['f1' => UtilidadesController::convertirFecha($request->f1)],
            ['f2' => UtilidadesController::convertirFecha($request->f2)],
            ['data' => implode(',', $data)]
        ];

       // dd($datos);

        return view('sistema.plantas.graficos.segPlanta', compact('datos'));
    }


}
