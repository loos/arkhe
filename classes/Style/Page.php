<?php namespace Arkhe_Theme\Style;

if ( ! defined( 'ABSPATH' ) ) exit;

class Page extends \Arkhe_Theme\Style {

	/**
	 * タイトル背景
	 */
	protected static function title_bg( $ttlbg_overlay_color, $ttlbg_overlay_opacity ) {
		self::add(
			'.p-topArea.c-filterLayer::before',
			array(
				'background-color:' . $ttlbg_overlay_color,
				'opacity:' . $ttlbg_overlay_opacity,
			)
		);
	}

}
