<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// 親テーマのパス
define( 'ARKHE_TMP_DIR', get_template_directory() );
define( 'ARKHE_TMP_DIR_URI', get_template_directory_uri() );

// 子テーマ（あれば）のパス
define( 'ARKHE_STL_DIR', get_stylesheet_directory() );
define( 'ARKHE_STL_DIR_URI', get_stylesheet_directory_uri() );

// テキストドメイン
load_theme_textdomain( 'arkhe', ARKHE_TMP_DIR . '/languages' );

// ※
define( 'ARKHE_NOTE', __( 'Note : ', 'arkhe' ) );


/**
 * CLASSのオートロード
 */
spl_autoload_register(
	function( $classname ) {

		// 名前に ARKHE_THEME がなければオートロードしない。
		if ( strpos( $classname, 'ARKHE_THEME' ) === false && strpos( $classname, 'ARKHE_THEME' ) === false) return;

		$classname = str_replace( '\\', '/', $classname );
		$file      = ARKHE_TMP_DIR . '/classes/' . $classname . '.php';

		if ( file_exists( $file ) ) require $file;
	}
);


/**
 * ベータ版アラート
 */
function arkhe_theme_beta_message() {
	echo '<div class="notice notice-info"><p>' .
		esc_html__( '"Arkhe" is currently in beta.', 'arkhe' ) . '<br>' .
		esc_html__( 'The theme structure is subject to change significantly until the version exceeds "1.0".', 'arkhe' ) .
	'</p></div>';
}
add_action( 'admin_notices', 'arkhe_theme_beta_message' );

/**
 * Init
 */
new \ARKHE_THEME();
