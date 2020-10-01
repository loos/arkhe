<?php
namespace Arkhe_Theme\Style;

if ( ! defined( 'ABSPATH' ) ) exit;

trait CSS {

	/**
	 * カラー変数のセット（フロント & エディターで共通のもの）
	 */
	protected static function css_common( $setting ) {
		self::add_root_css( '--color_main', $setting['color_main'] );
		self::add_root_css( '--color_sub', 'red' );
		self::add_root_css( '--color_text', $setting['color_text'] );
		self::add_root_css( '--color_link', $setting['color_link'] );
		self::add_root_css( '--color_border', 'rgba(200,200,200,.5)' );
		self::add_root_css( '--color_gray', 'rgba(200,200,200,.15)' );
		self::add_root_css( '--color_bg', $setting['color_bg'] );
	}


	/**
	 * カラー変数のセット（フロント & エディターで共通のもの）
	 */
	protected static function css_contents( $container_size, $article_size ) {

		// コンテナサイズ
		self::add_root_css( '--container_size', ( (int) $container_size + 96 ) . 'px' );

		// 記事コンテンツサイズ
		$page_template = basename( get_page_template_slug() ) ?: '';
		$article_size  = ( 'one-column-slim.php' === $page_template ) ? $article_size : $container_size;

		self::add_root_css( '--article_size', $article_size . 'px' );
	}


	/**
	 * ヘッダー関連
	 */
	protected static function css_header( $logo_size_sp, $logo_size_pc ) {
		self::add_root_css( '--logo_size_sp', $logo_size_sp . 'px' );
		self::add_root_css( '--logo_size_pc', $logo_size_pc . 'px' );
	}


	/**
	 * タイトル背景
	 */
	protected static function css_title_bg( $ttlbg_overlay_color, $ttlbg_overlay_opacity ) {
		self::add_css(
			'.p-topArea.c-filterLayer::before',
			array(
				'background-color:' . $ttlbg_overlay_color,
				'opacity:' . $ttlbg_overlay_opacity,
			)
		);
	}


	/**
	 * 設定に合わせてサムネイル比率を返す
	 */
	public static function get_thumb_ratio( $thumb_ratio ) {
		switch ( $thumb_ratio ) {
			case 'golden':
				return '61.8%';
			case 'silver':
				return '70.72%';
			case 'slr':
				return '66.66%';
			case 'wide':
				return '56.25%';
			case 'wide2':
				return '50%';
			case 'wide3':
				return '40%';
			default: // 'square'
				return '100%';
		}
	}


	/**
	 * サムネイル比率
	 */
	protected static function css_thumb_ratio( $card_ratio, $list_ratio ) {

		self::add_root_css(
			'--card_posts_thumb_ratio',
			self::get_thumb_ratio( $card_ratio )
		);
		self::add_root_css(
			'--list_posts_thumb_ratio',
			self::get_thumb_ratio( $list_ratio )
		);
	}
}
