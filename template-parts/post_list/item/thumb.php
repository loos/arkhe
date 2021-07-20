<?php
/**
 * 投稿リストに表示されるサムネイル画像
 */
$size  = isset( $args['size'] ) ? $args['size'] : 'large';
$sizes = isset( $args['sizes'] ) ? $args['sizes'] : '';
?>
<div class="p-postList__thumb c-postThumb" data-has-thumb="<?php echo has_post_thumbnail() ? '1' : '0'; ?>">
	<figure class="c-postThumb__figure">
		<?php
			ark_the__thumbnail( array(
				'size'        => $size,
				'sizes'       => $sizes,
				'class'       => 'c-postThumb__img',
			) );
		?>
	</figure>
</div>
