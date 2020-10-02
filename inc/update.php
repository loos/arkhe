<?php
namespace Arkhe_Theme;

/**
 * ウィジェット登録
 */
add_action( 'after_setup_theme', '\Arkhe_Theme\update_check' );

function update_check() {
	// 現在のバージョンを取得
	$now_version = \Arkhe::$arkhe_version;

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
	}
}
