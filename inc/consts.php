<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * テーマで定義する定数
 *   'wp_loaded' は プレビュー画面の即時反映データも受け取れる & AJAXでもギリギリ呼び出されるタイミング。
 */
add_action( 'wp_loaded', 'arkhe_hook__define_theme_const', 11 );
add_action( 'wp', 'arkhe_hook__define_page_template' );

/**
 * カスタマイザーのデータを受け取ってから定義する定数たち。
 */
if ( ! function_exists( 'arkhe_hook__define_theme_const' ) ) :
function arkhe_hook__define_theme_const() {
	$SETTING = \ARKHE_THEME::get_setting();

	// 高速化の設定
	// define( 'USE_CACHE_CARD_IN', $SETTING['cache_blogcard_in'] );
	// define( 'USE_CACHE_CARD_EX', $SETTING['cache_blogcard_ex'] );

	// プレースホルダー
	define( 'PLACEHOLDER', ARKHE_TMP_DIR_URI . '/assets/img/placeholder.gif' );

	// NO IMAGE画像
	$noimg_id  = (int) $SETTING['no_image'] ?: 0;
	$noimg_url = $noimg_id ? wp_get_attachment_url( $noimg_id ) : ARKHE_TMP_DIR_URI . '/assets/img/noimg.png';

	define( 'NOIMG_ID', $noimg_id );
	define( 'NOIMG_URL', $noimg_url );

	// 投稿リストのレイアウトタイプ
	if ( ! defined( 'POST_LIST_TYPE' ) ) {
		define( 'POST_LIST_TYPE', $SETTING['post_list_layout'] );
	}

	// 抜粋文の文字数
	if ( ! defined( 'ARKHE_EXCERPT_LENGTH' ) ) {
		define( 'ARKHE_EXCERPT_LENGTH', (int) $SETTING['excerpt_length'] );
	}
}
endif;


/**
 * ページテンプレートを定数化する。 (wp_loaded ではまだ 取得できない)
 */
if ( ! function_exists( 'arkhe_hook__define_page_template' ) ) :
function arkhe_hook__define_page_template(){

	// ページテンプレート名
	$template_slug = ( is_page() || is_single() ) ? basename( get_page_template_slug() ) : '';
	define( 'ARKHE_PAGE_TEMPLATE', $template_slug );

}
endif;