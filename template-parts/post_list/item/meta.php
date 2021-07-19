<?php
/**
 * 投稿リストに表示されるメタデータ
 */
$the_id    = isset( $args['post_id'] ) ? $args['post_id'] : get_the_ID();
$date      = isset( $args['date'] ) ? $args['date'] : null;
$modified  = isset( $args['modified'] ) ? $args['modified'] : null;
$author_id = isset( $args['author_id'] ) ? $args['author_id'] : 0;
$show_cat  = isset( $args['show_cat'] ) ? $args['show_cat'] : false;
?>
<div class="p-postList__meta c-postMetas u-flex--aicw">
	<?php
		if ( $date || $modified ) {
			\Arkhe::the_pluggable_part( 'post_list_times', array(
				'date'     => $date,
				'modified' => $modified,
			) );
		}
		if ( $show_cat ) {
			\Arkhe::the_pluggable_part( 'post_list_category', array(
				'post_id' => $the_id,
			) );
		}
		if ( $author_id ) {
			\Arkhe::the_pluggable_part( 'post_list_author', array(
				'author_id' => $author_id,
			) );
		}
	?>
</div>
