<?php
namespace Arkhe_Theme;

class Style {

	/**
	 * trait読み込み
	 */
	use Style\Add_Method,
		Style\CSS;


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

		self::set_common_style( $setting );
		if ( 'front' === $type ) self::set_front_style( $setting );
		if ( 'editor' === $type ) self::set_editor_style( $setting, $page_template );

	}


	/**
	 * 動的スタイルの生成 （共通）
	 */
	public static function set_common_style( $setting ) {

		// コンテンツ幅
		self::css_content_width( $setting['container_width'], $setting['slim_width'] );

		// カラー用CSS変数
		self::css_common( $setting );

		// 投稿リスト
		self::css_thumb_ratio( $setting['thumb_ratio'] );

		// ヘッダー
		self::css_header( $setting['logo_size_sp'], $setting['logo_size_pc'] );

	}


	/**
	 * 動的スタイルの生成 （フロント用）
	 */
	public static function set_front_style( $setting ) {
		$setting = \Arkhe::get_setting();

		self::css_alignwide( $setting['container_width'], $setting['slim_width'] );

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
