<?php
namespace Arkhe_Theme\Utility;

trait Parts {

	/**
	 * テンプレート読み込み
	 *   $path : 読み込むファイルのパス
	 *   $args : 引数として利用できるようにする変数
	 */
	public static function get_part( $path = '', $args = null ) {

		if ( '' === $path ) return '';

		// $path_key = str_replace( '/', '_', $path );

		// パーツ読み込み前に発火するフック
		if ( has_filter( 'arkhe_pre_get_part__' . $path ) ) {
			do_action( 'arkhe_pre_get_part__' . $path );
		}

		// $args 上書き用フック
		if ( has_filter( 'arkhe_part_args__' . $path ) ) {
			$args = apply_filters( 'arkhe_part_args__' . $path, $args );
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

		$cache_data = '';

		// キャッシュ取得用フック
		if ( has_filter( 'arkhe_part_cache__' . $path ) ) {
			$cache_data = apply_filters( 'arkhe_part_cache__' . $path, '', $path, $inc_path, $args );
		}

		// キャッシュがあればそれを出力
		if ( $cache_data ) {
			echo $cache_data; // phpcs:ignore
		} else {
			// キャッシュなければ普通にパーツを読み込んで出力
			self::the_part_content( $path, $inc_path, $args );
		}

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
	 * pluggableパーツ 取得版
	 */
	public static function get_pluggable_part( $name, $args = array() ) {
		$func_name = "ark_part__{$name}";
		if ( ! function_exists( $func_name ) ) return '';

		$return = $func_name( $args );
		return apply_filters( "arkhe_pluggable_part__{$name}", $return, $args );
	}


	/**
	 * pluggableパーツ出力版
	 */
	public static function the_pluggable_part( $name, $args = array() ) {
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo self::get_pluggable_part( $name, $args );
	}

}
