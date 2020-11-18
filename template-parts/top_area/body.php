<?php
/**
 * 固定ページヘッド部分 (コンテンツ上)
 * ※ ここはループ外なことに注意。
 */
$the_id   = isset( $args['the_id'] ) ? $args['the_id'] : get_queried_object_id();
$subtitle = apply_filters( 'arkhe_page_subtitle', '', $the_id, 'top' );
$excerpt  = apply_filters( 'arkhe_top_area_excerpt', '', $the_id );
?>
<div class="p-topArea__title c-pageTitle">
	<?php
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '<h1 class="c-pageTitle__main">' . get_the_title( $the_id ) . '</h1>'; // the_title() に倣ってエスケープ関数はなし

		// サブタイトル
		if ( '' !== $subtitle ) :
		echo '<div class="c-pageTitle__sub u-mt-5">' . wp_kses( $subtitle, \Arkhe::$allowed_text_html ) . '</div>';
		endif;
	?>
</div>

<?php if ( '' !== $excerpt ) : ?>
	<div class="p-topArea__excerpt u-mt-10">
		<?php echo wp_kses_post( $excerpt ); ?>
	</div>
<?php endif; ?>
