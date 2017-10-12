{{-- dd($visita,  $avprod, $avmpri, $avcom, $vinvp) --}}
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
    @page { margin: 60px 50px; header: page-header; footer: page-footer; }
    body { margin: 0; font-family: Arial, Verdana, sans-serif; }
    /*#content{ vertical-align: top !important;  }*/
    table{ font-size: 10px; border-collapse: collapse;}
    .cell{border: 1px solid grey; border-collapse: collapse; padding: 6px; margin: 0; }
    .cell-title{ background-color: darkred ; color: #ffffff; border: 1px solid darkred; border-collapse: collapse; padding: 6px; margin: 0; font-size: 12px; font-weight: bold; text-align: center;}
    .cell-subtitle{ background-color: darkred; color: #ffffff; border: 1px solid darkred; border-collapse: collapse; padding: 6px; margin: 0; font-size: 10px; font-weight: bold; text-align: center; }
    .foto{ width: 400px; }
</style>
</head>
<body>

<htmlpageheader name="page-header">
    <br>
    <img src="{{ public_path().'/assets/pages/img/cintillo.png' }}" width="100%">
</htmlpageheader>

<htmlpagefooter name="page-footer">
    <hr>
    <table width="100%" border="0">
        <tbody>
        <tr>
            <td align="center">
                Pág. {PAGENO}<br>
                Dirección de Seguimiento y Evaluación a la Industria<br>
                Sistema de Información Geográfica de Industria y Comercio  (SIGIC)
            </td>
        </tr>
        </tbody>
    </table>
</htmlpagefooter>

<div id="content">
    <hr>

    @foreach($visita as $vis)
    <table width="100%">
        <tbody>
        <tr>
            <td width="8.3%">&nbsp;</td>
            <td width="8.3%">&nbsp;</td>
            <td width="8.3%">&nbsp;</td>
            <td width="8.3%">&nbsp;</td>
            <td width="8.3%">&nbsp;</td>
            <td width="8.3%">&nbsp;</td>
            <td width="8.3%">&nbsp;</td>
            <td width="8.3%">&nbsp;</td>
            <td width="8.3%">&nbsp;</td>
            <td width="8.3%">&nbsp;</td>
            <td width="8.3%">&nbsp;</td>
            <td width="8.3%">&nbsp;</td>
        </tr>
        <tr>
            <td align="center" colspan="12"><h2>FICHA INFORMATIVA</h2></td>
        </tr>
        <tr>
            <td colspan="6" class="cell">Tiempo de operatividad de la empresa: <b>{{ $vis->operatividad  }}</b></td>
            <td colspan="3" class="cell">Fecha: <b>{{ $vis->fecha }}</b></td>
            <td colspan="3" class="cell">CIIU/CAEV: <b>{{ $vis->ciiu }}</b></td>
        </tr>
        <tr>
            <td colspan="12"><hr></td>
        </tr>
        <tr>
            <td colspan="12" class="cell-title">INFORMACIÓN DE LA EMPRESA</td>
        </tr>
        <tr>
            <td colspan="6" class="cell">Nombre de la Empresa: <b>{{ $vis->empresa }}</b></td>
            <td colspan="6" class="cell">RIF: <b>{{ $vis->rif }}</b></td>
        </tr>
        <tr>
            <td colspan="4" class="cell">Estado: <b>{{ $vis->edo }}</b></td>
            <td colspan="4" class="cell">Municipio: <b>{{ $vis->mcpio }}</b></td>
            <td colspan="4" class="cell">Parroquia: <b>{{ $vis->pquia }}</b></td>
        </tr>
        <tr>
            <td colspan="12" class="cell">Dirección: <b>{{ $vis->direccion }}</b></td>
        </tr>
        <tr>
            <td colspan="4" class="cell">Tipo de empresa: <b>{{ $vis->tipo_emp }}</b> </td>
            <td colspan="4" class="cell">Número de trabajadores: <b>{{ $vis->trabajadores }} @if($vis->tnum =! 0 )  ({{ $vis->tnum }})</b>@endif</td>
            <td colspan="4" class="cell">Sector actividad industrial: <b>{{ $vis->sector }}</b> </td>
        </tr>
        <tr>
            <td colspan="12" class="cell">Servicios de la Parcela: <b>{{ $vis->servicios }}</b></td>
        </tr>
        <tr>
            <td colspan="3" class="cell">Presidente: <b>{{ $vis->contacto }}</b> </td>
            <td colspan="3" class="cell">C.I.: <b>{{ number_format($vis->ci_cont, 0, ",", ".") }}</b></td>
            <td colspan="3" class="cell">Telf: <b>{{ $vis->telf }}</b> </td>
            <td colspan="3" class="cell">Email: <b>{{ $vis->email }}</b> </td>
        </tr>
        <tr>
            <td colspan="12" class="cell">Objeto de la empresa: <b>{{ $vis->objeto }}</b></td>
        </tr>
        <tr>
            <td colspan="12"><hr></td>
        </tr>
        <tr>
            <td colspan="12" class="cell-title">INFORMACIÓN DE LA PRODUCCIÓN</td>
        </tr>
         @if(count($avprod) != 0)
            @for($pi = 0; $pi < sizeof($avprod); $pi++)
            <tr><td colspan="12" class="cell">
                    <table width="100%">
                      <tbody>
                      <tr>
                          <td class="cell-subtitle" width="12.5%">Producto</td>
                          <td class="cell-subtitle" width="12.5%">Código arancelario</td>
                          <td class="cell-subtitle" width="12.5%">Medida</td>
                          <td class="cell-subtitle" width="12.5%">Capacidad Instalada (mes)</td>
                          <td class="cell-subtitle" width="12.5%">Capacidad utilizada (mes)</td>
                          <td class="cell-subtitle" width="12.5%">Producción anual (año ant)</td>
                          <td class="cell-subtitle" width="12.5%">Producción Actual (mes)</td>
                          <td class="cell-subtitle" width="12.5%">Producción meta (año en curso)</td>
                      </tr>
                       @foreach($avprod[$pi] as $vp)
                       <tr>
                           <td class="cell" width="12.5%">{!!  wordwrap($vp->producto, 30, "<br>") !!}</td>
                           <td class="cell" width="12.5%">{{ $vp->cod_aran }}</td>
                           <td class="cell" width="12.5%">{{ $vp->medida }}</td>
                           <td class="cell" width="12.5%">{{ number_format($vp->cinstalada, 2, ",", ".") }}</td>
                           <td class="cell" width="12.5%">{{ number_format($vp->coperativa, 2, ",", ".") }}</td>
                           <td class="cell" width="12.5%">{{ number_format($vp->prodaant, 2, ",", ".") }}</td>
                           <td class="cell" width="12.5%">{{ number_format($vp->prodact, 2, ",", ".") }}</td>
                           <td class="cell" width="12.5%">{{ number_format($vp->prodmeta, 2, ",", ".") }}</td>
                       </tr>
                       @endforeach
                        </tbody>
                    </table>
            </td></tr>
            @endfor
         @endif
        <tr>
            <td colspan="12" class="cell">Líneas de producción: <b>{{ $vis->l_prod }}</b></td>
        </tr>
        <tr>
            <td colspan="12" class="cell">Nudos críticos para la producción: <b>{{ $vis->nc_prod}}</b></td>
        </tr>
        <tr>
            <td colspan="12"><hr></td>
        </tr>
        <tr>
            <td colspan="12" class="cell-title">INFORMACIÓN DE LA MATERIA PRIMA</td>
        </tr>
          @if(count($avmpri) != 0)
                    @for($pm = 0; $pm < sizeof($avmpri); $pm++)
                    <tr><td colspan="12" class="cell">
                            <table width="100%">
                                <tbody>
                                <tr>
                                    <td class="cell-subtitle" width="16.6%">Producto</td>
                                    <td class="cell-subtitle" width="16.6%">Proveedor</td>
                                    <td class="cell-subtitle" width="16.6%">Código arancelario</td>
                                    <td class="cell-subtitle" width="16.6%">Medida</td>
                                    <td class="cell-subtitle" width="16.6%">Cantidad requerida (mes)</td>
                                    <td class="cell-subtitle" width="16.6%">Cantidad Disponible</td>
                                </tr>
                                @foreach($avmpri[$pm] as $vm)
                                    <tr>
                                        <td class="cell" width="16.6%">{!!  wordwrap($vm->producto, 30, "<br>") !!}</td>
                                        <td class="cell" width="16.6%">{!!  wordwrap($vm->proveedor, 30, "<br>") !!}</td>
                                        <td class="cell" width="16.6%">{{ $vm->cod_aran }}</td>
                                        <td class="cell" width="16.6%">{{ $vm->medida }}</td>
                                        <td class="cell" width="16.6%">{{ number_format($vm->creq, 2, ",", ".") }}</td>
                                        <td class="cell" width="16.6%">{{ number_format($vm->cdis, 2, ",", ".") }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                    </td></tr>
                    @endfor
          @endif
        <tr>
            <td colspan="12" class="cell">Nudos críticos para la adquisición de materia prima: <b>{{ $vis->nc_mprima }}</b></td>
        </tr>
        <tr>
            <td colspan="12"><hr></td>
        </tr>
        <tr>
            <td colspan="12" class="cell-title">INFORMACIÓN DE LA COMERCIALIZACIÓN</td>
        </tr>
           @if(count($avcom) != 0 )
                    @for($pc = 0; $pc < sizeof($avcom); $pc++)
                        <tr><td colspan="12" class="cell">
                        <table width="100%">
                            <tbody>
                            <tr>
                                <td class="cell-subtitle" width="11.1%">Producto</td>
                                <td class="cell-subtitle" width="11.1%">Código arancelario</td>
                                <td class="cell-subtitle" width="11.1%">Mercado Interno</td>
                                <td class="cell-subtitle" width="11.1%">Exportación</td>
                                <td class="cell-subtitle" width="11.1%">Precio Bs.</td>
                                <td class="cell-subtitle" width="11.1%">Venta Nacional (año ant)</td>
                                <td class="cell-subtitle" width="11.1%">Venta Nacional estimación (año act)</td>
                                <td class="cell-subtitle" width="11.1%">Exportación USD (año ant)</td>
                                <td class="cell-subtitle" width="11.1%">Exportación estimación (año act)$</td>
                            </tr>
                        @foreach($avcom[$pc] as $vc)
                        <tr>
                            <td class="cell"  width="11.1%">{!! wordwrap($vc->producto, 30, "<br>") !!}</td>
                            <td class="cell"  width="11.1%">{{ $vc->cod_aran }}</td>
                            <td class="cell"  width="11.1%">{{ $vc->minterno }}</td>
                            <td class="cell"  width="11.1%">{{ $vc->exportacion }}</td>
                            <td class="cell"  width="11.1%">{{ number_format($vc->preciobs, 2, ",", ".") }}</td>
                            <td class="cell"  width="11.1%">{{ number_format($vc->ventanac, 2, ",", ".") }}</td>
                            <td class="cell"  width="11.1%">{{ number_format($vc->ventanacest, 2, ",", ".") }}</td>
                            <td class="cell"  width="11.1%">{{ number_format($vc->exportacionusd, 2, ",", ".") }}</td>
                            <td class="cell"  width="11.1%">{{ number_format($vc->exportacionestusd, 2, ",", ".") }}</td>
                        </tr>
                        @endforeach
                            </tbody>
                        </table>
                        </td></tr>
                    @endfor
           @endif
        <tr>
            <td colspan="12" class="cell">Destino de colocación de la producción principales clientes: <b>{{ $vis->pclientes }}</b> </td>
        </tr>
        <tr>
            <td colspan="12" class="cell">Destino de colocación de la producción por estado:  <b>{{ $vis->pedo }}</b> </td>
        </tr>
        <tr>
            <td colspan="12"><hr></td>
        </tr>
        <tr>
            <td colspan="12" class="cell-title">REQUERIMIENTOS DE INVERSIÓN Y PERMISOS</td>
        </tr>
        @foreach($vinvp as $vv)
        <tr>
            <td colspan="4" class="cell">Requiere Financiamiento: <b>{{ $vv->financiamiento}}</b></td>
            <td colspan="4" class="cell">Monto en Bs.: <b>{{ number_format($vv->montobs, 2, ",", ".") }}</b></td>
            <td colspan="4" class="cell">Monto en USD: <b>{{ number_format($vv->montousd, 2, ",", ".") }}</b></td>
        </tr>
        <tr>
            <td colspan="12" class="cell">Uso del Financiamiento: <b>{{ $vv->uso }}</b></td>
        </tr>
        <tr>
            <td colspan="6" class="cell">Postura de compra de divisas en el Sistema DICOM: <b>{{ $vv->pdicom }}</b></td>
            <td colspan="6" class="cell">Adjudicado en la subastas: <b>{{ $vv->sdicom }}</b></td>
        </tr>
        <tr>
            <td colspan="6" class="cell">Números de Subasta: <b>{{ $vv->nsubastas }}</b></td>
            <td colspan="6" class="cell">Monto asignado USD: <b>{{ number_format($vv->asignacion, 2, ",", ".") }}</b></td>
        </tr>
        <tr>
            <td colspan="12" class="cell">Recibido financiamiento (ente): <b>{{ $vv->rfinaciamiento }}</b></td>
        </tr>
        <tr>
            <td colspan="6" class="cell">Cartera dirigida: <b>{{ $vv->cartera }}</b></td>
            <td colspan="6" class="cell">Monto financiado: <b>{{ number_format($vv->montofin, 2, ",", ".") }}</b></td>
        </tr>
        <tr>
            <td colspan="12" class="cell">Permisos, licencias, certificados y trámites: <b>{{ $vv->permisos }}</b></td>
        </tr>
        @endforeach
        <tr>
            <td colspan="12"><hr></td>
        </tr>
        <tr>
            <td colspan="12" class="cell">Observaciones generales: <b>{{ $vis->observacion }}</b></td>
        </tr>
        <tr>
            <td colspan="12" class="cell">Describa el Proceso productivo (paso a paso): <b>{{ $vis->pproductivo }}</b> </td>
        </tr>
        <tr>
            <td colspan="12"><hr></td>
        </tr>
        <tr>
            <td colspan="12" class="cell-title">FOTOS</td>
        </tr>
        <tr>
            <td colspan="6" class="cell"  align="center">
                @if(empty($vis->foto1))
                    &nbsp;
                @else
                    <img src="{{ public_path().'/imagenes/'.$vis->foto1  }}" width="80%" class="foto" >
                @endif
            </td>
            <td colspan="6" class="cell"  align="center">
                @if(empty($vis->foto2))
                    &nbsp;
                @else
                    <img src="{{ public_path().'/imagenes/'.$vis->foto2  }}" width="80%" class="foto">
                @endif
            </td>
        </tr>
        <tr>
            <td colspan="6" class="cell"  align="center">
                @if(empty($vis->foto3))
                    &nbsp;
                @else
                    <img src="{{ public_path().'/imagenes/'.$vis->foto3 }}" width="80%" class="foto">
                @endif
            </td>
            <td colspan="6" class="cell"  align="center">
                @if(empty($vis->foto4))
                    &nbsp;
                @else
                    <img src="{{ public_path().'/imagenes/'.$vis->foto4  }}" width="80%" class="foto">
                @endif
            </td>
        </tr>
        </tbody>
    </table>
    @endforeach
</div>
</body>
</html>