<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add hooks
 */
add_filter( 'excerpt_length', 'arkhe_hook__excerpt_length' );
add_filter( 'excerpt_mblength', 'arkhe_hook__excerpt_length' );
add_filter( 'excerpt_more', 'arkhe_hook__excerpt_more' );

add_filter( 'the_excerpt_rss', 'arkhe_hook__add_rss_thumb' );
add_filter( 'the_content_feed', 'arkhe_hook__add_rss_thumb' );

add_action( 'wp_list_categories', 'arkhe_hook__wp_list_categories' );
add_action( 'wp_list_pages', 'arkhe_hook__wp_list_pages' );
add_action( 'get_archives_link', 'arkhe_hook__get_archives_link', 10, 6 );
add_action( 'wp_terms_checklist_args', 'arkhe_hook__wp_terms_checklist_args', 10, 2 );

add_filter( 'navigation_markup_template', 'arkhe_hook__navigation_markup_template', 10, 2 );


/**
 * 抜粋文字数を変更する
 */
if ( ! function_exists( 'arkhe_hook__excerpt_length' ) ) :
function arkhe_hook__excerpt_length( $length ) {
	if ( defined( 'ARKHE_EXCERPT_LENGTH' ) ) {
		return ARKHE_EXCERPT_LENGTH;
		}
	return $length;
}
endif;

/**
 * 抜粋文の末尾を ... に
 */
if ( ! function_exists( 'arkhe_hook__excerpt_more' ) ) :
function arkhe_hook__excerpt_more() {
	return '&hellip;';
}
endif;

/**
 * Feedlyでアイキャッチ画像を取得できるようにする
 */
if ( ! function_exists( 'arkhe_hook__add_rss_thumb' ) ) :
function arkhe_hook__add_rss_thumb( $content ) {
	global $post;

	$thumb = get_the_post_thumbnail_url( $post->ID, 'large' );
	if ( $thumb ) {
		$content = '<p><img src="' . $thumb . '" class="webfeedsFeaturedVisual" /></p>' . $content;
		}
	return $content;
}
endif;

/**
 * カテゴリーリストの件数を</a>の中に移動 & spanで囲む
 */
if ( ! function_exists( 'arkhe_hook__wp_list_categories' ) ) :
function arkhe_hook__wp_list_categories( $output ) {
	$output = str_replace( '</a> (', '<span class="cat-post-count">(', $output );
	$output = str_replace( ')', ')</span></a>', $output );

	// サブメニューがある場合（ </a><ul> ）、トグルボタンを追加
	$output = preg_replace(
		'/<\/a>([^<]*)<ul/',
		'<span class="c-submenuToggleBtn" data-onclick="toggleSubmenu"></span></a><ul',
		$output
	);
	return $output;
}
endif;

/**
 * 固定ページリストへのフック
 */
if ( ! function_exists( 'arkhe_hook__wp_list_pages' ) ) :
function arkhe_hook__wp_list_pages( $output ) {

	// サブメニューがある場合（ </a><ul> ）、トグルボタンを追加
	$output = preg_replace(
		'/<\/a>([^<]*)<ul/',
		'<span class="c-submenuToggleBtn" data-onclick="toggleSubmenu"></span></a><ul',
		$output
	);
	return $output;
}
endif;

/**
 * 年別アーカイブリストの投稿件数 を</a>の中に置換
 */
if ( ! function_exists( 'arkhe_hook__get_archives_link' ) ) :
function arkhe_hook__get_archives_link( $link_html, $url, $text, $format, $before, $after ) {
	if ( 'html' === $format ) {
		$link_html = '<li>' . $before . '<a href="' . $url . '">' . $text . '<span class="post_count">' . $after . '</span></a></li>';
	}
	return $link_html;
}
endif;

/**
 * カテゴリーチェック時、順番をそのままに保つ
 */
if ( ! function_exists( 'arkhe_hook__wp_terms_checklist_args' ) ) :
function arkhe_hook__wp_terms_checklist_args( $args, $post_id ) {
	$args['checked_ontop'] = false;
	return $args;
}
endif;

/**
 * ページネーションの構造を書き換える
 */
if ( ! function_exists( 'arkhe_hook__navigation_markup_template' ) ) :
function arkhe_hook__navigation_markup_template( $template, $class ) {
	if ( 'pagination' === $class ) {
		return '<nav class="navigation %1$s" role="navigation" aria-label="%4$s">%3$s</nav>';
		}
	return $template;
}
endif;
