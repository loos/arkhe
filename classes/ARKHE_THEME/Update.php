<?php
namespace ARKHE_THEME;

use \ARKHE_THEME\Data;
if ( ! defined( 'ABSPATH' ) ) exit;

class Update {

	private function __construct() {}

	// init()
	public static function version_check() {

		// 現在のバージョンを取得
		$now_version = Data::$arkhe_version;

		// データベースに保存されているバージョンデータを取得
		$old_ver = get_option( 'arkhe_version' );

		// まだバージョン情報が記憶されていなければ DB更新だけする
		if ( false === $old_ver ) {
			update_option( 'arkhe_version', $now_version );
			return;
		}

		// アップデート時の処理
		if ( $now_version !== $old_ver ) {
			update_option( 'arkhe_version', $now_version );
			// self::updated_event();
		}
	}


	/**
	 * アップデート時に発火する処理
	 */
	// private static function updated_event() {}

}
