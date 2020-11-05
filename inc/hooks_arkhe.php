<?php
/**
 * Arkhe側で用意しているフックへの処理
 */
namespace Arkhe_Theme;

/**
 * コンテンツの出力
 */
add_filter( 'arkhe_start_content', function() {
	// コンテンツヘッダー
	if ( \Arkhe::is_show_ttltop() ) \Arkhe::get_part( 'top_area' );

	// パンくずリスト（上部表示の場合）
	if ( 'top' === \Arkhe::get_breadcrumbs_position() ) {
		\Arkhe::get_part( 'others/breadcrumb' );
	}
} );

add_filter( 'arkhe_before_footer', function() {
	// パンくずリスト（下部表示の場合）
	if ( 'bottom' === \Arkhe::get_breadcrumbs_position() ) {
		\Arkhe::get_part( 'others/breadcrumb' );
	}
} );
