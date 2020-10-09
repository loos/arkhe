<?php
namespace Arkhe_Theme;

/**
 * ファイルの読み込み
 */
add_action( 'wp_enqueue_scripts', '\Arkhe_Theme\enqueue_front_scripts', 8 );
add_action( 'admin_enqueue_scripts', '\Arkhe_Theme\enqueue_admin_scripts' );
add_action( 'enqueue_block_editor_assets', '\Arkhe_Theme\enqueue_block_scripts' );
add_action( 'customize_controls_enqueue_scripts', '\Arkhe_Theme\enqueue_customizer_scripts' );

/**
 * フロントで読み込むファイル
 */
function enqueue_front_scripts() {
	$setting = \Arkhe::get_setting();

	// wp-block-libraryを読み込み
	wp_enqueue_style( 'wp-block-library' );

	// main.css
	wp_enqueue_style( 'arkhe-main-style', ARKHE_THEME_URI . '/dist/css/main.css', array(), ARKHE_VER );
	wp_add_inline_style( 'arkhe-main-style', \Arkhe::output_style( 'front' ) );

	// ヘッダーオーバーレイ時
	if ( \Arkhe::is_header_overlay() ) {
		wp_enqueue_style( 'arkhe-overlay-header', ARKHE_THEME_URI . '/dist/css/module/-overlay-header.css', array(), ARKHE_VER );
	}

	// Lazysizes
	wp_enqueue_script( 'arkhe-lazysizes', ARKHE_THEME_URI . '/dist/js/plugin/lazysizes.js', array(), ARKHE_VER, true );

	// main.js
	wp_enqueue_script( 'arkhe-main-script', ARKHE_THEME_URI . '/dist/js/main.js', array(), ARKHE_VER, true );
	wp_localize_script( 'arkhe-main-script', 'arkheVars', \Arkhe::get_front_global_vars() );

	// コメント用
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

/**
 * 管理画面で読み込むファイル
 */
function enqueue_admin_scripts( $hook_suffix ) {

	$css_path = ARKHE_THEME_URI . '/dist/css';

	if ( is_customize_preview() ) {
		// カスタマイザー
		wp_enqueue_style( 'arkhe-customizer', $css_path . '/admin/customizer.css', array(), ARKHE_VER );

	} elseif ( 'nav-menus.php' === $hook_suffix ) {
		// カスタムメニュー
		wp_enqueue_style( 'arkhe-nav-menus', $css_path . '/admin/nav-menus.css', array(), ARKHE_VER );

	} elseif ( 'edit.php' === $hook_suffix ) {
		// 投稿一覧
		wp_enqueue_style( 'arkhe-edit-table', $css_path . '/admin/edit-table.css', array(), ARKHE_VER );
	} elseif ( 'appearance_page_arkhe' === $hook_suffix ) {
		// テーマ設定ページ
		wp_enqueue_style( 'arkhe-menu', $css_path . '/admin/menu.css', array(), ARKHE_VER );
	}
}

/**
 * Gutenberg用ファイル
 */
function enqueue_block_scripts( $hook_suffix ) {

	// CSS
	wp_enqueue_style( 'arkhe-block-editor', ARKHE_THEME_URI . '/dist/css/editor.css', array(), ARKHE_VER );

	// Inline CSS
	wp_add_inline_style( 'arkhe-block-editor', \Arkhe::output_style( 'editor' ) );

	// JS
	// wp_enqueue_script( 'arkhe-block-editor', ARKHE_THEME_URI . '/dist/js/block.js', [], ARKHE_VER, true);
}


/**
 * カスタマイザー画面で読み込むファイル
 */
function enqueue_customizer_scripts() {
	// プレビュー画面の更新 & デバイス情報の受け渡し
	$prev_handle = 'customizer-responsive-device-preview';
	wp_enqueue_script(
		'arkhe-customizer-preview',
		ARKHE_THEME_URI . '/dist/js/admin/responsive-device-preview.js',
		array( 'customize-controls' ),
		ARKHE_VER,
		false
	);
	wp_add_inline_script( 'arkhe-customizer-preview', 'CustomizerResponsiveDevicePreview.init( wp.customize );', 'after' );

	// 設定項目の表示・非表示を切り替える処理
	wp_enqueue_script(
		'arkhe-customizer-controls',
		ARKHE_THEME_URI . '/dist/js/admin/customizer-controls.js',
		array(),
		ARKHE_VER,
		false
	);
}
