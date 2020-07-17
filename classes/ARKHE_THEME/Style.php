<?php namespace ARKHE_THEME;

use ARKHE_THEME\Style as Style;
if ( ! defined( 'ABSPATH' ) ) exit;

class Style {

	/**
	 * CSS変数をまとめておく
	 */
	public static $root_styles = array(
		'all'    => '',
		'pc'     => '',
		'sp'     => '',
		'tab'    => '',
		'mobile' => '',
	);

	/**
	 * 最終的に吐き出すCSS
	 */
	public static $styles = array(
		'all'    => '',
		'pc'     => '',
		'sp'     => '',
		'tab'    => '',
		'mobile' => '',
	);

	/**
	 * モジュール化したCSSの一覧
	 */
	public static $modules = array();

	/**
	 * 外部からのインタンス呼び出し無効
	 */
	private function __construct() {}


	/**
	 * :root スタイル生成
	 */
	public static function add_root( $name, $val, $media_query = 'all' ) {

		self::$root_styles[ $media_query ] .= $name . ':' . $val . ';';

	}


	/**
	 * インライン出力するスタイルを登録する
	 */
	public static function add( $selectors, $properties, $media_query = 'all', $branch = '' ) {

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
	public static function add_set_post_content_style( $selectors, $properties, $media_query = 'all', $branch = 'both' ) {

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

		self::add( $new_selector, $properties, $media_query );
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
		$module_path = ARKHE_STL_DIR . '/dist/css/module/' . $filename . '.css';
		if ( ! file_exists( $module_path ) ) {

			// 小テーマにファイルがなければ 親テーマから探す
			$module_path = ARKHE_TMP_DIR . '/dist/css/module/' . $filename . '.css';
			if ( ! file_exists( $module_path ) ) {

				// 親テーマにもファイルが無ければ
				$module_path = '';

			}
		}

		return $module_path;

	}


	/**
	 * カスタムスタイルの生成 （フロント用）
	 */
	public static function set_front_style() {
		$SETTING = \ARKHE_THEME::get_setting();

		if ( is_user_logged_in() ) {
			self::add( '#wpadminbar', 'position: fixed !important' );
		}

		// コンテンツサイズ
		$container_size = (int) $SETTING['container_size'] + 96;
		self::add_root( '--container_size', $container_size . 'px' );

		// 記事コンテンツサイズ
		if ( 'one-column-slim.php' === ARKHE_PAGE_TEMPLATE ) {
			$article_size = (int) $SETTING['article_size'];
		} else {
			$article_size = (int) $SETTING['container_size'];
		};
		self::add_root( '--article_size', $article_size . 'px' );

		// ヘッダーオーバーレイ
		if ( \ARKHE_THEME::is_header_overlay() ) {
			self::add_module( '-overlay-header' );
		}

		// 投稿・固定ページ
		Style\Page::title_bg( $SETTING['ttlbg_overlay_color'], $SETTING['ttlbg_overlay_opacity'] );

	}


	/**
	 * カスタムスタイルの生成 （フロント&エディター共通用）
	 */
	public static function set_post_content_style() {

		$SETTING    = \ARKHE_THEME::get_setting();
		$color_main = $SETTING['color_main'];

		// カラー用CSS変数のセット
		Style\Color::common( $SETTING );

		// 投稿リストのサムネイル比率
		Style\Post_List::thumb_ratio(
			$SETTING['card_posts_thumb_ratio'],
			$SETTING['list_posts_thumb_ratio']
		);

		// ヘッダーロゴのサイズ
		self::add_root( '--logo_size_sp', $SETTING['logo_size_sp'] . 'px' );
		self::add_root( '--logo_size_pc', $SETTING['logo_size_pc'] . 'px' );

	}


	/**
	 * スタイルの出力 : 呼び出されるのはこいつ
	 */
	public static function output( $type = 'front' ) {

		// スタイルを生成
		if ( 'front' === $type ) {
			self::set_post_content_style();
			self::set_front_style();
		} elseif ( 'editor' === $type ) {
			self::set_post_content_style();
		}

		$output_style  = '';
		$output_style .= ':root{' . self::$root_styles['all'] . '}';

		$styles = self::$styles;

		$output_style .= $styles['all'];

		$output_style .= '@media screen and (min-width: 960px){:root{' . self::$root_styles['pc'] . '}' . $styles['pc'] . '}';
		$output_style .= '@media screen and (max-width: 959px){:root{' . self::$root_styles['sp'] . '}' . $styles['sp'] . '}';
		$output_style .= '@media screen and (min-width: 600px){:root{' . self::$root_styles['tab'] . '}' . $styles['tab'] . '}';
		$output_style .= '@media screen and (max-width: 599px){:root{' . self::$root_styles['mobile'] . '}' . $styles['mobile'] . '}';

		// モジュールCSSを読み込んで連結
		self::$modules;
		foreach ( self::$modules as $filename ) {
			$module_path = self::get_module_path( $filename );
			if ( $module_path ) {
				$module_style  = \ARKHE_THEME::get_file_contents( $module_path );
				$module_style  = str_replace( '@charset "UTF-8";', '', $module_style );
				$output_style .= $module_style;
			}
		}

		return $output_style;
	}

}
