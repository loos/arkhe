<?php
	// サイドバー
	if ( Arkhe::is_show_sidebar() ) get_sidebar();
?>
	</div>
	<!-- End: l-content__body -->
</div>
<!-- End: l-content -->
<?php
// パンくずリスト（下部表示）
if ( 'bottom' === Arkhe::get_breadcrumbs_position() ) {
	Arkhe::get_parts( 'others/breadcrumb' );
}
