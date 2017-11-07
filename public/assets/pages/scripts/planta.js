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

    dt_table = $('#dt_plantas').DataTable({
        pagingType: "full_numbers",
        buttons: [
            {text: '<i class="fa fa-plus fa-lg"></i>',titleAttr: 'Agregar registro', className: 'btn btn-no-border btn-sm blue btn-outline',
                action: function ( e, dt, node, config ){
                    $( '#addPlanta' ).modal('show');
                }
            },
            {extend:'excelHtml5',text:'<i class="fa fa-file-excel-o fa-lg"></i>',titleAttr: 'Excel', className: 'btn btn-no-border btn-sm green-meadow btn-outline'},
            /*{text: '<i class="fa fa-upload fa-lg"></i>',className: 'btn btn-no-border btn-sm grey-mint btn-outline',titleAttr: 'Cargar producción',
                 action: function ( e, dt, node, config ){
                     uploadProduccion('0', 'GRAL', $('#user-rol').data('rol'))
                 }
             },
            {text: '<i class="fa fa-cloud-upload fa-lg"></i>',className: 'btn btn-no-border btn-sm grey-mint btn-outline',titleAttr: 'Cargar data externa',
                action: function ( e, dt, node, config ){
                    $( '#cDataExt' ).modal('show');
                }
            },
            {text: '<i class="fa fa-money fa-lg"></i>',className: 'btn btn-no-border btn-sm grey-mint btn-outline',titleAttr: 'Cargar data DICOM',
                action: function ( e, dt, node, config ){
                    uploadDicom()
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
            [5, 10, 25, 100, 500, 1000, 5000/*, -1*/],
            [5, 10, 25, 100, 500, 1000, 5000] // change per page values here
        ],
        "pageLength": 10,// set the initial value
        "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
        language: {
            url: $('#dt_plantas').data('lenguaje')
        },
        ajax: {
            url: $('#dt_plantas').data('urldata'),
            /*data: function (d) {
             d.fecha_inicio = $('input[name=fecha_inicio]').val();
             d.fecha_fin = $('input[name=fecha_fin]').val();
             }
             //method: 'POST'*/
        },
        columns:
            [
                { data: 'rif', name: 'empresas.rif', 'width': '10%'},
                { data: 'rsocial', name: 'empresas.rsocial', 'width': '15%' },
                { data: 'estado', name: 'plantas.estado', 'width': '10%'},
                { data: 'municipio', name: 'plantas.municipio', orderable: false, searchable: false, visible: false },
                { data: 'parroquia', name: 'plantas.parroquia', orderable: false, searchable: false, visible: false },
                { data: 'direccion', name: 'plantas.direccion', orderable: false, searchable: false, visible: false },
                { data: 'status', name: 'plantas.status', orderable: false, searchable: false, visible: false},
                { data: 'fespecifica', name: 'plantas.fespecifica' },
                { data: 'telf', name: 'plantas.telf', orderable: false, searchable: false, visible: false },
                { data: 'ambito', name: 'plantas.ambito' },
                { data: 'latitud', name: 'plantas.latitud', orderable: false, searchable: false, visible: false },
                { data: 'longitud', name: 'plantas.longitud', orderable: false, searchable: false, visible: false },
                { data: 'actualizado', name: 'actualizado', orderable: false, searchable: false, visible: false },
                { data: 'accion', name: 'accion', orderable: false, searchable: false, "width": "20%" }
            ],
        initComplete: function () {
            this.api().columns([1, 2, 6, 7, 9]).every(function () {
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
    $('#fAddPlan').validate({
        submitHandler: function(form){
            //alert(JSON.stringify($('#fAddPlan').serializeArray()));
            $.ajax({
                type: "POST",
                url: $('#fAddPlan').data('accion'),
                data: $('#fAddPlan').serialize(),
                success: function( data ) {
                    if (data.status == 1) {
                        swal(data.msg, "", "success");
                        $('#fAddPlan').clearForm();
                        dt_table.ajax.reload( null, false );
                    }
                    else {
                        swal(data.msg, "", "error");
                    }
                }
            });
        }
    });

    $('#addPlanta').on('hidden.bs.modal', function (e) {
        $('#municipio, #parroquia, #ambito').find('option:not(:first)').remove();
        //$("#status option:last ").remove();
        $('#fAddPlan').clearForm();
    })

    findUpdatePlan  = function(id){
        $.ajax({
            type: "POST",
            url:$('#url-find').data('url'),
            data: { "id": id},
            success: function( data ) {
                $.each(data, function(i, item) {
                    $("#id_plan").val(item.id);
                    $("#rsocial2").val(item.rsocial);
                    $("#emp_rif2").val(item.rif);
                    $('#estado2').append($('<option>').text(item.estado).attr({value: item.estado,selected: "selected"}));
                    $('#municipio2').append($('<option>').text(item.municipio).attr({value: item.municipio,selected: "selected"}));
                    $('#parroquia2').append($('<option>').text(item.parroquia).attr({value: item.parroquia,selected: "selected"}));
                    $("#direccion2").val(item.direccion);
                    $("#fespecifica2").val(item.fespecifica);
                    $("#status2").append($('<option>').text(item.status).attr({value: item.status,selected: "selected"}));
                    $("#coordenadas2").val(item.coordenadas);
                    $("#telf2").val(item.telf);
                    $('#ambito2').append($('<option>').text(item.ambito).attr({value: item.ambito,selected: "selected"}));
                })
                $("#updPlanta").modal('show');
            }
        });
    }

    $('#fUpdPlan').validate({
        submitHandler: function(form){
            //alert(JSON.stringify($('#fAddPlan').serializeArray()));
            $.ajax({
                type: "POST",
                url: $('#fUpdPlan').data('accion'),
                data: $('#fUpdPlan').serialize(),
                success: function( data ) {
                    if (data.status == 1) {
                        swal(data.msg, "", "success");
                        dt_table.ajax.reload( null, false );
                        $("#updPlanta").modal('hide');
                        $('#fUpdPlan').clearForm();
                    }
                    else {
                        swal(data.msg, "", "error");
                    }
                }
            });
        }
    });

    $('#updPlanta').on('hidden.bs.modal', function (e) {
        $('#municipio2, #parroquia2, #ambito2').find('option:not(:first)').remove();
        $("#estado2 option:last, #status2 option:last ").remove();
        $('#fUpdPlan').clearForm();
    })


    deletePlan = function(id){
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


    viewPlan = function(id){
        $.ajax({
            type: "POST",
            url: $('#url-find').data('url'),
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
                        '<div class="col-md-12">Dirección: <strong>'+item.localidad+'</strong></div>'+
                        '</div>'+
                        '<div class="row">'+
                        '<div class="col-md-2">Estatus: <strong>'+item.status+'</strong></div>'+
                        '<div class="col-md-10">Función específica: <strong>'+item.fespecifica+'</strong></div>'+
                        '</div>'+
                        '<div class="row">'+
                        '<div class="col-md-4">Teléfono: <strong>'+item.tel+'</strong></div>'+
                        '<div class="col-md-8">Ámbito: <strong>'+item.ambito+'</strong></div>'+
                        '</div>';
                    $("#cuerpoPlanta").empty().html(html);
                })

                $("#viewPlanta").modal('show');
            }
        });
    }


    getCoordenadas = function(id){
        $('#modalMapa').modal('show');
        $('#iframeMapa').attr('src', $('#iframeMapa').data('url')+'?id='+id)
    }



    buscarEmpresa= function(id_input, id_input2){
        $( "#"+id_input).autocomplete({
            source: $('#url-srcEmpresa').data('url'),
            minLength: 2,
            select: function( event, ui ) {
                $("#"+id_input2).val(ui.item.id)
            }
        });
    }

    buscarAmbito= function(id_input, edo){
        if($('#'+edo).val() == ''){
            $('#'+edo).focus();
            swal('Primero debe elegir un estado!!!', "", "error");
        }
        else{
            $( "#"+id_input).autocomplete({
                source: $('#url-srcAmbito').data('url')+'?edo='+$('#'+edo).val(),
                minLength: 2,
            });
        }
    }

    infoPlan = function (id) {
        swal({
            title: '¿Qué desea hacer?',
            type: "question",
            html: "<br>" +
            '<button type="button" role="button" tabindex="0" class="btn btn-no-border btn-outline blue" id="btnAddInfoComp">' + 'Agregar Info Compl' + '</button>&nbsp;&nbsp;' +
            '<button type="button" role="button" tabindex="0" class="btn btn-no-border btn-outline green" id="btnViewInfoComp">' + 'Ver Info Compl' + '</button>',
            showCancelButton: false,
            showConfirmButton: false
        });
        $('#btnAddInfoComp').click(function(){
            swal.clickConfirm();
            $("#fAddInfoComp").clearForm();
            $('#planta_id').val(id);
            $('#addInfoComp').modal('show');
        })

        $('#btnViewInfoComp').click(function(){
            swal.clickConfirm();
            dataInfoComp(id, 'cuerpoInfoComp')
            $('#modalDivInfo').modal('show');

        })
    }

    $('#modalDivInfo').on('hidden.bs.modal', function (e) {
        dt_table.ajax.reload( null, false );
    })



    fInfcom =  $('#fAddInfoComp');
    fInfcom.validate({
        submitHandler: function(form){
            $.ajax({
                type: "POST",
                url: fInfcom.data('accion'),
                data: fInfcom.serialize(),
                success: function( data ) {
                    if (data.status == 1) {
                        swal(data.msg, "", "success");
                        fInfcom.clearForm();
                        dt_table.ajax.reload( null, false );
                        $('#addInfoComp').modal('hide');
                    }
                    else {
                        swal(data.msg, "", "error");
                    }
                }
            });
        }
    });


    function dataInfoComp(id, div){
        $.ajax({
            type: "POST",
            url:$('#url-info').data('url'),
            data: {"id": id},
            success: function( data ) {
                $('#'+div).empty().html(data);
            }
        });
    }


})

