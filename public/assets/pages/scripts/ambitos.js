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

    dt_table = $('#dt_ambitos').DataTable({
        pagingType: "full_numbers",
        buttons: [
            {text: '<i class="fa fa-plus fa-lg"></i>',titleAttr: 'Agregar registro', className: 'btn btn-no-border btn-sm blue btn-outline',
                action: function ( e, dt, node, config ){
                    $( '#addAmbitos' ).modal('show');
                }
            },
            {extend:'excelHtml5',text:'<i class="fa fa-file-excel-o fa-lg"></i>',titleAttr: 'Excel', className: 'btn btn-no-border btn-sm green-meadow btn-outline'},
            {extend:'pdfHtml5',text:'<i class="fa fa-file-pdf-o fa-lg"></i>',titleAttr: 'PDF', className: 'btn btn-sm btn-no-border red btn-outline', orientation: 'landscape', pageSize: 'LEGAL'},
        ],
        // setup responsive extension: http://datatables.net/extensions/responsive/
        processing: false,
        serverSide: true,
        responsive: true,
        //"ordering": false, disable column ordering
        //"paging": false, disable pagination
        "order": [
            [1, 'asc']
        ],
        "lengthMenu": [
            [5, 10, 25, 100, 500, 1000/*, -1*/],
            [5, 10, 25, 100, 500, 1000] // change per page values here
        ],
        "pageLength": 10,// set the initial value
        "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
        language: {
            url: $('#dt_ambitos').data('lenguaje')
        },
        ajax: {
            url: $('#dt_ambitos').data('urldata'),
            /*data: function (d) {
             d.fecha_inicio = $('input[name=fecha_inicio]').val();
             d.fecha_fin = $('input[name=fecha_fin]').val();
             }
             //method: 'POST'*/
        },
        columns:
            [
                { data: 'nombre', name: 'ambitos.nombre', 'width': '25%'  },
                { data: 'estado', name: 'ambitos.estado'},
                { data: 'municipio', name: 'ambitos.municipio', orderable: false, searchable: false, visible: false },
                { data: 'parroquia', name: 'ambitos.parroquia', orderable: false, searchable: false, visible: false },
                { data: 'superficie', name: 'ambitos.superficie', orderable: false, searchable: false, visible: false },
                { data: 'registros', name: 'ambitos.registros', orderable: false, searchable: false, visible: false },
                { data: 'parcelas', name: 'ambitos.parcelas', orderable: false, searchable: false, visible: false },
                { data: 'iactivos', name: 'ambitos.iactivos', orderable: false, searchable: false, visible: false },
                { data: 'iinactivos', name: 'ambitos.iinactivos', orderable: false, searchable: false, visible: false },
                { data: 'paeconomica', name: 'ambitos.paeconomica', orderable: false, searchable: false, visible: false },
                { data: 'paproductiva', name: 'ambitos.paproductiva' , 'width': '30%' },
                { data: 'poligonos', name: 'poligonos', searchable: false},
                { data: 'foto', name: 'foto', orderable: false, searchable: false, 'width': '10%' },
                { data: 'accion', name: 'accion', orderable: false, searchable: false, 'width': '20%' }
            ],
        initComplete: function () {
            this.api().columns([1, 10]).every(function () {
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
    $('#fAddAmb').validate({
        submitHandler: function(form){
            //alert(JSON.stringify($('#fAddAmb').serializeArray()));
            $.ajax({
                type: "POST",
                url: $('#fAddAmb').data('accion'),
                data: $('#fAddAmb').serialize(),
                success: function( data ) {
                    if (data.status == 1) {
                        swal(data.msg, "", "success");
                        $('#fAddAmb').clearForm();
                        dt_table.ajax.reload( null, false );
                    }
                    else {
                        swal(data.msg, "", "error");
                    }
                }
            });
        }
    });

    $('#addAmbitos').on('hidden.bs.modal', function (e) {
        $('#municipio, #parroquia').find('option:not(:first)').remove();
        $('#fAddAmb').clearForm();
    })

    findUpdateAmb  = function(id){
        $.ajax({
            type: "POST",
            url:$('#url-find').data('url'),
            data: { "id": id},
            success: function( data ) {
                $.each(data, function(i, item) {
                    $('#lbAmbito').html(item.nombre);
                    $("#id_amb").val(item.id);
                    $("#nombre2").val(item.nombre);
                    $('#estado2').append($('<option>').text(item.estado).attr({value: item.estado,selected: "selected"}));
                    $('#municipio2').append($('<option>').text(item.municipio).attr({value: item.municipio,selected: "selected"}));
                    $('#parroquia2').append($('<option>').text(item.parroquia).attr({value: item.parroquia,selected: "selected"}));

                    $("#superficie2").val(item.superficie.replace('.', ','));
                    $("#registros2").val(item.registros);
                    $("#parcelas2").val(item.parcelas);
                    $("#iactivos2").val(item.iactivos);
                    $("#iinactivos2").val(item.iinactivos);
                    $("#paeconomica2").val(item.paeconomica);
                    $("#paproductiva2").val(item.paproductiva);

                })
                $("#updAmbitos").modal('show');
            }
        });
    }

    $('#fUpdAmb').validate({
        submitHandler: function(form){
            //alert(JSON.stringify($('#fAddAmb').serializeArray()));
            $.ajax({
                type: "POST",
                url: $('#fUpdAmb').data('accion'),
                data: $('#fUpdAmb').serialize(),
                success: function( data ) {
                    if (data.status == 1) {
                        swal(data.msg, "", "success");
                        dt_table.ajax.reload( null, false );
                        $("#updAmbitos").modal('hide');
                        $('#fUpdAmb').clearForm();
                    }
                    else {
                        swal(data.msg, "", "error");
                    }
                }
            });
        }
    });

    $('#updAmbitos').on('hidden.bs.modal', function (e) {
        $('#municipio2, #parroquia2').find('option:not(:first)').remove();
        $("#estado2 option:last ").remove();
        $('#fUpdAmb').clearForm();
    })


    deleteAmb = function(id){
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


    viewAmb = function(id){
        $.ajax({
            type: "POST",
            url: $('#url-view').data('url'),
            data: {"id": id},
            success: function( data ) {
                $.each(data, function(i, item) {
                    html = '<div class="row">'+
                        '<div class="col-md-8">Nombre: <strong>'+item.nombre+'</strong></div>'+
                        '</div>'+
                        '<div class="row">'+
                        '<div class="col-md-4">Estado: <strong>'+item.estado+'</strong></div>'+
                        '<div class="col-md-4">Municipio: <strong>'+item.municipio+'</strong></div>'+
                        '<div class="col-md-4">Parroquia: <strong>'+item.parroquia+'</strong></div>'+
                        '</div>'+

                        '<div class="row">'+
                        '<div class="col-md-4">Superficie: <strong>'+item.superficie.replace('.', ',')+' ha</strong></div>'+
                        '<div class="col-md-4">Registros: <strong>'+item.registros+'</strong></div>'+
                        '<div class="col-md-4">Parcelas: <strong>'+item.parcelas+'</strong></div>'+
                        '</div>'+

                        '<div class="row">'+
                        '<div class="col-md-6">Inmuebles activos: <strong>'+item.iactivos+'</strong></div>'+
                        '<div class="col-md-6">Inmuebles inactivos: <strong>'+item.iinactivos+'</strong></div>'+
                        '</div>'+

                        '<div class="row">'+
                        '<div class="col-md-6">Ppal act económica: <strong>'+item.paeconomica+'</strong></div>'+
                        '<div class="col-md-6">Ppal act productiva: <strong>'+item.paproductiva+'</strong></div>'+
                        '</div><br><br>';
                    if(item.foto != ''){
                        html +='<div class="row">'+
                        '<div class="col-md-12 text-center"><img src="imagenes/ambitos/'+item.foto+'" title="Click para eliminar" onclick="eliminarFoto('+item.id+')"></div>'+
                        '</div><br><br>';
                    }
                    $id = item.id;
                })

                $('#cuerpoDetalleAmb').html(html);

                $('iframe#mapUbiAmbito').attr("src", $('iframe#mapUbiAmbito').data('url')+"?id="+$id);

                $("#modalCuerpoDetalleAmb").modal('show');
            }
        });

        $('#modalCuerpoDetalleAmb').on('hidden.bs.modal', function (e) {
            $('iframe#mapUbiAmbito').attr("src", "");
            dt_table.ajax.reload( null, false );
        })
    }

    cargarPoligono = function(id){
        textarea = 'coordenadas';
        $('#id_amb_pol').val(id);
        $('#modalMapaPol').modal('show');
        $('#iframeMapa').attr('src', $('#iframeMapa').data('url')+'?id='+textarea)
    }

    $('#fUplPolAmb').validate({
        submitHandler: function(form){
            swal({
                title: "¿Esta seguro que quiere agregar este polígono?",
                text: "Esta acción no puede ser desecha",
                type: "warning",
                cancelButtonText: "No",
                showCancelButton: true,
                confirmButtonText: "Si, estoy seguro",
                reverseButtons: true
            }).then(function (text) {
                $.ajax({
                    type: "POST",
                    url: $('#fUplPolAmb').data('accion'),
                    data: $('#fUplPolAmb').serialize(),
                    success: function( data ) {
                        if (data.status == 1) {
                            swal(data.msg, "", "success");
                            dt_table.ajax.reload( null, false );
                            $("#modalMapaPol").modal('hide');
                            $('#fUplPolAmb').clearForm();
                        }
                        else {
                            swal(data.msg, "", "error");
                        }
                    }
                });
            });






        }
    });

    uploadFoto = function(ide){

        $( '#uplFoto' ).modal('show');

        $(".upload").upload({
            action: $('#url-uplFoto').data('url'),
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

        $('#uplFoto').on('hidden.bs.modal', function (e) {
            dt_table.ajax.reload( null, false );
        })
    }

    $('#uplFoto').on('hidden.bs.modal', function (e) {
        $(".upload").upload("destroy");
        $(".filelist.queue, .filelist.complete").empty()
    })


})



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
            url:$('#url-delFoto').data('url'),
            data: { "id": id},
        success: function( data ) {
            if(data.status == 1){
                swal(data.msg, "", "success");
                viewAmb(id)
            }
            else{
                swal(data.msg, "", "error");
            }
        }
    });
    });
}


