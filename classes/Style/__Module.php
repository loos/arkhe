<?php
namespace Arkhe_Theme;

if ( ! defined( 'ABSPATH' ) ) exit;


// モジュールCSSを読み込んで連結
Style::$modules;
foreach ( Style::$modules as $filename ) {
	$module_path = Style::get_module_path( $filename );
	if ( $module_path ) {
		$module_style  = \Arkhe_Theme::get_file_contents( $module_path );
		$module_style  = str_replace( '@charset "UTF-8";', '', $module_style );
		$output_style .= $module_style;
	}
}


trait Module {

	/**
	 * ファイル読み込み
	 */
	public static function get_file_contents( $file ) {

		if ( ! file_exists( $file ) ) return false;

		if ( ! function_exists( 'WP_Filesystem' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		$creds = request_filesystem_credentials( '' );

		// WP_Filesystem 初期化
		if ( \WP_Filesystem( $creds ) ) {
			global $wp_filesystem;
			$file_content = $wp_filesystem->get_contents( $file );
			return $file_content;
		}

		return false;
	}


	/**
	 * モジュール化された.css ファイルを登録
	 */
	public static function add_module( $filename = '' ) {

		self::$modules[] = $filename;

	}

	/**
	 * モジュール化された.css ファイルを探す
	 */
	public static function get_module_path( $filename = '' ) {

		// まず子テーマ側から探す
		$module_path = ARKHE_CHILD_PATH . '/dist/css/module/' . $filename . '.css';
		if ( ! file_exists( $module_path ) ) {

			// 小テーマにファイルがなければ 親テーマから探す
			$module_path = ARKHE_THEME_PATH . '/dist/css/module/' . $filename . '.css';
			if ( ! file_exists( $module_path ) ) {

				// 親テーマにもファイルが無ければ
				$module_path = '';

			}
		}

		return $module_path;

	}
}
