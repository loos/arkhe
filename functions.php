<?php
/**
 * @package Arkhe
 * @author LOOS,Inc.
 * @link https://arkhe-theme.com/
 */

/**
 * パス・URIの定数化
 */
define( 'ARKHE_THEME_PATH', get_template_directory() );
define( 'ARKHE_THEME_URI', get_template_directory_uri() );

// 子テーマ用のパス, URI
if ( ! defined( 'ARKHE_CHILD_PATH' ) ) {
	define( 'ARKHE_CHILD_PATH', get_stylesheet_directory() );
}
if ( ! defined( 'ARKHE_CHILD_URI' ) ) {
	define( 'ARKHE_CHILD_URI', get_stylesheet_directory_uri() );
}


/**
 * CLASSのオートロード
 */
spl_autoload_register(
	function( $classname ) {

		// 名前に Arkhe_Theme がなければオートロードしない。
		if ( strpos( $classname, 'Arkhe_Theme' ) === false ) return;

		$classname = str_replace( '\\', '/', $classname );
		$classname = str_replace( 'Arkhe_Theme/', '', $classname );
		$file      = ARKHE_THEME_PATH . '/classes/' . $classname . '.php';

		if ( file_exists( $file ) ) require $file;
	}
);


/**
 * Arkhe_Theme
 */
class Arkhe extends \Arkhe_Theme\Data {

	use \Arkhe_Theme\Utility\Attrs;
    use \Arkhe_Theme\Utility\Get;
    use \Arkhe_Theme\Utility\SVG;
    use \Arkhe_Theme\Utility\Image;
    use \Arkhe_Theme\Utility\Parts;
    use \Arkhe_Theme\Utility\Output;
    use \Arkhe_Theme\Utility\Licence;
    use \Arkhe_Theme\Utility\Condition;

	public function __construct() {

		// Data::init データをセット
		self::init();

		// 定数定義
		require_once ARKHE_THEME_PATH . '/inc/consts.php';

		// テーマサポート機能
		require_once ARKHE_THEME_PATH . '/inc/theme_support.php';

		// ファイル読み込み
		require_once ARKHE_THEME_PATH . '/inc/enqueue_scripts.php';

		// カスタマイザー
		require_once ARKHE_THEME_PATH . '/inc/customizer.php';

		// カスタムメニュー
		require_once ARKHE_THEME_PATH . '/inc/custom_menu.php';

		// ウィジェット
		require_once ARKHE_THEME_PATH . '/inc/widget.php';

		// Gutenberg
		require_once ARKHE_THEME_PATH . '/inc/gutenberg.php';

		// クラシックエディター
		require_once ARKHE_THEME_PATH . '/inc/tinymce.php';

		// プラガブル関数
		require_once ARKHE_THEME_PATH . '/inc/pluggable.php';

		// 出力処理
		require_once ARKHE_THEME_PATH . '/inc/output.php';

		// その他、フック処理
		require_once ARKHE_THEME_PATH . '/inc/hooks.php';

		// 後方互換用関数
		require_once ARKHE_THEME_PATH . '/inc/backward.php';

		if ( is_admin() ) {
			// Notice
			require_once ARKHE_THEME_PATH . '/inc/notice.php';

			// テーマページ
			require_once ARKHE_THEME_PATH . '/inc/theme_menu.php';
		}

		// アップデート時の処理
		if ( is_admin() || is_user_logged_in() ) {
			require_once ARKHE_THEME_PATH . '/inc/update.php';
		}
	}
}


/**
 * Start!
 */
new \Arkhe();
