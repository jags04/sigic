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

    dt_table = $('#dt_usuarios').DataTable({
        pagingType: "full_numbers",
        buttons: [
            {text: '<i class="fa fa-plus fa-lg"></i>',titleAttr: 'Agregar registro', className: 'btn btn-no-border btn-sm blue btn-outline',
                action: function ( e, dt, node, config ){
                    $( '#addUsuarios' ).modal('show');
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
            [0, 'asc']
        ],
        "lengthMenu": [
            [5, 10, 25, 100, 500, 1000/*, -1*/],
            [5, 10, 25, 100, 500, 1000] // change per page values here
        ],
        "pageLength": 10,// set the initial value
        "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
        language: {
            url: $('#dt_usuarios').data('lenguaje')
        },
        ajax: {
            url: $('#dt_usuarios').data('urldata'),
            /*data: function (d) {
             d.fecha_inicio = $('input[name=fecha_inicio]').val();
             d.fecha_fin = $('input[name=fecha_fin]').val();
             }
             //method: 'POST'*/
        },
        columns:
            [
                { data: 'id', name: 'users.id' },
                { data: 'nombre', name: 'users.nombre' },
                { data: 'email', name: 'users.email' },
                { data: 'telefono', name: 'users.telefono' },
                { data: 'user', name: 'users.user' },
                { data: 'nrol', name: 'roles.descripcion' },
                { data: 'status', name: 'status' },
                { data: 'accion', name: 'accion', orderable: false, searchable: false }
            ]
    });


    $('#fAddUsu').validate({
        submitHandler: function(form){
            //alert(JSON.stringify($('#fAddUsu').serializeArray()));
            $.ajax({
                type: "POST",
                url: $('#fAddUsu').data('accion'),
                data: $('#fAddUsu').serialize(),
                success: function( data ) {
                    if (data.status == 1) {
                        swal(data.msg, "", "success");
                        $('#fAddUsu').clearForm();
                        dt_table.ajax.reload( null, false );
                    }
                    else {
                        swal(data.msg, "", "error");
                    }
                }
            });
        }
    });

    $('#addUsuarios').on('hidden.bs.modal', function (e) {
        $('#fAddUsu').clearForm();
    })

    findUpdateUsu  = function(id){
        $.ajax({
            type: "POST",
            url:$('#url-find').data('url'),
            data: { "id": id},
            success: function( data ) {
                $.each(data, function(i, item) {
                    $('#updNombre').html(item.nombre);
                    $("#id_usu").val(item.id);
                    $("#nombre2").val(item.nombre);
                    $("#email2").val(item.email);
                    $("#telefono2").val(item.telefono);
                    $("#user2").val(item.user);

                    $('#rol2').append($('<option>').text(item.nrol).attr({value: item.rol,selected: "selected"}));

                    nstatus = (item.status == 0)? 'Inactivo' : 'Activo';
                    $('#status2').append($('<option>').text(nstatus).attr({value: item.status,selected: "selected"}));

                    $("#empresa2").val(item.empresa);

                })
                $("#updUsuarios").modal('show');
            }
        });
    }

    $('#fUpdUsu').validate({
        submitHandler: function(form){
            //alert(JSON.stringify($('#fAddUsu').serializeArray()));
            $.ajax({
                type: "POST",
                url: $('#fUpdUsu').data('accion'),
                data: $('#fUpdUsu').serialize(),
                success: function( data ) {
                    if (data.status == 1) {
                        swal(data.msg, "", "success");
                        dt_table.ajax.reload( null, false );
                        $("#updUsuarios").modal('hide');
                    }
                    else {
                        swal(data.msg, "", "error");
                    }
                }
            });
        }
    });

    $('#updUsuarios').on('hidden.bs.modal', function (e) {
        //$('#municipio2, #parroquia2, #sector2, #subsector2, #ciiu2').find('option:not(:first)').remove();
        $("#rol2 option:last, #status2 option:last").remove();
        $('#fUpdUsu').clearForm();
    })

    deleteUsu = function(id){
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

    resetClaveUsu = function(id){

        swal({
            title: "¿Esta seguro que quiere resetear la clave de este usuario?",
            text: "Esta acción no puede ser desecha",
            type: "warning",
            cancelButtonText: "No",
            showCancelButton: true,
            confirmButtonText: "Si, estoy seguro",
            reverseButtons: true
        }).then(function (text) {
            $.ajax({
                type: "POST",
                url: $('#url-reset').data('url'),
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

    actDesUsu = function(id){
        swal({
            title: "¿Esta seguro que quiere modificar este registro?",
            type: "warning",
            cancelButtonText: "No",
            showCancelButton: true,
            confirmButtonText: "Si, estoy seguro",
            reverseButtons: true
        }).then(function (text) {
            $.ajax({
                type: "POST",
                url:$('#url-actdes').data('url'),
                data: {"id": id},
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
})


