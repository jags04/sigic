@foreach($info as $inf)
        <input type="hidden" id="planta_id_info" value="{{ $inf->planta_id  }}">
        <div class="row">
            <div class="col-sm-12 ">
                <a class="btn btn-no-border red btn-sm btn-outline pull-right" href="javascript:void(0)" title="Eliminar" onclick="eliminarInfoComp('{{ $inf->id }}')"><i class="fa fa-trash-o fa-lg"></i></a>
                <a class="btn btn-no-border green btn-sm btn-outline pull-right" href="javascript:void(0)" title="Recargar" onclick="recargaInfoComp('{{ $inf->planta_id }}', 'cuerpoInfoComp')"><i class="fa fa-refresh fa-lg"></i></a>
                <a class="btn btn-no-border blue btn-sm btn-outline pull-right" href="javascript:void(0)" title="Recargar" onclick="actInfoComp('{{ $inf->id }}', 'cuerpoInfoComp')"><i class="fa fa-edit fa-lg"></i></a>
            </div>
        </div><br>
        <div class="row">
            <div class="col-sm-6">Fecha: <strong>{{ \App\Http\Controllers\UtilidadesController::convertirFecha($inf->fecha) }}</strong></div>
        </div><br>
        <div class="row">
            <div class="col-sm-5">Empresa: <strong>{{ $inf->rsocial }}</strong></div>
            <div class="col-sm-5">Ámbito: <strong>{{ $inf->ambito }}</strong></div>
            <div class="col-sm-2">Mano de obra: <strong>{{ $inf->mobra }}</strong></div>
        </div><br>
        <div class="row">
            <div class="col-sm-3">Capacidad instalada (mes): <strong>{{ number_format($inf->cinstalada, 2, ",", ".") }}</strong></div>
            <div class="col-sm-3">Capacidad operativa (mes): <strong>{{ number_format($inf->coperativa, 2, ",", ".") }} %</strong></div>
            <div class="col-sm-3">Producción actual (mes): <strong>{{ number_format($inf->produccion, 2, ",", ".") }}</strong></div>
            <div class="col-sm-3">Inventario (dias): <strong>{{ $inf->inventario }}</strong></div>
        </div><br>
        <div class="row">
            <div class="col-sm-12">Producto principal: <strong>{{ $inf->pprincipal }}</strong></div>
        </div><br>
        <div class="row">
            <div class="col-sm-12">Nudo critico (producción): <strong>{{ $inf->ncritico }}</strong></div>
        </div><br>
        <div class="row">
            <div class="col-sm-12">Observación: <strong>{{ $inf->observacion }}</strong></div>
        </div><br><br><br>
        @if(empty($inf->foto))
            <div class="row ">
                <div class="col-sm-12 text-center">
                    <a href="javascript:;" class="icon-btn" onclick="uploadFoto({{ $inf->id }})">
                        <i class="fa fa-upload fa-5x"></i>
                        <div> Subir foto </div>
                    </a>
                </div>
            </div>
        @else
            <div class="row ">
                <div class="col-sm-12 text-center">
                    <img class="" src="{{ asset('imagenes/plantas/'.$inf->foto) }}" onclick="eliminarFoto({{ $inf->id }})" title="Click para eliminar foto">
                </div>
            </div>
        @endif

@endforeach

<div id="actInfoComp" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <form id="fActInfoComp" action="#" data-accion="{{ route('sistema.plantas.info.add') }}">
        {{ csrf_field() }}
        <input type="hidden" id="info_id" name="id">
        <input type="hidden" id="plan_id" name="planta_id">
        <div class="modal-dialog modal-full">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- BEGIN MARKERS PORTLET-->
                    <div class="portlet light portlet-fit">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-green bold uppercase">Actualizar información complementaria</span>
                            </div>
                            <div class="actions">
                                <a class="btn btn-circle btn-icon-only btn-default" data-dismiss="modal" aria-hidden="true">
                                    <i class="fa fa-close"></i>
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group form-md-line-input has-success">
                                        <input type="date" class="form-control" id="fecha2" name="fecha" required>
                                        <label for="fecha2">Fecha<span class="required" aria-required="true">*</span></label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-md-line-input has-success">
                                        <input type="text" class="form-control" id="mobra2" name="mobra" data-type='number' required>
                                        <label for="mobra2">Mano de obra<span class="required" aria-required="true">*</span></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group form-md-line-input has-success">
                                        <input type="text" class="form-control" id="cinstalada2" name="cinstalada" data-type='number' required>
                                        <label for="cinstalada2">Capacidad instalada (mes)<span class="required" aria-required="true">*</span></label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-md-line-input has-success">
                                        <input type="text" class="form-control" id="coperativa2" name="coperativa" data-type='number' required>
                                        <label for="coperativa2">Capacidad operativa % (mes)<span class="required" aria-required="true">*</span></label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-md-line-input has-success">
                                        <input type="text" class="form-control" id="produccion2" name="produccion" data-type='number' required>
                                        <label for="produccion2">Producción actual (mes)<span class="required" aria-required="true">*</span></label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group form-md-line-input has-success">
                                        <input type="text" class="form-control" id="inventario2" name="inventario" data-type='number' required>
                                        <label for="inventario2">Inventario (días)<span class="required" aria-required="true">*</span></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group form-md-line-input has-success">
                                        <input type="text" class="form-control" id="pprincipal2" name="pprincipal"  required>
                                        <label for="pprincipal2">Producto principal<span class="required" aria-required="true">*</span></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group form-md-line-input has-success">
                                        <textarea class="form-control" rows="3" id="ncritico2" name="ncritico" required></textarea>
                                        <label for="ncritico2">Nudo critico (producción)<span class="required" aria-required="true">*</span></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group form-md-line-input has-success">
                                        <textarea class="form-control" rows="3" id="observacion2" name="observacion" required></textarea>
                                        <label for="observacion2">Observación<span class="required" aria-required="true">*</span></label>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- END MARKERS PORTLET-->
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-no-border btn-outline red">Cancelar</button>
                    <button type="submit" class="btn btn-no-border btn-outline green">Actualizar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </form>
