<?php
namespace Arkhe_Theme\Style;

if ( ! defined( 'ABSPATH' ) ) exit;

trait Color {

	/**
	 * カラー変数のセット（フロント & エディターで共通のもの）
	 */
	protected static function css_common( $SETTING ) {
		self::add_root_css( '--color_main', $SETTING['color_main'] );
		self::add_root_css( '--color_sub', 'red' );
		self::add_root_css( '--color_text', $SETTING['color_text'] );
		self::add_root_css( '--color_link', $SETTING['color_link'] );
		self::add_root_css( '--color_border', 'rgba(200,200,200,.5)' );
		self::add_root_css( '--color_gray', 'rgba(200,200,200,.15)' );
		self::add_root_css( '--color_bg', $SETTING['color_bg'] );
	}
}
