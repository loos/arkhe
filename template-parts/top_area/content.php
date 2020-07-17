<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * 固定ページヘッド部分 (コンテンツ上)
 * ※ ここはループ外なことに注意。
 */
$the_id    = isset( $parts_args['post_id'] ) ? $parts_args['post_id'] : get_the_ID();
$post_data = get_post( $the_id );
$excerpt   = $post_data->post_excerpt;
?>
<h1 class="p-topArea__title c-pageTitle">
	<?php echo esc_html( get_the_title( $the_id ) ); ?>
</h1>
<?php if ( $excerpt ) : ?>
	<div class="p-topArea__excerpt">
		<?php echo wp_kses_post( $excerpt ); ?>
	</div>
<?php endif; ?>
