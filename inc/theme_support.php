<?php
namespace Arkhe_Theme;

/**
 * add_theme_supports
 */
add_action( 'after_setup_theme', __NAMESPACE__ . '\setup_theme' );
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
	add_theme_support( 'custom-line-height' );
	add_theme_support( 'custom-units', 'px', 'rem', 'em', '%', 'vw', 'vh' );
	remove_theme_support( 'core-block-patterns' );

	// html5サポート
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
	) );

	// フォントサイズ
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name'      => __( 'Extra small', 'arkhe' ),
				'shortName' => 'XS',
				'size'      => '.75rem',
				'slug'      => 'xsmall',
			),
			array(
				'name'      => __( 'Small', 'arkhe' ),
				'shortName' => 'S',
				'size'      => '.9rem',
				'slug'      => 'small',
			),
			array(
				'name'      => __( 'Normal', 'arkhe' ),
				'shortName' => 'N',
				'size'      => '1rem',
				'slug'      => 'normal',
			),
			array(
				'name'      => __( 'Large', 'arkhe' ),
				'shortName' => 'L',
				'size'      => '1.25rem',
				'slug'      => 'large',
			),
			array(
				'name'      => __( 'Extra large', 'arkhe' ),
				'shortName' => 'XL',
				'size'      => '1.5rem',
				'slug'      => 'xlarge',
			),
			array(
				'name'      => __( 'Huge', 'arkhe' ),
				'shortName' => 'XXL',
				'size'      => '2rem',
				'slug'      => 'huge',
			),
		)
	);
}
