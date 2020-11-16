<?php
/**
 * 固定ページヘッド部分 (コンテンツ内)
 * home.php からも呼ばれることに注意。
 */
if ( ! Arkhe::is_show_ttltop() ) :
	$the_id   = isset( $args['post_id'] ) ? $args['post_id'] : get_queried_object();
	$subtitle = apply_filters( 'arkhe_page_subtitle', '', $the_id, 'inner' );
?>
	<div class="p-page__title c-pageTitle u-flex--aic">
		<?php
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '<h1 class="c-pageTitle__main">' . get_the_title( $the_id ) . '</h1>'; // the_title() に倣ってエスケープ関数はなし

			// サブタイトル
			if ( '' !== $subtitle ) :
				echo '<div class="c-pageTitle__sub">' . wp_kses( $subtitle, \Arkhe::$allowed_text_html ) . '</div>';
			endif;
		?>
	</div>
<?php
endif;
