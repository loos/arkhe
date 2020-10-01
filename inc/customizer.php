<?php
namespace Arkhe_Theme;

/**
 * カスタマイザーの設定
 */
add_action( 'customize_register', '\Arkhe_Theme\customizer_setup', 20 );
add_action( 'customize_controls_init', '\Arkhe_Theme\customizer_init' );


/**
 * カスタマイザーの設定項目を登録
 */
function customizer_setup( $wp_customize ) {

	// 全体設定
	include_once ARKHE_THEME_PATH . '/inc/customizer/common.php';

	// ヘッダー設定
	include_once ARKHE_THEME_PATH . '/inc/customizer/header.php';

	// フッター設定
	include_once ARKHE_THEME_PATH . '/inc/customizer/footer.php';

	// サイドバー
	include_once ARKHE_THEME_PATH . '/inc/customizer/sidebar.php';

	// 固定ページ設定
	include_once ARKHE_THEME_PATH . '/inc/customizer/page.php';

	// 投稿ページ設定
	include_once ARKHE_THEME_PATH . '/inc/customizer/single.php';

	// 記事一覧リスト
	include_once ARKHE_THEME_PATH . '/inc/customizer/post_list.php';

}


/**
 * プレビュー画面でTab / Mobileのデバイス情報を取得できるようにする
 */
function customizer_init() {
	global $wp_customize;
	$previewed_device_name = null;

	// デバイス情報の取得
	$previewed_devices = $wp_customize->get_previewable_devices();
	foreach ( $previewed_devices as $device => $params ) {
		if ( isset( $params['default'] ) && true === $params['default'] ) {
			$previewed_device_name = $device;
			break;
		}
	}
	if ( $previewed_device_name ) {
		$wp_customize->set_preview_url(
			add_query_arg( 'customize_previewed_device', $previewed_device_name, $wp_customize->get_preview_url() )
		);
	}
}
