<?php
namespace Arkhe_Theme;

/**
 * add_theme_supports
 */
add_action( 'after_setup_theme', '\Arkhe_Theme\setup_theme' );

function setup_theme() {

	// phpcs:ignore WPThemeReview.CoreFunctionality.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'arkhe_content_width', \Arkhe::get_setting( 'container_width' ) );

	// 固定ページでも抜粋文を使用可能にする
	add_post_type_support( 'page', 'excerpt' );

	// カスタムロゴ
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 160,
			'width'       => 320,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// add_theme_support( 'menus' );
	add_theme_support( 'widgets' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	// feed
	add_theme_support( 'automatic-feed-links' );

	// Gutenberg用
	add_theme_support( 'align-wide' ); // 画像の全幅表示などを可能に
	add_theme_support( 'disable-custom-font-sizes' ); // フォントサイズのピクセル指定を不可に
	add_theme_support( 'custom-line-height' );
	add_theme_support( 'custom-units', 'px', 'vw', 'vh' );

	// html5サポート
	$html5s = array(
		'comment-form',
		'comment-list',
	);
	add_theme_support( 'html5', $html5s );

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
