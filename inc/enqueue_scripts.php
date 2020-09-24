<?php
use ARKHE_THEME\Style;
use ARKHE_THEME\Javascript;
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * ファイルの読み込み
 */
add_action( 'wp_enqueue_scripts', 'arkhe_hook__wp_enqueue_scripts', 8 );
add_action( 'admin_enqueue_scripts', 'arkhe_hook__admin_enqueue_scripts' );
add_action( 'enqueue_block_editor_assets', 'arkhe_hook__enqueue_block_editor_assets' );

/**
 * フロントで読み込むファイル
 */
function arkhe_hook__wp_enqueue_scripts() {
	$SETTING = \ARKHE_THEME::get_setting();

	// wp-block-libraryを読み込み
	wp_enqueue_style( 'wp-block-library' );

	// main.css
	wp_enqueue_style( 'arkhe_main_style', ARKHE_TMP_DIR_URI . '/dist/css/main.css', array(), ARKHE_VERSION );

	// インライン出力するCSS
	wp_add_inline_style( 'arkhe_main_style', Style::output( 'front' ) );

	// ヘッダーオーバーレイ時
	if ( \ARKHE_THEME::is_header_overlay() ) {
		wp_enqueue_style( 'arkhe_overlay_header', ARKHE_TMP_DIR_URI . '/dist/css/module/-overlay-header.css', array(), ARKHE_VERSION );
	}

	// JS
	wp_enqueue_script( 'arkhe_lazysizes', ARKHE_TMP_DIR_URI . '/dist/js/plugin/lazysizes.js', array(), ARKHE_VERSION, true );
	wp_enqueue_script( 'arkhe_main_script', ARKHE_TMP_DIR_URI . '/dist/js/main.js', array(), ARKHE_VERSION, true );

	// フロント側に渡すグローバル変数
	wp_localize_script( 'arkhe_main_script', 'arkheVars', Javascript::get_front_global_vars() );

	// コメント用
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

/**
 * 管理画面で読み込むファイル
 */
function arkhe_hook__admin_enqueue_scripts( $hook_suffix ) {

	$css_path = ARKHE_TMP_DIR_URI . '/dist/css';

	if ( is_customize_preview() ) {
		// カスタマイザー
		wp_enqueue_style( 'arkhe-customizer', $css_path . '/admin/customizer.css', array(), ARKHE_VERSION );

	} elseif ( 'nav-menus.php' === $hook_suffix ) {
		// カスタムメニュー
		wp_enqueue_style( 'arkhe-nav-menus', $css_path . '/admin/nav-menus.css', array(), ARKHE_VERSION );

	} elseif ( 'edit.php' === $hook_suffix ) {
		// 投稿一覧
		wp_enqueue_style( 'arkhe-edit-table', $css_path . '/admin/edit-table.css', array(), ARKHE_VERSION );
	}

	// if ( 'post.php' === $hook_suffix || 'post-new.php' === $hook_suffix ) {
		// 投稿編集画面
		// wp_enqueue_style( 'arkhe-editor', $css_path . '/editor.css', array(), ARKHE_VERSION );
	// }
}

/**
 * Gutenberg用ファイル
 */
function arkhe_hook__enqueue_block_editor_assets( $hook_suffix ) {

	// CSS
	wp_enqueue_style( 'arkhe-block-editor', ARKHE_TMP_DIR_URI . '/dist/css/editor.css', array(), ARKHE_VERSION );

	// Inline CSS
	wp_add_inline_style( 'arkhe-block-editor', Style::output( 'editor' ) );

	// JS
	// wp_enqueue_script( 'arkhe-block-editor', ARKHE_TMP_DIR_URI . '/dist/js/block.js', [], ARKHE_VERSION, true);
}
