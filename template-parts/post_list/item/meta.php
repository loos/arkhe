<?php
/**
 * 投稿リストに表示されるメタデータ
 */
$setting = Arkhe::get_setting();

// 投稿データ
$the_id    = isset( $args['post_id'] ) ? $args['post_id'] : get_the_ID();
$author_id = isset( $args['author_id'] ) ? $args['author_id'] : 0;
$date      = isset( $args['date'] ) ? $args['date'] : null;
$modified  = isset( $args['modified'] ) ? $args['modified'] : null;

// リストの表示設定データ
$show_date     = isset( $args['show_date'] ) ? $args['show_date'] : $setting['show_list_date'];
$show_modified = isset( $args['show_modified'] ) ? $args['show_modified'] : $setting['show_list_mod'];
$show_cat      = isset( $args['show_cat'] ) ? $args['show_cat'] : $setting['show_list_cat'];
$show_author   = isset( $args['show_author'] ) ? $args['show_author'] : $setting['show_list_author'];

?>
<div class="p-postList__meta c-postMetas u-flex--aicw">
	<?php ark_the__post_list_times( $show_date, $show_modified, $date, $modified ); ?>
	<?php if ( $show_cat ) ark_the__post_list_category( $the_id ); ?>
	<?php if ( $show_author ) ark_the__post_list_author( $author_id ); ?>
</div>
