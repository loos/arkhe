<?php
/**
 * 投稿リストに表示されるメタデータ
 */
$date      = isset( $args['date'] ) ? $args['date'] : null;
$modified  = isset( $args['modified'] ) ? $args['modified'] : null;
$author_id = isset( $args['author_id'] ) ? $args['author_id'] : 0;
$show_cat  = isset( $args['show_cat'] ) ? $args['show_cat'] : false;
?>
<div class="p-postList__meta c-postMetas u-flex--aicw">
	<?php
		if ( $date || $modified ) {
			\Arkhe::get_part( 'post_list/item/meta/times', array(
				'date'     => $date,
				'modified' => $modified,
			) );
		}
		if ( $show_cat ) {
			\Arkhe::get_part( 'post_list/item/meta/category' );
		}
		if ( $author_id ) {
			\Arkhe::get_part( 'post_list/item/meta/author', array(
				'author_id' => $author_id,
			) );
		}
	?>
</div>
