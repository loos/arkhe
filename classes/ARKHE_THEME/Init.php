<?php
namespace ARKHE_THEME;

if ( ! defined( 'ABSPATH' ) ) exit;

class Init {

	private static $instance;

	// 外部からインスタンス化させない
	private function __construct() {}

	// init()
	public static function init() {

		if ( isset( self::$instance ) ) return;
		self::$instance = new Init();

		// データをセット
		Data::init();

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
