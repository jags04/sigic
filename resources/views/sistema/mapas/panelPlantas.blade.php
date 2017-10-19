@extends('layouts.mapa')

@section('styles')
<style>
    .row {
        margin: 0 auto !important;
    }
    #panel, #panelIfr{
        width: 100%;
        height: 100vh !important;
    }
    #panelIfr{
        border: 1px dashed #cccccc;
    }

    .ui-autocomplete {
        position: absolute;
        top: 0;
        left: 0;
        cursor: default;
        z-index: 9050 !important;
        max-height: 400px !important;
        max-width: 400px !important;
        overflow-y: auto;
        overflow-x: hidden;
    }
</style>
@endsection

@section('content')
    <div class="row" id="panel">
        <div class="col-md-3">
            <!-- BEGIN Portlet PORTLET-->
            <br>
            <!-- BEGIN Portlet PORTLET-->
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">Buscar por estado ámbito </div>
                </div>
                <div class="portlet-body">
                    <div class="form-group form-md-line-input has-success">
                        <select class="form-control" id="estado_amb" name="estado_amb" onchange=" getAmbitos('estado_amb', 'amb', '{!! route('sistema.getAmbito') !!}') " >
                            <option value=""></option>
                            @foreach($estado as $edo)
                                <option value="{{ $edo->nombre }}">{{ $edo->nombre }}</option>
                            @endforeach
                        </select>
                        <label for="estado">Estado</label>
                    </div>

                    <div class="form-group form-md-line-input has-success">
                        <select class="form-control" id="amb" name="amb" >
                            <option value=""></option>
                        </select>
                        <label for="amb">Ámbito</label>
                    </div>
                </div>
            </div>
            <!-- END Portlet PORTLET-->
            <!-- END Portlet PORTLET-->

            <!-- BEGIN Portlet PORTLET-->
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">Buscar por estado </div>
                </div>
                <div class="portlet-body">
                    <div class="form-group form-md-line-input has-success">
                        <select class="form-control" id="estado" name="estado" >
                            <option value=""></option>
                            @foreach($estado as $edo)
                                <option value="{{ $edo->nombre }}">{{ $edo->nombre }}</option>
                            @endforeach
                        </select>
                        <!--<label for="estado">Estado</label>-->
                    </div>
                </div>
            </div>
            <!-- END Portlet PORTLET-->

        </div>
        <div class="col-md-9">
            <iframe frameborder="0" id="panelIfr"></iframe>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="http://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}" type="text/javascript"></script>
    <script src="{{ URL::to('assets/global/plugins/gmaps/gmaps.min.js') }}" type="text/javascript"></script>
    <script src="{{ URL::to('assets/global/plugins/gmaps/maps.utilities.js') }}" type="text/javascript"></script>
@endsection


@section('script-body')
    <script>
        $(function () {
            $('iframe').attr("src", "{!! route('sistema.mapasPlantas') !!}");
           /* $( "#com").autocomplete({
                source: '{--!! route('sistema.getPlantasCoord') !!--}',
                minLength: 2,
                select: function( event, ui ) {
                    $("#id").val(ui.item.id)
                }
            });

            $('#empBtn').click(function () {
                if($('#rif').val() == ''){
                    alert('Debe elegir una empresa del resultado del autocompletado!!!')
                }
                else{
                    $('iframe').attr("src", "{!! route('sistema.mapasComercio') !!}?id="+$('#id').val());
                }
            })*/

            $('#estado').change(function () {
                if($('#estado').val()==''){
                    alert('Debe elegir un estado de la lista!!!')
                }
                else{
                    $('iframe').attr("src", "{!! route('sistema.mapasPlantas') !!}?edo="+$('#estado').val());
                    $('#etiqueta').empty().html();
                }
            })

            $('#amb').change(function () {
                if($('#estado_amb').val()==''){
                    alert('Debe elegir un estado de la lista!!!')
                }
                else{
                    if($('#amb').val()==''){
                        alert('Debe elegir un ambito de la lista!!!')
                    }
                    else{
                        $('iframe').attr("src", "{!! route('sistema.mapasPlantas') !!}?edo="+$('#estado_amb').val()+'&amb='+$('#amb').val());
                        $('#etiqueta').empty().html();
                    }

                }
            })


        })

        function getSectorSubsectorActeco(cond, el1, el2,  url){
            $.ajax({
                dataType: "json",
                url: url,
                data: {cnd: cond, dato: $('#'+el1).val(), rand: Math.random() },
                beforeSend: function() { $('#'+el2).addClass('ui-autocomplete-loading'); },
                success: function(data) {
                    $('#'+el2).find('option:not(:first)').remove().removeClass('ui-autocomplete-loading');
                    $.each(data, function(i, item) {
                        $('#'+el2).append($('<option>').text(item.label).attr('value', item.value));
                    });
                },
                complete:function(){ $('#'+el2).removeClass('ui-autocomplete-loading'); }
            });
        }

        function getAmbitos(el1, el2,  url){
            $.ajax({
                dataType: "json",
                url: url,
                data: { edo: $('#'+el1).val(), rand: Math.random() },
                beforeSend: function() { $('#'+el2).addClass('ui-autocomplete-loading'); },
                success: function(data) {
                    $('#'+el2).find('option:not(:first)').remove().removeClass('ui-autocomplete-loading');
                    $.each(data, function(i, item) {
                        $('#'+el2).append($('<option>').text(item.label).attr('value', item.value));
                    });
                },
                complete:function(){ $('#'+el2).removeClass('ui-autocomplete-loading'); }
            });
        }

        /*function gmapPrint() {
            var content = window.document.body; // get you map details
            var newWindow = window.open(); // open a new window
            newWindow.document.write(content.innerHTML); // write the map into the new window
            newWindow.print(); // print the new window
        }*/

    </script>
@endsection