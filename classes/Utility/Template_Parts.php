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

		// フック名に使う
		// $path_key = str_replace( '/', '_', $path );

		// パーツ読み込み前に発火するフック
		if ( has_filter( 'arkhe_pre_get_parts__' . $path ) ) {
			do_action( 'arkhe_pre_get_parts__' . $path );
		}

		// ファイルまでのパスを取得
		$inc_path = self::get_include_parts_path( $path );

		// $inc_path を任意のパスに上書き可能なフック
		if ( has_filter( 'arkhe_parts_path__' . $path ) ) {
			$inc_path = apply_filters( 'arkhe_parts_path__' . $path, $inc_path );
		}

		if ( '' === $inc_path ) {
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				echo 'Not found : parts "' . esc_html( $path ) . '"';
			}
			return;
		}

		// キャッシュ取得用フック
		if ( has_filter( 'arkhe_get_parts_cache__' . $path ) ) {

			// 引数3つ
			$cache_data = apply_filters( 'arkhe_get_parts_cache__' . $path, '', $path, $inc_path, $args );

			// キャッシュがあればそれを出力
			if ( $cache_data ) {
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo $cache_data;
				return;
			}
		}

		self::the_parts_content( $path, $inc_path, $args );

		// パーツ読み込み後に発火するフック
		if ( has_filter( 'arkhe_did_get_parts__' . $path ) ) {
			do_action( 'arkhe_did_get_parts__' . $path );
		}
	}


	/**
	 * パーツテンプレートを見つけてパスを返す
	 */
	public static function get_include_parts_path( $path = '' ) {
		// 子テーマから探す
		$inc_path = ARKHE_CHILD_PATH . '/template-parts/' . $path . '.php';
		if ( file_exists( $inc_path ) ) return $inc_path;

		// 次に、独自のパスが設定されていればそちらを探す
		if ( '' !== \Arkhe::$ex_parts_path ) {
			$inc_path = \Arkhe::$ex_parts_path . '/template-parts/' . $path . '.php';
			if ( file_exists( $inc_path ) ) return $inc_path;
		}

		// 最後に、親テーマを探す
		$inc_path = ARKHE_THEME_PATH . '/template-parts/' . $path . '.php';
		if ( file_exists( $inc_path ) ) return $inc_path;

		return '';
	}


	/**
	 * テンプレート読み込み実行部分
	 * Toolkitからキャッシュされるのはここ
	 */
	public static function the_parts_content( $path = '', $include_path = '', $args = null ) {
		if ( has_filter( 'arkhe_parts__' . $path ) ) {
			// フィルターフックがあれば通す

			ob_start();
			include $include_path;
			$parts_content = ob_get_clean();

			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo apply_filters( 'arkhe_parts__' . $path, $parts_content, $args );

		} else {

			// フックがなければ、普通にファイルを読み込む
			include $include_path;

		}
	}
}
