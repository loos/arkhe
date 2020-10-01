<?php
if ( ! defined( 'ABSPATH' ) ) exit;
$SETTING = Arkhe_Theme::get_setting();
if ( Arkhe_Theme::is_show_sidebar() ) get_sidebar();
?>
</div><!-- // l-content__body -->
</div><!-- // l-content -->
<?php
	do_action( 'arkhe_before_footer' );

	// パンくずリスト
	if ( 'top' !== $SETTING['breadcrumbs_pos'] ) Arkhe_Theme::get_parts( 'others/breadcrumb' );

	Arkhe_Theme::get_parts( 'footer' );

	Arkhe_Theme::get_parts( 'footer/after' );
?>
</div><!--/ #wrapper-->
<?php wp_footer(); ?>
</body></html>
