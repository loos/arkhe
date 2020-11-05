<?php
/**
 * 固定ページヘッド部分 (コンテンツ内)
 * home.php からも呼ばれることに注意。
 */
$the_id = isset( $args['post_id'] ) ? $args['post_id'] : get_queried_object();

if ( ! Arkhe::is_show_ttltop() ) :
?>
	<h1 class="p-page__title c-pageTitle">
		<?php
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo get_the_title( $the_id ); // the_title() に倣ってエスケープ関数はなし

			// サブタイトル表示用
			do_action( 'arkhe_page_subtitle', $the_id, 'inner' );
		?>
	</h1>
<?php
endif;
