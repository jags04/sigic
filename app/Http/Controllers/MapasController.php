<?php

namespace App\Http\Controllers;

use Chumper\Zipper\Zipper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\URL;
//use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Empresa;
use App\Estado;

class MapasController extends Controller
{
    //
    public function getIndex()
    {
        return view('sistema.mapas.index');
    }

    public function getCoordMap(Request $request)
    {
        $id = $request->id;
        return view('sistema.mapas.getCoordMap', compact('id'));
    }

    public function getPanel()
    {
        $estado = Estado::orderBy('nombre', 'asc')->get();
        $sectores = DB::table('empresas')->select('sector')->groupBy('sector')->orderBy('sector', 'asc')->get();
        $sec_cla = DB::table('clasificacion_emp')->select('sector')->groupBy('sector')->orderBy('sector', 'asc')->get();

        return view('sistema.mapas.panelIndustria', compact('estado', 'sectores', 'sec_cla'));
    }

    public function getMapaIndustria(Request $request)
    {
        if($request->has('rif') || $request->has('edo') || $request->has('sec') || $request->has('subsector')){
            return view('sistema.mapas.industrias', compact('request'));
        }
        else{
            return view('sistema.mapas.industrias');
        }

    }
    public function getMapaComercio(Request $request)
    {
        if($request->has('id') || $request->has('edo') ){
            return view('sistema.mapas.comercios', compact('request'));
        }
        else{
            return view('sistema.mapas.comercios');
        }
    }
    public function getMapaAmbitos(Request $request)
    {
        return view('sistema.mapas.ambitos', compact('request'));
    }
    public function getMapaPlantas(Request $request)
    {
        if($request->has('id') || $request->has('edo') ){
            return view('sistema.mapas.plantas', compact('request'));
        }
        else{
            return view('sistema.mapas.plantas');
        }
    }

