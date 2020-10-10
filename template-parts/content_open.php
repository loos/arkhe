<!-- Start: l-content -->
<div id="content" class="l-content">
<?php
	// コンテンツヘッダー
	if ( Arkhe::is_show_ttltop() ) Arkhe::get_parts( 'top_area' );

	// パンくずリスト（上部表示）
	if ( 'top' === Arkhe::get_breadcrumbs_position() ) {
		Arkhe::get_parts( 'others/breadcrumb' );
	}
?>
	<!-- Start: l-content__body -->
	<div class="l-content__body l-container">
