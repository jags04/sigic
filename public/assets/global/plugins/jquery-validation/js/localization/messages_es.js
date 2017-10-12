(function( factory ) {
	if ( typeof define === "function" && define.amd ) {
		define( ["jquery", "../jquery.validate"], factory );
	} else if (typeof module === "object" && module.exports) {
		module.exports = factory( require( "jquery" ) );
	} else {
		factory( jQuery );
	}
}(function( $ ) {

/*
 * Translated default messages for the jQuery validation plugin.
 * Locale: ES (Spanish; Español)
 */
$.extend( $.validator.messages, {
	required: "Obligatorio.",
	remote: "Rellena este campo.",
	email: "Email no válida.",
	url: "URL no válida.",
	date: "Fecha no válida.",
	dateISO: "Fecha (ISO) no válida.",
	number: "Número no válido.",
	digits: "Sólo dígitos.",
	creditcard: "Número no válido.",
	equalTo: "Escribe el mismo valor de nuevo.",
	extension: "Escribe un valor con una extensión aceptada.",
	maxlength: $.validator.format( "No más de {0} caracteres." ),
	minlength: $.validator.format( "No menos de {0} caracteres." ),
	rangelength: $.validator.format( "Valor entre {0} y {1} caracteres." ),
	range: $.validator.format( "Valor entre {0} y {1}." ),
	max: $.validator.format( "Valor menor o igual a {0}." ),
	min: $.validator.format( "Valor mayor o igual a {0}." ),
	nifES: "NIF no válido.",
	nieES: "NIE no válido.",
	cifES: "CIF no válido."
} );
return $;
}));