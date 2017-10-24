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

use App\Estado;
use App\Empresa;

class EmpresasController extends Controller
{
    //
    public function getIndex()
    {
        $estado = Estado::orderBy('nombre', 'asc')->get();
        $ssciiu = DB::table('ciiu_seccion')->orderBy('sec', 'asc')->get();
        $motores = DB::table('clasificacion_emp')->select('motor')->groupBy('motor')->orderBy('motor', 'asc')->get();
        return view('sistema.empresas.index', compact('estado', 'ssciiu', 'motores'));
    }

    public function getData(Request $request)
    {
        $empresas = DB::table('empresas')
            /*->join('estados', 'empresas.edo', '=', 'estados.id')
            ->join('municipios', 'empresas.mcpio', '=', 'municipios.id')
            ->join('parroquias', 'empresas.pquia', '=', 'parroquias.id')
            ->join('users', 'empresas.usuario', '=', 'users.id')*/
            ->select(
                "empresas.id",
                "empresas.rif",
                "empresas.rsocial",
                "empresas.estado",
                "empresas.municipio",
                "empresas.parroquia",
                "empresas.localidad",
                "empresas.trabajadores",
                "empresas.ciiu",
                "empresas.acteconomica",
                "empresas.cnp",
                "empresas.fuente",
                "empresas.sector",
                "empresas.subsector",
                "empresas.motor",
                "empresas.status",
                "empresas.rlegal",
                "empresas.ci",
                "empresas.telefonos",
                "empresas.email",
                "empresas.latitud",
                "empresas.longitud",
                DB::raw("(select count(dicom.rif) from dicom where dicom.rif = empresas.rif) as dicom"),
                DB::raw("(select count(plantas.id) from plantas where plantas.emp_rif = empresas.rif) as plantas")
            );

        return Datatables::of($empresas)
            ->editColumn('rsocial', function($emp) {
                $visitas = DB::connection('pgsql_saiise')->table('vis_visitas')->select(DB::raw('count(*) as visitas'))->whereRaw("replace(vis_visitas.emp_rif, '-', '') = '".$emp->rif."'")->get();
                if($visitas[0]->visitas != 0 ){
                    return $emp->rsocial.'<a href="#" onclick="location.href = \''.route('sistema.empresas.visitas').'?rif='.$emp->rif.'\'" title="Vistas realizadas">[ '.$visitas[0]->visitas.' ]</a>';
                }
                else{
                    return $emp->rsocial;
                }

            })
            ->editColumn('dicom', function($emp) {
                return '<a href="javascript:;" onclick="verDetalleSubastas(\''.$emp->rif.'\' , \''.str_replace("'", "",$emp->rsocial).'\' )" title="Ver detalle de subasta">[ '. $emp->dicom . ' ]</a>';
            })
            ->addColumn('accion', function ($emp) {

                $btn = '';
                if(Auth::user()->rol != 6 ) {
                    $btn .= '<a href="javascript:void(0);" class="btn btn-no-border yellow btn-sm btn-outline" onclick="findUpdateEmp('.$emp->id.')" title="Actualizar"><i class="fa fa-edit fa-lg"></i></a> ';
                    if(Auth::user()->rol == 10 || Auth::user()->rol == 1){
                        $btn .='<a href="javascript:void(0);" class="btn btn-no-border red btn-sm btn-outline" onclick="deleteEmp('.$emp->id.')" title="Eliminar"><i class="fa fa-trash-o fa-lg"></i></a> ';
                    }
                    $btn .= '<a href="javascript:void(0);" class="btn btn-no-border purple btn-sm btn-outline" onclick="uploadProduccion(\''.$emp->rif.'\', \'ESP\', '.Auth::user()->rol.')" title="Cargar producción"><i class="fa fa-upload fa-lg"></i></a> ';
                }
                $btn .='<a href="javascript:void(0);" class="btn btn-no-border green btn-sm btn-outline" onclick="viewEmp('.$emp->id.')" title="Detalle"><i class="fa fa-eye fa-lg"></i></a>';

                return  $btn;
            })
            /*->filterColumn('fecha', function ($query, $keyword) {
                $query->whereRaw("to_char(fecha, 'DD/MM/YYYY') ilike ?", ["%$keyword%"]);
            })*/
            ->rawColumns(['rsocial','dicom','accion'])
            ->make(true);

    }

