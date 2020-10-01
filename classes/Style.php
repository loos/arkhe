<?php
namespace Arkhe_Theme;

if ( ! defined( 'ABSPATH' ) ) exit;

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
	 * コンストラクタ
	 */
	public function __construct( $type = '' ) {
		if ( 'front' === $type ) {
			self::set_common_style();
			self::set_front_style();
		} elseif ( 'editor' === $type ) {
			self::set_common_style();
		}
	}


	/**
	 * 動的スタイルの生成 （フロント用）
	 */
	public static function set_front_style() {
		$setting = \Arkhe_Theme::get_setting();

		// 投稿・固定ページ
		self::css_title_bg( $setting['ttlbg_overlay_color'], $setting['ttlbg_overlay_opacity'] );

		// 管理バー
		if ( is_user_logged_in() ) {
			self::add_css( '#wpadminbar', 'position: fixed !important' );
		}

	}


	/**
	 * 動的スタイルの生成 （フロント&エディター共通用）
	 */
	public static function set_common_style() {

		$setting = \Arkhe_Theme::get_setting();

		// カラー用CSS変数
		self::css_common( $setting );

		// コンテンツサイズ
		self::css_contents( $setting['container_size'], $setting['article_size'] );

		// 投稿リスト
		self::css_thumb_ratio( $setting['card_posts_thumb_ratio'], $setting['list_posts_thumb_ratio'] );

		// ヘッダー
		self::css_header( $setting['logo_size_sp'], $setting['logo_size_pc'] );

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
