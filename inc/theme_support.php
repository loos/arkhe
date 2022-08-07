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
	add_theme_support( 'custom-spacing' );
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
				'name'      => __( 'Double extra large', 'arkhe' ),
				'shortName' => 'XXL',
				'size'      => '2rem',
				'slug'      => 'xxlarge',
			),
			array(
				'name'      => __( 'Huge', 'arkhe' ),
				'shortName' => 'XXXL',
				'size'      => '2.75rem',
				'slug'      => 'huge',
			),
		)
	);

	// カラーパレット memo : 'slug'はクラス名で使用されるので変更NGなことに注意。
	add_theme_support( 'editor-color-palette', array(
		array(
			'name'  => __( 'Main color', 'arkhe' ),
			'slug'  => 'ark-main',
			'color' => 'var(--ark-color--main)',
		),
		array(
			'name'  => __( 'Text color', 'arkhe' ),
			'slug'  => 'ark-text',
			'color' => 'var(--ark-color--text)',
		),
		array(
			'name'  => __( 'Link color', 'arkhe' ),
			'slug'  => 'ark-link',
			'color' => 'var(--ark-color--link)',
		),
		array(
			'name'  => __( 'Background color', 'arkhe' ),
			'slug'  => 'ark-bg',
			'color' => 'var(--ark-color--bg)',
		),
		array(
			'name'  => __( 'Light gray color', 'arkhe' ),
			'slug'  => 'ark-gray',
			'color' => 'var(--ark-color--gray)',
		),
	) );

}


/**
 * デフォルトカラーパレットを使用可能にする。
 */
function enable_default_color_palette( $editor_settings, $editor_context ) {
	if ( isset( $editor_settings['__experimentalFeatures']['color'] ) ) {
		$editor_settings['__experimentalFeatures']['color']['defaultPalette'] = true;
	}
	return $editor_settings;
}
add_filter( 'block_editor_settings_all', __NAMESPACE__ . '\enable_default_color_palette', 20, 2 );