    public function getKmlIndustria(Request $request)
    {
        try{
            $where = null;
            if($request->has('rif')){
                $where = [['empresas.latitud','<>',''],['empresas.rif', $request->rif]];
            }
            elseif($request->has('edo')){
                $where = [['empresas.latitud','<>',''],['empresas.estado', $request->edo]];
            }
            elseif($request->has('sector')){
                if(empty($request->sector)){
                    $where = [['empresas.latitud','<>',''],['empresas.sector', '']];
                }else{
                    $where = [['empresas.latitud','<>',''],['empresas.sector', $request->sector]];
                }
            }
            else{
                $where = [['empresas.latitud','<>','']];
            }


            $empresas = DB::table('empresas')
                /* ->join('estados', 'empresas.edo', '=', 'estados.id')
                 ->join('municipios', 'empresas.mcpio', '=', 'municipios.id')
                 ->join('parroquias', 'empresas.pquia', '=', 'parroquias.id')
                 ->join('users', 'empresas.usuario', '=', 'users.id')*/
                ->select('empresas.id',
                    'empresas.rif',
                    DB::raw('upper(rsocial) as rsocial'),
                    'empresas.latitud',
                    'empresas.longitud')
                ->whereNotNull('empresas.latitud')
                ->where($where)
                ->orderBy('id', 'asc')
                ->get();
            $kml='<?xml version="1.0" encoding="UTF-8"?><kml xmlns="http://www.opengis.net/kml/2.2" xmlns:gx="http://www.google.com/kml/ext/2.2" xmlns:kml="http://www.opengis.net/kml/2.2" xmlns:atom="http://www.w3.org/2005/Atom"><Document><name>Mapa Industrias</name>
<open>1</open>';
            foreach ($empresas as $emp){
                $kml.='<Placemark>
                  <name>'.UtilidadesController::limpiarCaracteresEspeciales($emp->rsocial).'</name>
                     <description> <![CDATA[ '.UtilidadesController::limpiarCaracteresEspeciales($emp->rsocial).'
                      <br><iframe src="'.URL::to('/dataProdAsigAnual').'?rif='.$emp->rif.'" frameborder="0"  style="height: 60vh; width: 100%"></iframe>
                      ]]> </description>
                     <Style>
                       <IconStyle>
                         <scale>1</scale>
                           <Icon><href>'.URL::to('assets/layouts/layout/img/markers/32x32/MapMarker_PushPin1_Left_Pink.png').'</href></Icon>
                       </IconStyle>
                     </Style>
                     <Point><coordinates>'.trim($emp->longitud).','.trim($emp->latitud).'</coordinates></Point>
                </Placemark>';
            }
            $kml.='</Document>
</kml>';
            return response($kml)->header('Content-Type', 'application/vnd.google-earth.kml+xml');

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
    public function getKmzIndustria(Request $request)
    {
        try{
                $where = null;
                if($request->has('rif')){
                    $where = [['empresas.latitud','<>',''],['empresas.rif', $request->rif]];
                }
                elseif($request->has('edo')){
                    $where = [['empresas.latitud','<>',''],['empresas.estado', $request->edo]];
                }
                elseif($request->has('sector')){
                    if(empty($request->sector)){
                        $where = [['empresas.latitud','<>',''],['empresas.sector', '']];
                    }else{
                        $where = [['empresas.latitud','<>',''],['empresas.sector', $request->sector]];
                    }
                }
                elseif($request->has('subsector')){
                        $where = [['empresas.latitud','<>',''],['empresas.sector', $request->sec_cla],['empresas.subsector', $request->subsector]];
                }
                else{
                    $where = [['empresas.latitud','<>','']];
                }


                $empresas = DB::table('empresas')
                    /* ->join('estados', 'empresas.edo', '=', 'estados.id')
                     ->join('municipios', 'empresas.mcpio', '=', 'municipios.id')
                     ->join('parroquias', 'empresas.pquia', '=', 'parroquias.id')
                     ->join('users', 'empresas.usuario', '=', 'users.id')*/
                    ->select('empresas.id',
                        'empresas.rif',

                        'empresas.localidad',
                        'empresas.sector',
                        'empresas.subsector',
                        'empresas.acteconomica',

                        DB::raw('upper(rsocial) as rsocial'),
                        DB::raw("COALESCE( (SELECT users.nombre FROM users INNER JOIN logs on logs.usuario = users.user where logs.modulo = 'EMPRESAS' and logs.empresa = empresas.rif ORDER BY logs.fecha desc LIMIT 1 OFFSET 0),'ESTA EMPRESA NO HA SIDO ACTUALIZADA') as usuario"),
                        'empresas.latitud',
                        'empresas.longitud')
                    ->whereNotNull('empresas.latitud')
                    ->where($where)
                    ->orderBy('latitud', 'asc')
                    ->get();
                $kml='<?xml version="1.0" encoding="UTF-8"?><kml xmlns="http://www.opengis.net/kml/2.2" xmlns:gx="http://www.google.com/kml/ext/2.2" xmlns:kml="http://www.opengis.net/kml/2.2" xmlns:atom="http://www.w3.org/2005/Atom"><Document><name>Mapa Industrias</name>
<open>1</open>';
                foreach ($empresas as $emp){
                    $kml.='<Placemark>
                  <name>'.UtilidadesController::limpiarCaracteresEspeciales($emp->rsocial).'</name>
                     <description> <![CDATA[ <table style="font-family:Arial,Verdana,Times;font-size:14px;text-align:left;width:100%;border-collapse:collapse;">
        <tr style="text-align:center;font-weight:bold;background:#9CBCE2">
            <td>'.UtilidadesController::limpiarCaracteresEspeciales($emp->rsocial).'</td>
        </tr>
        <tr>
            <td>
                <table style="font-family:Arial,Verdana,Times;font-size:12px;text-align:left;width:100%;border-spacing:0px; border-collapse:collapse;">
                    <tr bgcolor="#D4E4F3">
                        <td style="border: 1px #999999 solid;" colspan="2">Direccion</td>
                    </tr>
                    <tr>
                        <td style="border: 1px #999999 solid;" colspan="2">'.$emp->localidad.'</td>
                    </tr>

                    <tr bgcolor="#D4E4F3">
                        <td style="border: 1px #999999 solid; width: 50%;">SECTOR</td>
                        <td style="border: 1px #999999 solid; width: 50%;">SUBSECTOR</td>
                    </tr>
                    <tr>
                        <td style="border: 1px #999999 solid;">'.$emp->sector.'</td>
                        <td style="border: 1px #999999 solid;">'.$emp->subsector.'</td>
                    </tr>
                    <tr bgcolor="#D4E4F3">
                        <td style="border: 1px #999999 solid;" colspan="2">Actividad economica</td>
                    </tr>
                    <tr>
                        <td style="border: 1px #999999 solid;" colspan="2">'.$emp->acteconomica.'</td>
                    </tr>
                     <tr bgcolor="#D4E4F3">
                        <td style="border: 1px #999999 solid;" colspan="2">Actualizada por</td>
                    </tr>
                    <tr>
                        <td style="border: 1px #999999 solid;" colspan="2">'.$emp->usuario.'</td>
                    </tr>
                   
                </table>
            </td>
        </tr>
    </table>
    <br>
    <iframe src="'.URL::to('/dataProdAsigAnual').'?rif='.$emp->rif.'" frameborder="0"  style="height: 40vh; width: 100%"></iframe>
                      ]]> </description>
                     <Style>
                       <IconStyle>
                         <scale>1</scale>
                           <Icon><href>'.URL::to('assets/layouts/layout/img/markers/32x32/MapMarker_PushPin1_Left_Pink.png').'</href></Icon>
                       </IconStyle>
                     </Style>';

                    $lat1 = explode(',', $emp->latitud);
                    $lat2 = explode('-', $emp->latitud);

                     $kml.='<Point><coordinates>'.trim($emp->longitud).','.trim($lat2[0]).'</coordinates></Point>
                </Placemark>';
                }
                $kml.='</Document>
</kml>';



            $file = "kmz_files/industrias.kmz";
            $zipper = new Zipper();
            $zipper->make($file)->addString('doc.kml', $kml);
            $zipper->close();

            $headers = [ 'Content-Type' => 'application/octet-stream' ];
            return response()->download( $file, 'mapasKmzIndustria.kmz', $headers );

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

    public function getPanelComercio()
    {
        $estado = Estado::orderBy('nombre', 'asc')->get();
        return view('sistema.mapas.panelComercios', compact('estado'));
    }
    public function getKmlComercio(Request $request)
    {
        try{

            $where = null;
            if($request->has('id')){
                $where = [['comercios.latitud','<>',''],['comercios.latitud','<>','0.0'],['comercios.id', $request->id]];
            }
            elseif($request->has('edo')){
                $where = [['comercios.latitud','<>',''],['comercios.latitud','<>','0.0'],['comercios.estado', $request->edo]];
            }
            else{
                $where = [['comercios.latitud','<>',''],['comercios.latitud','<>','0.0']];
            }

            $empresas = DB::table('comercios')
                /* ->join('estados', 'empresas.edo', '=', 'estados.id')
                 ->join('municipios', 'empresas.mcpio', '=', 'municipios.id')
                 ->join('parroquias', 'empresas.pquia', '=', 'parroquias.id')
                 ->join('users', 'empresas.usuario', '=', 'users.id')*/
                ->select('comercios.id',
                    DB::raw('upper(rsocial) as rsocial'),
                    'comercios.latitud',
                    'comercios.longitud')
                ->whereNotNull('comercios.latitud')
                ->where('comercios.latitud','<>','')
                ->orderBy($where)
                ->get();
            $kml='<?xml version="1.0" encoding="UTF-8"?><kml xmlns="http://www.opengis.net/kml/2.2" xmlns:gx="http://www.google.com/kml/ext/2.2" xmlns:kml="http://www.opengis.net/kml/2.2" xmlns:atom="http://www.w3.org/2005/Atom"><Document><name>Mapa Industrias</name>
<open>1</open>';
            foreach ($empresas as $emp){
                $kml.='<Placemark>
                  <name>'.UtilidadesController::limpiarCaracteresEspeciales($emp->rsocial).'</name>
                     <description> <![CDATA[ '.UtilidadesController::limpiarCaracteresEspeciales($emp->rsocial).' ]]> </description>
                     <Style>
                       <IconStyle>
                         <scale>1</scale>
                           <Icon><href>'.URL::to('assets/layouts/layout/img/markers/32x32/MapMarker_PushPin1_Left_Azure.png').'</href></Icon>
                       </IconStyle>
                     </Style>
                     <Point><coordinates>'.trim($emp->longitud).','.trim($emp->latitud).'</coordinates></Point>
                </Placemark>';
            }
            $kml.='</Document>
</kml>';
            return response($kml)->header('Content-Type', 'application/vnd.google-earth.kml+xml');

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
    public function getKmzComercio(Request $request)
    {
        try{
            $where = null;
            if($request->has('id')){
                $where = [['comercios.latitud','<>',''],['comercios.latitud','<>','0.0'],['comercios.id', $request->id]];
            }
            elseif($request->has('edo')){
                $where = [['comercios.latitud','<>',''],['comercios.latitud','<>','0.0'],['comercios.estado', $request->edo]];
            }
            else{
                $where = [['comercios.latitud','<>',''],['comercios.latitud','<>','0.0']];
            }

            $empresas = DB::table('comercios')
                /* ->join('estados', 'empresas.edo', '=', 'estados.id')
                 ->join('municipios', 'empresas.mcpio', '=', 'municipios.id')
                 ->join('parroquias', 'empresas.pquia', '=', 'parroquias.id')
                 ->join('users', 'empresas.usuario', '=', 'users.id')*/
                ->select('comercios.id',
                    DB::raw('upper(rsocial) as rsocial'),
                    "comercios.rif",
                    "comercios.estado",
                    "comercios.municipio",
                    "comercios.parroquia",
                    "comercios.direccion",
                    "comercios.telf",
                    'comercios.latitud',
                    'comercios.longitud')
                ->whereNotNull('comercios.latitud')
                ->where($where)
                ->orderBy('id', 'asc')
                ->get();

            $kml='<?xml version="1.0" encoding="UTF-8"?><kml xmlns="http://www.opengis.net/kml/2.2" xmlns:gx="http://www.google.com/kml/ext/2.2" xmlns:kml="http://www.opengis.net/kml/2.2" xmlns:atom="http://www.w3.org/2005/Atom"><Document><name>Mapa Industrias</name>
<open>1</open>';


            foreach ($empresas as $emp){
                $kml.='<Placemark>
                  <name>'.UtilidadesController::limpiarCaracteresEspeciales($emp->rsocial).'</name>
                     <description> <![CDATA[ <table style="font-family:Arial,Verdana,Times;font-size:14px;text-align:left;width:100%;border-collapse:collapse;">
        <tr style="text-align:center;font-weight:bold;background:#9CBCE2">
            <td>'.UtilidadesController::limpiarCaracteresEspeciales($emp->rsocial).'</td>
        </tr>
        <tr>
            <td>
                <table style="font-family:Arial,Verdana,Times;font-size:12px;text-align:left;width:100%;border-spacing:0px; border-collapse:collapse;">

                    <tr>
                        <td style="border: 1px #999999 solid; width: 33%;">ESTADO</td>
                        <td style="border: 1px #999999 solid; width: 33%;">MUNICIPIO</td>
                        <td style="border: 1px #999999 solid; width: 34%;">PARROQUIA</td>
                    </tr>
                    <tr>
                        <td style="border: 1px #999999 solid;">'.$emp->estado.'</td>
                        <td style="border: 1px #999999 solid;">'.$emp->municipio.'</td>
                        <td style="border: 1px #999999 solid;">'.$emp->parroquia.'</td>
                    </tr>
                    <tr bgcolor="#D4E4F3">
                        <td style="border: 1px #999999 solid;" colspan="3">Direccion</td>
                    </tr>
                    <tr>
                        <td style="border: 1px #999999 solid;" colspan="3">'.$emp->direccion.'</td>
                    </tr>

                    <tr>
                        <td style="border: 1px #999999 solid;" colspan="3">Teléfonos</td>
                    </tr>
                    <tr>
                        <td style="border: 1px #999999 solid;" colspan="3">'.$emp->telf.'</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table> ]]> </description>
                     <Style>
                       <IconStyle>
                         <scale>1</scale>
                           <Icon><href>'.URL::to('assets/layouts/layout/img/markers/32x32/MapMarker_PushPin1_Left_Azure.png').'</href></Icon>
                       </IconStyle>
                     </Style>
                     <Point><coordinates>'.trim($emp->longitud).','.trim($emp->latitud).'</coordinates></Point>
                </Placemark>';
            }
            $kml.='</Document>
</kml>';

            $file = "kmz_files/comercios.kmz";
            $zipper = new Zipper();
            $zipper->make($file)->addString('doc.kml', $kml);
            $zipper->close();

            $headers = [ 'Content-Type' => 'application/octet-stream' ];
            return response()->download( $file, 'mapasKmzComercio.kmz', $headers );


           // return response($kml)->header('Content-Type', 'application/vnd.google-earth.kml+xml');

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

    public function getPanelAmbitos()
    {
        $estado = Estado::orderBy('nombre', 'asc')->get();
        return view('sistema.mapas.panelAmbitos', compact('estado'));
    }
    public function getKmzAmbitos(Request $request)
    {
        try{
            $where = null;
           if($request->has('edo')){
                $where = [['ambitos_poligonos.coordenadas','<>',''], ['ambitos.estado', 'ilike', '%'.$request->edo.'%']];
            }
            elseif($request->has('id')){
                $where = [['ambitos_poligonos.coordenadas','<>',''], ['ambitos_poligonos.ambito_id', $request->id ]];
            }
            else{
                $where = [['ambitos_poligonos.coordenadas','<>','']];
            }


            $ambitos = DB::table('ambitos')
                ->join('ambitos_poligonos', 'ambitos.id', '=', 'ambitos_poligonos.ambito_id')
                ->select("ambitos.estado",
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
                    "ambitos_poligonos.coordenadas")
                ->where($where)
                ->get();
           //dd($request->all(), $ambitos);

            $kml='<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://www.opengis.net/kml/2.2" xmlns:gx="http://www.google.com/kml/ext/2.2" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
 xsi:schemaLocation="http://www.opengis.net/kml/2.2 http://schemas.opengis.net/kml/2.2.0/ogckml22.xsd http://www.google.com/kml/ext/2.2 http://code.google.com/apis/kml/schema/kml22gx.xsd">
<Document id="POL_AMB_NAC">
  <name>POL_AMB_NAC</name>
  <Snippet></Snippet>
  <Folder id="FeatureLayer0">
    <name>POL_AMB_NAC</name>
    <Snippet></Snippet>';


            foreach ($ambitos as $amb){
                $kml.='<Placemark>
      <name>'.$amb->nombre.'</name>
      <Snippet></Snippet>
      <description><![CDATA[<table style="font-family:Arial,Verdana,Times;font-size:14px;text-align:left;width:100%;border-collapse:collapse;">
        <tr style="text-align:center;font-weight:bold;background:#9CBCE2">
            <td>'.$amb->nombre.'</td>
        </tr>
        <tr>
            <td>
                <table style="font-family:Arial,Verdana,Times;font-size:10px;text-align:left;width:100%;border-spacing:0px; border-collapse:collapse;">
                    <tr bgcolor="#D4E4F3">
                        <td style="border: 1px #999999 solid;">ESTADO</td>
                        <td style="border: 1px #999999 solid;">MUNICIPIO</td>
                        <td style="border: 1px #999999 solid;">PARROQUIA</td>
                    </tr>
                    <tr>
                        <td style="border: 1px #999999 solid;">'.$amb->estado.'</td>
                        <td style="border: 1px #999999 solid;">'.$amb->municipio.'</td>
                        <td style="border: 1px #999999 solid;">'.$amb->parroquia.'</td>
                    </tr>

                    <tr bgcolor="#D4E4F3">
                        <td style="border: 1px #999999 solid;">SUPERFICIE</td>
                        <td style="border: 1px #999999 solid;">REGISTROS</td>
                        <td style="border: 1px #999999 solid;">PARCELAS</td>
                    </tr>
                    <tr>
                        <td style="text-align: right;border: 1px #999999 solid;">'.$amb->superficie.' ha</td>
                        <td style="text-align: right;border: 1px #999999 solid;">'.$amb->registros.'</td>
                        <td style="text-align: right;border: 1px #999999 solid;">'.$amb->parcelas.'</td>
                    </tr>
                    <tr bgcolor="#D4E4F3">
                        <td style="border: 1px #999999 solid;">INMUEBLES ACTIVOS</td>
                        <td colspan="2" style="border: 1px #999999 solid;">INMUEBLES INACTIVOS</td>
                    </tr>
                    <tr>
                        <td style="text-align: right;border: 1px #999999 solid;">'.$amb->iactivos.'</td>
                        <td style="text-align: right;border: 1px #999999 solid;" colspan="2">'.$amb->iinactivos.'</td>
                    </tr>
                    <tr bgcolor="#D4E4F3">
                        <td colspan="3" style="border: 1px #999999 solid;">PPAL ACT ECONÓMICA</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="border: 1px #999999 solid;">'.$amb->paeconomica.'</td>
                    </tr>

                    <tr bgcolor="#D4E4F3">
                        <td  colspan="3" style="border: 1px #999999 solid;">PPAL ACT PRODUCTIVA</td>
                    </tr>
                    <tr>
                        <td  colspan="3" style="border: 1px #999999 solid;">'.$amb->paproductiva.'</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
]]></description>
      <styleUrl>#PolyStyle00</styleUrl>
      <MultiGeometry>
        <Polygon>
          <extrude>0</extrude>          
          <altitudeMode>clampToGround</altitudeMode>
          <outerBoundaryIs>
          <LinearRing>
          <coordinates>'.$amb->coordenadas.'</coordinates>
          </LinearRing>
          </outerBoundaryIs>
        </Polygon>
      </MultiGeometry>
    </Placemark>';

            }





            $kml.='</Folder>
  <Style id="PolyStyle00">
    <LabelStyle>
      <color>00000000</color>
      <scale>0.000000</scale>
    </LabelStyle>
    <LineStyle>
      <color>ff6e6e6e</color>
      <width>1</width>
    </LineStyle>
    <PolyStyle>
      <color>3f0000ff</color>
      <outline>1</outline>
    </PolyStyle>
  </Style>
</Document>
</kml>';



            $file = "kmz_files/ambitos.kmz";
            $zipper = new Zipper();
            $zipper->make($file)->addString('doc.kml', $kml);
            $zipper->close();

            $headers = [ 'Content-Type' => 'application/octet-stream' ];
            return response()->download( $file, 'mapasKmzAmbitos.kmz', $headers );

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

    public function getPanelPlantas()
    {
        $estado = Estado::orderBy('nombre', 'asc')->get();
        return view('sistema.mapas.panelPlantas', compact('estado'));
    }
    public function getKmzPlantas(Request $request)
    {

        try{
            $where = null;
            if($request->has('edo')){
                $where = [['plantas.latitud','<>',''], ['plantas.estado', 'ilike', '%'.$request->edo.'%']];
            }
            elseif($request->has('amb')){
                $where = [['plantas.latitud','<>',''], ['plantas.ambito', 'ilike', '%'.$request->amb.'%' ]];
            }
            else{
                $where = [['plantas.latitud','<>','']];
            }



            $plantas = DB::table('plantas')
                ->join('ambitos', 'plantas.ambito', 'like', 'ambitos.nombre')
                ->join('empresas', 'plantas.emp_rif', '=', 'empresas.rif')
                ->join('planta_info_comp', 'planta_info_comp.planta_id', '=', 'plantas.id')
                ->select("empresas.rsocial",
                    "plantas.estado",
                    "plantas.municipio",
                    "plantas.parroquia",
                    "plantas.fespecifica",
                    "plantas.telf",
                    "plantas.latitud",
                    "plantas.longitud",
                    "plantas.ambito",
                    DB::raw("(select to_char(fecha,'DD/MM/YYYY') from planta_info_comp where planta_id = plantas.id order by fecha desc  limit 1 offset 0 ) as fecha"),
                    DB::raw("(select mobra from planta_info_comp where planta_id = plantas.id order by fecha desc  limit 1 offset 0 ) as mobra"),
                    DB::raw("(select cinstalada from planta_info_comp where planta_id = plantas.id order by fecha desc  limit 1 offset 0 ) as cinstalada"),
                    DB::raw("(select coperativa from planta_info_comp where planta_id = plantas.id order by fecha desc  limit 1 offset 0 ) as coperativa"),
                    DB::raw("(select produccion from planta_info_comp where planta_id = plantas.id order by fecha desc  limit 1 offset 0 ) as produccion"),
                    DB::raw("(select inventario from planta_info_comp where planta_id = plantas.id order by fecha desc  limit 1 offset 0 ) as inventario"),
                    DB::raw("(select pprincipal from planta_info_comp where planta_id = plantas.id order by fecha desc  limit 1 offset 0 ) as pprincipal"),
                    DB::raw("(select foto from planta_info_comp where planta_id = plantas.id order by fecha desc  limit 1 offset 0 ) as foto"),
                    "ambitos.nombre")
                ->where($where)
                ->get();

            $kml='<?xml version="1.0" encoding="UTF-8"?><kml xmlns="http://www.opengis.net/kml/2.2" xmlns:gx="http://www.google.com/kml/ext/2.2" xmlns:kml="http://www.opengis.net/kml/2.2" xmlns:atom="http://www.w3.org/2005/Atom"><Document><name>Mapa Industrias</name>
<open>1</open>';

            //dd($kml);
            foreach ($plantas as $emp){
                $kml.='<Placemark>
                  <name>'.UtilidadesController::limpiarCaracteresEspeciales($emp->rsocial).'</name>
                  <description><![CDATA[<table style="font-family:Arial,Verdana,Times;font-size:14px;text-align:left;width:100%;border-collapse:collapse;">
       <tr style="text-align:center;font-weight:bold;">
            <td>PLANTAS</td>
        </tr>
        <tr style="text-align:center;font-weight:bold;background:#9CBCE2">
            <td>'.UtilidadesController::limpiarCaracteresEspeciales($emp->ambito).' </td>
        </tr>
        <tr style="text-align:center;font-weight:bold;background:#9CBCE2">
            <td>'.UtilidadesController::limpiarCaracteresEspeciales($emp->rsocial).' </td>
        </tr>
        <tr>
            <td>
               <table style="font-family:Arial,Verdana,Times;font-size:10px;text-align:left;width:100%;border-spacing:0px; border-collapse:collapse;">
                    <tr bgcolor="#D4E4F3">
                        <td style="border: 1px #999999 solid;">ESTADO</td>
                        <td style="border: 1px #999999 solid;">MUNICIPIO</td>
                        <td style="border: 1px #999999 solid;">PARROQUIA</td>
                    </tr>
                    <tr>
                        <td style="border: 1px #999999 solid;">'.$emp->estado.'</td>
                        <td style="border: 1px #999999 solid;">'.$emp->municipio.'</td>
                        <td style="border: 1px #999999 solid;">'.$emp->parroquia.'</td>
                    </tr>
                    <tr bgcolor="#D4E4F3">
                        <td style="border: 1px #999999 solid;" colspan="2">FUNCION ESPECIFICA</td>
                        <td style="border: 1px #999999 solid;" >TELF</td>
                    </tr>
                    <tr>
                        <td style="border: 1px #999999 solid;" colspan="2">'.$emp->fespecifica.'</td>
                        <td style="border: 1px #999999 solid;">'.$emp->telf.'</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="text-align:center;font-weight:bold;background:#9CBCE2">
            <td>INFO. COMPLEMENTARIA</td>
        </tr>
        <tr style="text-align:center;font-weight:bold;">
            <td>
            <table style="font-family:Arial,Verdana,Times;font-size:10px;text-align:left;width:100%;border-spacing:0px; border-collapse:collapse;">
                    <tr bgcolor="#D4E4F3">
                        <td style="border: 1px #999999 solid;">FECHA</td>
                        <td style="border: 1px #999999 solid;">M OBRA</td>
                        <td style="border: 1px #999999 solid;">C INSTALADA</td>
                    </tr>
                    <tr>
                        <td style="border: 1px #999999 solid;">'.$emp->fecha.'</td>
                        <td style="text-align: right;border: 1px #999999 solid;">'.$emp->mobra.'</td>
                        <td style="text-align: right;border: 1px #999999 solid;">'.$emp->cinstalada.'</td>
                    </tr>

                    <tr bgcolor="#D4E4F3">
                        <td style="border: 1px #999999 solid;">C OPERATIVA</td>
                        <td style="border: 1px #999999 solid;">PRODUCCION</td>
                        <td style="border: 1px #999999 solid;">INVENTARIO</td>
                    </tr>
                    <tr>
                        <td style="text-align: right;border: 1px #999999 solid;">'.$emp->coperativa.' (%)</td>
                        <td style="text-align: right;border: 1px #999999 solid;">'.$emp->produccion.'</td>
                        <td style="text-align: right;border: 1px #999999 solid;">'.$emp->inventario.' (DIAS)</td>
                    </tr>
                    <tr bgcolor="#D4E4F3">
                        <td style="border: 1px #999999 solid;" colspan="3">PRODUCTO PRINCIPAL</td>
                    </tr>
                    <tr>
                        <td style="border: 1px #999999 solid;" colspan="3">'.$emp->pprincipal.'</td>
                    </tr>
                    <tr>
                        <td style="text-align: center;border: 1px #999999 solid;" colspan="3">';
                if(empty($emp->foto)){
                    $kml.='NO HAY FOTO CARGADA';
                }
                else{
                    $kml.='<br><img src="'.URL::to('imagenes/plantas/'.$emp->foto).'" width="400"><br>';
                }

                $kml.='</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
]]></description>
                     <Style>
                       <IconStyle>
                         <scale>1</scale>
                           <Icon><href>'.URL::to('assets/layouts/layout/img/markers/32x32/MapMarker_Flag1_Right_Pink.png').'</href></Icon>
                       </IconStyle>
                     </Style>';

                 $lat1 = explode(',', $emp->latitud);
                 $lat2 = explode('-', $emp->latitud);

                $kml.='<Point><coordinates>'.trim($emp->longitud).','.trim($lat2[0]).'</coordinates></Point>
                </Placemark>';
            }
            $kml.='</Document>
</kml>';
            $file = "kmz_files/plantas.kmz";
            $zipper = new Zipper();
            $zipper->make($file)->addString('doc.kml', $kml);
            $zipper->close();

            $headers = [ 'Content-Type' => 'application/octet-stream' ];
            return response()->download( $file, 'mapasKmzPlantas.kmz', $headers );

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
