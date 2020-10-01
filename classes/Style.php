<?php
namespace Arkhe_Theme;

if ( ! defined( 'ABSPATH' ) ) exit;

class Style {

	/**
	 * trait読み込み
	 */
	use Style\Add_Method,
		Style\Color,
		Style\Page,
		Style\Post_List;

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
	 * 動的スタイルの生成 （フロント用）
	 */
	public static function set_front_style() {
		$SETTING = \Arkhe_Theme::get_setting();

		// 投稿・固定ページ
		self::css_title_bg( $SETTING['ttlbg_overlay_color'], $SETTING['ttlbg_overlay_opacity'] );

		// 管理バー
		if ( is_user_logged_in() ) {
			self::add_css( '#wpadminbar', 'position: fixed !important' );
		}

	}


	/**
	 * 動的スタイルの生成 （フロント&エディター共通用）
	 */
	public static function set_common_style() {

		$SETTING = \Arkhe_Theme::get_setting();

		// コンテンツサイズ
		$container_size = $SETTING['container_size'];
		self::add_root_css( '--container_size', ( (int) $container_size + 96 ) . 'px' );

		// 記事コンテンツサイズ
		$page_template = basename( get_page_template_slug() ) ?: '';
		$article_size  = ( 'one-column-slim.php' === $page_template ) ? $SETTING['article_size'] : $container_size;

		self::add_root_css( '--article_size', $article_size . 'px' );

		// カラー用CSS変数のセット
		self::css_common( $SETTING );

		// 投稿リストのサムネイル比率
		self::css_thumb_ratio(
			$SETTING['card_posts_thumb_ratio'],
			$SETTING['list_posts_thumb_ratio']
		);

		// ヘッダーロゴのサイズ
		self::add_root_css( '--logo_size_sp', $SETTING['logo_size_sp'] . 'px' );
		self::add_root_css( '--logo_size_pc', $SETTING['logo_size_pc'] . 'px' );

	}


	/**
	 * メディアクエリ付きスタイルの生成
	 */
	public static function get_media_query_css( $size = '', $condition = '' ) {
		$return     = '';
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
