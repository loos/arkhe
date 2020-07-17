<?php namespace ARKHE_THEME\Style;

if ( ! defined( 'ABSPATH' ) ) exit;

class Color extends \ARKHE_THEME\Style {

	/**
	 * カラー変数のセット（フロント & エディターで共通のもの）
	 */
	protected static function common( $SETTING ) {
		self::add_root( '--color_main', $SETTING['color_main'] );
		self::add_root( '--color_sub', 'red' );
		self::add_root( '--color_text', $SETTING['color_text'] );
		self::add_root( '--color_link', $SETTING['color_link'] );
		self::add_root( '--color_border', 'rgba(200,200,200,.5)' );
		self::add_root( '--color_gray', 'rgba(200,200,200,.15)' );
		self::add_root( '--color_bg', $SETTING['color_bg'] );
	}
}
