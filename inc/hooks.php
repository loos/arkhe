<?php
/**
 * 各種フックへの処理
 */
namespace Arkhe_Theme;

/**
 * Arkheを使用しているかどうかをJS側で判別するためのグローバル変数を出力
 */
add_action( 'admin_head', function() {
	echo '<script>window.arkheTheme = 1;</script>' . PHP_EOL;
} );

/**
 * 抜粋文字数を変更する
 */
add_filter( 'excerpt_length', '\Arkhe_Theme\hook_excerpt_length' );
add_filter( 'excerpt_mblength', '\Arkhe_Theme\hook_excerpt_length' );
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
add_filter( 'excerpt_more', '\Arkhe_Theme\hook_excerpt_more' );
function hook_excerpt_more( $more ) {
	if ( is_admin() ) return $more;
	return '&hellip;';
}


/**
 * Feedlyでアイキャッチ画像を取得できるようにする
 */
add_filter( 'the_excerpt_rss', '\Arkhe_Theme\add_rss_thumb' );
add_filter( 'the_content_feed', '\Arkhe_Theme\add_rss_thumb' );
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
add_action( 'wp_body_open', '\Arkhe_Theme\hook_wp_body_open', 5 );
function hook_wp_body_open( $output ) {
	echo '<a class="skip-link screen-reader-text" href="#main_content">' . esc_html__( 'Skip to the content', 'arkhe' ) . '</a>';
}


/**
 * カテゴリーリストの件数を</a>の中に移動 & spanで囲む
 */
add_action( 'wp_list_categories', '\Arkhe_Theme\hook_wp_list_categories' );
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
add_action( 'wp_list_pages', '\Arkhe_Theme\hook_wp_list_pages' );
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
add_action( 'get_archives_link', '\Arkhe_Theme\hook_get_archives_link', 10, 6 );
function hook_get_archives_link( $link_html, $url, $text, $format, $before, $after ) {
	if ( 'html' === $format ) {
		$link_html = '<li>' . $before . '<a href="' . $url . '">' . $text . '<span class="post_count">' . $after . '</span></a></li>';
	}
	return $link_html;
}


/**
 * カテゴリーチェック時、順番をそのままに保つ
 */
add_action( 'wp_terms_checklist_args', '\Arkhe_Theme\hook_terms_checklist_args', 10, 2 );
function hook_terms_checklist_args( $args, $post_id ) {
	$args['checked_ontop'] = false;
	return $args;
}


/**
 * ページネーションの構造を書き換える
 */
add_filter( 'navigation_markup_template', '\Arkhe_Theme\hook_navigation_markup', 10, 2 );
function hook_navigation_markup( $template, $class ) {
	if ( 'pagination' === $class ) {
		return '<nav class="navigation %1$s" role="navigation" aria-label="%4$s">%3$s</nav>';
	}
	return $template;
}


/**
 * コアのリストブロックにクラスをつける
 */
add_filter( 'render_block', '\Arkhe_Theme\add_core_list_class', 99, 2 );
function add_core_list_class( $block_content, $block ) {
	if ( 'core/list' !== $block['blockName'] ) return $block_content;

	// 最初の ul, olをいじる
	$block_content = preg_replace_callback(
		'/^<(ul|ol)([^>]*)>/im',
		function( $matches ) {
			$tag   = $matches[1];
			$props = $matches[2];

			// クラスの追加
			if ( strpos( $props, 'class=' ) === false ) {
				$props .= ' class="is-core-list" ';
			} elseif ( strpos( $props, 'is-core-list' ) === false ) {
				$props = str_replace( 'class="', 'class="is-core-list ', $props );
			}

			return '<' . $tag . $props . '>';
		},
		$block_content
	);

	return $block_content;
}
