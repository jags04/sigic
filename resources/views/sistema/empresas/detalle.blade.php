
<table class="table table-hover">
    <thead>
    <tr>
        <th> Subasta </th>
        <th> Fecha de Adjudicación </th>
        <th> Destino </th>
        <th> Monto adjudicado </th>
    </tr>
    </thead>
    <tbody>


@foreach($subastas as $sub)
    <tr>
        <td> {{ $sub->subasta }} </td>
        <td  class="text-right"> {{ \App\Http\Controllers\UtilidadesController::convertirFecha($sub->adjudicacion)}} </td>
        <td> {{ $sub->destino }} </td>
        <td class="text-right"> {{ number_format($sub->monto, 2, ",", ".") }} </td>
    </tr>
@endforeach
    </tbody>
    <tfoot>
    <tr>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th class="text-right">TOTAL:</th>
        <th class="text-right">{{ number_format($totalasig[0]->sum, 2, ",", ".") }}</th>
    </tr>
    </tfoot>
</table>


