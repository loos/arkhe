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
if ( ! function_exists( 'arkhe_hook__wp_enqueue_scripts' ) ) :
function arkhe_hook__wp_enqueue_scripts() {
	$SETTING = \ARKHE_THEME::get_setting();

	// wp-block-libraryを読み込み
	wp_enqueue_style( 'wp-block-library' );

	// main.css
	wp_enqueue_style( 'arkhe_main_style', ARKHE_TMP_DIR_URI . '/dist/css/main.css', array(), ARKHE_VERSION );

	// インライン出力するCSS
	wp_add_inline_style( 'arkhe_main_style', Style::output( 'front' ) );

	// JS
	wp_enqueue_script( 'arkhe_lazysizes', ARKHE_TMP_DIR_URI . '/assets/js/lazysizes.js', array(), ARKHE_VERSION, true );
	wp_enqueue_script( 'arkhe_main_script', ARKHE_TMP_DIR_URI . '/dist/js/main.js', array(), ARKHE_VERSION, true );

	// フロント側に渡すグローバル変数
	wp_localize_script( 'arkhe_main_script', 'arkheVars', Javascript::get_front_global_vars() );

	// コメント用
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
endif;

/**
 * 管理画面で読み込むファイル
 */

if ( ! function_exists( 'arkhe_hook__admin_enqueue_scripts' ) ) :
function arkhe_hook__admin_enqueue_scripts( $hook_suffix ) {

	global $post_type;

	// メディアアップローダー用
	// wp_enqueue_media();
	// wp_enqueue_script( 'mediauploader', ARKHE_TMP_DIR_URI.'/dist/js/admin/mediauploader.js', [ 'jquery' ], ARKHE_VERSION );

	// カラーピッカー
	// wp_enqueue_style( 'wp-color-picker' );
	// wp_enqueue_script( 'wp-color-picker' );

	// 管理画面用CSS
	wp_enqueue_style( 'arkhe_admin_style', ARKHE_TMP_DIR_URI . '/dist/css/admin.css', array(), ARKHE_VERSION );

	// インライン出力するCSS
	wp_add_inline_style( 'arkhe_admin_style', Style::output( 'editor' ) );

	// 管理画面用JS
	// wp_enqueue_script( 'arkhe_admin_script', ARKHE_TMP_DIR_URI . '/dist/js/admin/admin_script.js', array( 'jquery' ), ARKHE_VERSION );

	// 管理画面側に渡すグローバル変数
	wp_localize_script( 'arkhe_admin_script', 'arkheVars', Javascript::get_admin_global_vars() );
}
endif;

/**
 * Gutenberg用ファイル
 */
if ( ! function_exists( 'arkhe_hook__enqueue_block_editor_assets' ) ) :
function arkhe_hook__enqueue_block_editor_assets( $hook_suffix ) {

	// CSS
	wp_enqueue_style( 'arkhe_block_style', ARKHE_TMP_DIR_URI . '/dist/css/editor.css', array(), ARKHE_VERSION );

	// JS
	// wp_enqueue_script( 'arkhe_block_script', ARKHE_TMP_DIR_URI . '/dist/js/block.js', [], ARKHE_VERSION, true);
}
endif;
