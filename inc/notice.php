<?php
namespace Arkhe_Theme;

/**
 * 管理画面へ表示するメッセージ
 */
add_action( 'after_switch_theme', function() {
	add_action( 'admin_notices', function() {
		$theme_url = admin_url( 'themes.php?page=arkhe' );
		echo '<div class="notice notice-info is-dismissible" style="padding-top:8px;padding-bottom:8px;">' .
				'<p>' . esc_html__( 'Thank you for using "Arkhe" !', 'arkhe' ) . '</p>' .
				'<p><a href="' . esc_url( $theme_url ) . '" class="button button-primary">' .
					esc_html__( 'Go to the theme page', 'arkhe' ) .
				'</a></p>' .
			'</div>';
	} );
} );

// add_action( 'admin_notices', '\Arkhe_Theme\arkhe_theme_beta_message' );
// function arkhe_theme_beta_message() {

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
// }
