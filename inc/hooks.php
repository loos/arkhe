<?php
namespace Arkhe_Theme\Hooks;

require_once __DIR__ . '/hooks/self_hooks.php';

/**
 * 抜粋文字数を変更する
 */
add_filter( 'excerpt_length', __NAMESPACE__ . '\hook_excerpt_length' );
add_filter( 'excerpt_mblength', __NAMESPACE__ . '\hook_excerpt_length' );
function hook_excerpt_length( $length ) {
	if ( is_admin() ) return $length;

	if ( null !== \Arkhe::$excerpt_length ) {
		return \Arkhe::$excerpt_length;
	}
	return $length;
}


/**
 * 抜粋文の末尾を ... に
 */
add_filter( 'excerpt_more', __NAMESPACE__ . '\hook_excerpt_more' );
function hook_excerpt_more( $more ) {
	if ( is_admin() ) return $more;
	return '&hellip;';
}


/**
 * Feedlyでアイキャッチ画像を取得できるようにする
 */
add_filter( 'the_excerpt_rss', __NAMESPACE__ . '\add_rss_thumb' );
add_filter( 'the_content_feed', __NAMESPACE__ . '\add_rss_thumb' );
function add_rss_thumb( $content ) {
	global $post;

	$thumb = get_the_post_thumbnail_url( $post->ID, 'large' );
	if ( $thumb ) {
		$content = '<p><img src="' . esc_url( $thumb ) . '" class="webfeedsFeaturedVisual" /></p>' . $content;
	}
	return $content;
}


/**
 * カテゴリーリストの件数を</a>の中に移動 & spanで囲む
 */
add_action( 'wp_list_categories', __NAMESPACE__ . '\hook_wp_list_categories' );
function hook_wp_list_categories( $output ) {
	$output = str_replace( '</a> (', '<span class="cat-post-count">(', $output );
	$output = str_replace( ')', ')</span></a>', $output );
	// $output = preg_replace( '/<\/a>\s*\((\d+)\)/', ' <span class="cat-post-count">($1)</span></a>', $output );

	// サブメニューがある場合（ </a><ul> ）、トグルボタンを追加
	$output = preg_replace(
		'/<\/a>([^<]*)<ul/',
		'<button class="c-submenuToggleBtn u-flex--c" data-onclick="toggleSubmenu"></button></a><ul',
		$output
	);
	return $output;
}


/**
 * 固定ページリストにサブメニューがある場合（ </a><ul> ）、トグルボタンを追加
 */
add_action( 'wp_list_pages', __NAMESPACE__ . '\hook_wp_list_pages' );
function hook_wp_list_pages( $output ) {
	$output = preg_replace(
		'/<\/a>([^<]*)<ul/',
		'<button class="c-submenuToggleBtn u-flex--c" data-onclick="toggleSubmenu"></button></a><ul',
		$output
	);
	return $output;
}


/**
 * 年別アーカイブリストの投稿件数 を</a>の中に置換
 */
add_action( 'get_archives_link', __NAMESPACE__ . '\hook_get_archives_link', 10, 6 );
function hook_get_archives_link( $link_html, $url, $text, $format, $before, $after ) {
	if ( 'html' === $format ) {
		$link_html = '<li>' . $before . '<a href="' . $url . '">' . $text . '<span class="post_count">' . $after . '</span></a></li>';
	}
	return $link_html;
}


/**
 * カテゴリーチェック時、順番をそのままに保つ
 */
add_action( 'wp_terms_checklist_args', __NAMESPACE__ . '\hook_terms_checklist_args', 10 );
function hook_terms_checklist_args( $args ) {
	$args['checked_ontop'] = false;
	return $args;
}


/**
 * ページネーションの構造を書き換える
 */
add_filter( 'navigation_markup_template', __NAMESPACE__ . '\hook_navigation_markup', 10, 2 );
function hook_navigation_markup( $template, $class ) {
	if ( 'pagination' === $class ) {
		return '<nav class="navigation %1$s" role="navigation" aria-label="%4$s">%3$s</nav>';
	}
	return $template;
}
