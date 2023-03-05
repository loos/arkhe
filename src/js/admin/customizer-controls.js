( function ( $ ) {
	// Wait until the customizer has finished loading.

	wp.customize.bind( 'ready', function () {
		// トップヘッダー
		function toggleHeaderOverlay( val ) {
			if ( 'off' !== val ) {
				$( '.customize-control.-header-overlay' ).removeClass( '-hide' );
			} else {
				$( '.customize-control.-header-overlay' ).addClass( '-hide' );
			}
		}
		wp.customize( 'arkhe_settings[header_overlay]', function ( value ) {
			toggleHeaderOverlay( value.get() );
			value.bind( function ( to ) {
				toggleHeaderOverlay( to );
			} );
		} );

		// トップヘッダー
		function toggleCatPriority( val ) {
			if ( 'parent' === val ) {
				$( '#customize-control-arkhe_settings-force_get_top_cat' ).removeClass( '-hide' );
			} else {
				$( '#customize-control-arkhe_settings-force_get_top_cat' ).addClass( '-hide' );
			}
		}
		wp.customize( 'arkhe_settings[cat_priority_on_list]', function ( value ) {
			toggleCatPriority( value.get() );
			value.bind( function ( to ) {
				toggleCatPriority( to );
			} );
		} );
	} );
} )( window.jQuery );
