<?php
/**
 * 固定ページヘッド部分 (コンテンツ上)
 * ※ ここはループ外なことに注意。
 */
$the_id    = isset( $args['the_id'] ) ? $args['the_id'] : get_queried_object_id();
$post_data = get_post( $the_id );
$excerpt   = empty( $post_data ) ? '' : $post_data->post_excerpt;
$excerpt   = apply_filters( 'arkhe_top_area_excerpt', $excerpt, $the_id );
?>
<h1 class="p-topArea__title c-pageTitle">
	<?php
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo get_the_title( $the_id ); // the_title() に倣ってエスケープ関数はなし

		// サブタイトル表示用
		do_action( 'arkhe_page_subtitle', $the_id, 'top' );
	?>
</h1>
<?php if ( $excerpt ) : ?>
	<div class="p-topArea__excerpt">
		<?php echo wp_kses_post( $excerpt ); ?>
	</div>
<?php endif; ?>
