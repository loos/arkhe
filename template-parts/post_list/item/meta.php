<?php
/**
 * 投稿リストに表示されるメタデータ
 * memo: ここには表示させたい情報だけしか渡ってこないようにしている
 */
$show_date     = isset( $args['show_date'] ) ? $args['show_date'] : false;
$show_modified = isset( $args['show_modified'] ) ? $args['show_modified'] : null;
$show_cat      = isset( $args['show_cat'] ) ? $args['show_cat'] : false;
$author_id     = isset( $args['author_id'] ) ? $args['author_id'] : 0;
?>
<div class="p-postList__meta c-postMetas u-flex--aicw">
	<?php
		if ( $show_date || $show_modified ) {
			\Arkhe::get_part( 'post_list/item/meta/times', array(
				'show_date'     => $show_date,
				'show_modified' => $show_modified,
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
