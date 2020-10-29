<?php
/**
 * 固定ページヘッド部分 (コンテンツ上)
 * ※ ここはループ外なことに注意。
 */
$the_id    = isset( $args['post_id'] ) ? $args['post_id'] : get_the_ID();
$post_data = get_post( $the_id );
$excerpt   = $post_data->post_excerpt;
?>
<h1 class="p-topArea__title c-pageTitle">
	<?php
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo get_the_title( $the_id ); // the_title() に倣ってエスケープ関数はなし

		// サブタイトル表示用
		do_action( 'arkhe_page_subtitle', $the_id );
	?>
</h1>
<?php if ( $excerpt ) : ?>
	<div class="p-topArea__excerpt">
		<?php echo wp_kses_post( $excerpt ); ?>
	</div>
<?php endif; ?>