    public function uploadProduccion(Request $request)
    {
        $normalTimeLimit = ini_get('max_execution_time');
        $normalMemoryLimit = ini_get('memory_limit');

        ini_set('max_execution_time', 1200);
        ini_set('memory_limit', "512M");


        if($request->ajax()) {
           DB::connection('pgsql')->beginTransaction();

            try{
                $arr = array();
                if($request->hasFile('file')){
                    $path = $request->file('file')->getRealPath();
                    $data = UtilidadesController::ImportCSV2Array($path, ';');
                    if(count($data) > 0){
                        $ttal_reg = count($data);
                        $noext_reg = 0;
                        foreach ($data as $key => $value) {

                            $rif = ($request->cnd == 'GRAL') ? trim(str_replace('-', '',$value['rif'])) : $request->id;
                            if(Empresa::where('rif', $rif)->count() == 1){
                                $arr[] = [
                                    'rif' => $rif,
                                    'producto' => trim(strtoupper($value['producto'])),
                                    'especificacion' => trim(strtoupper($value['especificacion'])),
                                    'descripcion' => trim(strtoupper($value['descripcion'])),
                                    'medida' => trim(strtoupper($value['medida'])),
                                    'cinstalada' => trim(str_replace(',', '.', $value['cinstalada'])),
                                    'coperativa' => trim(str_replace(',', '.', $value['coperativa'])),
                                    'produccion' => trim(str_replace(',', '.', $value['produccion'])),
                                    'fecha' => trim(UtilidadesController::invertirFecha($value['fecha']))
                                ];
                            }
                            else{
                                $noext_reg++;
                            }
                        }


                       $no_dupl = array_map("unserialize", array_unique(array_map("serialize", $arr)));


                       // dd(count($no_dupl),$noext_reg);
//dd($no_dupl);
                        if(count($arr) > 10000){
                            ini_set('max_execution_time', $normalTimeLimit);
                            ini_set('memory_limit', $normalMemoryLimit);
                            return response()->json(//array('error' => */
                                "El archivo no puede tener mas de 10.000 registros"
                            // )
                            );
                        }
                        if(!empty($no_dupl)){
                            $data = array_chunk($no_dupl, 2500, true);
                            for($i=0; $i < sizeof($data); $i++){
                                DB::table('produccion')->insert($data[$i]);
                            }
                            //DB::rollBack();
                            DB::commit();

                            $arr = array();

                            UtilidadesController::setLog(Auth::user()->user, 'EMPRESA', 'AGREGAR PRODUCCION', mb_strtoupper($request->id));
                            ini_set('max_execution_time', $normalTimeLimit);
                            ini_set('memory_limit', $normalMemoryLimit);
                            return response()->json(//array(
                                count($no_dupl).' agr. '.$noext_reg.' desc.'
                           // )
                           );/**/
                        }
                        else{
                            ini_set('max_execution_time', $normalTimeLimit);
                            ini_set('memory_limit', $normalMemoryLimit);
                            return response()->json(array(
                                'error' => 'No hay data que cargar'
                            ));
                        }
                    }
                }
            }
            catch (QueryException $e) {
                if ($request->ajax()) {
                    DB::rollBack();
                    ini_set('max_execution_time', $normalTimeLimit);
                    ini_set('memory_limit', $normalMemoryLimit);
                    $msg = '';
                    switch ($e->getCode()){
                        case 23505:
                            $msg = 'Algunos de los datos que intenta subir ya estan registrados por favor verifique el archivo he intente de nuevo (Cod. error '.$e->getCode().')';
                        break;
                        default:
                            $msg = $e->getCode().'-'.$e->getMessage();//UtilidadesController::errorPostgres($e->getCode())
                        break;

                    }
                    if($e->getCode() )
                    return response()->json(//array('error' =>
                        $msg
                    //)
                    );
                }
            }
            catch (Exception $e) {
                if ($request->ajax()) {
                    ini_set('max_execution_time', $normalTimeLimit);
                    ini_set('memory_limit', $normalMemoryLimit);
                    return response()->json(//array('error' => */
                        $e->getCode().'-'.$e->getMessage()
                   // )
                   );
                }
            }
        }
    }

