<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * 投稿ページのタイトル部分
 * $parts_args['post_id'] : 投稿IDが渡ってくる
 * $parts_args['post_title'] : 投稿タイトルが渡ってくる
 */
$the_id   = isset( $parts_args['post_id'] ) ? $parts_args['post_id'] : get_the_ID();
$show_cat = isset( $parts_args['show_cat'] ) ? $parts_args['show_cat'] : true;
$show_tag = isset( $parts_args['show_tag'] ) ? $parts_args['show_tag'] : false;

// カテゴリー・タグを取得
$cat_list = $show_cat ? \ARKHE_THEME::get_the_term_links( $the_id, 'cat' ) : '';
$tag_list = $show_tag ? \ARKHE_THEME::get_the_term_links( $the_id, 'tag' ) : '';

$return                   = '';
if ( $cat_list ) $return .= '<div class="c-postMetas__item -category">' . $cat_list . '</div>';
if ( $tag_list ) $return .= '<div class="c-postMetas__item -tag">' . $tag_list . '</div>';

// カテゴリー or タグ が取得されていれば出力
if ( $return ) echo '<div class="c-postMetas">' . wp_kses_post( $return ) . '</div>';
