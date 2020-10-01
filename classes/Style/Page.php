<?php
namespace Arkhe_Theme\Style;

if ( ! defined( 'ABSPATH' ) ) exit;

trait Page {

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

}
