<?php
namespace Arkhe_Theme;

/**
 * 管理画面へ表示するメッセージ
 */
add_action( 'admin_notices', '\Arkhe_Theme\arkhe_theme_beta_message' );
function arkhe_theme_beta_message() {

	// ベータ版アラート （1.0 で消す）
	echo '<div class="notice notice-info -arkhe-beta"><p>' .
		esc_html__( '"Arkhe" is currently in beta.', 'arkhe' ) . '<br>' .
		esc_html__( 'The theme structure is subject to change significantly until the version exceeds "1.0".', 'arkhe' ) .
	'</p></div>';

	// 管理者にだけテーマに関する重要なお知らせを表示
	// if ( current_user_can( 'administrator' ) ) {

	// 	// delete_transient( 'arkhe_notice_message' );
	// 	$json = get_transient( 'arkhe_notice_message' );
	// 	if ( ! $json ) {
	// 		$response = wp_remote_get( 'https://looscdn.com/cdn/curltest/json/test.json' );
	// 		$json     = wp_remote_retrieve_body( $response );
	// 		set_transient( 'arkhe_notice_message', $json, 1 * DAY_IN_SECONDS );
	// 	}

	// 	$notice_data = json_decode( $json, true );

	// 	$message = $notice_data['message'];
	// 	$links   = $notice_data['links'];

	// 	echo '<div class="notice notice-info -arkhe-info">';
	// 	echo '<p>' . esc_html( $message ) . '<br>';
	// 	foreach ( $links as $link ) {
	// 		echo '<a href="' . esc_url( $link['url'] ) . '">' . esc_html( $link['text'] ) . '</a>';
	// 	}
	// 	echo '</p></div>';
	// }
}
