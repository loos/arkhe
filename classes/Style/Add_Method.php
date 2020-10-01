<?php
namespace Arkhe_Theme\Style;

trait Add_Method {

	/**
	 * :root スタイル生成
	 */
	public static function add_root_css( $name, $val, $media_query = 'all' ) {

		self::$root_styles[ $media_query ] .= $name . ':' . $val . ';';

	}


	/**
	 * インライン出力するスタイルを登録する
	 */
	public static function add_css( $selectors, $properties, $media_query = 'all', $branch = '' ) {

		if ( empty( $properties ) ) return;

		// セレクタの配列を分解して文字列へ
		if ( is_array( $selectors ) ) $selectors = implode( ',', $selectors );

		// プロパティの配列を分解して文字列へ
		if ( is_array( $properties ) ) $properties = implode( ';', $properties );

		// 出し分け
		if ( 'editor' === $branch ) {

			// 管理画面側でだけ出力
			if ( ! is_admin() ) return;

		} elseif ( 'front' === $branch ) {

			// フロント側でだけ出力
			if ( is_admin() ) return;

		}

		// メディアクエリごとに登録
		self::$styles[ $media_query ] .= $selectors . '{' . $properties . '}';
	}


	/**
	 * インライン出力するスタイルを登録する（フロントとエディターでそれぞれ親クラスを付与して出し分けるもの）
	 */
	public static function add_branch_css( $selectors, $properties, $media_query = 'all', $branch = 'both' ) {

		if ( empty( $properties ) ) return;
		if ( 'editor' === $branch && ! is_admin() ) return;
		if ( 'front' === $branch && is_admin() ) return;

		$new_selector = '';

		foreach ( $selectors as $s ) {
			if ( is_admin() ) {
				$new_selector .= '.mce-content-body ' . $s . ', .editor-styles-wrapper ' . $s;
			} else {
				$new_selector .= '.c-postContent ' . $s;
			}
			if ( end( $selectors ) !== $s ) {
				$new_selector .= ',';
			}
		}

		self::add_css( $new_selector, $properties, $media_query );
	}
}
