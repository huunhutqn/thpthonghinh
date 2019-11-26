(function( $ ) {
	'use strict';

	$(function() {

		/* For Input Switch */
		$( '.catchids-input-switch' ).on( 'click', function() {
			var loader = $( this ).parent().next();
			
			loader.show();
			
			var main_control = $( this );
			var data = {
				'action'      : 'catchids_switch',
				'value'       : this.checked,
				'option_name' : main_control.attr( 'rel' )
			};

			$.post( ajaxurl, data, function( response ) {
				response = $.trim( response );

				if ( '1' == response ) {
					main_control.parent().parent().addClass( 'active' );
					main_control.parent().parent().removeClass( 'inactive' );
				} else if( '0' == response ) {
					main_control.parent().parent().addClass( 'inactive' );
					main_control.parent().parent().removeClass( 'active' );
				} else {
					alert( response );
				}
				
				loader.hide();
			});
		});
		/* For Input Switch End */
	});

})( jQuery );
