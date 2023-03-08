<?php
namespace Arkhe_Theme;

class Style {

	/**
	 * trait読み込み
	 */
	use Style\Helper;


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
	// public static $modules = array();


	/**
	 * CSS生成
	 */
	public function __construct( $type = '' ) {

		$setting = \Arkhe::get_setting();

		// ページテンプレート取得
		$page_template = basename( get_page_template_slug() ) ?: '';

		self::set_common_style();

		if ( 'front' === $type ) self::set_front_style( $setting );
		if ( 'editor' === $type ) self::set_editor_style( $setting, $page_template );

	}


	/**
	 * 動的スタイルの生成 （共通）
	 */
	public static function set_common_style() {

		// コンテンツ幅
		self::set_content_width();

		// カラー用CSS変数
		self::add_root_css( '--ark-color--main', \Arkhe::get_setting( 'color_main' ) );
		self::add_root_css( '--ark-color--text', \Arkhe::get_setting( 'color_text' ) );
		self::add_root_css( '--ark-color--link', \Arkhe::get_setting( 'color_link' ) );
		self::add_root_css( '--ark-color--bg', \Arkhe::get_setting( 'color_bg' ) );
		self::add_root_css( '--ark-color--gray', \Arkhe::get_setting( 'color_gray' ) );

		// 投稿リストのサムネイル比率
		self::add_root_css( '--ark-thumb_ratio', self::get_thumb_ratio( \Arkhe::get_setting( 'thumb_ratio' ) ) );

		// ヘッダー
		self::add_root_css( '--ark-color--header_bg', \Arkhe::get_setting( 'header_color_bg' ) );
		self::add_root_css( '--ark-color--header_txt', \Arkhe::get_setting( 'header_color_txt' ) );
		self::add_root_css( '--ark-logo_size--sp', \Arkhe::get_setting( 'logo_size_sp' ) . 'px' );
		self::add_root_css( '--ark-logo_size--pc', \Arkhe::get_setting( 'logo_size_pc' ) . 'px' );

		if ( \Arkhe::get_setting( 'under_gnav_color_bg' ) ) {
			self::add_css( '.l-headerUnder', '--the-color--bg:' . \Arkhe::get_setting( 'under_gnav_color_bg' ) );
		}
		if ( \Arkhe::get_setting( 'under_gnav_color_txt' ) ) {
			self::add_css( '.l-headerUnder', '--the-color--txt:' . \Arkhe::get_setting( 'under_gnav_color_txt' ) );
		}

		// フッター
		self::add_root_css( '--ark-color--footer_bg', \Arkhe::get_setting( 'footer_color_bg' ) );
		self::add_root_css( '--ark-color--footer_txt', \Arkhe::get_setting( 'footer_color_txt' ) );

	}


	/**
	 * 動的スタイルの生成 （フロント用）
	 */
	public static function set_front_style( $setting ) {
		$setting = \Arkhe::get_setting();

		// 投稿・固定ページ
		self::css_title_bg( $setting['ttlbg_overlay_color'], $setting['ttlbg_overlay_opacity'] );

		// 管理バー
		if ( is_user_logged_in() ) {
			self::add_css( '#wpadminbar', 'position: fixed !important' );
		}

	}


	/**
	 * 動的スタイルの生成 （エディター用）
	 */
	public static function set_editor_style( $setting, $page_template ) {

		// ブロック幅
		self::css_block_width( $setting['container_width'], $setting['slim_width'], $page_template );

	}


	/**
	 * メディアクエリ付きスタイルの生成
	 */
	public static function get_media_query_css( $size = '', $condition = '' ) {
		$return = '';

		$style      = self::$styles[ $size ];
		$root_style = self::$root_styles[ $size ];

		// CSS変数
		if ( $root_style ) $return .= ':root{' . $root_style . '}';

		// スタイル
		if ( $style ) $return .= ':root{' . $style . '}';

		// スタイルのない場合
		if ( ! $return ) return '';

		return '@media (' . $condition . '){' . $return . '}';
	}

}
