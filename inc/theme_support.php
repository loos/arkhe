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
	// add_theme_support( 'custom-spacing' );

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
				'name'      => __( 'Extra small', 'arkhe' ),
				'shortName' => 'XS',
				'size'      => 10,
				'slug'      => 'xsmall',
			),
			array(
				'name'      => __( 'Small', 'arkhe' ),
				'shortName' => 'S',
				'size'      => 12,
				'slug'      => 'small',
			),
			array(
				'name'      => __( 'Normal', 'arkhe' ),
				'shortName' => 'N',
				'size'      => 16,
				'slug'      => 'normal',
			),
			array(
				'name'      => __( 'Large', 'arkhe' ),
				'shortName' => 'L',
				'size'      => 18,
				'slug'      => 'large',
			),
			array(
				'name'      => __( 'Extra large', 'arkhe' ),
				'shortName' => 'XL',
				'size'      => 20,
				'slug'      => 'xlarge',
			),
			array(
				'name'      => __( 'Huge', 'arkhe' ),
				'shortName' => 'XXL',
				'size'      => 24,
				'slug'      => 'huge',
			),
		)
	);
}
