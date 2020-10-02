<?php if ( Arkhe_Theme::is_show_sidebar() ) get_sidebar(); // サイドバー ?>
	</div><!-- // l-content__body -->
</div><!-- // l-content -->
<?php

	do_action( 'arkhe_before_footer' );

	// パンくずリスト
	if ( 'top' !== Arkhe_Theme::get_setting( 'breadcrumbs_pos' ) ) {
		Arkhe_Theme::get_parts( 'others/breadcrumb' );
	}

	// フッターコンテンツ
	Arkhe_Theme::get_parts( 'footer' );
	Arkhe_Theme::get_parts( 'footer/after' );
?>
</div><!--/ #wrapper-->
<?php wp_footer(); ?>
</body></html>