    public function uploadDicom(Request $request)
    {
        if($request->ajax()) {
            try{
                // 'rif' => str_replace('-', '',trim(mb_strtoupper($value->rif, 'UTF-8'))),
                if($request->hasFile('file')){
                    $path = $request->file('file')->getRealPath();
                    $data = Excel::load($path)->get();

                    if($data->count()){
                        foreach ($data as $key => $value) {
                            $arr[] = [
                                 'rif' => trim(mb_strtoupper($value->rif, 'UTF-8')),
                                 'rsocial' => trim(mb_strtoupper($value->rsocial, 'UTF-8')),
                                 'monto' => trim(str_replace(',', '.', $value->monto) ),
                                 'destino' => trim(mb_strtoupper($value->destino, 'UTF-8')),
                                 'sector' => trim(mb_strtoupper($value->sector, 'UTF-8')),
                                 'subsector' => trim(mb_strtoupper($value->subsector, 'UTF-8')),
                                 'adjudicacion' => trim(UtilidadesController::invertirFecha($value->adjudicacion)),
                                 'subasta' => trim(mb_strtoupper($value->subasta, 'UTF-8'))

                             ];
                        }
                        //dd($arr);
                        if(!empty($arr)){
                            UtilidadesController::setLog(Auth::user()->user, 'EMPRESA', 'CARGAR DATA', 'DICOM');
                            DB::table('dicom')->insert($arr);
                            return response()->json(/*array(*/
                                'Se han agregado '.count($arr).' registros'
                            /*)*/);
                        }
                        else{
                            return response()->json(/*array(
                                'error' => '*/'No hay data que cargar'
                            /*)*/);
                        }
                    }
                }
            }
            catch (QueryException $e) {
                if ($request->ajax()) {
                    return response()->json(/*array(
                        'error' => $e->getCode().'-'.$e->getMessage()*/UtilidadesController::errorPostgres($e->getCode())
                    /*)*/);
                }
            }
            catch (Exception $e) {
                if ($request->ajax()) {
                    return response()->json(/*array(
                        'error' => */$e->getCode().'-'.$e->getMessage()
                   /* )*/);
                }
            }
        }
    }

