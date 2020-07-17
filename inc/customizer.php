<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * カスタマイザーの設定
 */
add_action( 'customize_controls_init', 'arkhe_hook__customize_controls_init' );
add_action( 'customize_controls_enqueue_scripts', 'arkhe_hook__customize_controls_enqueue_scripts' );
add_action( 'customize_register', 'arkhe_hook__customize_register', 99 );


/**
 * プレビュー画面でTab / Mobileのデバイス情報を取得できるようにする
 */
if ( ! function_exists( 'arkhe_hook__customize_controls_init' ) ) :
function arkhe_hook__customize_controls_init() {
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
endif;

/**
 * カスタマイザー画面で読み込むファイル
 */
if ( ! function_exists( 'arkhe_hook__customize_controls_enqueue_scripts' ) ) :
function arkhe_hook__customize_controls_enqueue_scripts() {
	// プレビュー画面の更新 & デバイス情報の受け渡し
	$prev_handle = 'customizer-responsive-device-preview';
	wp_enqueue_script(
		$prev_handle,
		ARKHE_TMP_DIR_URI . '/dist/js/admin/responsive-device-preview.js',
		array( 'customize-controls' ),
		ARKHE_VERSION,
		false
	);
	wp_add_inline_script( $prev_handle, 'CustomizerResponsiveDevicePreview.init( wp.customize );', 'after' );

	// 設定項目の表示・非表示を切り替える処理
	wp_enqueue_script(
		'arkhe_customizer_controls',
		ARKHE_TMP_DIR_URI . '/dist/js/admin/customizer-controls.js',
		array(),
		ARKHE_VERSION,
		false
	);
}
endif;

/**
 * カスタマイザー 登録
 */
if ( ! function_exists( 'arkhe_hook__customize_register' ) ) :
function arkhe_hook__customize_register( $wp_customize ) {

	// 全体設定
	include_once ARKHE_TMP_DIR . '/inc/customizer/common.php';

	// ヘッダー設定
	include_once ARKHE_TMP_DIR . '/inc/customizer/header.php';

	// フッター設定
	include_once ARKHE_TMP_DIR . '/inc/customizer/footer.php';

	// サイドバー
	include_once ARKHE_TMP_DIR . '/inc/customizer/sidebar.php';

	// 固定ページ設定
	include_once ARKHE_TMP_DIR . '/inc/customizer/page.php';

	// 投稿ページ設定
	include_once ARKHE_TMP_DIR . '/inc/customizer/single.php';

	// 記事一覧リスト
	include_once ARKHE_TMP_DIR . '/inc/customizer/post_list.php';

}
endif;
