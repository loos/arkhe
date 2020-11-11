<?php
/**
 * 投稿リストに表示されるサムネイル画像
 */
$the_id      = isset( $args['post_id'] ) ? $args['post_id'] : 0;
$list_type   = isset( $args['list_type'] ) ? $args['list_type'] : ARKHE_LIST_TYPE;
$thumb_class = isset( $args['thumb_class'] ) ? $args['thumb_class'] : 'p-postList__thumb';

// サムネイル画像取得
$sp_sizes = 'card' === $list_type ? '100vw' : '40vw';

// クラス
if ( ! has_post_thumbnail( $the_id ) ) {
	$thumb_class .= ' has-nothumb';
}
?>
<div class="c-postThumb <?php echo esc_attr( $thumb_class ); ?>">
	<figure class="c-postThumb__figure">
		<?php
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo Arkhe::get_thumbnail(
				$the_id,
				array(
					'size'        => 'large',
					'sizes'       => '(min-width: 600px) 400px, ' . $sp_sizes,
					'class'       => 'c-postThumb__img',
				)
			);
		?>
	</figure>
</div>
