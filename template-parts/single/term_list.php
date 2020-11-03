<?php
/**
 * 投稿ページのタイトル部分
 * $args['post_id'] : 投稿IDが渡ってくる
 * $args['post_title'] : 投稿タイトルが渡ってくる
 */

$the_id   = isset( $args['post_id'] ) ? $args['post_id'] : get_the_ID();
$show_cat = isset( $args['show_cat'] ) ? $args['show_cat'] : true;
$show_tag = isset( $args['show_tag'] ) ? $args['show_tag'] : false;
$is_head  = isset( $args['is_head'] ) ? $args['is_head'] : true;

// カテゴリー・タグを取得
$cat_list = $show_cat ? \Arkhe::get_the_term_links( $the_id, 'cat', $is_head ) : '';
$tag_list = $show_tag ? \Arkhe::get_the_term_links( $the_id, 'tag', $is_head ) : '';

$return = '';
if ( $cat_list ) {
	$return .= '<div class="c-postTerms__item -category u-flex--aicw">' . $cat_list . '</div>';
}
if ( $tag_list ) {
	$return .= '<div class="c-postTerms__item -tag u-flex--aicw">' . $tag_list . '</div>';
}

// カテゴリー or タグ が取得されていれば出力
if ( $return ) echo '<div class="c-postTerms u-flex--aicw">' . wp_kses_post( $return ) . '</div>';