</div>

<div class="modal fade" id="uplFoto" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="portlet light portlet-fit">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject font-green bold uppercase">Cargar Foto</span>
                        </div>
                        <div class="actions">
                            <a class="btn btn-circle btn-icon-only btn-default" data-dismiss="modal" aria-hidden="true">
                                <i class="fa fa-close"></i>
                            </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <!--<form action="upload.php" class="dropzone"></form>-->
                        <form action="#" method="GET" class="form demo_form">
                            <div class="upload"></div>
                            <div class="filelists">
                                <h5>Completados</h5>
                                <ol class="filelist complete"></ol>
                                <h5>En cola</h5>
                                <ol class="filelist queue"></ol>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="closeModalUpload" class="btn btn-no-border btn-outline green">Aceptar</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<script>

    function actInfoComp(id){
        $.ajax({
            type: "POST",
            url:'{{ route('sistema.plantas.info.src') }}',
            data: { "id": id},
            success: function( data ) {
                $.each(data, function(i, item) {
                    $('#info_id').val(item.id);
                    $("#fecha2").val(item.fecha);
                    $("#mobra2").val(item.mobra);
                    $("#cinstalada2").val(item.cinstalada);
                    $('#coperativa2').val(item.coperativa);
                    $("#produccion2").val(item.produccion);
                    $('#inventario2').val(item.inventario);

                    $('#pprincipal2').val(item.pprincipal);

                    $('#ncritico2').text(item.ncritico);
                    $('#observacion2').text(item.observacion);
                    $('#plan_id').val(item.planta_id);

                })

                $("input[data-type='number']").inputmask("decimal", {
                    radixPoint: ",",
                    autoGroup: true,
                    groupSeparator: ".",
                    groupSize: 3,
                    autoUnmask: true
                });
                $("#actInfoComp").modal('show');
            }
        });
    }

    $('#fActInfoComp').validate({
        submitHandler: function(form){
            //alert(JSON.stringify($('#fAddPlan').serializeArray()));
            $.ajax({
                type: "POST",
                url: '{{ route('sistema.plantas.info.upd') }}',
                data: $('#fActInfoComp').serialize(),
                success: function( data ) {
                    if (data.status == 1) {
                        swal(data.msg, "", "success");
                        recargaInfoComp($('#plan_id').val(), 'cuerpoInfoComp');
                        $("#actInfoComp").modal('hide');
                        $('#fActInfoComp').clearForm();
                    }
                    else {
                        swal(data.msg, "", "error");
                    }
                }
            });
        }
    });







    function recargaInfoComp(id, div){
        $.ajax({
            type: "POST",
            url:'{!! route('sistema.plantas.info.data') !!}',
            data: {"id": id},
            success: function( data ) {
                $('#'+div).empty().html(data);
            }
        });
    }

    eliminarInfoComp = function(id){
        swal({
            title: "¿Esta seguro que quiere borrar este registro?",
            text: "Esta acción no puede ser desecha",
            type: "warning",
            cancelButtonText: "No",
            showCancelButton: true,
            confirmButtonText: "Si, estoy seguro",
            reverseButtons: true
        }).then(function (text) {
            $.ajax({
                type: "POST",
                url:'{!! route('sistema.plantas.info.del') !!}',
                data: {"_token": "{{ csrf_token() }}", "id": id},
                success: function( data ) {
                    if(data.status == 1){
                        swal(data.msg, "", "success");
                        $('#modalDivInfo').modal('hide');
                    }
                    else{
                        swal(data.msg, "", "error");
                    }
                }
            });
        });
    }

    function eliminarFoto(id){
        swal({
            title: "¿Esta seguro que quiere borrar esta imagen?",
            text: "Esta acción no puede ser desecha",
            type: "warning",
            cancelButtonText: "No",
            showCancelButton: true,
            confirmButtonText: "Si, estoy seguro",
            reverseButtons: true
        }).then(function (text) {
            $.ajax({
                type: "POST",
                url:'{!! route('sistema.plantas.info.delFoto') !!}',
                data: {"_token": "{{ csrf_token() }}", "id": id},
                success: function( data ) {
                    if(data.status == 1){
                        swal(data.msg, "", "success");
                        recargaInfoComp($('#planta_id_info').val(), 'cuerpoInfoComp');
                    }
                    else{
                        swal(data.msg, "", "error");
                    }
                }
            });
        });
    }

    $('#closeModalUpload').click(function(){
        $('#uplFoto').modal('hide');
    })

    function uploadFoto(ide){

        $( '#uplFoto' ).modal('show');

        $(".upload").upload({
            action: '{{ route('sistema.plantas.info.uplFoto') }}',
            label: '<br><i class="fa fa-upload fa-5x"></i>',
            multiple: false,
            postData: { id : ide},
            autoUpload: true,
            //maxSize: 1073741824,
            maxSize: 2097152, // 2mb
            beforeSend: onBeforeSend
        }).on("start.upload", onStart)
            .on("complete.upload", onComplete)
            .on("filestart.upload", onFileStart)
            .on("fileprogress.upload", onFileProgress)
            .on("filecomplete.upload", onFileComplete)
            .on("fileerror.upload", onFileError)
            .on("chunkstart.upload", onChunkStart)
            .on("chunkprogress.upload", onChunkProgress)
            .on("chunkcomplete.upload", onChunkComplete)
            .on("chunkerror.upload", onChunkError)
            .on("queued.upload", onQueued);

        $(".filelist.queue").on("click", ".cancel", onCancel);
        $(".cancel_all").on("click", onCancelAll);

        /*$("#dzone").upload({});*/

        $('#uplProduccion').on('hidden.bs.modal', function (e) {
            $(".upload").upload("destroy");
            $(".filelist.queue, .filelist.complete").empty()
        })
    }

    function onCancel(e) {
        console.log("Cancel");
        var index = $(this).parents("li").data("index");
        $(this).parents("form").find(".upload").upload("abort", parseInt(index, 10));
    }

    function onCancelAll(e) {
        console.log("Cancel All");
        $(this).parents("form").find(".upload").upload("abort");
    }

    function onBeforeSend(formData, file) {
        console.log("Before Send");
        /*formData.append("test_field", "test_value");
         return (file.name.indexOf(".csv") < -1) ? false : formData; // cancel all jpgs
         //return formData;*/
        if (file.name.indexOf(".jpg") < 0 && file.name.indexOf(".JPG") < 0) {
            return false;
        }

        return formData;
    }

    function onQueued(e, files) {
        console.log("Queued");
        var html = '';
        for (var i = 0; i < files.length; i++) {
            html += '<li data-index="' + files[i].index + '"><span class="content"><span class="file">' + files[i].name + '</span><span class="cancel">Cancel</span><span class="progress">Queued</span></span><span class="bar"></span></li>';
        }

        $(this).parents("form").find(".filelist.queue").append(html);
    }

    function onStart(e, files) {
        console.log("Start");
        $(this).parents("form").find(".filelist.queue")
            .find("li")
            .find(".progress").text("Error");
    }

    function onComplete(e) {
        console.log("Complete");
        // All done!
    }

    function onFileStart(e, file) {
        console.log("File Start");
        $(this).parents("form").find(".filelist.queue")
            .find("li[data-index=" + file.index + "]")
            .find(".progress").text("0%");
    }

    function onFileProgress(e, file, percent) {
        console.log("File Progress");
        var $file = $(this).parents("form").find(".filelist.queue").find("li[data-index=" + file.index + "]");

        $file.find(".progress").text(percent + "%")
        $file.find(".bar").css("width", percent + "%");
    }

    function onFileComplete(e, file, response) {
        console.log("File Complete");
        if (response.trim() === "" || response.toLowerCase().indexOf("error") > -1) {
            $(this).parents("form").find(".filelist.queue")
                .find("li[data-index=" + file.index + "]").addClass("error")
                .find(".progress").text(response.trim());
            swal(response, "", "error");
        }
        else {
            var $target = $(this).parents("form").find(".filelist.queue").find("li[data-index=" + file.index + "]").addClass('font-green-sharp');
            $target.find(".file").text(file.name+" Listo");//file.name+' '+response.trim()
            $target.find(".progress").remove();
            $target.find(".cancel").remove();
            $target.appendTo($(this).parents("form").find(".filelist.complete"));
            swal(file.name+'<br>'+response, "", "success");
            recargaInfoComp($('#planta_id_info').val(), 'cuerpoInfoComp');
        }
    }

    function onFileError(e, file, error) {
        console.log("File Error");
        $(this).parents("form").find(".filelist.queue")
            .find("li[data-index=" + file.index + "]").addClass("error")
            .find(".progress").text("Error: " + error);
    }

    function onChunkStart(e, file) {
        console.log("Chunk Start");
    }

    function onChunkProgress(e, file, percent) {
        console.log("Chunk Progress");
    }

    function onChunkComplete(e, file, response) {
        console.log("Chunk Complete");
    }

    function onChunkError(e, file, error) {
        console.log("Chunk Error");
    }
</script>