/**
 * Created by jags on 01/08/2017.
 */

$(function(){
    $("input[data-type='number']").inputmask("decimal", {
        radixPoint: ",",
        autoGroup: true,
        groupSeparator: ".",
        groupSize: 3,
        autoUnmask: true
    });
    $(":input").inputmask();

    dt_table = $('#dt_comercios').DataTable({
        pagingType: "full_numbers",
        buttons: [
            {text: '<i class="fa fa-plus fa-lg"></i>',titleAttr: 'Agregar registro', className: 'btn btn-no-border btn-sm blue btn-outline',
                action: function ( e, dt, node, config ){
                    $( '#addComercios' ).modal('show');
                }
            },
            {extend:'excelHtml5',text:'<i class="fa fa-file-excel-o fa-lg"></i>',titleAttr: 'Excel', className: 'btn btn-no-border btn-sm green-meadow btn-outline'},
            {extend:'pdfHtml5',text:'<i class="fa fa-file-pdf-o fa-lg"></i>',titleAttr: 'PDF', className: 'btn btn-sm btn-no-border red btn-outline', orientation: 'landscape', pageSize: 'LEGAL'},
            /*{text: '<i class="fa fa-cloud-upload fa-lg"></i>',className: 'btn btn-no-border btn-sm grey-mint btn-outline',titleAttr: 'Cargar data externa',
                action: function ( e, dt, node, config ){
                    $( '#cDataExt' ).modal('show');
                }
            },
            {text: '<i class="fa fa-money fa-lg"></i>',className: 'btn btn-no-border btn-sm grey-mint btn-outline',titleAttr: 'Cargar data DICOM',
                action: function ( e, dt, node, config ){
                    alert('Boton!!!!')
                }
            }*/
        ],
        // setup responsive extension: http://datatables.net/extensions/responsive/
        processing: false,
        serverSide: true,
        responsive: true,
        //"ordering": false, disable column ordering
        //"paging": false, disable pagination
        "order": [
            [0, 'asc']
        ],
        "lengthMenu": [
            [5, 10, 25, 100, 500, 1000/*, -1*/],
            [5, 10, 25, 100, 500, 1000] // change per page values here
        ],
        "pageLength": 10,// set the initial value
        "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
        language: {
            url: $('#dt_comercios').data('lenguaje')
        },
        ajax: {
            url: $('#dt_comercios').data('urldata'),
            /*data: function (d) {
             d.fecha_inicio = $('input[name=fecha_inicio]').val();
             d.fecha_fin = $('input[name=fecha_fin]').val();
             }
             //method: 'POST'*/
        },
        columns:
            [
                { data: 'rif',       name: 'comercios.rif'},
                { data: 'rsocial',   name: 'comercios.rsocial'},
                { data: 'estado',    name: 'comercios.estado'},
                { data: 'municipio', name: 'comercios.municipio', orderable: false, searchable: false, visible: false },
                { data: 'parroquia', name: 'comercios.parroquia', orderable: false, searchable: false, visible: false },
                { data: 'direccion', name: 'comercios.direccion', orderable: false, searchable: false, visible: false },
                { data: 'telf',      name: 'comercios.telf',      orderable: false, searchable: false },
                { data: 'latitud',   name: 'comercios.latitud',   orderable: false, searchable: false, visible: false },
                { data: 'longitud',  name: 'comercios.longitud',  orderable: false, searchable: false, visible: false },
                { data: 'dist',      name: 'dist',                orderable: false, searchable: false },
                { data: 'accion',    name: 'accion',              orderable: false, searchable: false}
            ],
        initComplete: function () {
            this.api().columns([1, 2]).every(function () {
                var column = this;
                var input = document.createElement("input");
                $(input).addClass('md-input').attr("placeholder", "Buscar press ENTER").appendTo($(column.footer()).empty())
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());

                        column.search(val ? val : '', true, false).draw();
                    });
                // keyup change
            });
        }
    });
    $('div .dataTables_filter input').addClass('material');
    $('#fAddCom').validate({
        submitHandler: function(form){
            //alert(JSON.stringify($('#fAddCom').serializeArray()));
            $.ajax({
                type: "POST",
                url: $('#fAddCom').data('accion'),
                data: $('#fAddCom').serialize(),
                success: function( data ) {
                    if (data.status == 1) {
                        swal(data.msg, "", "success");
                        $('#fAddCom').clearForm();
                        dt_table.ajax.reload( null, false );
                    }
                    else {
                        swal(data.msg, "", "error");
                    }
                }
            });
        }
    });

    $('#addComercio').on('hidden.bs.modal', function (e) {
        $('#municipio, #parroquia').find('option:not(:first)').remove();
        $('#fAddCom').clearForm();
    })



    findUpdateCom  = function(id){
        $.ajax({
            type: "POST",
            url:$('#url-find').data('url'),
            data: { "id": id},
            success: function( data ) {
                $.each(data, function(i, item) {
                    $('#updRsocial').html(item.rsocial);
                    $("#id_com").val(item.id);
                    $("#rsocial2").val(item.rsocial);
                    $("#rif2").val(item.rif);
                    $('#estado2').append($('<option>').text(item.estado).attr({value: item.estado,selected: "selected"}));
                    $('#municipio2').append($('<option>').text(item.municipio).attr({value: item.municipio,selected: "selected"}));
                    $('#parroquia2').append($('<option>').text(item.parroquia).attr({value: item.parroquia,selected: "selected"}));
                    $("#direccion2").val(item.direccion);
                    $("#coordenadas2").val(item.coordenadas);
                    telf = item.telf.split(';')
                    $("#telf12").val(telf[0]);
                    $("#telf22").val(telf[1]);
                    $("#telf32").val(telf[2]);
                })
                $("#updComercios").modal('show');
            }
        });
    }

    $('#fUpdCom').validate({
        submitHandler: function(form){
            //alert(JSON.stringify($('#fAddCom').serializeArray()));
            $.ajax({
                type: "POST",
                url: $('#fUpdCom').data('accion'),
                data: $('#fUpdCom').serialize(),
                success: function( data ) {
                    if (data.status == 1) {
                        swal(data.msg, "", "success");
                        dt_table.ajax.reload( null, false );
                        $("#updComercios").modal('hide');
                        $('#fUpdCom').clearForm();
                    }
                    else {
                        swal(data.msg, "", "error");
                    }
                }
            });
        }
    });

    $('#updComercio').on('hidden.bs.modal', function (e) {
        $('#municipio2, #parroquia2').find('option:not(:first)').remove();
        $("#estado2 option:last").remove();
        $('#fUpdCom').clearForm();
    })


    deleteCom = function(id){
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
                url: $('#url-del').data('url'),
                data: { "id": id},
                success: function( data ) {
                    if(data.status == 1){
                        swal(data.msg, "", "success");
                        dt_table.ajax.reload( null, false );
                    }
                    else{
                        swal(data.msg, "", "error");
                    }
                }
            });
        });
    }


    viewCom = function(id){
        $.ajax({
            type: "POST",
            url: $('#url-view').data('url'),
            data: {"id": id},
            success: function( data ) {
                $.each(data, function(i, item) {
                    html = '<div class="row">'+
                        '<div class="col-md-4">RIF: <strong>'+item.rif+'</strong></div>'+
                        '<div class="col-md-8">Razón social: <strong>'+item.rsocial+'</strong></div>'+
                        '</div>'+
                        '<div class="row">'+
                        '<div class="col-md-4">Estado: <strong>'+item.estado+'</strong></div>'+
                        '<div class="col-md-4">Municipio: <strong>'+item.municipio+'</strong></div>'+
                        '<div class="col-md-4">Parroquia: <strong>'+item.parroquia+'</strong></div>'+
                        '</div>'+
                        '<div class="row">'+
                        '<div class="col-md-12">Dirección: <strong>'+item.direccion+'</strong></div>'+
                        '</div>'+
                        '<div class="row">'+
                        '<div class="col-md-12">Teléfonos: <strong>'+item.telf+'</strong></div>'
                        '</div>';
                    rif = item.id;
                })


                $('iframe#mapUbicacion').attr("src", $('#url-mapUbicacion').data('url')+"?id="+rif);

                $("#tab_1_1").empty().html(html);
                $("#detalleCom").modal('show');
            }
        });

        $('#detalleCom').on('hidden.bs.modal', function (e) {
            $('#mapUbicacion').attr("src", "");
        })
    }

    getCoordenadas = function(id){
        $('#modalMapa').modal('show');
        $('#iframeMapa').attr('src', $('#iframeMapa').data('url')+'?id='+id)
    }




    verDetalleSubastas = function(id, nombre){
        $('#modalDetSubastas').modal('show');
        $('#rsocialSubastas').empty().html(nombre);
        $.ajax({
            type: "POST",
            url: $('#url-dicomSubasta').data('url'),
            data: { "rif" : id},
            success: function( data ) {
                $('#cuerpoSubastas').empty().html(data);

            }
        });
    }

})


