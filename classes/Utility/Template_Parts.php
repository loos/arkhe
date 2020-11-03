<?php
namespace Arkhe_Theme\Utility;

trait Template_Parts {

	/**
	 * テンプレート読み込み
	 *   $path : 読み込むファイルのパス
	 *   $args : 引数として利用できるようにする変数
	 */
	public static function get_parts( $path = '', $args = null ) {

		if ( '' === $path ) return '';

		// フック名に流用する
		$path_key = str_replace( '/', '_', $path );

		// ファイルまでのパスを取得
		$include_path = self::get_include_parts_path( $path );

		// $include_path を任意のパスに上書き可能なフック
		$ex_path_filter = 'arkhe_ex_path_' . $path_key;
		if ( has_filter( $ex_path_filter ) ) {
			$include_path = apply_filters( $ex_path_filter, $include_path );
		}

		// キャッシュ取得用フックがあれば通す
		$cache_filter_name = 'arkhe_get_cache_' . $path_key;
		if ( has_filter( $cache_filter_name ) ) {

			// 引数3つ渡す
			$cache_data = apply_filters( $cache_filter_name, '', $path_key, $include_path, $args );

			// キャッシュがあればそれを出力
			if ( $cache_data ) {
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo $cache_data;
				return;
			}
		}

		self::the_parts_content( $path_key, $include_path, $args );
	}


	/**
	 * パーツテンプレートを見つけてパスを返す
	 */
	public static function get_include_parts_path( $path = '' ) {
		// 子テーマから探す
		$include_path = ARKHE_CHILD_PATH . '/template-parts/' . $path . '.php';
		if ( file_exists( $include_path ) ) return $include_path;

		// 次に、独自のパスが設定されていればそちらを探す
		if ( '' !== \Arkhe::$ex_parts_path ) {
			$include_path = \Arkhe::$ex_parts_path . '/template-parts/' . $path . '.php';
			if ( file_exists( $include_path ) ) return $include_path;
		}

		// 最後に、親テーマを探す
		$include_path = ARKHE_THEME_PATH . '/template-parts/' . $path . '.php';
		if ( file_exists( $include_path ) ) return $include_path;

		return ''; // どこにもファイルが見つからなかった時
	}


	/**
	 * テンプレート読み込み実行部分
	 * Toolkitからキャッシュされるのはここ
	 */
	public static function the_parts_content( $path_key = '', $include_path = '', $args = null ) {
		// フィルターフックがあれば通す
		$filter_name = 'arkhe_parts_' . $path_key;
		if ( has_filter( $filter_name ) ) {

			ob_start();
			include $include_path;
			$parts_content = ob_get_clean();

			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo apply_filters( $filter_name, $parts_content, $args );

		} else {

			// 普通にファイルを読み込むだけ
			include $include_path;

		}
	}
}
