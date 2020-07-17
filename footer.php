<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$SETTING = ARKHE_THEME::get_setting();
if ( ARKHE_THEME::is_show_sidebar() ) get_sidebar();
?>
</div><!-- // l-content__body -->
</div><!-- // l-content -->
<?php
	do_action( 'arkhe_before_footer' ); // ? : ぱんくずの前でいいか...？

	// パンくずリスト
	if ( 'top' !== $SETTING['breadcrumbs_pos'] ) ARKHE_THEME::get_parts( 'others/breadcrumb' );

	ARKHE_THEME::get_parts( 'footer' );

	ARKHE_THEME::get_parts( 'footer/after' );
?>

</div><!--/ #wrapper-->
<?php wp_footer(); ?>
</body></html>