    public function searchDicom(Request $request)
    {
        if($request->ajax()) {
            try{
                $dicom = DB::table('dicom')
                    ->select(DB::raw('DISTINCT dicom.rif'),
                        'dicom.rsocial',
                        'clasificacion_emp.motor',
                        DB::raw("CASE WHEN clasificacion_emp.sector is null THEN dicom.sector ELSE clasificacion_emp.sector END as sector"),
                        DB::raw("CASE WHEN clasificacion_emp.subsector is null THEN dicom.subsector ELSE clasificacion_emp.subsector END as subsector"))
                    ->leftJoin('data_gral_seniat', 'dicom.rif', '=', 'data_gral_seniat.rif')
                    ->leftJoin('clasificacion_emp', 'data_gral_seniat.cod_act', '=', 'clasificacion_emp.ciiu')
                    ->whereBetween('adjudicacion', [$request->fid, $request->ffd])
                    ->get();

                $ttal_reg = count($dicom);
                $noext_reg = 0;

                foreach ($dicom as $sai){
                    if(Empresa::where('rif', $sai->rif)->count() == 0){
                        $arr_insert[] = [
                            'rif' => $sai->rif,
                            'rsocial' => $sai->rsocial,
                            'sector' => $sai->sector,
                            'subsector' => $sai->subsector,
                            'fuente' => 'DICOM'
                        ];
                    }
                    else{
                        $noext_reg++;
                    }
                }

               if(!empty($arr_insert)){
                    DB::table('empresas')->insert($arr_insert);
                    UtilidadesController::setLog(Auth::user()->user, 'EMPRESA', 'ACTUALIZAR DATA', 'DICOM');
                    return response()->json(array(
                        'status' => 1,
                        'msg' => 'Se han agregado '.count($arr_insert).' registros de '.$ttal_reg
                    ));
                }
                else{
                    return response()->json(array(
                        'status' => 0,
                        'msg' => '¡¡¡ No se encontro data que agregar !!!'
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

    public function agregarEmpresa(Request $request)
    {
        try{
            $empresa = new Empresa();

            $ciiu = explode('-', $request->ciiu);

            $empresa->rif = mb_strtoupper($request->rif);
            $empresa->rsocial = mb_strtoupper($request->rsocial);
            $empresa->estado = mb_strtoupper($request->estado);
            $empresa->municipio = mb_strtoupper($request->municipio);
            $empresa->parroquia = mb_strtoupper($request->parroquia);
            $empresa->localidad = mb_strtoupper($request->localidad);
            $empresa->trabajadores = mb_strtoupper($request->trabajadores);
            $empresa->ciiu = mb_strtoupper($ciiu[0]);
            $empresa->acteconomica = mb_strtoupper($ciiu[1]);
            $empresa->cnp = '';
            $empresa->fuente = 'SIGIC';
            $empresa->sector = mb_strtoupper($request->sector);
            $empresa->subsector = mb_strtoupper($request->subsector);
            $empresa->motor = mb_strtoupper($request->motor);
            $empresa->status = mb_strtoupper($request->status);
            $empresa->rlegal = mb_strtoupper($request->rlegal);
            $empresa->ci = mb_strtoupper($request->ci);
            $empresa->telefonos = mb_strtoupper(implode(';', $request->telefonos));
            $empresa->email = mb_strtoupper($request->email);
            if($request->coordenadas != ''){
                $coord = explode(',', $request->coordenadas);
                $empresa->latitud = mb_strtoupper($coord[1]);
                $empresa->longitud = mb_strtoupper($coord[0]);
            }

            if($empresa->save()){
                UtilidadesController::setLog(Auth::user()->user, 'EMPRESA', 'AGREGAR', mb_strtoupper($request->rif));
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

    public function buscarEmpresa(Request $request)
    {
        if($request->ajax()) {
            $empresas = DB::table('empresas')
                /*->join('estados', 'empresas.edo', '=', 'estados.id')
                ->join('municipios', 'empresas.mcpio', '=', 'municipios.id')
                ->join('parroquias', 'empresas.pquia', '=', 'parroquias.id')
                ->join('users', 'empresas.usuario', '=', 'users.id')*/
                ->select(
                    "empresas.id",
                    "empresas.rif",
                    "empresas.rsocial",
                    "empresas.estado",
                    "empresas.municipio",
                    "empresas.parroquia",
                    "empresas.localidad",
                    "empresas.trabajadores",
                    DB::raw("concat(empresas.ciiu,'-',empresas.acteconomica) as ciiu"),
                    "empresas.cnp",
                    "empresas.fuente",
                    "empresas.sector",
                    "empresas.subsector",
                    "empresas.motor",
                    "empresas.status",
                    "empresas.rlegal",
                    "empresas.ci",
                    "empresas.telefonos",
                    "empresas.email",
                    DB::raw("concat(empresas.longitud,',',empresas.latitud) as coordenadas"))
                ->where('empresas.id', '=', $request->id)->get();
            return response()->json($empresas);
        }
    }

    public function actualizarEmpresa(Request $request)
    {
        try{
            $empresa = Empresa::find($request->id_emp);

            $ciiu = explode('-', $request->ciiu);

            $empresa->rif = mb_strtoupper($request->rif);
            $empresa->rsocial = mb_strtoupper($request->rsocial);
            $empresa->estado = mb_strtoupper($request->estado);
            $empresa->municipio = mb_strtoupper($request->municipio);
            $empresa->parroquia = mb_strtoupper($request->parroquia);
            $empresa->localidad = mb_strtoupper($request->localidad);
            $empresa->trabajadores = mb_strtoupper($request->trabajadores);
            $empresa->ciiu = mb_strtoupper($ciiu[0]);
            $empresa->acteconomica = mb_strtoupper($ciiu[1]);
            $empresa->cnp = '';
            $empresa->fuente = 'SIGIC';
            $empresa->sector = mb_strtoupper($request->sector);
            $empresa->subsector = mb_strtoupper($request->subsector);
            $empresa->motor = mb_strtoupper($request->motor);
            $empresa->status = mb_strtoupper($request->status);
            $empresa->rlegal = mb_strtoupper($request->rlegal);
            $empresa->ci = mb_strtoupper($request->ci);
            $empresa->telefonos = mb_strtoupper(implode(';', $request->telefonos));
            $empresa->email = mb_strtoupper($request->email);
            if($request->coordenadas != ''){
                $coord = explode(',', $request->coordenadas);
                $empresa->latitud = mb_strtoupper($coord[1]);
                $empresa->longitud = mb_strtoupper($coord[0]);
            }


                if($empresa->update()){
                    UtilidadesController::setLog(Auth::user()->user, 'EMPRESAS', 'ACTUALIZAR', mb_strtoupper($request->rif));
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

    public function eliminarEmpresa(Request $request)
    {
        if($request->ajax()) {
            try{
                $rif_emp = DB::table('empresas')->select('rif')->where('id', $request->id )->first();
                $deletedRows = Empresa::where('id', $request->id )->delete();
                if ($deletedRows == 1) {
                    UtilidadesController::setLog(Auth::user()->user, 'EMPRESAS', 'ELIMINAR - '.$rif_emp->rif);
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

    public function verEmpresa(Request $request)
    {
        if($request->ajax()) {

           /* $solicitud = UtilidadesController::getDetalleSolicitud($request->id);
            $permisos = UtilidadesController::getPermisologia($solicitud[0]->id);
            $mprima = UtilidadesController::getMprima($solicitud[0]->id);*/

           $empresa = DB::table('empresas')
               /*->join('estados', 'empresas.edo', '=', 'estados.id')
               ->join('municipios', 'empresas.mcpio', '=', 'municipios.id')
               ->join('parroquias', 'empresas.pquia', '=', 'parroquias.id')
               ->join('users', 'empresas.usuario', '=', 'users.id')*/
               ->select(
                   "empresas.id",
                   "empresas.rif",
                   "empresas.rsocial",
                   "empresas.estado",
                   "empresas.municipio",
                   "empresas.parroquia",
                   "empresas.localidad",
                   "empresas.trabajadores",
                   "empresas.acteconomica",
                   "empresas.sector",
                   "empresas.subsector",
                   "empresas.motor",
                   "empresas.status",
                   "empresas.rlegal",
                   "empresas.ci",
                   "empresas.telefonos",
                   "empresas.email",
                   "empresas.latitud",
                   "empresas.longitud",
                   DB::raw("(select count(plantas.id) from plantas where plantas.emp_rif = empresas.rif) as plantas"))
               ->where('id', $request->id)->get();

            /*$dproduccion = DB::table('produccion')->select("rif", DB::raw("date_part('year', fecha) as anio"))->where('rif', $empresa[0]->rif )->orderBy('anio', 'asc')->get();
            $prod = count($dproduccion);


            $returnHTML = view('sistema.empresas.detalle', compact('empresa', 'prod'))->render();
            return $returnHTML;*/

            return response()->json($empresa);

        }
    }

    public function getDetalleDicomSubastas(Request $request)
    {
        $subastas = DB::table('dicom')->where('rif', $request->rif )->orderBy('adjudicacion', 'desc')->get();
            $totalasig = DB::table('dicom')->select(DB::raw('SUM(monto)'))->where('rif', $request->rif )->get();


            $returnHTML = view('sistema.empresas.detalle', compact('subastas', 'totalasig'))->render();
            return $returnHTML;
    }

    public function getDataSAIISE(Request $request)
    {
        $saiise = DB::connection('pgsql_saiise')
            ->table('empresas')
            ->join('estados', 'empresas.edo', '=', 'estados.id')
            ->join('municipios', 'empresas.mcpio', '=', 'municipios.id')
            ->join('parroquias', 'empresas.pquia', '=', 'parroquias.id')
            ->select(
                DB::raw("replace(empresas.rif, '-', '') as rif"),
                'empresas.empresa as rsocial',
                'estados.nombre AS estado',
                'municipios.nombre AS municipio',
                'parroquias.nombre AS parroquia',
                'empresas.direccion',
                'empresas.sector',
                'empresas.contacto as rlegal',
                'empresas.ci_cont as ci',
                'empresas.telf as telefonos',
                'empresas.email'
                )
          ->where([
              ['empresas.rif', 'not ilike', 'V%'],
              ['empresas.rif', 'not ilike', 'G%'],
              ['empresas.rif', 'not ilike', '%\_%'],
              ['empresas.empresa', 'not ilike', '%SIN RIF%']
          ])
        ->whereBetween('empresas.created_at', [$request->fis.' 00:00:00' , $request->ffs.' 23:59:59'])
        ->orderBy('empresas.rif', 'asc')->get();

        $ttal_reg = count($saiise);
        $noext_reg = 0;
        $arr_insert = array();

        foreach ($saiise as $sai){
            if(Empresa::where('rif', $sai->rif)->count() == 0){
                $arr_insert[] = [
                    'rif' => $sai->rif,
                    'rsocial' => $sai->rsocial,
                    'estado' => $sai->estado,
                    'municipio' => $sai->municipio,
                    'parroquia' => $sai->parroquia,
                    'localidad' => $sai->direccion,
                    'sector' => $sai->sector,
                    'rlegal' => $sai->rlegal,
                    'ci' => $sai->ci,
                    'email' => $sai->email,
                    'telefonos' => $sai->telefonos,
                    'fuente' => 'SAIISE'
                ];
            }
            else{
                $noext_reg++;
            }
        }
        if(!empty($arr_insert)){
            DB::table('empresas')->insert($arr_insert);
            UtilidadesController::setLog(Auth::user()->user, 'EMPRESA', 'ACTUALIZAR DATA', 'SAIISE');
            return response()->json(array(
                'status' => 1,
                'msg' => 'Se han agregado '.count($arr_insert).' registros de '.$ttal_reg
            ));
        }
        else{
            return response()->json(array(
                'status' => 0,
                'msg' => '¡¡¡ No se encontro data que agregar !!!'
            ));
        }
    }

    public function generarFicha(Request $request)
    {
        $visita_id = DB::connection('pgsql_saiise')->table('vis_visitas')->select('vis_visitas.id')->whereRaw("replace(vis_visitas.emp_rif, '-', '') = '".$request->rif."'")->orderBy('vis_visitas.fecha', 'desc')->first();

        if(!empty($visita_id)){
            $visita = DB::connection('pgsql_saiise')->table('vis_visitas')
                ->join('empresas', 'vis_visitas.emp_rif', '=', 'empresas.rif')
                ->join('estados', 'empresas.edo', '=', 'estados.id')
                ->join('municipios', 'empresas.mcpio', '=', 'municipios.id')
                ->join('parroquias', 'empresas.pquia', '=', 'parroquias.id')
                ->select('vis_visitas.id',
                    'empresas.rif',
                    'empresas.empresa',
                    'estados.nombre AS edo',
                    'municipios.nombre AS mcpio',
                    'parroquias.nombre AS pquia',
                    'empresas.direccion',
                    'empresas.sector',
                    'empresas.contacto',
                    'empresas.ci_cont',
                    'empresas.telf',
                    'empresas.email',
                    DB::raw("to_char(vis_visitas.fecha, 'DD/MM/YYYY') as fecha"),
                    'vis_visitas.operatividad',
                    'vis_visitas.ciiu',
                    'vis_visitas.tipo_emp',
                    'vis_visitas.trabajadores',
                    'vis_visitas.tnum',
                    'vis_visitas.servicios',
                    'vis_visitas.objeto',
                    'vis_visitas.l_prod',
                    'vis_visitas.nc_prod',
                    'vis_visitas.nc_mprima',
                    'vis_visitas.pclientes',
                    'vis_visitas.pedo',
                    'vis_visitas.pproductivo',
                    'vis_visitas.observacion',
                    'vis_visitas.foto1',
                    'vis_visitas.foto2',
                    'vis_visitas.foto3',
                    'vis_visitas.foto4')
                ->whereColumn('empresas.mcpio', 'municipios.id')
                ->whereColumn('empresas.pquia' , 'parroquias.id')
                ->where('vis_visitas.id', $visita_id->id)->get();
            $vprod = DB::connection('pgsql_saiise')->table('vis_produccion')->where('vis_id', $visita_id->id)->get()->toArray();
            $vmpri = DB::connection('pgsql_saiise')->table('vis_mprima')->where('vis_id', $visita_id->id)->get()->toArray();
            $vcom = DB::connection('pgsql_saiise')->table('vis_comercializacion')->where('vis_id', $visita_id->id)->get()->toArray();
            $vinvp = DB::connection('pgsql_saiise')->table('vis_invper')->where('vis_id', $visita_id->id)->get();

            $avprod = array_chunk($vprod, 12, true);

            $avmpri = array_chunk($vmpri, 12, true);
            $avcom = array_chunk($vcom, 12, true);



            $pdf = PDF::loadView('sistema.empresas.pdf', compact('visita', 'avprod', 'avmpri', 'avcom', 'vinvp'), [], ['orientation' => 'L']);
            return $pdf->download('ficha.pdf');
        }

    }
}
