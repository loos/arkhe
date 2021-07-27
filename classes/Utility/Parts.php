<?php
namespace Arkhe_Theme\Utility;

trait Parts {

	/**
	 * テンプレート読み込み
	 *   $slug : 読み込むファイルのパス
	 *   $args : 引数として利用できるようにする変数
	 */
	public static function get_part( $slug = '', $args = null ) {

		if ( '' === $slug ) return '';

		// パーツ読み込み前に発火するフック
		if ( has_filter( "arkhe_pre_get_part__{$slug}" ) ) {
			do_action( "arkhe_pre_get_part__{$slug}" );
		}

		// $args 上書き用フック
		if ( has_filter( "arkhe_part_args__{$slug}" ) ) {
			$args = apply_filters( "arkhe_part_args__{$slug}", $args );
		}

		// ファイルまでのパスを取得
		$inc_path = self::get_include_part_path( $slug );

		// $inc_path を任意のパスに上書き可能なフック
		if ( has_filter( "arkhe_part_path__{$slug}" ) ) {
			$inc_path = apply_filters( "arkhe_part_path__{$slug}", $inc_path );
		}

		if ( '' === $inc_path ) {
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				echo 'Not found : part "' . esc_html( $slug ) . '"';
			}
			return;
		}

		$cache_data = null;

		// キャッシュ取得用フック
		if ( has_filter( "arkhe_part_cache__{$slug}" ) ) {

			$cache_data = apply_filters( "arkhe_part_cache__{$slug}", null, $slug, $inc_path, $args );
		}

		// キャッシュがあればそれを出力
		if ( null !== $cache_data ) {
			echo $cache_data; // phpcs:ignore
		} else {
			// キャッシュなければ普通にパーツを読み込んで出力
			self::the_part_content( $slug, $inc_path, $args );
		}

		// パーツ読み込み後に発火するフック
		if ( has_filter( "arkhe_did_get_part__{$slug}" ) ) {
			do_action( "arkhe_did_get_part__{$slug}" );
		}
	}


	/**
	 * パーツテンプレートを見つけてパスを返す
	 */
	public static function get_include_part_path( $slug = '' ) {
		// 子テーマから探す
		if ( is_child_theme() ) {
			$inc_path = ARKHE_CHILD_PATH . "/template-parts/{$slug}.php";
			if ( file_exists( $inc_path ) ) return $inc_path;
		}

		// 次に、独自のパスが設定されていればそちらを探す
		if ( '' !== \Arkhe::$ex_parts_path ) {
			$inc_path = \Arkhe::$ex_parts_path . "/template-parts/{$slug}.php";
			if ( file_exists( $inc_path ) ) return $inc_path;
		}

		// 最後に、親テーマを探す
		$inc_path = ARKHE_THEME_PATH . "/template-parts/{$slug}.php";
		if ( file_exists( $inc_path ) ) return $inc_path;

		return '';
	}


	/**
	 * テンプレート読み込み実行部分
	 */
	public static function the_part_content( $slug = '', $include_path = '', $args = null ) {
		if ( has_filter( "arkhe_part__{$slug}" ) ) {
			// フィルターフックがあれば

			\ob_start();
			include $include_path;
			$part_content = \ob_get_clean();

			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo apply_filters( "arkhe_part__{$slug}", $part_content, $args );

		} else {

			// フックがなければ、普通にファイルを読み込む
			include $include_path;

		}
	}

}
