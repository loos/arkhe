<?php
/**
 * 投稿リストに表示されるサムネイル画像
 */
$the_id = isset( $args['post_id'] ) ? $args['post_id'] : 0;
$size   = isset( $args['size'] ) ? $args['size'] : 'large';
$sizes  = isset( $args['sizes'] ) ? $args['sizes'] : '';

?>
<div class="p-postList__thumb c-postThumb" data-has-thumb="<?php echo has_post_thumbnail( $the_id ) ? '1' : '0'; ?>">
	<figure class="c-postThumb__figure">
		<?php
			Arkhe::the_pluggable_part( 'thumbnail', array(
				'post_id'     => $the_id,
				'size'        => $size,
				'sizes'       => $sizes,
				'class'       => 'c-postThumb__img',
			) );
		?>
	</figure>
</div>