/******************************************************upload****/
function uploadDicom(){
    $( '#uplDicom' ).modal('show');

    $(".upload_dicom").upload({
        action: $('#url-uplDicom').data('url'),
        label: '<br><i class="fa fa-upload fa-5x"></i>',
        multiple: false,
        //postData: { id : ide },
        autoUpload: true,
        maxSize: 1073741824,
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

    $('#uplDicom').on('hidden.bs.modal', function (e) {
        $(".upload_dicom").upload("destroy");
        $(".filelist.queue, .filelist.complete").empty()
    })
}

function uploadProduccion(ide){
    $( '#uplProduccion' ).modal('show');

    $(".upload").upload({
        action: $('#url-uplProduccion').data('url'),
        label: '<br><i class="fa fa-upload fa-5x"></i>',
        multiple: false,
        postData: { id : ide },
        autoUpload: true,
        maxSize: 1073741824,
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
    if (file.name.indexOf(".csv") < 0 ) {
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
    }
    else {
        var $target = $(this).parents("form").find(".filelist.queue").find("li[data-index=" + file.index + "]").addClass('font-green-sharp');
        $target.find(".file").text(file.name+' '+response.trim());
        $target.find(".progress").remove();
        $target.find(".cancel").remove();
        $target.appendTo($(this).parents("form").find(".filelist.complete"));
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

//"_token": "{{ csrf_token() }}",
