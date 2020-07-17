<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * add_theme_supports
 */
add_action( 'after_setup_theme', 'arkhe_hook__setup_theme' );

if ( ! function_exists( 'arkhe_hook__setup_theme' ) ) :
function arkhe_hook__setup_theme() {
	$GLOBALS['content_width'] = apply_filters( 'arkhe_content_width', \ARKHE_THEME::get_setting( 'container_size' ) );

	// ウィジェットのカスタムHTMLでショートコードを有効化
	add_filter( 'widget_text', 'do_shortcode' );

	// タイトルでアイコン用ショートコード 使えるように
	add_filter( 'widget_title', 'do_shortcode' );

	// 固定ページでも抜粋文を使用可能にする
	add_post_type_support( 'page', 'excerpt' );

	// add_theme_support( 'menus' );
	add_theme_support( 'widgets' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	// feed
	add_theme_support( 'automatic-feed-links' );

	// Gutenberg用
	add_theme_support( 'align-wide' ); // 画像の全幅表示などを可能に
	add_theme_support( 'disable-custom-font-sizes' ); // フォントサイズのピクセル指定を不可に

	// 16:9で保つ...？
	// add_theme_support( 'responsive-embeds' );

	add_theme_support(
		'html5',
		array(
			'comment-form',
			'comment-list',
		// 'search-form',
		// 'gallery',
		// 'caption',
		)
	);

	// フォントサイズ
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name'      => '極小',
				'shortName' => 'XS',
				'size'      => 10,
				'slug'      => 'xs',
			),
			array(
				'name'      => '小',
				'shortName' => 'S',
				'size'      => 12,
				'slug'      => 'small',
			),
			array(
				'name'      => '標準',
				'shortName' => 'M',
				'size'      => 16,
				'slug'      => 'normal',
			),
			array(
				'name'      => '大',
				'shortName' => 'L',
				'size'      => 18,
				'slug'      => 'large',
			),
			array(
				'name'      => '特大',
				'shortName' => 'XL',
				'size'      => 24,
				'slug'      => 'huge',
			),
		)
	);
}
endif;
