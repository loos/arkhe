<?php
namespace Arkhe_Theme\Update;

/**
 * ウィジェット登録
 */
add_action( 'after_setup_theme', __NAMESPACE__ . '\update_check' );
function update_check() {
	// 現在のバージョンを取得
	$now_version = \Arkhe::$theme_ver;

	// データベースに保存されているバージョンデータを取得
	$old_ver = get_theme_mod( 'version' );

	// まだバージョン情報が記憶されていない（インストール時）、 DB更新だけ
	if ( false === $old_ver ) {
		set_theme_mod( 'version', $now_version );
		return;
	}

	// アップデート時の処理
	if ( $now_version !== $old_ver ) {
		set_theme_mod( 'version', $now_version );
		delete_transient( 'arkhe_informations' );
	}
}
