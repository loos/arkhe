<?php
namespace Arkhe_Theme\Notice;

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
