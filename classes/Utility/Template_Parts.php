<?php
namespace Arkhe_Theme\Utility;

trait Template_Parts {

	/**
	 * テンプレート読み込み
	 *   $path : 読み込むファイルのパス
	 *   $args : 引数として利用できるようにする変数
	 */
	public static function get_part( $path = '', $args = null ) {

		if ( '' === $path ) return '';

		// フック名に使う
		// $path_key = str_replace( '/', '_', $path );

		// パーツ読み込み前に発火するフック
		if ( has_filter( 'arkhe_pre_get_part__' . $path ) ) {
			do_action( 'arkhe_pre_get_part__' . $path );
		}

		// ファイルまでのパスを取得
		$inc_path = self::get_include_part_path( $path );

		// $inc_path を任意のパスに上書き可能なフック
		if ( has_filter( 'arkhe_part_path__' . $path ) ) {
			$inc_path = apply_filters( 'arkhe_part_path__' . $path, $inc_path );
		}

		if ( '' === $inc_path ) {
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				echo 'Not found : part "' . esc_html( $path ) . '"';
			}
			return;
		}

		// キャッシュ取得用フック
		if ( has_filter( 'arkhe_part_cache__' . $path ) ) {

			// 引数3つ
			$cache_data = apply_filters( 'arkhe_part_cache__' . $path, '', $path, $inc_path, $args );

			// キャッシュがあればそれを出力
			if ( $cache_data ) {
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo $cache_data;
				return;
			}
		}

		// パーツ出力
		self::the_part_content( $path, $inc_path, $args );

		// パーツ読み込み後に発火するフック
		if ( has_filter( 'arkhe_did_get_part__' . $path ) ) {
			do_action( 'arkhe_did_get_part__' . $path );
		}
	}


	/**
	 * パーツテンプレートを見つけてパスを返す
	 */
	public static function get_include_part_path( $path = '' ) {
		// 子テーマから探す
		if ( is_child_theme() ) {
			$inc_path = ARKHE_CHILD_PATH . '/template-parts/' . $path . '.php';
			if ( file_exists( $inc_path ) ) return $inc_path;
		}

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
	 */
	public static function the_part_content( $path = '', $include_path = '', $args = null ) {
		if ( has_filter( 'arkhe_part__' . $path ) ) {
			// フィルターフックがあれば

			ob_start();
			include $include_path;
			$part_content = ob_get_clean();

			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo apply_filters( 'arkhe_part__' . $path, $part_content, $args );

		} else {

			// フックがなければ、普通にファイルを読み込む
			include $include_path;

		}
	}

	/**
	 * 0.7時の関数名変更の後方互換用 -> 1.0 で消す
	 */
	public static function get_parts( $path = '', $args = null ) {
		self::get_part( $path, $args );
	}
	public static function the_parts_content( $path = '', $include_path = '', $args = null ) {
		self::the_part_content( $path, $include_path, $args );
	}
}
