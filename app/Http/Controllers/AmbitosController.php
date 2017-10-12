<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\URL;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Image;

use App\Estado;
use App\Ambito;
use App\PoligonoAmbito;

class AmbitosController extends Controller
{
    //
    public function getIndex()
    {
        $estado = Estado::orderBy('nombre', 'asc')->get();
        return view('sistema.ambitos.index', compact('estado'));
    }

    public function getData(Request $request)
    {
        $ambitos = DB::table('ambitos')
            /*->join('estados', 'empresas.edo', '=', 'estados.id')
            ->join('municipios', 'empresas.mcpio', '=', 'municipios.id')
            ->join('parroquias', 'empresas.pquia', '=', 'parroquias.id')
            ->join('users', 'empresas.usuario', '=', 'users.id')*/
            ->select("ambitos.id",
                "ambitos.estado",
                "ambitos.municipio",
                "ambitos.parroquia",
                "ambitos.nombre",
                "ambitos.superficie",
                "ambitos.registros",
                "ambitos.parcelas",
                "ambitos.iactivos",
                "ambitos.iinactivos",
                "ambitos.paeconomica",
                "ambitos.paproductiva",
                DB::raw("(select count(ambitos_poligonos.id) from ambitos_poligonos where ambitos_poligonos.ambito_id = ambitos.id) as poligonos"),
                "ambitos.foto"
            );
        /*->where('oficina.nombre', 'NOT ILIKE', '%DELETE%');
        if(Auth::user()->rol == 30){
            $ambresas->where('empresas.rif', 'ilike', Auth::user()->empresa);
        }

        if(Auth::user()->rol == 2){
            $ambresas->where('empresas.usuario', '=', Auth::user()->id);
        }*/

        return Datatables::of($ambitos)
            ->editColumn('poligonos', function($amb) {
                 return $amb->poligonos;
                //return '<a href="javascript:;" onclick="verDetalleSubastas(\''.$amb->rif.'\' , \''.$amb->rsocial.'\' )" title="Ver detalle de subasta">[ '. $amb->dicom . ' ]</a>';
            })
            ->editColumn('foto', function($amb) {
                if(empty($amb->foto)){
                    return '<a href="javascript:;" onclick="uploadFoto('.$amb->id.')" >[ Subir foto ]</a>';
                }
                else{
                    return '<span class="text-success"><strong>[ Foto Subida ]</strong></span>';

                }
            })
            ->addColumn('accion', function ($amb) {

                $btn = '';
                if(Auth::user()->rol != 6 ) {
                    $btn .= '<a href="javascript:void(0);" class="btn btn-no-border yellow btn-sm btn-outline" onclick="findUpdateAmb('.$amb->id.')" title="Actualizar"><i class="fa fa-edit fa-lg"></i></a> ';
                    if(Auth::user()->rol == 10 || Auth::user()->rol == 1){
                        $btn .='<a href="javascript:void(0);" class="btn btn-no-border red btn-sm btn-outline" onclick="deleteAmb('.$amb->id.')" title="Eliminar"><i class="fa fa-trash-o fa-lg"></i></a> ';
                    }
                    $btn .= '<a href="javascript:void(0);" class="btn btn-no-border purple btn-sm btn-outline" onclick="cargarPoligono('.$amb->id.')" title="Cargar poligono"><i class="fa fa-object-group fa-lg"></i></a> ';
                }
                $btn .='<a href="javascript:void(0);" class="btn btn-no-border green btn-sm btn-outline" onclick="viewAmb('.$amb->id.')" title="Detalle"><i class="fa fa-eye fa-lg"></i></a>';

                return  $btn;
            })
            /*->filterColumn('fecha', function ($query, $keyword) {
                $query->whereRaw("to_char(fecha, 'DD/MM/YYYY') ilike ?", ["%$keyword%"]);
            })*/
            ->rawColumns(['poligonos','foto','accion'])
            ->make(true);

    }

