( function ( $ ) {
	// Wait until the customizer has finished loading.

	wp.customize.bind( 'ready', function () {
		// トップヘッダー
		function toggleHeaderOverlay( val ) {
			if ( 'off' !== val ) {
				$( '.customize-control.-headerOverlay' ).removeClass( '-hide' );
			} else {
				$( '.customize-control.-headerOverlay' ).addClass( '-hide' );
			}
		}
		wp.customize( 'arkhe_settings[header_overlay]', function ( value ) {
			toggleHeaderOverlay( value.get() );
			value.bind( function ( to ) {
				toggleHeaderOverlay( to );
			} );
		} );

		// gnavの位置による設定切り替え
		function toggleUnderGnav( val ) {
			if ( val ) {
				$( '.customize-control.-underGnav' ).removeClass( '-hide' );
			} else {
				$( '.customize-control.-underGnav' ).addClass( '-hide' );
			}
		}
		wp.customize( 'arkhe_settings[move_gnav_under]', function ( value ) {
			toggleUnderGnav( value.get() );
			value.bind( function ( to ) {
				toggleUnderGnav( to );
			} );
		} );

		// カテゴリー優先度
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
