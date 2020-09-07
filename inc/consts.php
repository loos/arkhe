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
function arkhe_hook__define_theme_const() {
	$SETTING = \ARKHE_THEME::get_setting();

	// プレースホルダー
	define( 'ARKHE_PLACEHOLDER', ARKHE_TMP_DIR_URI . '/assets/img/placeholder.gif' );

	// NO IMAGE画像
	$noimg_id  = (int) $SETTING['no_image'] ?: 0;
	$noimg_url = $noimg_id ? wp_get_attachment_url( $noimg_id ) : ARKHE_TMP_DIR_URI . '/assets/img/noimg.png';

	define( 'ARKHE_NOIMG_ID', $noimg_id );
	define( 'ARKHE_NOIMG_URL', $noimg_url );

	// 投稿リストのレイアウトタイプ
	if ( ! defined( 'ARKHE_LIST_TYPE' ) ) {
		define( 'ARKHE_LIST_TYPE', $SETTING['post_list_layout'] );
	}

	// 抜粋文の文字数
	if ( ! defined( 'ARKHE_EXCERPT_LENGTH' ) ) {
		define( 'ARKHE_EXCERPT_LENGTH', (int) $SETTING['excerpt_length'] );
	}
}

/**
 * ページテンプレートを定数化する。 (wp_loaded ではまだ 取得できない)
 */
function arkhe_hook__define_page_template() {

	// ページテンプレート名
	$template_slug = ( is_page() || is_single() ) ? basename( get_page_template_slug() ) : '';
	define( 'ARKHE_PAGE_TEMPLATE', $template_slug );

}
