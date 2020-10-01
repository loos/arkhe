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

		// 名前に Arkhe_Theme がなければオートロードしない。
		if ( strpos( $classname, 'Arkhe_Theme' ) === false && strpos( $classname, 'Arkhe_Theme' ) === false) return;

		$classname = str_replace( '\\', '/', $classname );
		$classname = str_replace( 'Arkhe_Theme/', '', $classname );
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
 * Arkhe_Theme
 */
class Arkhe_Theme extends \Arkhe_Theme\Data {

	use \Arkhe_Theme\Utility\Attrs,
		\Arkhe_Theme\Utility\Parts,
		\Arkhe_Theme\Utility\Output,
		\Arkhe_Theme\Utility\Utility,
		\Arkhe_Theme\Utility\Condition,
		\Arkhe_Theme\Utility\Template_Parts;

	public function __construct() {
		// データをセット
		self::init();

		// 定数定義
		require_once ARKHE_TMP_DIR . '/inc/consts.php';

		// テーマサポート機能
		require_once ARKHE_TMP_DIR . '/inc/theme_support.php';

		// ファイル読み込み
		require_once ARKHE_TMP_DIR . '/inc/enqueue_scripts.php';

		// ウィジェット
		require_once ARKHE_TMP_DIR . '/inc/widget.php';

		// カスタムメニュー
		require_once ARKHE_TMP_DIR . '/inc/custom_menu.php';

		// カスタマイザー
		require_once ARKHE_TMP_DIR . '/inc/customizer.php';

		// クラシックエディター
		require_once ARKHE_TMP_DIR . '/inc/tinymce.php';

		// その他、フック処理
		require_once ARKHE_TMP_DIR . '/inc/hooks.php';

		// アップデートチェック
		if ( is_admin() || is_user_logged_in() ) {
			require_once ARKHE_TMP_DIR . '/inc/update.php';
		}
	}
}

/**
 * Init
 */
new \Arkhe_Theme();
