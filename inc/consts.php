<?php
namespace Arkhe_Theme;

// 「※」を定数化しておく
define( 'ARKHE_NOTE', __( 'Note : ', 'arkhe' ) );

/**
 * 定数定義 （'wp_loaded' は プレビュー画面の即時反映データも受け取れる & AJAXでもギリギリ呼び出されるタイミング。）
 */
add_action( 'wp_loaded', '\Arkhe_Theme\define_theme_const', 11 );

function define_theme_const() {

	$setting = \Arkhe::get_setting();

	// 投稿リストのレイアウトタイプ
	define( 'ARKHE_LIST_TYPE', $setting['post_list_layout'] );

	// 抜粋文の文字数
	define( 'ARKHE_EXCERPT_LENGTH', (int) $setting['excerpt_length'] );
	\Arkhe::$excerpt_length = ARKHE_EXCERPT_LENGTH;

	// プレースホルダー画像
	define( 'ARKHE_PLACEHOLDER', ARKHE_THEME_URI . '/assets/img/placeholder.gif' );

	// NO IMAGE画像
	$noimg_id  = (int) $setting['no_image'] ?: 0;
	$noimg_url = $noimg_id ? wp_get_attachment_url( $noimg_id ) : ARKHE_THEME_URI . '/assets/img/noimg.png';
	define( 'ARKHE_NOIMG_ID', $noimg_id );
	define( 'ARKHE_NOIMG_URL', $noimg_url );

}
