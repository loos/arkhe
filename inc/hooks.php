<?php
namespace Arkhe_Theme;

/**
 * Add hooks
 */
add_filter( 'excerpt_length', '\Arkhe_Theme\hook_excerpt_length' );
add_filter( 'excerpt_mblength', '\Arkhe_Theme\hook_excerpt_length' );
add_filter( 'excerpt_more', '\Arkhe_Theme\hook_excerpt_more' );

add_filter( 'the_excerpt_rss', '\Arkhe_Theme\add_rss_thumb' );
add_filter( 'the_content_feed', '\Arkhe_Theme\add_rss_thumb' );

add_filter( 'navigation_markup_template', '\Arkhe_Theme\hook_navigation_markup', 10, 2 );

add_action( 'wp_body_open', '\Arkhe_Theme\wp_body_open', 5 );
add_action( 'wp_list_categories', '\Arkhe_Theme\wp_list_categories' );
add_action( 'wp_list_pages', '\Arkhe_Theme\wp_list_pages' );
add_action( 'get_archives_link', '\Arkhe_Theme\hook_get_archives_link', 10, 6 );
add_action( 'wp_terms_checklist_args', '\Arkhe_Theme\hook_terms_checklist_args', 10, 2 );


/**
 * 抜粋文字数を変更する
 */
function hook_excerpt_length( $length ) {
	if ( is_admin() ) return $length;

	if ( defined( 'ARKHE_EXCERPT_LENGTH' ) ) {
		return ARKHE_EXCERPT_LENGTH;
	}
	return $length;
}


/**
 * 抜粋文の末尾を ... に
 */
function hook_excerpt_more( $more ) {
	if ( is_admin() ) return $more;
	return '&hellip;';
}


/**
 * Feedlyでアイキャッチ画像を取得できるようにする
 */
function add_rss_thumb( $content ) {
	global $post;

	$thumb = get_the_post_thumbnail_url( $post->ID, 'large' );
	if ( $thumb ) {
		$content = '<p><img src="' . esc_url( $thumb ) . '" class="webfeedsFeaturedVisual" /></p>' . $content;
		}
	return $content;
}


/**
 * Add skip link
 */
function wp_body_open( $output ) {
	echo '<a class="skip-link screen-reader-text" href="#main_content">' . esc_html__( 'Skip to the content', 'arkhe' ) . '</a>';
}


/**
 * カテゴリーリストの件数を</a>の中に移動 & spanで囲む
 */
function wp_list_categories( $output ) {
	$output = str_replace( '</a> (', '<span class="cat-post-count">(', $output );
	$output = str_replace( ')', ')</span></a>', $output );

	// サブメニューがある場合（ </a><ul> ）、トグルボタンを追加
	$output = preg_replace(
		'/<\/a>([^<]*)<ul/',
		'<button class="c-submenuToggleBtn" data-onclick="toggleSubmenu"></button></a><ul',
		$output
	);
	return $output;
}


/**
 * 固定ページリストへのフック
 */
function wp_list_pages( $output ) {

	// サブメニューがある場合（ </a><ul> ）、トグルボタンを追加
	$output = preg_replace(
		'/<\/a>([^<]*)<ul/',
		'<button class="c-submenuToggleBtn" data-onclick="toggleSubmenu"></button></a><ul',
		$output
	);
	return $output;
}


/**
 * 年別アーカイブリストの投稿件数 を</a>の中に置換
 */
function hook_get_archives_link( $link_html, $url, $text, $format, $before, $after ) {
	if ( 'html' === $format ) {
		$link_html = '<li>' . $before . '<a href="' . $url . '">' . $text . '<span class="post_count">' . $after . '</span></a></li>';
	}
	return $link_html;
}


/**
 * カテゴリーチェック時、順番をそのままに保つ
 */
function hook_terms_checklist_args( $args, $post_id ) {
	$args['checked_ontop'] = false;
	return $args;
}


/**
 * ページネーションの構造を書き換える
 */
function hook_navigation_markup( $template, $class ) {
	if ( 'pagination' === $class ) {
		return '<nav class="navigation %1$s" role="navigation" aria-label="%4$s">%3$s</nav>';
	}
	return $template;
}