    public function agregarAmbito(Request $request)
    {
        try{
            $ambito = new Ambito();
            
            $ambito->nombre = mb_strtoupper($request->nombre, 'UTF-8');
            $ambito->estado = mb_strtoupper($request->estado, 'UTF-8');
            $ambito->municipio = mb_strtoupper($request->municipio, 'UTF-8');
            $ambito->parroquia = mb_strtoupper($request->parroquia, 'UTF-8');

            $ambito->superficie = mb_strtoupper(str_replace(',', '.', $request->superficie));
            $ambito->registros = mb_strtoupper($request->registros);
            $ambito->parcelas = mb_strtoupper($request->parcelas);
            $ambito->iactivos = mb_strtoupper($request->iactivos);
            $ambito->iinactivos = mb_strtoupper($request->iinactivos);

            $ambito->paeconomica = mb_strtoupper($request->paeconomica, 'UTF-8');
            $ambito->paproductiva = mb_strtoupper($request->paproductiva, 'UTF-8');

            
            if($ambito->save()){
                UtilidadesController::setLog(Auth::user()->user, 'AMBITO', 'AGREGAR', mb_strtoupper($request->nombre));
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

    public function buscarAmbito(Request $request)
    {
        if($request->ajax()) {
            $ambitos = DB::table('ambitos')
                /*->join('estados', 'empresas.edo', '=', 'estados.id')
                ->join('municipios', 'empresas.mcpio', '=', 'municipios.id')
                ->join('parroquias', 'empresas.pquia', '=', 'parroquias.id')
                ->join('users', 'empresas.usuario', '=', 'users.id')*/
                ->select("ambitos.id",
                    "ambitos.estado",
                    "ambitos.municipio",
                    "ambitos.parroquia",
                    "ambitos.nombre",
                    "ambitos.superficie",
                    "ambitos.registros",
                    "ambitos.parcelas",
                    "ambitos.iactivos",
                    "ambitos.iinactivos",
                    "ambitos.paeconomica",
                    "ambitos.paproductiva")
                ->where('ambitos.id', '=', $request->id)->get();
            return response()->json($ambitos);
        }
    }

    public function actualizarAmbito(Request $request)
    {
        try{
            $ambito = Ambito::find($request->id_amb);

            $ambito->nombre = mb_strtoupper($request->nombre, 'UTF-8');
            $ambito->estado = mb_strtoupper($request->estado, 'UTF-8');
            $ambito->municipio = mb_strtoupper($request->municipio, 'UTF-8');
            $ambito->parroquia = mb_strtoupper($request->parroquia, 'UTF-8');

            $ambito->superficie = mb_strtoupper(str_replace(',', '.', $request->superficie));
            $ambito->registros = mb_strtoupper($request->registros);
            $ambito->parcelas = mb_strtoupper($request->parcelas);
            $ambito->iactivos = mb_strtoupper($request->iactivos);
            $ambito->iinactivos = mb_strtoupper($request->iinactivos);

            $ambito->paeconomica = mb_strtoupper($request->paeconomica, 'UTF-8');
            $ambito->paproductiva = mb_strtoupper($request->paproductiva, 'UTF-8');


            if($ambito->update()){
                UtilidadesController::setLog(Auth::user()->user, 'AMBITOS', 'ACTUALIZAR', mb_strtoupper($request->nombre));
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

    public function eliminarAmbito(Request $request)
    {
        if($request->ajax()) {
            try{
                $amb = DB::table('ambitos')->select('nombre')->where('id', $request->id )->first();
                $deletedRows = Ambito::where('id', $request->id )->delete();
                if ($deletedRows == 1) {
                    UtilidadesController::setLog(Auth::user()->user, 'AMBITOS', 'ELIMINAR - '.$amb->nombre);
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

    public function verAmbito(Request $request)
    {
        if($request->ajax()) {

            $ambitos = DB::table('ambitos')
                /*->join('estados', 'empresas.edo', '=', 'estados.id')
                ->join('municipios', 'empresas.mcpio', '=', 'municipios.id')
                ->join('parroquias', 'empresas.pquia', '=', 'parroquias.id')
                ->join('users', 'empresas.usuario', '=', 'users.id')*/
                ->select("ambitos.id",
                    "ambitos.estado",
                    "ambitos.municipio",
                    "ambitos.parroquia",
                    "ambitos.nombre",
                    "ambitos.superficie",
                    "ambitos.registros",
                    "ambitos.parcelas",
                    "ambitos.iactivos",
                    "ambitos.iinactivos",
                    "ambitos.paeconomica",
                    "ambitos.paproductiva",
                    "ambitos.foto")
                ->where('ambitos.id', '=', $request->id)->get();
            return response()->json($ambitos);

        }
    }

    public function cargarPoligono(Request $request)
    {
        try{
            $ambito = new PoligonoAmbito();
            $ambito->coordenadas = str_replace('-', ' -', $request->coordenadas);
            $ambito->ambito_id = $request->id_amb;


            if($ambito->save()){
                UtilidadesController::setLog(Auth::user()->user, 'AMBITOS', 'AGREGAR POLIGONO', mb_strtoupper($request->id_amb));
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

    public function subirFoto(Request $request)
    {
        //dd($request->all());
        try{
            //
            $image = $request->file('file');
            $name = explode('.', $image->getClientOriginalName());
            $input['imagename'] = time().'_'.$name[0].'.'.$image->getClientOriginalExtension();
            //dd($image->getRealPath());
            $destinationPath = public_path().'/imagenes/ambitos';

            if($image->move($destinationPath, $input['imagename'])){
                $img = Image::make($destinationPath.'/'.$input['imagename']);
                $img->resize(700, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                if($img->save($destinationPath.'/'.$input['imagename'],90)){
                    $info = Ambito::find($request->id);

                    $info->foto = $input['imagename'];


                    if($info->update()){
                        UtilidadesController::setLog(Auth::user()->user, 'AMBITOS - SUBIR FOTO', 'ACTUALIZAR - '.$request->id);
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
                $foto = DB::table('ambitos')->select('foto')->where('id', $request->id)->first();
                if(unlink(public_path().'/imagenes/ambitos/'.$foto->foto)) {
                    $visita = Ambito::find($request->id);
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
    
    
    
    
}
