/**
 * Created by jags on 19/07/2017.
 */

$.fn.dataTable.ext.classes.sPageButtonActive = 'current';
$.fn.dataTable.ext.classes.sPageButton = 'btn btn-no-border btn-sm blue btn-outline';

$.validator.setDefaults({
    errorElement: 'span', //default input error message container
    errorClass: 'help-block help-block-error', // default input error message class
    focusInvalid: false, // do not focus the last invalid input
    ignore: "",
    errorPlacement: function(error, element) {
        if (element.is(':checkbox')) {
            error.insertAfter(element.closest(".md-checkbox-list, .md-checkbox-inline, .checkbox-list, .checkbox-inline"));
        } else if (element.is(':radio')) {
            error.insertAfter(element.closest(".md-radio-list, .md-radio-inline, .radio-list,.radio-inline"));
        } else {
            error.insertAfter(element); // for other inputs, just perform default behavior
        }
    },
    highlight: function(element) { // hightlight error inputs
        $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
    },
    unhighlight: function(element) { // revert the change done by hightlight
        $(element).closest('.form-group').removeClass('has-error'); // set error class to the control group
    },
    success: function(label) {
        label.closest('.form-group').removeClass('has-error'); // set success class to the control group
    }
});

$.validator.addMethod( "rif", function( value, element ) {
    return this.optional( element ) || /^[JGVEC]{1}[0-9]{9}$/.test( value );
}, "Ingrese un RIF valido" );

$.validator.addMethod( "telfv", function( value, element ) {
    return this.optional( element ) || /^[0-9]{4}-[0-9]{7}$/.test( value );
}, "Ingrese un telf. valido" );

$.fn.clearForm = function(tag1) {
    tag1 = tag1 || 'form';
    return this.each(function() {
        var type = this.type, tag = this.tagName.toLowerCase();
        if (tag == tag1)
            return $(':input',this).clearForm();
        if (type == 'text' || type == 'password' || tag == 'textarea' || type == 'number' || type == 'date' || type == 'email')
            this.value = '';
        else if (type == 'checkbox' || type == 'radio')
            this.checked = false;
        else if (tag == 'select'){
            if (this.getAttribute("multiple") == null) {
                this.selectedIndex = 0;
            }else{
                this.value = '';
            }
        }
    });
}
if (!Modernizr.inputtypes.date) {
    $('input[type=date]').datepicker({autoclose: true, todayHighlight: true, format: "yyyy-mm-dd"});
}

$(function () {
    $(".env-loader").show();
    $(".dataTables_length label select, .dataTables_filter label input[type=search]").addClass('md-input');
})

$(window).load(function () {
    setTimeout(function () {
        $(".env-loader").hide();
    }, 200);
});

$(document).ajaxStart(function() {
    $(".env-loader").show();
}).ajaxStop(function() {
    $(".env-loader").hide();
});

$.ajaxSetup({
    headers: {
        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
    }
});

function logout(){
    swal({
        title: "¿Esta seguro que quiere salir del sistema?",
        type: "warning",
        cancelButtonText: "No",
        showCancelButton: true,
        confirmButtonText: "Si, estoy seguro",
        reverseButtons: true
    }).then(function () {
        $.ajax({
            type: "POST",
            url: $('#asalir').data('url'),
            //data: {"_token": "{{ csrf_token() }}"},
            success: function( data ) {
                location.href = $('#asalir').data('urlsuccess');
            }
        });
    });
}

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

function getMcpiosPquias(cond, el1, el2,  url, ed){
    $.ajax({
        dataType: "json",
        url: url,
        data: {cnd: cond, dato: $('#'+el1).val(), edo: $('#'+ed).val(), rand: Math.random() },
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

function cambioClave(){
    $('#modalCClave').modal('show');
    $('#modalCClave').on('hidden.bs.modal', function (e) {
        $('#pcamCla').clearForm();
    })
}






/*swal.setDefaults({
    confirmButtonText: 'Next &rarr;',
    showCancelButton: true,
    animation: false
});*/
